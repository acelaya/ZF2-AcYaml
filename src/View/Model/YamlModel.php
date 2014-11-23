<?php
namespace Acelaya\Yaml\View\Model;

use Zend\View\Model\ViewModel;

/**
 * Class YamlStrategy
 * @author Alejandro Celaya Alastrué
 * @link http://www.alejandrocelaya.com
 */
class YamlModel extends ViewModel
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
}
