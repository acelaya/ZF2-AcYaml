<?php
namespace Acelaya\Yaml\View\Renderer;

use Acelaya\Yaml\View\Exception\DomainException;
use Acelaya\Yaml\View\Model\YamlModel;
use Symfony\Component\Yaml\Yaml;
use Zend\Stdlib\ArrayUtils;
use Zend\View\Model\ModelInterface;
use Zend\View\Renderer\JsonRenderer;

/**
 * Class YamlStrategy
 * @author Alejandro Celaya Alastrué
 * @link http://www.alejandrocelaya.com
 */
class YamlRenderer extends JsonRenderer
{
    /**
     * This method is not applicable
     *
     * @param  string $callback
     * @return JsonRenderer
     */
    public function setJsonpCallback($callback)
    {
        // Do nothing
        return $this;
    }

    /**
     * This method is not applicable
     *
     * @return bool
     */
    public function hasJsonpCallback()
    {
        // Do nothing
        return false;
    }
    /**
     * Processes a view script and returns the output.
     *
     * @param  string|ModelInterface $nameOrModel The script/resource process, or a view model
     * @param  null|array|\ArrayAccess $values Values to use during rendering
     * @return string The script output.
     */
    public function render($nameOrModel, $values = null)
    {
        // use case 1: View Models
        // Serialize variables in view model
        if ($nameOrModel instanceof ModelInterface) {
            if ($nameOrModel instanceof YamlModel) {
                $children = $this->recurseModel($nameOrModel, false);
                $this->injectChildren($nameOrModel, $children);
                $values = $nameOrModel->serialize();
            } else {
                $values = $this->recurseModel($nameOrModel);
                $values = Yaml::dump($values);
            }

            return $values;
        }

        // use case 2: $nameOrModel is populated, $values is not
        // Serialize $nameOrModel
        if (null === $values) {
            if (! is_object($nameOrModel)) {
                $return = Yaml::dump($nameOrModel);
            } elseif ($nameOrModel instanceof \Traversable) {
                $nameOrModel = ArrayUtils::iteratorToArray($nameOrModel);
                $return = Yaml::dump($nameOrModel);
            } else {
                $return = Yaml::dump(get_object_vars($nameOrModel));
            }

            return $return;
        }

        // use case 3: Both $nameOrModel and $values are populated
        throw new DomainException(sprintf(
            '%s: Do not know how to handle operation when both $nameOrModel and $values are populated',
            __METHOD__
        ));
    }
}
