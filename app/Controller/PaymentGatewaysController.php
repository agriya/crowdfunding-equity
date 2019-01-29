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
class PaymentGatewaysController extends AppController
{
    public $name = 'PaymentGateways';
    public function admin_index() 
    {
        $this->pageTitle = __l('Payment Gateways');
		$conditions = array();
		if (!isPluginEnabled('Sudopay')) {
			$conditions['PaymentGateway.id != '] = ConstPaymentGateways::SudoPay;
		}
        $this->paginate = array(
			'conditions' => $conditions,
            'contain' => array(
                'PaymentGatewaySetting' => array(
                    'order' => array(
                        'PaymentGatewaySetting.name' => 'asc'
                    )
                )
            ) ,
            'order' => array(
                'PaymentGateway.id' => 'desc'
            ) ,
            'recursive' => 2
        );
        $this->set('paymentGateways', $this->paginate());
    }
    public function admin_edit($id = null) 
    {
        $this->pageTitle = sprintf(__l('Edit %s') , __l('Payment Gateway'));
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($id == ConstPaymentGateways::SudoPay) {
            $this->loadModel('Sudopay.Sudopay');
            $SudoPayGatewaySettings = $this->Sudopay->GetSudoPayGatewaySettings();
            $this->set(compact('SudoPayGatewaySettings', 'id'));
        }
        if (!empty($this->request->data)) {
            if ($this->PaymentGateway->save($this->request->data)) {
                if (!empty($this->request->data['PaymentGatewaySetting'])) {
                    foreach($this->request->data['PaymentGatewaySetting'] as $key => $value) {
                        $value['test_mode_value'] = !empty($value['test_mode_value']) ? trim($value['test_mode_value']) : '';
                        $value['live_mode_value'] = !empty($value['live_mode_value']) ? trim($value['live_mode_value']) : '';
                        $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                            'PaymentGatewaySetting.test_mode_value' => '\'' . $value['test_mode_value'] . '\'',
                            'PaymentGatewaySetting.live_mode_value' => '\'' . $value['live_mode_value'] . '\''
                        ) , array(
                            'PaymentGatewaySetting.id' => $key
                        ));
                    }
                }
                $this->Session->setFlash(sprintf(__l('%s has been updated') , __l('Payment Gateway')) , 'default', null, 'success');
                if ($this->request->data['PaymentGateway']['id'] == ConstPaymentGateways::SudoPay) {
                    $this->redirect(array(
                        'controller' => 'sudopays',
                        'action' => 'synchronize',
                        'admin' => true
                    ));
                }
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.') , __l('Payment Gateway')) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->PaymentGateway->read(null, $id);
            unset($this->request->data['PaymentGatewaySetting']);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $paymentGatewaySettings = $this->PaymentGateway->PaymentGatewaySetting->find('all', array(
            'conditions' => array(
                'PaymentGatewaySetting.payment_gateway_id' => $id
            ) ,
            'order' => array(
                'PaymentGatewaySetting.id' => 'asc'
            )
        ));
        if (!empty($this->request->data['PaymentGatewaySetting'])) {
            foreach($paymentGatewaySettings as $key => $paymentGatewaySetting) {
                $paymentGatewaySettings[$key]['PaymentGatewaySetting']['value'] = $this->request->data['PaymentGatewaySetting'][$paymentGatewaySetting['PaymentGatewaySetting']['id']]['value'];
            }
        }
        $this->set(compact('paymentGatewaySettings'));
        $this->pageTitle.= ' - ' . $this->request->data['PaymentGateway']['name'];
    }
    public function admin_update_status($id = null, $actionId = null) 
    {
        $paymentGateways = array(
            ConstPaymentGateways::Wallet => 'Wallet',
            ConstPaymentGateways::SudoPay => 'SudoPay',
        );
        if (is_null($id) || is_null($actionId)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $toggle = empty($this->request->params['named']['toggle']) ? 0 : 1;
        switch ($actionId) {
            case ConstPaymentGateways::Testmode:
                $newToggle = empty($toggle) ? 1 : 0;
                $this->PaymentGateway->updateAll(array(
                    'PaymentGateway.is_test_mode' => $toggle
                ) , array(
                    'PaymentGateway.id' => $id
                ));
                break;

            case ConstPaymentGateways::Active:
                $this->PaymentGateway->updateAll(array(
                    'PaymentGateway.is_active' => $toggle
                ) , array(
                    'PaymentGateway.id' => $id
                ));
                $this->Cms = new CmsPlugin();
                $this->Cms->setController($this);
                $plugin = Inflector::camelize(strtolower($paymentGateways[$id]));
                if ($this->Cms->pluginIsActive($plugin)) {
                    $this->Cms->removePluginBootstrap($plugin);
                } else {
                    $this->Cms->addPluginBootstrap($plugin);
                }
                break;

            case ConstPaymentGateways::Masspay:
                $this->PaymentGateway->updateAll(array(
                    'PaymentGateway.is_mass_pay_enabled' => $toggle
                ) , array(
                    'PaymentGateway.id' => $id
                ));
                break;

            case ConstPaymentGateways::Wallet:
                $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                    'PaymentGatewaySetting.test_mode_value' => $toggle
                ) , array(
                    'PaymentGatewaySetting.payment_gateway_id' => $id,
                    'PaymentGatewaySetting.name' => 'is_enable_for_add_to_wallet'
                ));
                break;

            case ConstPaymentGateways::Project:
                $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                    'PaymentGatewaySetting.test_mode_value' => $toggle
                ) , array(
                    'PaymentGatewaySetting.payment_gateway_id' => $id,
                    'PaymentGatewaySetting.name' => 'is_enable_for_project'
                ));
                break;

            case ConstPaymentGateways::Pledge:
                $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                    'PaymentGatewaySetting.test_mode_value' => $toggle
                ) , array(
                    'PaymentGatewaySetting.payment_gateway_id' => $id,
                    'PaymentGatewaySetting.name' => 'is_enable_for_pledge'
                ));
                break;

            case ConstPaymentGateways::Donate:
                $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                    'PaymentGatewaySetting.test_mode_value' => $toggle
                ) , array(
                    'PaymentGatewaySetting.payment_gateway_id' => $id,
                    'PaymentGatewaySetting.name' => 'is_enable_for_donate'
                ));
                break;

            case ConstPaymentGateways::Lend:
                $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                    'PaymentGatewaySetting.test_mode_value' => $toggle
                ) , array(
                    'PaymentGatewaySetting.payment_gateway_id' => $id,
                    'PaymentGatewaySetting.name' => 'is_enable_for_lend'
                ));
                break;

            case ConstPaymentGateways::Equity:
                $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                    'PaymentGatewaySetting.test_mode_value' => $toggle
                ) , array(
                    'PaymentGatewaySetting.payment_gateway_id' => $id,
                    'PaymentGatewaySetting.name' => 'is_enable_for_equity'
                ));
                break;
				
			case ConstPaymentGateways::Signup:
                $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                    'PaymentGatewaySetting.test_mode_value' => $toggle
                ) , array(
                    'PaymentGatewaySetting.payment_gateway_id' => $id,
                    'PaymentGatewaySetting.name' => 'is_enable_for_signup_fee'
                ));
                break;
        }
		/* for delete full page caching  temporary fix*/
		$gateway =  $this->PaymentGateway->find('first',array(
			'conditions' => array(
				'PaymentGateway.name' => 'Wallet'
			)
		));
		if(!empty($gateway))
		{
			$data = array();
			$data['PaymentGateway']['is_test_mode'] =  $gateway['PaymentGateway']['is_test_mode'];
			$data['PaymentGateway']['id'] =  $gateway['PaymentGateway']['id'];
			$this->PaymentGateway->save($data);
		}
		/* for delete full page caching */
        $this->set('id', $id);
        $this->set('actionId', $actionId);
        $this->set('toggle', $toggle);
    }
}
?>