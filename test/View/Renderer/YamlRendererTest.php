<?php
namespace Acelaya\Yaml\Test\View\Renderer;

use Acelaya\Yaml\View\Model\YamlModel;
use Acelaya\Yaml\View\Renderer\YamlRenderer;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\Config\Config;
use Zend\View\Model\JsonModel;

/**
 * Class YamlRendererTest
 * @author Alejandro Celaya Alastrué
 * @link http://www.alejandrocelaya.com
 */
class YamlRendererTest extends TestCase
{
    /**
     * @var YamlRenderer
     */
    private $renderer;

    public function setUp()
    {
        $this->renderer = new YamlRenderer();
    }

    public function testNonApplicableMethods()
    {
        $this->assertSame($this->renderer, $this->renderer->setJsonpCallback(''));
        $this->assertFalse($this->renderer->hasJsonpCallback());
    }

    public function testRenderYamlModel()
    {
        $expected = file_get_contents(__DIR__ . '/../../files/yaml.yml');
        $model = new YamlModel(include __DIR__ . '/../../files/php-array.php');
        $this->assertEquals($expected, $this->renderer->render($model));
    }

    public function testRenderOtherModel()
    {
        $expected = file_get_contents(__DIR__ . '/../../files/yaml.yml');
        $model = new JsonModel(include __DIR__ . '/../../files/php-array.php');
        $this->assertEquals($expected, $this->renderer->render($model));
    }

    public function testRenderNonObject()
    {
        // Array
        $expected = file_get_contents(__DIR__ . '/../../files/yaml.yml');
        $array = include __DIR__ . '/../../files/php-array.php';
        $this->assertEquals($expected, $this->renderer->render($array));

        // String
        $expected = 'Hello';
        $this->assertEquals($expected, $this->renderer->render($expected));

        // Int
        $expected = 53;
        $this->assertEquals($expected, $this->renderer->render($expected));
    }

    public function testRenderTraversableObject()
    {
        $expected = file_get_contents(__DIR__ . '/../../files/yaml.yml');
        $obj = new \ArrayObject(include __DIR__ . '/../../files/php-array.php');
        $this->assertEquals($expected, $this->renderer->render($obj));
    }

    public function testRenderOtherObject()
    {
        $expected = file_get_contents(__DIR__ . '/../../files/yaml.yml');
        $obj = (object) include __DIR__ . '/../../files/php-array.php';
        $this->assertEquals($expected, $this->renderer->render($obj));
    }

    /**
     * @expectedException \Acelaya\Yaml\View\Exception\DomainException
     */
    public function testInvalidRendering()
    {
        $this->renderer->render('foobar', array('foo' => 'bar'));
    }
}
