<?php
namespace Acelaya\Yaml\View\Strategy;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\View\ViewEvent;

/**
 * Class YamlStrategy
 * @author Alejandro Celaya Alastrué
 * @link http://www.alejandrocelaya.com
 */
class YamlStrategy extends AbstractListenerAggregate
{
    /**
     * Attach one or more listeners
     *
     * @param EventManagerInterface $events
     * @param int $priority
     *
     * @return void
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RENDERER, array($this, 'selectRenderer'), $priority);
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RESPONSE, array($this, 'injectResponse'), $priority);
    }

    public function selectRenderer(ViewEvent $e)
    {

    }

    public function injectResponse(ViewEvent $e)
    {

    }
}
