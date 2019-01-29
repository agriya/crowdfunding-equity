<?php
class CakeformHelper extends AppHelper
{
    public $helpers = array(
        'Html',
        'Form'
    );
    /**
     * used in generating form fieldsets
     *
     * @access public
     */
    public $openFieldset = false;
    /**
     * Generates form HTMl
     *
     * @param array $formData
     *
     * @return string Form Html
     * @access public
     */
    function insert($formData) 
    {
        $out = '';
        if (isset($formData['FormField'])) {
            $j = 1;
            foreach($formData['FormField'] as $field) {
                if (!empty($field['is_dynamic_field'])) {
                    $field['name'] = 'Form.' . $field['name'];
                } else {
                    $field['name'] = $field['name'];
                }
                if (!empty($field['display']) && empty($field['is_reward'])) {
                    if ($field['type'] == 'url' || $field['type'] == 'video') {
                        $field['type'] = 'text';
                        $field['class'] = 'js-remove-error';
                    }
                    $out.= $this->_field($field);
                    if (!empty($field['Attachment'])) {
                        $out.= "<div class='offset5'><div class='pull-left'>" . $this->Html->cText($field['Attachment']['filename']) . '</div><div class="pull-left left-mspace"><p class="delete-block"><i class="fa fa-times fa-fw"></i> ' . $this->Html->link(__l('Delete') , array(
                            'action' => 'delete_attachment',
                            $this->request->data['Project']['id'],
                            $this->request->data['Project']['project_type_id'],
                            $field['Attachment']['id'],
                            $field['Attachment']['foreign_id'],
                            $this->request->params['action'],
                            $this->request->data['Project']['form_field_step'],
                            'admin' => false
                        ) , array(
                            'class' => 'js-confirm delete',
                            'escape' => false
                        )) . '</p></div></div>';
                    }
                } else {
                    if (!empty($field['is_reward'])) {
                      //  if ($j == 1) {
                            $class = '';
                            if (!Configure::read('Project.is_project_reward_optional')):
                                $class = 'required';
                            endif;
							if ($j == 1) {
								$out.= '<div class="js-clone">';
								$out.= '<div class="clearfix add-block pull-right cur"><span class ="js-add-more js-no-pjax btn btn-default clone-add "><i class="fa fa-plus-circle"></i> ' . __l("Add More") . '</span></div>';
							}
                            if (empty($this->request->data['ProjectReward'])) {
                                if (!empty($field['reward'])) {
									$out.= '<div class="website-block js-field-list reward-block clearfix">'; 
									$out.= '<div class=" ' . $class . '">';
									// js-reward-input removed because while clone  after input comes 0.
									$out.= $this->Form->input('ProjectReward.0.pledge_amount', array(
										'label' => sprintf(__l('%s amount') , Configure::read('project.alt_name_for_pledge_singular_caps')) . ' (' . Configure::read('site.currency') . ')',
										'info' => sprintf(__l('%s amount') , Configure::read('project.alt_name_for_reward_singular_caps')) ,
										'class' => 'js-no-pjax'
									));
									$out.= '</div>';
									$out.= '<div class=" ' . $class . '">';
									$out.= $this->Form->input('ProjectReward.0.reward', array(
										'info' => sprintf(__l('%s description') , Configure::read('project.alt_name_for_reward_singular_caps')) ,
										'class' => 'js-remove-error'
									));
									$out.= '</div>';
									// js-reward-input removed because while clone  after input comes 0.
									$out.= $this->Form->input('ProjectReward.0.pledge_max_user_limit', array(
										'label' => sprintf(__l('%s max user limit') , Configure::read('project.alt_name_for_pledge_singular_caps')) ,
										'info' => sprintf(__l('Maximum user allowed for this %s. Leave blank for no limit.') , Configure::read('project.alt_name_for_reward_singular_small')) ,
										'class' => 'js-no-pjax'
									));
								}
								if (!empty($field['is_shipping'])) {
									$out.= $this->Form->input('ProjectReward.0.is_shipping', array(
										'type' => 'checkbox',
										'onclick' => 'js_shipping_click(this.id,"ProjectReward0estimated_delivery_date")',
										'label' => __l('Shipping')
									));
								}
								if (!empty($field['estimated_delivery_date'])) {
									$out.= '<div id="ProjectReward0estimated_delivery_date" class="hide js-div-index">';
									$out.= $this->Form->input('ProjectReward.0.estimated_delivery_date', array(
										'class' => 'js-remove-error',
										'label' => __l('Estimated delivery date') ,
										'type' => 'date',
										'div' => true,
										'orderYear' => 'asc',
										'minYear' => date('Y') ,
									));
									$out.= '</div>';
								}
								if (!empty($field['is_having_additional_info'])) {
									$out.= $this->Form->input('ProjectReward.0.is_having_additional_info', array(
										'type' => 'checkbox',
										'onclick' => 'js_additional_info(this.id,"ProjectReward0additional_info_label")',
										'label' => __l('Additional Information')
									));
								}
								if (!empty($field['additional_info_label'])) {
									$out.= '<div id="ProjectReward0additional_info_label" class="hide js-div-index">';
									$out.= $this->Form->input('ProjectReward.0.additional_info_label', array(
										'type' => 'text',
										'label' => __l('Additional Information') ,
										'info' => __l("An input field will be generated in funding page to get information from the funders in the given name.")
									));
									$out.= '</div>';
								}
                            } else {
                                if($j == 1) {
									$i = 0;
									foreach($this->request->data['ProjectReward'] as $key => $projectReward) {
										$reward = '';
										if ($i != 0) {
											$reward = ' reward-clone ';
										}
										$out.= '<div class="reward-block clearfix js-field-list js-new-clone-' . $i . $reward . '">';
										if ($key) {
											$out.= '<span class="js-website-remove js-no-pjax btn btn-default clone-remove pull-right cur"><i class="fa fa-times"></i>' . __l('Remove') . '</span>';
										}
										$out.= $this->Form->input('ProjectReward.' . $key . '.id', array(
											'type' => 'hidden'
										));
										$out.= $this->Form->input('ProjectReward.' . $key . '.pledge_amount', array(
											'label' => sprintf(__l('%s amount') , Configure::read('project.alt_name_for_pledge_singular_caps')) . ' (' . Configure::read('site.currency') . ')',
											'info' => sprintf(__l('%s amount') , Configure::read('project.alt_name_for_reward_singular_caps')) ,
											'class' => 'js-no-pjax'
										));
										$out.= $this->Form->input('ProjectReward.' . $key . '.reward', array(
											'info' => sprintf(__l('%s description') , Configure::read('project.alt_name_for_reward_singular_caps')) ,
											'class' => 'js-remove-error'
										));
										$out.= $this->Form->input('ProjectReward.' . $key . '.pledge_max_user_limit', array(
											'label' => sprintf(__l('%s max user limit') , Configure::read('project.alt_name_for_pledge_singular_caps')) ,
											'info' => sprintf(__l('Maximum user allowed for this %s. Leave blank for no limit.') , Configure::read('project.alt_name_for_reward_singular_small')) ,
											'class' => 'js-no-pjax'
										));
										$out.= $this->Form->input('ProjectReward.' . $key . '.is_shipping', array(
											'type' => 'checkbox',
											'onclick' => 'js_shipping_click(this.id,"ProjectReward.' . $key . '.estimated_delivery_date")',
											'label' => __l('Shipping')
										));
										if ($projectReward['is_shipping']) {
											$out.= '<div id="ProjectReward' . $key . 'estimated_delivery_date" class="js-div-index">';
										} else {
											$out.= '<div id="ProjectReward' . $key . 'estimated_delivery_date" class="hide js-div-index">';
										}
										$out.= $this->Form->input('ProjectReward.' . $key . '.estimated_delivery_date', array(
											'class' => 'js-remove-error',
											'label' => __l('Estimated delivery date') ,
											'type' => 'date',
											'div' => true,
											'orderYear' => 'asc'
										));
										$out.= '</div>';
										$out.= $this->Form->input('ProjectReward.' . $key . '.is_having_additional_info', array(
											'class' => 'js-remove-error',
											'type' => 'checkbox',
											'onclick' => 'js_additional_info(this.id,"ProjectReward' . $key . 'additional_info_label")',
											'label' => __l('Additional Information') ,
											'info' => __l("An input field will be generated in funding page to get information from the funders in the given name.")
										));
										if ($projectReward['is_having_additional_info']) {
											$out.= '<div id="ProjectReward' . $key . 'additional_info_label" class="js-div-index">';
										} else {
											$out.= '<div id="ProjectReward' . $key . 'additional_info_label" class="hide js-div-index">';
										}
										$out.= $this->Form->input('ProjectReward.' . $key . '.additional_info_label', array(
											'class' => 'js-remove-error',
											'type' => 'text',
											'label' => __l('Additional Information Label') ,
											'info' => __l("An input field will be generated in funding page to get information from the funders in the given name.")
										));
										$out.= '</div>';
										$out.= '</div>';
										$i++;
									}
								}
                            }
							if (!empty($field['is_reward_end'])) {
								$out.= '</div>';
							}
                            $j++;
                       // }
                    }
                }
            }
            if ($this->openFieldset == true) {
                $out.= '</fieldset>';
            }
        }
        return $this->output($out);
    }
    /**
     * Generates appropriate html per field
     *
     * @param array $field Field to process
     * @parram array $custom_options Custom $this->Forminput options for field
     *
     * @return string field html
     * @access public
     */
    function _field($field, $custom_options = array()) 
    {
        $required = '';
        if ($field['required'] == 1) {
            $required = 'required';
        }
        $options = array();
        $out = '';
        if (!empty($field['type'])) {
            $class = '';
            if (empty($this->request->data['UserProfile']['address']) and empty($this->request->data['Project']['address'])) {
                $class = 'hide';
            }
            if (!empty($field['name'])) {
                if ($field['name'] == 'Project.name') {
                    $options['class'] = "js-preview-keyup js-no-pjax {'display':'js-name'}";
                }
                if ($field['name'] == 'Project.needed_amount') {
                    $options['info'] = sprintf(__l('Minimum Amount: %s%s <br/> Maximum Amount: %s') , Configure::read('site.currency') , $this->Html->cCurrency(Configure::read('Project.minimum_amount')) , Configure::read('site.currency') . $this->Html->cCurrency(Configure::read('Project.maximum_amount')));
                }
                if ($field['name'] == 'Pledge.is_allow_over_funding') {
                    if ($_SESSION['Auth']['User']['role_id'] != ConstUserTypes::Admin && !Configure::read('Project.is_allow_user_to_set_overfunding')) {
                        return;
                    }
                }
                if ($field['name'] == 'Project.project_end_date') {
                    $options['info'] = sprintf(__l('Ending date should be within %s days from today.') , Configure::read('maximum_project_expiry_day'));
                }
                if ($field['name'] == 'Project.country_id' || $field['name'] == 'State.name') {
                    $options['class'] = 'location-input';
                }
                if ($field['name'] == 'Project.address') {
                    $out.= '<div class="profile-block clearfix"><div class="mapblock-info mapblock-info1"><div class="clearfix address-input-block required col-md-9 no-pad">';
                    $options['class'] = 'js-preview-address-change';
                    $options['id'] = 'ProjectAddressSearch';
                }
                if ($field['name'] == 'Pledge.min_amount_to_fund' || $field['name'] == 'Donate.min_amount_to_fund') {
                    $out.= '<div class="js-min-amount hide">';
                    $options['class'] = 'js-min-amount-needed';
                }
                if ($field['name'] == 'Pledge.pledge_type_id' || $field['name'] == 'Donate.pledge_type_id') {
                    $options['class'] = 'js-pledge-type';
                }
                if ($field['name'] == 'Attachment.filename') {
                    if (!empty($this->request->data['Attachment']) && !empty($this->request->data['Project']['name'])) {
                        $options['class'] = 'browse-field js-remove-error';
                        $options['info'] = __l('Maximum allowed size ') . Configure::read('Project.image.allowedSize') . Configure::read('Project.image.allowedSizeUnits');
                        $options['size'] = 33;
                        $out.= '<div class="upload-image navbar-btn">';
                        $out.= $this->Html->showImage('Project', $this->request->data['Attachment'], array(
                            'dimension' => 'big_thumb',
                            'alt' => sprintf('[Image: %s]', $this->Html->cText($this->request->data['Project']['name'], false)) ,
                            'title' => $this->Html->cText($this->request->data['Project']['name'], false)
                        ));
                        $out.= '</div>';
                    }
                    $options['class'] = (!empty($options['class'])) ? $options['class'] : '';
                    $options['class'].= " {'UmimeType':'jpg,jpeg,png,gif', 'Uallowedsize':'5','UallowedMaxFiles':'1'}";
                }
                if ($field['name'] == 'Project.address1') {
                    $out.= '<div id="js-geo-fail-address-fill-block" class="' . $class . '"><div class="clearfix"><div class="map-address-left-block address-input-block">';
                    $options['class'] = 'js-preview-address-change';
                    $options['id'] = 'js-street_id';
                    $out.= '</div>';
                }
                if ($field['name'] == 'Project.description') {
                    $options['class'] = 'js-editor col-md-8 descblock {"is_html":"false"}';
                    $options['rows'] = false;
                    $options['cols'] = false;
                }
                if ($field['name'] == 'Pledge.is_allow_over_funding' || $field['name'] == 'Donate.is_allow_over_funding') {
                    $options['before'] = '<div>';
                    $options['after'] = '</div>';
                }
                if ($field['name'] == 'Project.country_id') {
                    $options['id'] = 'js-country_id';
                }
                if (!empty($field['class'])) {
                    $options['class'] = $field['class'];
                }
                if ($field['name'] == 'Project.feed_url') {
                    $options['class'] = 'js-remove-error';
                }
            }
            switch ($field['type']) {
                case 'fieldset':
                    if ($this->openFieldset == true) {
                        $out.= '</fieldset>';
                    }
                    $out.= '<fieldset>';
                    $this->openFieldset = true;
                    if (!empty($field['name'])) {
                        $out.= '<legend>' . Inflector::humanize($field['label']) . '</legend>';
                        $out.= $this->Form->hidden('fs_' . $field['name'], array(
                            'value' => $field['name']
                        ));
                    }
                    break;

                case 'textonly':
                    $out = $this->Html->para('textonly', __l($field['label']));
                    break;

                default:
                    $options['type'] = $field['type'];
                    $options['info'] = $field['info'];
                    if (in_array($field['type'], array(
                        'select',
                        'checkbox',
                        'radio'
                    ))) {
                        if (!empty($field['options']) && !is_array($field['options'])) {
                            $field['options'] = str_replace(', ', ',', $field['options']);
                            $field['options'] = $this->explode_escaped(',', $field['options']);
                        }
                        if ($field['type'] == 'checkbox') {
                            if (count($field['options']) > 1) {
                                $options['type'] = 'select';
                                $options['multiple'] = 'checkbox';
                                $options['options'] = $field['options'];
                            } else {
								if($field['name'] == 'Pledge.is_allow_over_funding' && isset($this->request->data['Pledge']) && $this->request->data['Pledge']['is_allow_over_funding'] == 1)
								{
									$this->request->data['Pledge']['is_allow_over_funding'] = $field['name'];
								}
								if($field['name'] == 'Donate.is_allow_over_donating' && isset($this->request->data['Pledge']) && $this->request->data['Donate']['is_allow_over_donating'] == 1)
								{
									$this->request->data['Donate']['is_allow_over_donating'] = $field['name'];
								}
                                $options['value'] = $field['name'];
                            }
                        } else {
                            $options['options'] = $field['options'];
                        }
                        if ($field['type'] == 'select' && !empty($field['multiple']) && $field['multiple'] == 'multiple') {
                            $options['multiple'] = 'multiple';
                        } elseif ($field['type'] == 'select') {
                            $options['empty'] = __l('Please Select');
                        }
                    }
                    if (!empty($field['depends_on']) && !empty($field['depends_value'])) {
                        $options['class'] = 'dependent';
                        $options['dependsOn'] = $field['depends_on'];
                        $options['dependsValue'] = $field['depends_value'];
                    }
                    $options['info'] = str_replace("##MULTIPLE_AMOUNT##", Configure::read('equity.amount_per_share') , $options['info']);
                    $options['info'] = str_replace("##SITE_CURRENCY##", Configure::read('site.currency') , $options['info']);
                    $field['label'] = str_replace("##SITE_CURRENCY##", Configure::read('site.currency') , $field['label']);
                    if (!empty($field['label'])) {
                        $options['label'] = __l($field['label']);
                        if ($field['type'] == 'radio') {
                            $options['legend'] = __l($field['label']);
                        }
                    }
                    if ($field['type'] == 'file') {
                        if ($field['name'] != 'Attachment.filename') {
								$options['class'] = 'upload';
                            $options['class'] = (!empty($options['class'])) ? $options['class'] : '';
                            $options['class'].= " {'UmimeType':'*', 'Uallowedsize':'5','UallowedMaxFiles':'1'}";
                        }
                    }
                    if ($field['type'] == 'radio') {
                        $options['div'] = true;
                        $options['legend'] = false;
                        $options['multiple'] = 'radio';
                    }
                    if ($field['type'] == 'slider') {
                        for ($num = 1; $num <= 100; $num++) {
                            $num_array[$num] = $num;
                        }
                        $options['div'] = 'input select slider-input-select-block clearfix' . ' ' . $required;
                        $options['options'] = $num_array;
                        $options['type'] = 'select';
                        $options['class'] = 'js-uislider';
                        $options['label'] = false;
                        $i = 0;
                        if (!empty($field['options'])) {
                            foreach($field['options'] as $value) {
                                if ($i == 0) {
                                    $options['before'] = '<div class="clearfix"><span class="grid_left uislider-inner">' . $value . '</span>';
                                } else {
                                    $options['after'] = '<span class="grid_left uislider-right">' . $value . '</span></div>';
                                }
                                $i++;
                            }
                        }
                        $out.= $this->Html->div('label-block slider-label ' . $required, $field['label']);
                    }
                    if ($field['type'] == 'date') {
                        $options['div'] = $required;
                        $options['orderYear'] = 'asc';
                        $options['minYear'] = date('Y') -10;
                        $options['maxYear'] = date('Y') +10;
                    }
                    if ($field['type'] == 'datetime') {
                        $options['div'] = 'clearfix';
                        $options['div'] = 'input text ' . ' ' . $required;
                        $options['orderYear'] = 'asc';
                        $options['minYear'] = date('Y') -10;
                        $options['maxYear'] = date('Y') +10;
                    }
                    if ($field['type'] == 'time') {
                        $options['div'] = 'clearfix';
                        $options['div'] = 'input text js-time' . ' ' . $required;
                        $options['orderYear'] = 'asc';
                        $options['timeFormat'] = 12;
                        $options['type'] = 'time';
                    }
                    if ($field['type'] == 'color') {
                        $options['div'] = 'input text clearfix' . ' ' . $required;
                        $options['class'] = 'js-colorpick';
                        if (!empty($field['info'])) {
                            $info = $field['info'] . ' <br>Comma separated RGB hex code. You can use color picker.';
                        } else {
                            $info = 'Comma separated RGB hex code. You can use color picker.';
                        }
                        $options['info'] = __l($info);
                        $options['type'] = 'text';
                    }
                    if ($field['type'] == 'thumbnail') {
                        $options['div'] = 'clearfix';
                        $options['div'] = 'input text' . ' ' . $required;
                    }
                    if (!empty($field['default']) && empty($this->data['Form'][$field['name']])) {
                        $options['value'] = $field['default'];
                    }
                    if ($field['type'] == 'text') {
                        $options['div'] = 'clearfix';
                        $options['div'] = 'input text' . ' ' . $required;
                    }
                    if ($field['type'] == 'textarea') {
                        $options['div'] = 'clearfix';
                        $options['div'] = 'input textarea' . ' ' . $required;
                    }
                    if ($field['type'] == 'select') {
                        $options['div'] = 'clearfix';
                        $options['div'] = 'input select' . ' ' . $required;
                        if (!empty($field['multiple']) && $field['multiple'] == 'multiple') {
                            $options['div'].= ' multi-select';
                        }
                    }
                    $options = Set::merge($custom_options, $options);
                    if ($field['type'] == 'date' || $field['type'] == 'datetime' || $field['type'] == 'time') {
                        if ($field['name'] == 'Project.project_end_date') {
                            $date_display = date('Y-m-d', strtotime('+' . Configure::read('maximum_project_expiry_day') . ' days'));
                        } else {
                            $date_display = date('Y-m-d');
                        }
                        if ($field['type'] == 'datetime') {
                            $out.= '<div class="input js-datetimepicker clearfix ' . $required . '"><div class="js-cake-date">';
                        } else {
                            $out.= '<div class="input js-datetime clearfix ' . $required . '"><div class="js-cake-date">';
                        }
                    }
                    if ($field['type'] == 'radio') {
                        $out.= '<div class="input select radio-block clearfix">';
                        $out.= '<label class="label-block pull-left ' . $required . '" for="' . $field['name'] . '">' . __l($field['label']) . '</label>';
                    }
                    if ($field['name'] == 'Project.short_description') {
                        $options['class'] = 'js-preview-keyup js-no-pjax js-description-count {"display":"js-short-description","field":"js-short-description-count","count":"' . Configure::read('Project.project_short_description_length') . '"}';
                        $options['info'] = __l($field['info']) . ' ' . '<span class="character-info">' . __l('You have') . ' ' . '<span id="js-short-description-count"></span>' . ' ' . __l('characters left') . '</span>';
                    }
                    if (!empty($field['name']) && $field['name'] == 'Project.description') {
                        $options['label'] = false;
                        $options['info'] = false;
                        $out.= '<div>';
                        $out.= '<label class="control-label pull-left" for="ProjectDescription">' . __l('Description') . '</label>';
                        $out.= '<div class="help">';
                    }
                    if (!empty($field['name']) && $field['name'] == 'Project.needed_amount') {
                        $options['label'] = __l('Needed amount') . ' (' . Configure::read('site.currency') . ')';
                    }
                    $out.= $this->Form->input($field['name'], $options);
                    if (!empty($field['name']) && $field['name'] == 'Project.description') {
                        $out.= '</div>';
                        $out.= '<span class="info hor-space"><i class="fa fa-info-circle"></i> ' . __l('Entered description will display in view page') . '</span>';
                        $out.= '</div>';
                    }
                    if ($field['type'] == 'date' || $field['type'] == 'datetime' || $field['type'] == 'time') {
                        $out.= '</div></div>';
                    }
                    if ($field['type'] == 'radio') {
                        $out.= '</div>';
                    }
                    if (!empty($field['name']) && $field['name'] == 'City.name') {
                        $out.= '</div></div></div><div class="pull-left js-side-map-div col-md-3 ' . $class . '"><h5>' . __l('Point Your Location') . '</h5><div class="js-side-map"><div id="js-map-container"></div><span>' . __l('Point the exact location in map by dragging marker') . '</span></div></div><div id="mapblock"><div id="mapframe"><div id="mapwindow"></div></div></div></div></div>';
                    }
                    if (!empty($field['name']) && $field['name'] == 'Pledge.min_amount_to_fund' || $field['name'] == 'Donate.min_amount_to_fund') {
                        $out.= '</div>';
                    }
                    break;
            }
        }
        return $out;
    }
    function explode_escaped($delimiter, $string) 
    {
        $exploded = explode($delimiter, $string);
        $fixed = array();
        for ($k = 0, $l = count($exploded); $k < $l; ++$k) {
            if ($exploded[$k][strlen($exploded[$k]) -1] == '\\') {
                if ($k+1 >= $l) {
                    $fixed[] = trim($exploded[$k]);
                    break;
                }
                $exploded[$k][strlen($exploded[$k]) -1] = $delimiter;
                $exploded[$k].= $exploded[$k+1];
                array_splice($exploded, $k+1, 1);
                --$l;
                --$k;
            } else $fixed[] = trim($exploded[$k]);
        }
        return $fixed;
    }
}
?>