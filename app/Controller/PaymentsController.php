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
class PaymentsController extends AppController
{
	public $name = 'Payments';
	public function beforeFilter()
	{
		$this->Security->disabledFields = array(
				'User.normal',
				'User.payment_gateway_id',
				'User.wallet',
				'User.payment_id',
				'User.gateway_method_id',
				'Sudopay'
		);
		parent::beforeFilter();
		if($this->RequestHandler->prefers('json') && ($this->request->params['action'] == 'user_pay_now')) {
			$this->Security->validatePost = false;
		}
	}
	public function user_pay_now($user_id = null, $hash = null)
	{
		$this->pageTitle = __l('Pay Sign Up Fee');
		if ($this->RequestHandler->prefers('json'))
		{
		    $this->request->data['Sudopay'] = $this->request->data; 
		    $this->request->data['User']['id'] = $user_id;
		    $this->request->data['User']['payment_gateway_id']  = $this->request->data['Sudopay']['payment_gateway_id'];
		    $this->request->data['User']['wallet'] = 'Pay Now';   
		}
		
		$this->loadModel('User');
		if (!empty($this->request->data['User']['id'])) {
			$user_id = $this->request->data['User']['id'];
		}
		if (is_null($user_id)) {
			if ($this->RequestHandler->prefers('json')) {
				$this->set('iphone_response', array("message" =>__l('Invalid request') , "error" => 1));
			} else {
				throw new NotFoundException(__l('Invalid request'));
			}
		}
		if ($this->User->isValidActivateHash($user_id, $hash)) {
			$user = $this->User->find('first', array(
					'conditions' => array(
							'User.id = ' => $user_id,
							'User.is_paid' => 0,
					) ,
					'fields' => array(
							'User.id',
							'User.username',
					) ,
					'recursive' => -1,
			));
			if (empty($user)) {
				if ($this->RequestHandler->prefers('json')) {
					$this->set('iphone_response', array("message" =>__l('Invalid request') , "error" => 1));
				}else{
					throw new NotFoundException(__l('Invalid request'));
				}
			}
			$total_amount = round(Configure::read('User.signup_fee') , 2);
			if (!empty($this->request->data)) {
				$this->request->data['User']['sudopay_gateway_id'] = 0;
				if ($this->request->data['User']['payment_gateway_id'] != ConstPaymentGateways::Wallet && strpos($this->request->data['User']['payment_gateway_id'], 'sp_') >= 0) {
					$this->request->data['User']['sudopay_gateway_id'] = str_replace('sp_', '', $this->request->data['User']['payment_gateway_id']);
					$this->request->data['User']['payment_gateway_id'] = ConstPaymentGateways::SudoPay;
				}
				$_data = array();
				$_data['User']['id'] = $this->request->data['User']['id'];
				$_data['User']['sudopay_gateway_id'] = $this->request->data['User']['sudopay_gateway_id'];
				$this->User->save($_data);
				$data['user_id'] = $this->request->data['User']['id'];
				$data['amount'] = $total_amount;
				if ($this->request->data['User']['payment_gateway_id'] == ConstPaymentGateways::SudoPay) {
					$this->loadModel('Sudopay.Sudopay');
					$sudopay_gateway_settings = $this->Sudopay->GetSudoPayGatewaySettings();
					$this->set('sudopay_gateway_settings', $sudopay_gateway_settings);
					if ($sudopay_gateway_settings['is_payment_via_api'] == ConstBrandType::VisibleBranding) {
						$sudopay_data = $this->Sudopay->getSudoPayPostData($this->request->data['User']['id'], ConstPaymentType::Signup);
						$sudopay_data['merchant_id'] = $sudopay_gateway_settings['sudopay_merchant_id'];
						$sudopay_data['website_id'] = $sudopay_gateway_settings['sudopay_website_id'];
						$sudopay_data['secret_string'] = $sudopay_gateway_settings['sudopay_secret_string'];
						$sudopay_data['action'] = 'capture';
						$this->set('sudopay_data', $sudopay_data);
					} else {
						$this->request->data['Sudopay'] = !empty($this->request->data['Sudopay']) ? $this->request->data['Sudopay'] : '';
						if ($this->RequestHandler->prefers('json')) 
						{  
						       $call_back_url = $this->Sudopay->processPayment($this->request->data['User']['id'], ConstPaymentType::Signup, $this->request->data['Sudopay'], 'json'); 
						       if(is_array($call_back_url))
						       {
							     $return = $call_back_url;
                               }else{
                                   $this->set('iphone_response', array("message" => $call_back_url, "error" => 0));
                               }
						}else
						{
							$return = $this->Sudopay->processPayment($this->request->data['User']['id'], ConstPaymentType::Signup, $this->request->data['Sudopay']);
						}
						$redirect = 0;
						if (!empty($return['pending'])) {
							$this->Session->setFlash(__l('Your payment is in pending.') , 'default', null, 'success');
							$this->set('iphone_response', array("message" =>__l('Your payment is in pending.') , "error" => 0));
							$redirect = 1;
						} elseif (!empty($return['success'])) {
							$this->Payment->processUserSignupPayment($this->request->data['User']['id'], ConstPaymentGateways::SudoPay);
							$this->Session->setFlash(__l('You have paid signup fee successfully') , 'default', null, 'success');
							$this->set('iphone_response', array("message" =>__l('You have paid signup fee successfully') , "error" => 0));
							$redirect = 1;
						} elseif (!empty($return['error'])) {
							$this->Session->setFlash($return['error_message'] . __l('Your payment could not be completed.') , 'default', null, 'error');
							$this->set('iphone_response', array("message" =>$return['error_message'] . __l('Your payment could not be completed.') , "error" => 1));
						}
						if (!empty($redirect)) {
							if (!$this->RequestHandler->prefers('json')) {
								$this->redirect('/');
							}
						}
					}
				}
				if (!empty($return['error'])) {
					$this->Session->setFlash(__l('Payment could not be completed.') , 'default', null, 'error');
					$this->set('iphone_response', array("message" => __l('Payment could not be completed.') , "error" => 1));
				}
			} else {
				$this->request->data = $user;
			}
			$this->set('total_amount', $total_amount);
		} else {
			if ($this->RequestHandler->prefers('json')) {
				$this->set('iphone_response', array("message" =>__l('Invalid request') , "error" => 1));
			}else{
				throw new NotFoundException(__l('Invalid request'));
			}
		}
		if ($this->RequestHandler->prefers('json')) {
			$response = Cms::dispatchEvent('Controller.Payments.MembershipPayNow', $this, array());	
		}
	}
	
