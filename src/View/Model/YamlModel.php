<?php
namespace Acelaya\Yaml\View\Model;

use Symfony\Component\Yaml\Yaml;
use Zend\Stdlib\ArrayUtils;
use Zend\View\Model\ViewModel;

/**
 * Class YamlStrategy
 * @author Alejandro Celaya Alastrué
 * @link http://www.alejandrocelaya.com
 */
class YamlModel extends ViewModel implements \Serializable
{
    /**
     * Yaml probably won't need to be captured into a parent container.
     * @var string
     */
    protected $captureTo = null;

    /**
     * @var bool
     */
    protected $terminate = true;

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        $variables = $this->getVariables();
        if ($variables instanceof \Traversable) {
            $variables = ArrayUtils::iteratorToArray($variables);
        }

        return Yaml::dump($variables);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     */
    public function unserialize($serialized)
    {
        $this->setVariables(Yaml::parse($serialized));
    }
}
