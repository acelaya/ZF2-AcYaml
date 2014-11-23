<?php
namespace Acelaya\Yaml\Test\View\Strategy;

use Acelaya\Yaml\View\Renderer\YamlRenderer;
use Acelaya\Yaml\View\Strategy\YamlStrategyFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\ServiceManager\ServiceManager;

/**
 * Class YamlStrategyFactoryTest
 * @author Alejandro Celaya Alastrué
 * @link http://www.alejandrocelaya.com
 */
class YamlStrategyFactoryTest extends TestCase
{
    /**
     * @var YamlStrategyFactory
     */
    private $factory;

    public function setUp()
    {
        $this->factory = new YamlStrategyFactory();
    }

    public function testCreateService()
    {
        $sm = new ServiceManager();
        $sm->setService('Acelaya\Yaml\View\Renderer\YamlRenderer', new YamlRenderer());
        $service = $this->factory->createService($sm);
        $this->assertInstanceOf('Acelaya\Yaml\View\Strategy\YamlStrategy', $service);
    }
}