	/** Method for getting sudopay gateways list for iPhone **/
	public function get_sudopay_gateways()
	{
	    $sudoPayments['paymentGroup'] = array();
	    if(empty($this->request->params['named']['project_type']) || ($this->request->params['named']['project_type'] != 'lend' && $this->request->params['named']['project_type'] != 'equity')) {
		$this->loadModel('SudopayPaymentGroup');
		$this->loadModel('SudopayPaymentGateway');
		$this->loadModel('Sudopay.SudopayPaymentGatewaysUser');
		$this->SudopayPaymentGatewaysUser = new SudopayPaymentGatewaysUser();
		
		if(!empty($this->request->params['named']['project_owner']) && $this->request->params['named']['project_owner'] > 0) {
		    $user_id = $this->request->params['named']['project_owner'];
		} else {
		    $user_id = $this->Auth->user('id');
		}
            
		$connected_gateways = $this->SudopayPaymentGatewaysUser->find('all', array(
		    'conditions' => array(
				    'SudopayPaymentGatewaysUser.user_id' => $user_id ,
		    ) ,
		    'recursive' => -1,
		));
		    
		$user_connected_gateways = array();
		foreach($connected_gateways as $connected_gateway) {
		    $user_connected_gateways[] = $connected_gateway['SudopayPaymentGatewaysUser']['sudopay_payment_gateway_id'];
		}
		if(!empty($this->request->params['named']['gateway_list_for']) && ($this->request->params['named']['gateway_list_for'] == 'MembershipFee' || $this->request->params['named']['gateway_list_for'] == 'AddToWallet' || $this->request->params['named']['gateway_list_for'] == 'ProjectListing')) {
			$sudoPay['paymentGateway'] = $this->SudopayPaymentGateway->find('all', array(
				'recursive' => 0
			));
		} else {
			$sudoPay['paymentGateway'] = $this->SudopayPaymentGateway->find('all', array(
			    'conditions' => array(
				    'OR'=>array(
					    array(
					       'SudopayPaymentGateway.is_marketplace_supported' => 0
					    ),
					    array(
					       'SudopayPaymentGateway.is_marketplace_supported' => 1,
					       'SudopayPaymentGateway.sudopay_gateway_id' => $user_connected_gateways
					    )
					),
			    ),
			    'recursive' => 0
			));
		}

		foreach($sudoPay['paymentGateway'] as $k => $v)
		{
		    $group_ids[] = $v['SudopayPaymentGateway']['sudopay_payment_group_id'];
		}
		$sudoPayments['paymentGroup'] = $this->SudopayPaymentGroup->find('all',array(
		    'conditions'=>array(
			    'SudopayPaymentGroup.id' => $group_ids,
		    ),
		    'recursive' => -1,
		));
		$subcategory = array();
		foreach($sudoPayments['paymentGroup'] as $key => $main)
		{
		    foreach($sudoPay['paymentGateway'] as $sudopayment)
		    {
			$out =unserialize($sudopayment['SudopayPaymentGateway']['sudopay_gateway_details']);
	    
			if($sudopayment['SudopayPaymentGateway']['sudopay_payment_group_id'] == $main['SudopayPaymentGroup']['id'])
			{
			    $subcategory['gateway_name'] = $sudopayment['SudopayPaymentGateway']['sudopay_gateway_name'];
			    $subcategory['gateway_id'] = $sudopayment['SudopayPaymentGateway']['sudopay_gateway_id'];
			    $subcategory['gateway_group_id'] = $sudopayment['SudopayPaymentGateway']['sudopay_payment_group_id'];
			    $subcategory['gateway_thumb_url'] = 'http:'.$out['thumb_url'];
			    $subcategory['id'] = $sudopayment['SudopayPaymentGateway']['id'];
			    $sudoPayments['paymentGroup'][$key]['SudopayPaymentGroup']['GatewayTypes'][] = $subcategory;
			}
		    }
		}	
	    }
	    
	    
	    if((!empty($this->request->params['named']['project_owner']) && $this->request->params['named']['project_owner'] > 0) || (!empty($this->request->params['named']['gateway_list_for']) && $this->request->params['named']['gateway_list_for'] == 'ProjectListing')) {
		if (isPluginEnabled('Wallet')) {
		    App::import('Model', 'User');
		    $this->loadModel('User');
		    $user = $this->User->find('first', array(
				    'conditions' => array(
					'User.id =' => $this->Auth->user('id') ,
				    ),
				    'fields' => array(
					'User.id',
					'User.available_wallet_amount',
				    ) ,
				    'recursive' => -1,
		    ));
		    
		    $walletPayment = array();
		    $walletPayment['SudopayPaymentGroup']['name'] = "Wallet";
		    $walletPayment['SudopayPaymentGroup']['id'] = ConstPaymentGateways::Wallet;
		    $walletPayment['SudopayPaymentGroup']['payment_gateway_id'] = ConstPaymentGateways::Wallet;
		    $walletPayment['SudopayPaymentGroup']['available_wallet_amount'] = $user['User']['available_wallet_amount'];
		    array_push($sudoPayments['paymentGroup'], $walletPayment);
		}
	    }

	    if ($this->RequestHandler->prefers('json')) 
	    {
		$this->request->data = $sudoPayments;
		Cms::dispatchEvent('Controller.Payment.get_sudopay_gateways', $this);
	    }
	}
    
