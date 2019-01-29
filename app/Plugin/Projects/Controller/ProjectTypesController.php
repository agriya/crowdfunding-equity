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
class ProjectTypesController extends AppController
{
    public $name = 'ProjectTypes';
    public $helpers = array(
        'Projects.Cakeform'
    );
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'ProjectType',
            'FormField',
            'Attachment',
        );
        parent::beforeFilter();
    }
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'q',
            'type'
        ));
        $conditions = array();
        if (!isPluginEnabled('Pledge')) {
            $conditions[] = array(
                'NOT' => array(
                    'ProjectType.id' => ConstProjectTypes::Pledge
                )
            );
        }
        if (!isPluginEnabled('Donate')) {
            $conditions[] = array(
                'NOT' => array(
                    'ProjectType.id' => ConstProjectTypes::Donate
                )
            );
        }
        if (!isPluginEnabled('Lend')) {
            $conditions[] = array(
                'NOT' => array(
                    'ProjectType.id' => ConstProjectTypes::Lend
                )
            );
        }
        if (!isPluginEnabled('Equity')) {
            $conditions[] = array(
                'NOT' => array(
                    'ProjectType.id' => ConstProjectTypes::Equity
                )
            );
        }
        $this->pageTitle = sprintf(__l('%s Types') , Configure::read('project.alt_name_for_project_singular_caps'));
        if (!empty($this->request->params['named']['q'])) {
            $conditions[] = array(
                'OR' => array(
                    array(
                        'ProjectType.name LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                )
            );
            $this->request->data['ProjectType']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'ProjectType.id' => 'desc'
            )
        );
        $projectTypes = $this->paginate();
        $this->set('ProjectTypes', $projectTypes);
        $moreActions = $this->ProjectType->moreActions;
        $this->set('moreActions', $moreActions);
    }
    public function admin_edit($id = null)
    {
        App::import('Model', 'Projects.ProjectType');
        $this->ProjectType = new ProjectType();
        $projectType = $this->ProjectType->find('first', array(
            'conditions' => array(
                'ProjectType.id' => $id
            ) ,
            'recursive' => -1
        ));
        if (empty($projectType)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->set('projectType', $projectType);
        $this->pageTitle = sprintf(__l('%s Type') , Configure::read('project.alt_name_for_project_singular_caps')) . ' - ' . $projectType['ProjectType']['name'] . ' - ' . __l('Form Fields');
        $this->disableCache();
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(sprintf(__l('Invalid %s') , sprintf(__l('%s Type') , Configure::read('project.alt_name_for_project_singular_caps'))) , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        if (!empty($this->request->data)) {
            $error = 0;
            if (!empty($this->request->data['FormField'])) {
                $error_str = '';
                foreach($this->request->data['FormField'] as $formFields) {
                    if (!empty($formFields['FormField']['is_dynamic_field'])) {
                        $multiSelectArray = $this->ProjectType->FormField->multiTypes;
                        if (in_array($formFields['type'], $multiSelectArray)) {
                            if (empty($formFields['options'])) {
                                $error = 1;
                            } else if ($formFields['type'] == 'slider') {
                                $options_val = explode(',', $formFields['options']);
                                if (count($options_val) != 2) {
                                    $error = 1;
                                    $error_str = 'slider';
                                }
                            }
                        }
                    }
                }
            }
            if (!$error) {
                if ($this->ProjectType->save($this->request->data['ProjectType'])) {
                    if (!empty($this->request->data['FormField'])) {
                        foreach($this->request->data['FormField'] as $formField) {
                            if (!empty($formField['options'])) {
                                $formField['options'] = rtrim($formField['options'], ",");
                            }
                            $_data = array();
                            $_data['FormField'] = $formField;
                            $this->ProjectType->FormField->save($_data);
                        }
                    }
                    $this->Session->setFlash(sprintf(__l('%s has been updated') , sprintf(__l('%s Type') , Configure::read('project.alt_name_for_project_singular_caps'))) , 'default', null, 'success');
                    $this->redirect(array(
                        'action' => 'edit',
                        $id
                    ));
                } else {
                    $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.') , sprintf(__l('%s Type') , Configure::read('project.alt_name_for_project_singular_caps'))) , 'default', null, 'error');
                }
            } else if (empty($error_str)) {
                $this->Session->setFlash(sprintf(__l('%s Type could not be saved. Please enter all option values needed.') , Configure::read('project.alt_name_for_project_singular_caps')) , 'default', null, 'error');
            } else if (!empty($error_str) == 'slider') {
                $this->Session->setFlash(sprintf(__l('%s Type could not be saved. Please enter exactly 2 options for slider control.') , Configure::read('project.alt_name_for_project_singular_caps')) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->ProjectType->find('first', array(
                'conditions' => array(
                    'ProjectType.id' => $id
                ) ,
                'contain' => array(
                    'FormField'
                ) ,
                'recursive' => 0
            ));
            $this->request->data['ProjectType']['id'] = $id;
        }
        if (!empty($this->request->data['ProjectType']['id'])) {
            $id = $this->request->data['ProjectType']['id'];
        }
        $this->loadModel('Projects.FormFieldStep');
        $FormFieldSteps = $this->FormFieldStep->find('all', array(
            'conditions' => array(
                'FormFieldStep.project_type_id' => $id
            ) ,
            'contain' => array(
                'FormFieldGroup' => array(
                    'FormField' => array(
                        'order' => array(
                            'FormField.order' => 'ASC'
                        )
                    ) ,
                    'order' => array(
                        'FormFieldGroup.order' => 'ASC'
                    )
                )
            ) ,
            'order' => array(
                'FormFieldStep.order' => 'ASC'
            ) ,
            'recursive' => 2
        ));
        $multiTypes = $this->ProjectType->FormField->multiTypes;
        $types = $this->ProjectType->FormField->types;
        $this->set(compact('types', 'multiTypes', 'FormFieldSteps'));
    }
    public function admin_pricing($id = null)
    {
        if (!empty($this->request->data['ProjectType'])) {
            $id = $this->request->data['ProjectType']['id'];
        }
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $projectType = $this->ProjectType->find('first', array(
            'conditions' => array(
                'ProjectType.id' => $id
            ) ,
            'recursive' => -1
        ));
        if (empty($projectType)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->set('projectType', $projectType);
        if (!empty($this->request->data['ProjectType'])) {
            $this->ProjectType->save($this->request->data);
            $this->Session->setFlash(sprintf(__l('%s type pricing has been updated') , Configure::read('project.alt_name_for_project_singular_caps')) , 'default', null, 'success');
        }
        if (empty($this->request->data['ProjectType'])) {
            $this->request->data['ProjectType'] = $projectType['ProjectType'];
            if (empty($projectType['ProjectType']['commission_percentage'])) {
                $this->request->data['ProjectType']['commission_percentage'] = Configure::read('Project.fund_commission_percentage');
                $this->request->data['ProjectType']['listing_fee'] = Configure::read('Project.listing_fee');
                $this->request->data['ProjectType']['listing_fee_type'] = (Configure::read('Project.project_listing_fee_type') == 'amount') ? ConstListingFeeType::amount : ConstListingFeeType::percentage;
            }
            $this->request->data['ProjectType']['id'] = $projectType['ProjectType']['id'];
        }
        $this->pageTitle = sprintf(__l('%s Type') , Configure::read('project.alt_name_for_project_singular_caps')) . ' - ' . $projectType['ProjectType']['name'] . ' - ' . __l('Pricing');
        $listingFeeTypes = array(
            ConstListingFeeType::amount => "amount",
            ConstListingFeeType::percentage => "percentage"
        );
        $this->set(compact('listingFeeTypes'));
    }
    public function admin_preview($id = null, $form_field_step = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $projectType = $this->ProjectType->find('first', array(
            'conditions' => array(
                'ProjectType.id' => $id
            ) ,
            'recursive' => -1
        ));
        if (empty($projectType)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->set('projectType', $projectType);
        $this->loadModel('Projects.Form');
        $this->loadModel('Projects.FormField');
        $this->loadModel('Projects.Project');
        unset($this->Form->validate);
        unset($this->FormField->validate);
        unset($this->Project->validate);
        $projectTypeFormFields = $this->Form->buildSchema($projectType['ProjectType']['id']);
        if (empty($this->request->data[$projectType['ProjectType']['name']]['project_end_date'])) {
            $date = strtotime(date('Y-m-d', strtotime(date('Y-m-d'))) . ' + ' . Configure::read('maximum_project_expiry_day') . ' days');
            $this->request->data[$projectType['ProjectType']['name']]['project_end_date'] = date('Y-m-d', $date);
        }
        $this->loadModel('Projects.FormFieldStep');
        $FormFieldSteps = $this->FormFieldStep->find('all', array(
            'conditions' => array(
                'FormFieldStep.project_type_id' => $projectType['ProjectType']['id']
            ) ,
            'contain' => array(
                'FormFieldGroup' => array(
                    'FormField' => array(
                        'conditions' => array(
                            'FormField.is_active' => 1
                        ) ,
                        'order' => array(
                            'FormField.order' => 'ASC'
                        )
                    ) ,
                    'order' => array(
                        'FormFieldGroup.order' => 'ASC'
                    )
                )
            ) ,
            'order' => array(
                'FormFieldStep.order' => 'ASC'
            ) ,
            'recursive' => 2
        ));
        $this->set('FormFieldSteps', $FormFieldSteps);
        $this->set('total_form_field_steps', count($FormFieldSteps));
        $this->set('projectTypeFormFields', $projectTypeFormFields);
        $this->set('projectType', $projectType);
        $is_disable_pledge_type_amount = 1;
        $pledgeTypes[ConstPledgeTypes::Any] = 'Any';
        if (Configure::read('Project.is_pledge_minimum_amount_enabled') && ($this->Auth->user('role_id') == ConstUserTypes::Admin || Configure::read('Project.is_allow_user_to_set_minimum_amount_pledge'))) {
            $pledgeTypes[ConstPledgeTypes::Minimum] = 'Minimum';
        }
        if (Configure::read('Project.is_suggested_pledge_enabled') && ($this->Auth->user('role_id') == ConstUserTypes::Admin || Configure::read('Project.is_allow_user_to_set_suggested_pledge'))) {
            $pledgeTypes[ConstPledgeTypes::Reward] = 'Reward';
        }
        if (Configure::read('Project.is_multiple_amount_pledge_enabled') && ($this->Auth->user('role_id') == ConstUserTypes::Admin || Configure::read('Project.is_allow_user_to_set_multiple_amount_pledge'))) {
            $pledgeTypes[ConstPledgeTypes::Multiple] = 'Multiple';
        }
        if (Configure::read('Project.is_fixed_amount_pledge_enabled') && ($this->Auth->user('role_id') == ConstUserTypes::Admin || Configure::read('Project.is_allow_user_to_set_fixed_amount_pledge'))) {
            $pledgeTypes[ConstPledgeTypes::Fixed] = 'Fixed';
        }
        if (count($pledgeTypes) > 1) {
            $is_disable_pledge_type_amount = 0;
        }
        $this->set(compact('pledgeTypes'));
        $this->set('is_disable_pledge_type_amount', $is_disable_pledge_type_amount);
        $projectTypeName = ucwords($projectType['ProjectType']['name']);
        App::import('Model', $projectTypeName . '.' . $projectTypeName);
        $model = new $projectTypeName();
        $response = $model->onProjectCategories();
        $this->set($projectType['ProjectType']['slug'] . 'Categories', $response[$projectType['ProjectType']['slug'] . 'Categories']);
        unset($this->Project->
        {
            $projectType['ProjectType']['name']}->validate);
            if (isPluginEnabled('ProjectRewards')) {
                $this->loadModel('ProjectRewards.ProjectReward');
                unset($this->ProjectReward->validate);
            }
            $paymentMethods = array(
                ConstPaymentMethod::AoN => 'Fixed Funding',
                ConstPaymentMethod::KiA => 'Flexible Funding'
            );
            if (empty($this->request->data['Project']['payment_method_id'])) {
                $this->request->data['Project']['payment_method_id'] = (Configure::read('Project.project_fund_capture') == 'Fixed Funding') ? ConstPaymentMethod::AoN : ConstPaymentMethod::KiA;
            }
            $this->loadModel('Country');
            $countries = $this->Country->find('list', array(
                'fields' => array(
                    'Country.iso_alpha2',
                    'Country.name'
                )
            ));
            $this->set(compact('paymentMethods', 'countries'));
            $this->pageTitle = sprintf(__l('%s Type') , Configure::read('project.alt_name_for_project_singular_caps')) . ' - ' . $projectType['ProjectType']['name'] . ' - ' . __l('Preview');
            if (empty($this->request->data['Form']['form_field_step'])) {
                $this->request->data['Form']['form_field_step'] = 1;
            }
            if (!empty($this->request->data['Form']['next'])) {
                $this->request->data['Form']['form_field_step'] = $this->request->data['Form']['form_field_step']+1;
            }
            // form field steps
            if (!empty($form_field_step)) {
                $this->request->data['Form']['form_field_step'] = $form_field_step;
                $this->request->data['Form']['step'] = 2;
            }
        }
    }
?>