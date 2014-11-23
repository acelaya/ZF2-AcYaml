<?php
namespace Acelaya\Yaml\View\Strategy;

use Acelaya\Yaml\View\Renderer\YamlRenderer;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class YamlStrategy
 * @author Alejandro Celaya Alastrué
 * @link http://www.alejandrocelaya.com
 */
class YamlStrategyFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var YamlRenderer $renderer */
        $renderer = $serviceLocator->get('Acelaya\Yaml\View\Renderer\YamlRenderer');
        return new YamlStrategy($renderer);
    }
}
