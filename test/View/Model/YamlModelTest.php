<?php
namespace Acelaya\Yaml\Test\View\Model;

use Acelaya\Yaml\View\Model\YamlModel;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\Stdlib\ArrayUtils;

/**
 * Class YamlModelTest
 * @author Alejandro Celaya Alastrué
 * @link http://www.alejandrocelaya.com
 */
class YamlModelTest extends TestCase
{
    /**
     * @var YamlModel
     */
    private $model;

    public function setUp()
    {
        $this->model = new YamlModel();
    }

    public function testSerialize()
    {
        $expected = file_get_contents(__DIR__ . '/../../files/yaml.yml');
        $this->model->setVariables(include __DIR__ . '/../../files/php-array.php');
        $this->assertEquals($expected, $this->model->serialize());
    }

    public function testUnserialize()
    {
        $expected = include __DIR__ . '/../../files/php-array.php';
        $this->model->unserialize(file_get_contents(__DIR__ . '/../../files/yaml.yml'));
        $this->assertEquals($expected, ArrayUtils::iteratorToArray($this->model->getVariables()));
    }
}
