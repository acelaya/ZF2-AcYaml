<?php
namespace Acelaya\Yaml\View\Renderer;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class YamlStrategy
 * @author Alejandro Celaya Alastrué
 * @link http://www.alejandrocelaya.com
 */
class YamlRendererFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $renderer = new YamlRenderer();
        return $renderer;
    }
}
