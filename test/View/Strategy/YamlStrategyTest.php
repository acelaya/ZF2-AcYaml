<?php
namespace Acelaya\Yaml\Test\View\Strategy;

use Acelaya\Yaml\View\Model\YamlModel;
use Acelaya\Yaml\View\Renderer\YamlRenderer;
use Acelaya\Yaml\View\Strategy\YamlStrategy;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\EventManager\EventManager;
use Zend\Http\Headers;
use Zend\Http\Response;
use Zend\View\Model\JsonModel;
use Zend\View\Renderer\JsonRenderer;
use Zend\View\ViewEvent;

/**
 * Class YamlStrategyTest
 * @author Alejandro Celaya Alastrué
 * @link http://www.alejandrocelaya.com
 */
class YamlStrategyTest extends TestCase
{
    /**
     * @var YamlStrategy
     */
    private $strategy;
    /**
     * @var YamlRenderer
     */
    private $renderer;

    public function setUp()
    {
        $this->renderer = new YamlRenderer();
        $this->strategy = new YamlStrategy($this->renderer);
    }

    public function testSelectRendererNotApplicable()
    {
        $e = new ViewEvent();
        $e->setModel(new JsonModel());
        $this->assertNull($this->strategy->selectRenderer($e));
    }

    public function testSelectRendererApplicable()
    {
        $e = new ViewEvent();
        $e->setModel(new YamlModel());
        $this->assertSame($this->renderer, $this->strategy->selectRenderer($e));
    }

    public function testInjectResponseNotApplicable()
    {
        $e = $this->createBaseViewEvent();
        $e->setRenderer(new JsonRenderer());
        $this->strategy->injectResponse($e);
        $this->assertEmpty($e->getResponse()->getContent());

        $e->setRenderer($this->renderer);
        $e->setResult(new \stdClass());
        $this->strategy->injectResponse($e);
        $this->assertEmpty($e->getResponse()->getContent());
    }

    public function testInjectResponseApplicable()
    {
        $yamlContent = file_get_contents(__DIR__ . '/../../files/yaml.yml');
        $e = $this->createBaseViewEvent();
        $e->setRenderer($this->renderer);
        $e->setResult($yamlContent);
        $this->strategy->injectResponse($e);

        /** @var Headers $headers */
        $headers = $e->getResponse()->getHeaders();
        $this->assertEquals(
            sprintf('Content-Type: application/x-yaml; charset=%s', $this->strategy->getCharset()),
            $headers->get('Content-type')->toString()
        );
        $this->assertEquals($yamlContent, $e->getResponse()->getContent());

        $this->strategy->setCharset('utf-16');
        $this->strategy->injectResponse($e);
        $headers = $e->getResponse()->getHeaders();
        $this->assertTrue($headers->has('content-transfer-encoding'));
        $this->assertEquals($yamlContent, $e->getResponse()->getContent());
    }

    public function testAttach()
    {
        $em = new EventManager();
        $this->assertEmpty($em->getListeners(ViewEvent::EVENT_RENDERER));
        $this->assertEmpty($em->getListeners(ViewEvent::EVENT_RESPONSE));

        $this->strategy->attach($em);
        $this->assertCount(1, $em->getListeners(ViewEvent::EVENT_RENDERER));
        $this->assertCount(1, $em->getListeners(ViewEvent::EVENT_RESPONSE));
    }

    /**
     * Creates a ViewEvent object with some dependencies already injected
     * @return ViewEvent
     */
    private function createBaseViewEvent()
    {
        $e = new ViewEvent();
        $e->setResponse(new Response());
        return $e;
    }
}
