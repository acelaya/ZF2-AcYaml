<?php
namespace Acelaya\Yaml\Test\View\Renderer;

use Acelaya\Yaml\View\Renderer\YamlRendererFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\ServiceManager\ServiceManager;

/**
 * Class YamlRendererFactoryTest
 * @author Alejandro Celaya Alastrué
 * @link http://www.alejandrocelaya.com
 */
class YamlRendererFactoryTest extends TestCase
{
    /**
     * @var YamlRendererFactory
     */
    private $factory;

    public function setUp()
    {
        $this->factory = new YamlRendererFactory();
    }

    public function testCreateService()
    {
        $service = $this->factory->createService(new ServiceManager());
        $this->assertInstanceOf('Acelaya\Yaml\View\Renderer\YamlRenderer', $service);
    }
}