	public function get_gateways()
	{
		App::import('Model', 'User');
		$this->loadModel('User');
		$countries = $this->User->UserProfile->Country->find('list', array(
				'fields' => array(
						'Country.iso_alpha2',
						'Country.name'
				) ,
				'order' => array(
						'Country.name' => 'ASC'
				) ,
				'recursive' => -1,
		));
		$user_profile = $this->User->UserProfile->find('first', array(
				'conditions' => array(
						'UserProfile.user_id' => $this->Auth->user('id') ,
				) ,
				'contain' => array(
						'User',
						'City',
						'State',
						'Country'
				) ,
				'recursive' => 0,
		));
		$gateway_ids="";
		$gatewaygroup_ids="";
		if (isPluginEnabled('Sudopay')) {
			$this->loadModel('Sudopay.SudopayPaymentGatewaysUser');
			$this->SudopayPaymentGatewaysUser = new SudopayPaymentGatewaysUser();
			$this->loadModel('Sudopay.SudopayPaymentGateway');
			$this->SudopayPaymentGateway = new SudopayPaymentGateway();
			
			$connected_gateways = $this->SudopayPaymentGatewaysUser->find('all', array(
					'conditions' => array(
							'SudopayPaymentGatewaysUser.user_id' => $this->request->params['named']['user_id'] ,
					) ,
					'contain'=>array(
							'SudopayPaymentGateway',
					),
					'recursive' => 0,
			));
			 
			foreach ($connected_gateways as $gateway_id){
				$connected_gateways_group = $this->SudopayPaymentGateway->find('first', array(
						'conditions' => array(
								'SudopayPaymentGateway.sudopay_gateway_id' =>$gateway_id['SudopayPaymentGatewaysUser']['sudopay_payment_gateway_id'],
						) ,
						'contain'=>array(
								'SudopayPaymentGroup',
						),
						'recursive' => 0
				));
				if(empty($gateway_ids)){
					$gateway_ids = $gateway_id['SudopayPaymentGatewaysUser']['sudopay_payment_gateway_id'];
				}else{
					$gateway_ids = $gateway_id['SudopayPaymentGatewaysUser']['sudopay_payment_gateway_id'].",".$gateway_ids;
				}
				if(empty($gatewaygroup_ids)){
					$gatewaygroup_ids = $connected_gateways_group['SudopayPaymentGroup']['sudopay_group_id'];
				}else{
					$gatewaygroup_ids = $connected_gateways_group['SudopayPaymentGroup']['sudopay_group_id'].",".$gatewaygroup_ids;
				}
			}
		}
		$gateway_ids = explode(",",$gateway_ids);
		$gatewaygroup_ids = explode(",",$gatewaygroup_ids);
		
		if(!empty($this->request->params['named']['project_type'])){
			$project_type = $this->request->params['named']['project_type'];
		}
		if (!empty($this->request->params['named']['type'])) {
			$type = $this->request->params['named']['type'];
			$gateway_types = $this->Payment->getGatewayTypes($type);
		} else {
			$gateway_types = $this->Payment->getGatewayTypes();
		}
		if (isPluginEnabled('Sudopay') && !empty($gateway_types[ConstPaymentGateways::SudoPay])) {
			$this->request->data[$this->request->params['named']['model']]['payment_gateway_id'] = ConstPaymentGateways::SudoPay;
		} elseif (isPluginEnabled('Wallet') && !empty($gateway_types[ConstPaymentGateways::Wallet])) {
			$this->request->data[$this->request->params['named']['model']]['payment_gateway_id'] = ConstPaymentGateways::Wallet;
		}
		if (isPluginEnabled('Sudopay')) {
			$this->loadModel('Sudopay.Sudopay');
			$this->Sudopay = new Sudopay();
			$response = $this->Sudopay->GetSudoPayGatewaySettings();
			$this->set('response', $response);
		}
		$this->set('model', $this->request->params['named']['model']);
		$this->set('foreign_id', $this->request->params['named']['foreign_id']);
		$this->set('transaction_type', $this->request->params['named']['transaction_type']);
		$this->set(compact('countries', 'user_profile', 'gateway_types','project_type','gateway_ids','gatewaygroup_ids'));
		
	}
}
?>