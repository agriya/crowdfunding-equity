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
class ProjectsCronComponent extends Component
{
    public function main()
    {
        App::import('Model', 'Projects.Project');
        $this->Project = new Project();
        $this->Project->_updateCityProjectCount();
    }
}
