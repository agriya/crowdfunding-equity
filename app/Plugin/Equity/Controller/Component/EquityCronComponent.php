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
class EquityCronComponent extends Component
{
    public function main() 
    {
        App::import('Model', 'Equity.Equity');
        $this->Equity = new Equity();
        $projects = $this->Equity->find('all', array(
            'conditions' => array(
                'Project.is_draft' => 0,
                'Equity.equity_project_status_id' => array(
                    ConstEquityProjectStatus::OpenForInvesting
                ) ,
            ) ,
            'contain' => array(
                'Project'
            ) ,
            'recursive' => 0
        ));
        foreach($projects as $project) {
            if (($project['Project']['collected_amount'] >= $project['Project']['needed_amount'] && strtotime($project['Project']['project_end_date'] . ' 23:55:59') <= strtotime(date('Y-m-d H:i:s'))) || (strtotime($project['Project']['project_end_date'] . ' 23:55:59') <= strtotime(date('Y-m-d H:i:s')) && $project['Project']['payment_method_id'] == ConstPaymentMethod::KiA)) {
                if (empty($project['Project']['project_fund_count'])) {
                    $this->Equity->updateStatus(ConstEquityProjectStatus::ProjectExpired, $project['Project']['id']);
                } else {
                    $this->Equity->updateStatus(ConstEquityProjectStatus::ProjectClosed, $project['Project']['id']);
                }
            } elseif (strtotime($project['Project']['project_end_date'] . ' 23:55:59') <= strtotime(date('Y-m-d H:i:s'))) {
                $this->Equity->updateStatus(ConstEquityProjectStatus::ProjectExpired, $project['Project']['id']);
            }
        }
    }
}
