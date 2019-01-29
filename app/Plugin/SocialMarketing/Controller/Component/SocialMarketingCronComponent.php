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
class SocialMarketingCronComponent extends Component
{
    public function daily()
    {
        App::import('Model', 'SocialMarketing.SocialMarketing');
        $this->SocialMarketing = new SocialMarketing();
		if (empty($_GET) && !defined('STDIN')) {
			$this->SocialMarketing->updateSocialActivityCount();
		}
    }
}