<?php
namespace Acelaya\Yaml\View\Strategy;

use Acelaya\Yaml\View\Model\YamlModel;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Http\Headers;
use Zend\View\ViewEvent;
use Acelaya\Yaml\View\Renderer\YamlRenderer;
use Zend\Http;

/**
 * Class YamlStrategy
 * @author Alejandro Celaya Alastrué
 * @link http://www.alejandrocelaya.com
 */
class YamlStrategy extends AbstractListenerAggregate
{
    /**
     * Character set for associated content-type
     *
     * @var string
     */
    protected $charset = 'utf-8';

    /**
     * Multibyte character sets that will trigger a binary content-transfer-encoding
     *
     * @var array
     */
    protected $multibyteCharsets = array(
        'UTF-16',
        'UTF-32',
    );

    /**
     * @var YamlRenderer
     */
    protected $renderer;

    /**
     * Constructor
     *
     * @param  YamlRenderer $renderer
     */
    public function __construct(YamlRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

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

    /**
     * Returns the YamlRenderer if current model is a YamlModel
     * @param ViewEvent $e
     * @return YamlRenderer
     */
    public function selectRenderer(ViewEvent $e)
    {
        $model = $e->getModel();

        if (! $model instanceof YamlModel) {
            return;
        }

        // JsonModel found
        return $this->renderer;
    }

    public function injectResponse(ViewEvent $e)
    {
        $renderer = $e->getRenderer();
        if ($renderer !== $this->renderer) {
            // Discovered renderer is not ours; do nothing
            return;
        }

        $result = $e->getResult();
        if (! is_string($result)) {
            // We don't have a string, and thus, no yaml
            return;
        }

        // Populate response
        /** @var Http\Response $response */
        $response = $e->getResponse();
        $response->setContent($result);
        /** @var Headers $headers */
        $headers = $response->getHeaders();

        $contentType = sprintf('application/x-yaml; charset=%s', $this->charset);
        $headers->addHeaderLine('content-type', $contentType);

        // Add content-transfer-encoding header in charset is multibyte
        if (in_array(strtoupper($this->charset), $this->multibyteCharsets)) {
            $headers->addHeaderLine('content-transfer-encoding', 'BINARY');
        }
    }

    /**
     * Set the content-type character set
     *
     * @param  string $charset
     * @return $this
     */
    public function setCharset($charset)
    {
        $this->charset = (string) $charset;
        return $this;
    }

    /**
     * Retrieve the current character set
     *
     * @return string
     */
    public function getCharset()
    {
        return $this->charset;
    }
}
