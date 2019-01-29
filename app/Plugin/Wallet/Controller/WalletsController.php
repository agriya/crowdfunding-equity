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
class WalletsController extends AppController
{
    public $permanentCacheAction = array(
        'user' => array(
            'add_to_wallet',
        ) ,
    );
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
	    'Payment.connect',
            'Payment.wallet',
            'Payment.standard_connect',
            'UserAddWalletAmount.normal',
            'UserAddWalletAmount.wallet',
            'UserAddWalletAmount.payment_gateway_id',
            'UserAddWalletAmount.sudopay_gateway_id',
            'Sudopay'
        );
        parent::beforeFilter();
	if($this->RequestHandler->prefers('json') && ($this->request->params['action'] == 'add_to_wallet')) {
            $this->Security->validatePost = false;
        }
    }
    public function add_to_wallet()
    {
        $this->loadModel('User');
        $this->pageTitle = sprintf(__l('Add %s') , __l('Amount to Wallet'));
	if ($this->RequestHandler->prefers('json') && ($this->request->is('post'))){
	    //UserAddWalletAmount
	    $this->request->data['normal'] = 'Pay Now';
            $this->request->data['UserAddWalletAmount']['amount'] = $this->request->data['amount'];
	    $this->request->data['UserAddWalletAmount']['payment_gateway_id']= $this->request->data['payment_gateway_id'];
	    $this->request->data['UserAddWalletAmount']['normal'] = $this->request->data['normal'];		
	    //Sudopay 	
	    $this->request->data['Sudopay']['buyer_email'] = $this->request->data['buyer_email'];  
	    $this->request->data['Sudopay']['buyer_address'] = !empty($this->request->data['buyer_address']) ? $this->request->data['buyer_address'] : '';
	    $this->request->data['Sudopay']['buyer_city'] = !empty($this->request->data['buyer_city']) ? $this->request->data['buyer_city'] : '';
	    $this->request->data['Sudopay']['buyer_state'] = !empty($this->request->data['buyer_state']) ? $this->request->data['buyer_state'] : '';
	    $this->request->data['Sudopay']['buyer_country'] = !empty($this->request->data['buyer_country']) ? $this->request->data['buyer_country'] : '';
	    $this->request->data['Sudopay']['buyer_zip_code'] = !empty($this->request->data['buyer_zip_code']) ? $this->request->data['buyer_zip_code'] : '';
	    $this->request->data['Sudopay']['buyer_phone'] = !empty($this->request->data['buyer_phone']) ? $this->request->data['buyer_phone'] : '';
	    $this->request->data['Sudopay']['credit_card_number'] = !empty($this->request->data['credit_card_number']) ? $this->request->data['credit_card_number'] : '';
	    $this->request->data['Sudopay']['credit_card_expire'] = !empty($this->request->data['credit_card_expire']) ? $this->request->data['credit_card_expire'] : '';
	    $this->request->data['Sudopay']['credit_card_name_on_card'] = !empty($this->request->data['credit_card_name_on_card']) ? $this->request->data['credit_card_name_on_card'] : '';
	    $this->request->data['Sudopay']['credit_card_code'] = !empty($this->request->data['credit_card_code']) ? $this->request->data['credit_card_code'] : '';
	    $this->request->data['Sudopay']['payment_note'] = !empty($this->request->data['payment_note']) ? $this->request->data['payment_note'] : '';
			  
        }
	
        if (!empty($this->request->data)) {
            $this->User->UserAddWalletAmount->create();
            if (empty($this->request->data['UserAddWalletAmount']['payment_gateway_id'])) {
                $this->Session->setFlash(__l('Please select payment type') , 'default', null, 'error');
		$this->set('iphone_response', array("message" =>__l('Please select payment type') , "error" => 1));
            } else {
                $this->request->data['UserAddWalletAmount']['sudopay_gateway_id'] = 0;
		if ($this->request->data['UserAddWalletAmount']['payment_gateway_id'] != ConstPaymentGateways::Wallet && strpos($this->request->data['UserAddWalletAmount']['payment_gateway_id'], 'sp_') >= 0) {
                    $PaymentGateway['PaymentGateway']['id'] = ConstPaymentGateways::SudoPay;
                    $this->request->data['UserAddWalletAmount']['sudopay_gateway_id'] = str_replace('sp_', '', $this->request->data['UserAddWalletAmount']['payment_gateway_id']);
                    $this->request->data['UserAddWalletAmount']['payment_gateway_id'] = ConstPaymentGateways::SudoPay;
                }
                $this->request->data['UserAddWalletAmount']['user_id'] = $this->Auth->user('id');
                App::uses('PaymentGateway', 'Model');
                $this->PaymentGateway = new PaymentGateway();
                $PaymentGateway = $this->PaymentGateway->find('first', array(
                    'conditions' => array(
                        'PaymentGateway.id' => $this->request->data['UserAddWalletAmount']['payment_gateway_id']
                    ) ,
                    'recursive' => -1
                ));
                if ($this->User->UserAddWalletAmount->save($this->request->data)) {
                    if ($PaymentGateway['PaymentGateway']['id'] == ConstPaymentGateways::SudoPay && isPluginEnabled('Sudopay')) {
                        $this->loadModel('Sudopay.Sudopay');
                        $this->Sudopay = new Sudopay();
                        $sudopay_gateway_settings = $this->Sudopay->GetSudoPayGatewaySettings();
                        $this->set('sudopay_gateway_settings', $sudopay_gateway_settings);
                        if ($sudopay_gateway_settings['is_payment_via_api'] == ConstBrandType::VisibleBranding) {
                            $sudopay_data = $this->Sudopay->getSudoPayPostData($this->User->UserAddWalletAmount->id, ConstPaymentType::Wallet);
                            $sudopay_data['merchant_id'] = $sudopay_gateway_settings['sudopay_merchant_id'];
                            $sudopay_data['website_id'] = $sudopay_gateway_settings['sudopay_website_id'];
                            $sudopay_data['secret_string'] = $sudopay_gateway_settings['sudopay_secret_string'];
                            $sudopay_data['action'] = 'capture';
                            $this->set('sudopay_data', $sudopay_data);
                        } else {
                            $this->request->data['Sudopay'] = !empty($this->request->data['Sudopay']) ? $this->request->data['Sudopay'] : '';
			    
			    if ($this->RequestHandler->prefers('json')) 
			    {
				$call_back_url = $this->Sudopay->processPayment($this->User->UserAddWalletAmount->id, ConstPaymentType::Wallet, $this->request->data['Sudopay'], 'json');
				$this->set('iphone_response', array("message" => $call_back_url, "error" => 0));
				
				if(!is_array($call_back_url)){
				      $this->set('iphone_response', array("message" => $call_back_url, "error" => 0));
				}else{
				      $return = $call_back_url;
				}
			    }else
			    {
				$return = $this->Sudopay->processPayment($this->User->UserAddWalletAmount->id, ConstPaymentType::Wallet, $this->request->data['Sudopay']);
			    }
                        }
                    }
		    $redirect = 0;
                    if (!empty($return['pending'])) {
			$this->set('iphone_response', array("message" =>__l('Your payment is in pending.') , "error" => 0));
                        $this->Session->setFlash(__l('Your payment is in pending.') , 'default', null, 'success');
			$redirect = 1;
                    } elseif (!empty($return['success'])) {
                        $this->Wallet->processAddtoWallet($this->User->UserAddWalletAmount->id, ConstPaymentGateways::SudoPay);
                        $this->Session->setFlash(__l('Your payment processed successfully. The amount will add to your wallet shortly.') , 'default', null, 'success');
			$this->set('iphone_response', array("message" =>__l('Your payment processed successfully. The amount will add to your wallet shortly.') , "error" => 0));
			$redirect = 1;
                    } elseif (!empty($return['error'])) {
                        $return['error_message'].= '. ';
                        $this->Session->setFlash($return['error_message'] . __l('Your payment could not be completed.') , 'default', null, 'error');
			$this->set('iphone_response', array("message" => $return['error_message'] . __l('Your payment could not be completed.'), "error" => 1));
                    }
		    if (!$this->RequestHandler->prefers('json')) {
			if (!empty($redirect)) {
			    $this->redirect(array(
				'controller' => 'wallets',
				'action' => 'add_to_wallet'
			    ));
			}
		    }
                } else {
		    $validationErrors = array();
		    $validationErrors = $this->User->UserAddWalletAmount->validationErrors;
		    if(!empty($validationErrors) && !empty($validationErrors[amount])) {
			$errorMsg = $validationErrors[amount][0];
		    }
		    $this->request->data['Sudopay']['credit_card_number'] = '';
		    $this->request->data['Sudopay']['credit_card_expire'] = '';
		    $this->request->data['Sudopay']['credit_card_name_on_card'] = '';
		    $this->request->data['Sudopay']['credit_card_code'] =  '';
		    $this->request->data['Sudopay']['payment_note'] = '';
                    $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Amount')) , 'default', null, 'error');
		    $this->set('iphone_response', array("message" => sprintf(__l('%s. %s could not be added. Please, try again.') , $errorMsg, __l('Amount')), "error" => 1));
                }
            }
        } else {
		$this->request->data['UserAddWalletAmount']['amount'] = '';
		$this->User->UserAddWalletAmount->set($this->request->data);
	}
        $user_info = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'fields' => array(
                'User.id',
                'User.username',
                'User.available_wallet_amount',
            ) ,
            'recursive' => -1
        ));
        $this->request->data['User']['type'] = 'user';
        $this->set('user_info', $user_info);
	if ($this->RequestHandler->prefers('json')) {
            $response = Cms::dispatchEvent('Controller.Wallet.Add', $this);
        }
    }
}
?>