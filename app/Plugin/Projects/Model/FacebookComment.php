<?php
/**
 * CrowdFunding
 *
 * PHP version 5
 *
 * @category   PHP
 * @package    Crowdfunding
 * @subpackage Core
 * @author     Agriya <info@agriya.com>
 * @copyright  2018 Agriya Infoway Private Ltd
 * @license    http://www.agriya.com/ Agriya Infoway Licence
 * @link       http://www.agriya.com
 */
class FacebookComment extends AppModel
{
    /**
     * Model name
     *
     * @var string
     * @access public
     */
    public $name = 'FacebookComment';
    /**
     * Behaviors used by the Model
     *
     * @var array
     * @access public
     */
    public function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
    }
}
