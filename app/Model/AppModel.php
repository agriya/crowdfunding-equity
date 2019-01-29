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
App::uses('Model', 'Model');
class AppModel extends Model
{
    public $actsAs = array(
        'Containable',
    );
    /**
     * use Caching
     *
     * @var string
     */
    public $useCache = true;
    public $recursive = -1;
    /**
     * Constructor
     *
     * @param mixed  $id    Set this ID for this model on startup, can also be an array of options, see above.
     * @param string $table Name of database table to use.
     * @param string $ds    DataSource connection name.
     */
    public function __construct($id = false, $table = null, $ds = null)
    {
        Cms::applyHookProperties('Hook.model_properties', $this);
        CmsHook::applyBindModel($this);
        parent::__construct($id, $table, $ds);
    }
    /**
     * Override find function to use caching
     *
     * Caching can be done either by unique names,
     * or prefixes where a hashed value of $options array is appended to the name
     *
     * @param mixed $type
     * @param array $options
     * @return mixed
     * @access public
     */
    public function find($type = 'first', $query = array())
    {
        if (Configure::read('Memcached.is_memcached_enabled')) {
            $cachedQuery = Cms::dispatchEvent('Model.HighPerformance.getCachedQuery', $this, array(
                'type' => $type,
                'params' => $query,
                'version' => '',
                'fullTag' => '',
            ));
            if (!empty($cachedQuery->data['result'])) {
                return $cachedQuery->data['result'];
            }
            $result = array(
                'version' => $cachedQuery->data['version'],
                'data' => parent::find($type, $query)
            );
            Cms::dispatchEvent('Model.HighPerformance.setCachedQuery', $this, array(
                'result' => $result,
                'fullTag' => $cachedQuery->data['fullTag'],
            ));
            return $result['data'];
        } else {
            return parent::find($type, $query);
        }
    }
    /**
     * Updates multiple model records based on a set of conditions.
     *
     * call afterSave() callback after successful update.
     *
     * @param array $fields     Set of fields and values, indexed by fields.
     *                          Fields are treated as SQL snippets, to insert literal values manually escape your data.
     * @param mixed $conditions Conditions to match, true for all records
     * @return boolean True on success, false on failure
     * @access public
     */
    public function updateAll($fields, $conditions = true)
    {
        $args = func_get_args();
        $output = call_user_func_array(array(
            'parent',
            'updateAll'
        ) , $args);
        if ($output) {
            $created = false;
            $options = array();
            $field = sprintf('%s.%s', $this->alias, $this->primaryKey);
            if (!empty($args[1][$field])) {
				if (is_array($args[1][$field])) {
					foreach($args[1][$field] as $id) {
						$this->id = $id;
						$event = new CakeEvent('Model.afterSave', $this, array(
							$created,
							$options
						));
						$this->getEventManager()->dispatch($event);
					}
				} else {
					$this->id = $args[1][$field];
					$event = new CakeEvent('Model.afterSave', $this, array(
						$created,
						$options
					));
					$this->getEventManager()->dispatch($event);
				}
            } else {
				// quick fix. while using tree behavior
				$this->id = 1;
				$event = new CakeEvent('Model.afterSave', $this, array(
					$created,
					$options
				));
				$this->getEventManager()->dispatch($event);
			}
            $this->_clearCache();
            return true;
        }
        return false;
    }
	public function deleteAll($conditions, $cascade = true, $callbacks = false)
    {
        $args = func_get_args();
        $output = call_user_func_array(array(
            'parent',
            'deleteAll'
        ) , $args);
        if ($output) {
            $field = sprintf('%s.%s', $this->alias, $this->primaryKey);
            if (!empty($args[0][$field])) {
				if (is_array($args[0][$field])) {
					foreach($args[0][$field] as $id) {
						$this->id = $id;
						$event = new CakeEvent('Model.afterDelete', $this, array());
						$this->getEventManager()->dispatch($event);
					}
				} else {
					$this->id = $args[0][$field];
					$event = new CakeEvent('Model.afterDelete', $this, array());
					$this->getEventManager()->dispatch($event);
				}
            }
            $this->_clearCache();
            return true;
        }
        return false;
    }
    /**
     * Fix to the Model::invalidate() method to display localized validate messages
     *
     * @param string $field The name of the field to invalidate
     * @param mixed $value Name of validation rule that was not failed, or validation message to
     *    be returned. If no validation key is provided, defaults to true.
     * @access public
     */
    public function invalidate($field, $value = true)
    {
        return parent::invalidate($field, $value);
    }
    /**
     * Return formatted display fields
     *
     * @param array $displayFields
     * @return array
     */
    public function displayFields($displayFields = null)
    {
        $this->_displayFields = array();
        if (isset($displayFields)) {
            $this->_displayFields = $displayFields;
        }
        $out = array();
        $defaults = array(
            'sort' => true,
            'type' => 'text',
            'url' => array() ,
            'options' => array()
        );
        foreach($this->_displayFields as $field => $label) {
            if (is_int($field)) {
                $field = $label;
                list(, $label) = pluginSplit($label);
                $out[$field] = Set::merge($defaults, array(
                    'label' => Inflector::humanize($label) ,
                ));
            } elseif (is_array($label)) {
                $out[$field] = Set::merge($defaults, $label);
                if (!isset($out[$field]['label'])) {
                    $out[$field]['label'] = Inflector::humanize($field);
                }
            } else {
                $out[$field] = Set::merge($defaults, array(
                    'label' => $label,
                ));
            }
        }
        return $out;
    }
    /**
     * Return formatted edit fields
     *
     * @param array $editFields
     * @return array
     */
    public function editFields($editFields = null)
    {
        if (isset($editFields)) {
            $this->_editFields = $editFields;
        }
        if (empty($this->_editFields)) {
            $this->_editFields = array_keys($this->schema());
            $id = array_search('id', $this->_editFields);
            if ($id !== false) {
                unset($this->_editFields[$id]);
            }
        }
        $out = array();
        foreach($this->_editFields as $field => $label) {
            if (is_int($field)) {
                $out[$label] = array();
            } elseif (is_array($label)) {
                $out[$field] = $label;
            } else {
                $out[$field] = array(
                    'label' => $label,
                );
            }
        }
        return $out;
    }
    function getGatewayTypes($field = null)
    {
        App::uses('PaymentGateway', 'Model');
        $this->PaymentGateway = new PaymentGateway();
        $paymentGateways = $this->PaymentGateway->find('all', array(
            'conditions' => array(
                'PaymentGateway.is_active' => 1
            ) ,
            'contain' => array(
                'PaymentGatewaySetting' => array(
                    'conditions' => array(
                        'PaymentGatewaySetting.name' => $field,
                        'PaymentGatewaySetting.test_mode_value' => 1
                    ) ,
                ) ,
            ) ,
            'order' => array(
                'PaymentGateway.display_name' => 'asc'
            ) ,
            'recursive' => 1
        ));
        $payment_gateway_types = array();
        foreach($paymentGateways as $paymentGateway) {
            if (!empty($paymentGateway['PaymentGatewaySetting'])) {
                if (($paymentGateway['PaymentGateway']['id'] == ConstPaymentGateways::SudoPay && isPluginEnabled('Sudopay')) || ($paymentGateway['PaymentGateway']['id'] == ConstPaymentGateways::Wallet && isPluginEnabled('Wallet'))) {
                    $payment_gateway_types[$paymentGateway['PaymentGateway']['id']] = $paymentGateway['PaymentGateway']['display_name'];
                }
            }
        }
        return $payment_gateway_types;
    }
    public function toSaveIp()
    {
        App::import('Model', 'Ip');
        $this->Ip = new Ip();
        $this->data['Ip']['ip'] = RequestHandlerComponent::getClientIP();
        $this->data['Ip']['host'] = RequestHandlerComponent::getReferer();
        $ip = $this->Ip->find('first', array(
            'conditions' => array(
                'Ip.ip' => $this->data['Ip']['ip']
            ) ,
            'fields' => array(
                'Ip.id'
            ) ,
            'recursive' => -1
        ));
        if (empty($ip)) {
            if (!empty($_COOKIE['_geo'])) {
                $_geo = explode('|', $_COOKIE['_geo']);
                $country = $this->Ip->Country->find('first', array(
                    'conditions' => array(
                        'Country.iso_alpha2' => $_geo[0]
                    ) ,
                    'fields' => array(
                        'Country.id'
                    ) ,
                    'recursive' => -1
                ));
                if (empty($country)) {
                    $this->data['Ip']['country_id'] = 0;
                } else {
                    $this->data['Ip']['country_id'] = $country['Country']['id'];
                }
                $state = $this->Ip->State->find('first', array(
                    'conditions' => array(
                        'State.name' => $_geo[1]
                    ) ,
                    'fields' => array(
                        'State.id'
                    ) ,
                    'recursive' => -1
                ));
                if (empty($state)) {
                    $this->data['State']['name'] = $_geo[1];
                    $this->Ip->State->create();
                    $this->Ip->State->save($this->data['State']);
                    $this->data['Ip']['state_id'] = $this->Ip->getLastInsertId();
                } else {
                    $this->data['Ip']['state_id'] = $state['State']['id'];
                }
                $city = $this->Ip->City->find('first', array(
                    'conditions' => array(
                        'City.name' => $_geo[2]
                    ) ,
                    'fields' => array(
                        'City.id'
                    ) ,
                    'recursive' => -1
                ));
                if (empty($city)) {
                    $this->data['City']['name'] = $_geo[2];
                    $this->Ip->City->create();
                    $this->Ip->City->save($this->data['City']);
                    $this->data['Ip']['city_id'] = $this->Ip->City->getLastInsertId();
                } else {
                    $this->data['Ip']['city_id'] = $city['City']['id'];
                }
                $this->data['Ip']['latitude'] = $_geo[3];
                $this->data['Ip']['longitude'] = $_geo[4];
            } else {
                $this->data['Ip']['user_agent'] = env('HTTP_USER_AGENT');
            }
            $this->Ip->create();
            if ($this->Ip->save($this->data['Ip'])) {
	            return $this->Ip->getLastInsertId();
			} else {
				return 0;
			}
        } else {
            return $ip['Ip']['id'];
        }
    }
    public function findOrSaveAndGetId($data, $country_id = null, $state_id = null)
    {
        $findExist = $this->find('first', array(
            'conditions' => array(
                'name' => $data
            ) ,
            'fields' => array(
                'id'
            ) ,
            'recursive' => -1
        ));
        if (!empty($findExist)) {
            return $findExist[$this->name]['id'];
        } else {
            $_Data[$this->name]['name'] = $data;
            if (!empty($country_id)) {
                $_Data[$this->name]['country_id'] = $country_id;
            }
            if (!empty($state_id)) {
                $_Data[$this->name]['state_id'] = $state_id;
            }
            $this->create();
            $this->save($_Data[$this->name]);
            return $this->id;
        }
    }
    public function getIdHash($ids = null)
    {
        return md5($ids . Configure::read('Security.salt'));
    }
    public function siteCurrencyFormat($amount)
    {
        if (Configure::read('site.currency_symbol_place') == 'left') {
            return Configure::read('site.currency') . $amount;
        } else {
            return $amount . Configure::read('site.currency');
        }
    }
    public function _isValidCaptcha()
    {
        include_once VENDORS . DS . 'securimage' . DS . 'securimage.php';
        $img = new Securimage();
        return $img->check($this->data[$this->name]['captcha']);
    }
    public function _isValidCaptchaSolveMedia()
    {
        include_once VENDORS . DS . 'solvemedialib.php';
        $privkey = Configure::read('captcha.verification_key');
        $hashkey = Configure::read('captcha.hash_key');
        $solvemedia_response = solvemedia_check_answer($privkey, $_SERVER["REMOTE_ADDR"], $_POST["adcopy_challenge"], $_POST["adcopy_response"], $hashkey);
        if (!$solvemedia_response->is_valid) {
            //handle incorrect answer
            return false;
        } else {
            return true;
        }
    }
    public function _sendEmail($template, $replace_content, $to, $from = null)
    {
        App::uses('CakeEmail', 'Network/Email');
        $this->Email = new CakeEmail();
        if (isPluginEnabled('HighPerformance') && Configure::read('mail.is_smtp_enabled')) {
            $this->Email->config('smtp');
        }
        $default_content = array(
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##SITE_URL##' => Router::url('/', true) ,
            '##SITE_LINK##' => Router::url('/', true) ,
            '##FROM_EMAIL##' => Configure::read('EmailTemplate.from_email') ,
			'##CONTACT_URL##' => Router::url(array(
				'controller' => 'contacts',
				'action' => 'add',
				'admin' => false
			), true),
			'##SITE_LOGO##' => Router::url(array(
            	'controller' => 'img',
                'action' => 'crowdfunding.png',
                'admin' => false
            ) , true) ,
        );
        $emailFindReplace = array_merge($default_content, $replace_content);
        $content['text'] = strtr($template['email_text_content'], $emailFindReplace);
        $content['html'] = strtr($template['email_html_content'], $emailFindReplace);
        $subject = strtr($template['subject'], $emailFindReplace);
        if (!empty($from)) {
            $from_email = $from;
        } else {
	        $from_email = $template['from'];
	        $from_email = strtr($from_email, $emailFindReplace);
		}
        $this->Email->from($from_email, Configure::read('site.name'));
        $reply_to_email = (!empty($template['reply_to']) && $template['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $template['reply_to'];
        if (!empty($reply_to_email)) {
            $this->Email->replyTo($reply_to_email);
        }
        $this->Email->to($to);
        $this->Email->subject($subject);
        $this->Email->emailFormat('both');
        $this->Email->send($content);
    }
    function findCountryId($data)
    {
        $findExist = $this->find('first', array(
            'conditions' => array(
                'iso_alpha2' => $data
            ) ,
            'fields' => array(
                'id'
            ) ,
            'recursive' => -1
        ));
        return $findExist[$this->name]['id'];
    }
    function findOrSaveAndGetIdWithArray($name, $data)
    {
        $findExist = $this->find('first', array(
            'conditions' => array(
                'name' => $name
            ) ,
            'fields' => array(
                'id'
            ) ,
            'recursive' => -1
        ));
        if (!empty($findExist)) {
            return $findExist[$this->name]['id'];
        } else {
            $this->data[$this->name] = $data;
            $this->save($this->data[$this->name]);
            return $this->id;
        }
    }
    function _sendAlertOnNewMessage($email, $message, $message_id, $template)
    {
        App::import('Model', 'Projects.Message');
        $this->Message = new Message();
        App::import('Model', 'Projects.MessageContent');
        $this->MessageContent = new MessageContent();
        $get_message_hash = $this->Message->find('first', array(
            'conditions' => array(
                'Message.message_content_id = ' => $message_id,
                'Message.is_sender' => 0
            ) ,
            'fields' => array(
                'Message.id',
                'Message.created',
                'Message.user_id',
                'Message.other_user_id',
                'Message.parent_message_id',
                'Message.message_content_id',
                'Message.message_folder_id',
                'Message.is_sender',
                'Message.is_starred',
                'Message.is_read',
                'Message.is_deleted',
                'Message.hash',
            ) ,
            'contain' => array(
                'MessageContent' => array(
                    'fields' => array(
                        'MessageContent.id',
                        'MessageContent.message',
                        'MessageContent.is_system_flagged',
                        'MessageContent.detected_suspicious_words',
                    )
                )
            ) ,
            'recursive' => 2
        ));
        if (!empty($get_message_hash) && empty($get_message_hash['MessageContent']['is_system_flagged'])) {
            $get_user = $this->Message->User->find('first', array(
                'conditions' => array(
                    'User.id' => $get_message_hash['Message']['user_id']
                ) ,
                'recursive' => -1
            ));
            $emailFindReplace = array(
                '##MESSAGE##' => $message['message'],
                '##REPLY_LINK##' => Router::url(array(
                    'controller' => 'messages',
                    'action' => 'compose',
                    'admin' => false,
                    $get_message_hash['Message']['id'],
                    'reply'
                ) , true) ,
                '##VIEW_LINK##' => Router::url(array(
                    'controller' => 'messages',
                    'action' => 'v',
                    'admin' => false,
                    $get_message_hash['Message']['id'],
                ) , true) ,
                '##TO_USER##' => $get_user['User']['username'],
                '##FROM_USER##' => (($template == 'Fund Alert Mail') ? 'Administrator' : $_SESSION['Auth']['User']['username']) ,
                '##FROM_USER##' => (($template == 'Fund Alert Mail') ? 'Administrator' : $_SESSION['Auth']['User']['username']) ,
                '##SUBJECT##' => $message['subject'],
            );
            $this->_sendEmail($template, $emailFindReplace, $email);
        }
    }
    function _uuid()
    {
        return sprintf('%07x%1x', mt_rand(0, 0xffff) , mt_rand(0, 0x000f));
    }
    function _unum()
    {
        $acceptedChars = '0123456789';
        $max = strlen($acceptedChars) -1;
        $unique_code = '';
        for ($i = 0; $i < 8; $i++) {
            $unique_code.= $acceptedChars{mt_rand(0, $max) };
        }
        return $unique_code;
    }
    public function postActivity($project, $activity_id, $data)
    {
        $engagement_flag = 0;
        App::import('Model', 'Projects.Project');
        $this->Project = new Project();
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        if (isPluginEnabled('ProjectFollowers')) {
            $projectFollowers = $this->Project->ProjectFollower->find('all', array(
                'conditions' => array(
                    'ProjectFollower.project_id' => $project['Project']['id']
                ) ,
                'contain' => array(
                    'User'
                ) ,
                'recursive' => 0
            ));
        }
        $emailFindAndReplace = array(
            '##PROJECT##' => $project['Project']['name'],
            '##PROJECT_OWNER_NAME##' => !empty($project['User']['username']) ? $project['User']['username'] : '',
            '##PROJECT_URL##' => Router::url(array(
                'controller' => 'projects',
                'action' => 'view',
                $project['Project']['slug'],
                'admin' => false
            ) , true)
        );
        $activity_user_id = $is_anonymous_fund = 0;
        // Fund Activities
        if ($activity_id == ConstProjectActivities::Fund) {
            $projectFund = $this->Project->ProjectFund->find('first', array(
                'conditions' => array(
                    'ProjectFund.id' => $data
                ) ,
                'contain' => array(
                    'User'
                ) ,
                'recursive' => 0
            ));
            $template = $this->EmailTemplate->selectTemplate('New Fund Alert');
            // follow mail
            $follow_mail = 'funded for';
            // activities message variables
            $subject = __l('Fund');
            $message = sprintf(__l('%s %s') , Configure::read('project.alt_name_for_' . $project['ProjectType']['slug'] . '_past_tense_caps') , $project['Project']['name']);
            $class = 'ProjectFund';
            $foreign_id = $data;
            $activity_user_id = $projectFund['ProjectFund']['user_id'];
        }
        // Project Comment Activities
        if ($activity_id == ConstProjectActivities::ProjectComment) {
            $message = $this->Project->Message->find('first', array(
                'conditions' => array(
                    'Message.id' => $data
                ) ,
                'contain' => array(
                    'User'
                ) ,
                'recursive' => 0
            ));
            $template = $this->EmailTemplate->selectTemplate('Project Comment Alert');
            $emailFindAndReplace = array_merge($emailFindAndReplace, array(
                '##COMMENTED_USER##' => $message['User']['username'],
            ));
            // activities message variables
            $activity_user_id = $message['Message']['user_id'];
            $subject = __l('New Project Comment');
            $message = sprintf(__l('Commented on %s') , $project['Project']['name']);
            $class = 'Message';
            $foreign_id = $data;
        }
        // Project Update Activities
        if ($activity_id == ConstProjectActivities::ProjectUpdate) {
            $blog = $this->Project->Blog->find('first', array(
                'conditions' => array(
                    'Blog.id' => $data
                ) ,
                'recursive' => -1
            ));
            $template = $this->EmailTemplate->selectTemplate('Project Update Alert');
            $emailFindAndReplace = array_merge($emailFindAndReplace, array(
                '##BLOG_TITLE##' => $blog['Blog']['title'],
                '##BLOG_URL##' => Router::url(array(
                    'controller' => 'blogs',
                    'action' => 'view',
                    $blog['Blog']['slug']
                ) , true) ,
            ));
            // activities message variables
            $subject = __l('New Project Update');
            $message = sprintf(__l('Update for %s') , $project['Project']['name']);
            $class = 'Blog';
            $foreign_id = $data;
            $activity_user_id = $blog['Blog']['user_id'];
        }
        // Project Update Comment Activities
        if ($activity_id == ConstProjectActivities::ProjectUpdateComment) {
            $blogComment = $this->Project->Blog->BlogComment->find('first', array(
                'conditions' => array(
                    'BlogComment.id' => $data
                ) ,
                'contain' => array(
                    'User',
                    'Blog',
                ) ,
                'recursive' => 0
            ));
            $template = $this->EmailTemplate->selectTemplate('Project Update Comment Alert');
            $emailFindAndReplace = array_merge($emailFindAndReplace, array(
                '##COMMENTED_USER##' => $blogComment['User']['username'],
                '##BLOG_TITLE##' => $blogComment['Blog']['title'],
                '##BLOG_URL##' => Router::url(array(
                    'controller' => 'blogs',
                    'action' => 'view',
                    $blogComment['Blog']['slug']
                ) , true) ,
            ));
            // activities message variables
            $subject = __l('New Project Update Comment');
            $message = sprintf(__l('Commented for update on %s') , $project['Project']['name']);
            $class = 'BlogComment';
            $foreign_id = $data;
            $activity_user_id = $blogComment['BlogComment']['user_id'];
        }
        // Project Follower Activities
        if ($activity_id == ConstProjectActivities::ProjectFollower) {
            $projectFollower = $this->Project->ProjectFollower->find('first', array(
                'conditions' => array(
                    'ProjectFollower.id' => $data
                ) ,
                'contain' => array(
                    'User',
                ) ,
                'recursive' => 0
            ));
            $template = $this->EmailTemplate->selectTemplate('Project Follower Alert');
            $emailFindAndReplace = array_merge($emailFindAndReplace, array(
                '##FOLLOWED_USER##' => $projectFollower['User']['username'],
            ));
            // follow mail
            $follow_mail = 'followed';
            // activities message variables
            $subject = __l('New Project Follower');
            $message = sprintf(__l('Following %s') , $project['Project']['name']);
            $class = 'ProjectFollower';
            $foreign_id = $data;
            $activity_user_id = $projectFollower['ProjectFollower']['user_id'];
        }
        // Project Rating Activities
        if ($activity_id == ConstProjectActivities::ProjectRating) {
            $projectRating = $this->Project->ProjectRating->find('first', array(
                'conditions' => array(
                    'ProjectRating.id' => $data
                ) ,
                'contain' => array(
                    'User',
                ) ,
                'recursive' => 0
            ));
            $template = $this->EmailTemplate->selectTemplate('Project Voting Alert');
            $emailFindAndReplace = array_merge($emailFindAndReplace, array(
                '##VOTED_USER##' => $projectRating['User']['username'],
            ));
            // activities message variables
            $subject = __l('New Project Voting');
            $message = sprintf(__l('Voted on %s') , $project['Project']['name']);
            $class = 'ProjectRating';
            $foreign_id = $data;
            $activity_user_id = $projectRating['ProjectRating']['user_id'];
        }
        // Status Change Activities
        if ($activity_id == ConstProjectActivities::StatusChange) {
            $projectStatuses = $this->{$project['ProjectType']['name'] . 'ProjectStatus'}->find('list', array(
                'recursive' => -1
            ));
            $toProjectStatus = $this->{$project['ProjectType']['name'] . 'ProjectStatus'}->find('first', array(
                'conditions' => array(
                    $project['ProjectType']['name'] . 'ProjectStatus.id' => $data['to_project_status_id']
                ) ,
                'recursive' => -1
            ));
            $template = $this->EmailTemplate->selectTemplate('Project Change Status Alert');
            $emailFindAndReplace = array_merge($emailFindAndReplace, array(
                '##PREVIOUS_STATUS##' => $projectStatuses[$data['from_project_status_id']],
                '##CURRENT_STATUS##' => $projectStatuses[$data['to_project_status_id']],
            ));
            // activities message variables
            $subject = sprintf(__l('%s Activity') , Configure::read('project.alt_name_for_project_singular_caps'));
            $message = strtr($toProjectStatus[$project['ProjectType']['name'] . 'ProjectStatus']['message'], $emailFindAndReplace);
            $class = $project['ProjectType']['name'];
            $foreign_id = $project[$project['ProjectType']['name']]['project_id'];
        }
        // Fund Cancel
        if ($activity_id == ConstProjectActivities::FundCancel) {
            $projectFund = $this->Project->ProjectFund->find('first', array(
                'conditions' => array(
                    'ProjectFund.id' => $data
                ) ,
                'contain' => array(
                    'User'
                ) ,
                'recursive' => 0
            ));
            $template = $this->EmailTemplate->selectTemplate('Project Fund Canceled Alert');
            // activities message variables
            $subject = sprintf(__l('%s Canceled') , Configure::read('project.alt_name_for_' . $project['ProjectType']['slug'] . '_singular_caps'));
            $message = sprintf(__l('%s Canceled %s') , Configure::read('project.alt_name_for_' . $project['ProjectType']['slug'] . '_past_tense_caps') , $project['Project']['name']);
            $class = 'ProjectFund';
            $foreign_id = $data;
            $activity_user_id = $projectFund['ProjectFund']['user_id'];
        }
        $is_hide_rejected_activity = 0;
        // Project Rejected Activities
        if ($activity_id == ConstProjectActivities::ProjectRejected) {
            $template = $this->EmailTemplate->selectTemplate('Project Rejected');
            $emailFindAndReplace = array_merge($emailFindAndReplace, array(
                '##USERNAME##' => $project['User']['username'],
                '##PROJECT_NAME##' => $project['Project']['name'],
                '##PROJECT_URL##' => Router::url(array(
                    'controller' => 'projects',
                    'action' => 'view',
                    $project['Project']['slug'],
                    'admin' => false
                ) , true)
            ));
            // activities message variables
            $subject = sprintf(__l('%s Activity') , Configure::read('project.alt_name_for_project_singular_caps'));
            $message = sprintf(__l('%s Rejected by Admin') , Configure::read('project.alt_name_for_project_singular_caps'));
            $class = 'Project';
            $foreign_id = $project['Project']['id'];
            $is_hide_rejected_activity = 1;
        }
        // @todo fund cancel settings
        // send activity mail to followers
        if (!empty($projectFollowers)) {
            foreach($projectFollowers as $projectFollower) {
                if (!empty($projectFollower['User']['is_send_activities_mail'])) {
                    $emailFindAndReplace = array_merge($emailFindAndReplace, array(
                        '##USERNAME##' => $projectFollower['User']['username'],
                    ));
                    // anonymous handling
                    if (!empty($projectFund)) {
                        $backer = __l('Anonymous');
                        $amount = '-';
                        if (!empty($projectFund['ProjectFund']['is_anonymous'])) {
                            if (!empty($projectFund['ProjectFund']['is_anonymous']) && $projectFund['ProjectFund']['is_anonymous'] == ConstAnonymous::FundedAmount || $projectFund['User']['id'] == $projectFollower['User']['id']) {
                                $backer = $projectFund['User']['username'];
                            }
                            if (!empty($projectFund['ProjectFund']['is_anonymous']) && $projectFund['ProjectFund']['is_anonymous'] == ConstAnonymous::Username || $projectFund['User']['id'] == $projectFollower['User']['id']) {
                                $amount = $projectFund['ProjectFund']['amount'];
                            }
                        } else {
                            $backer = $projectFund['User']['username'];
                            $amount = $projectFund['ProjectFund']['amount'];
                        }
                        $emailFindAndReplace = array_merge($emailFindAndReplace, array(
                            '##BACKER##' => $backer,
                            '##AMOUNT##' => $amount,
                        ));
                    }
                    if (!empty($project['ProjectType']['slug'])) {
                        $emailFindAndReplace = array_merge($emailFindAndReplace, array(
                            '##BACKER_TYPE##' => Configure::read('project.alt_name_for_' . $project['ProjectType']['slug'] . '_singular_caps') ,
                        ));
                    }
                    $this->_sendEmail($template, $emailFindAndReplace, $projectFollower['User']['email']);
                }
            }
        }
        $emailFindAndReplace = array_merge($emailFindAndReplace, array(
            '##USERNAME##' => 'admin',
        ));
        // anonymous trim off for admin
        if (!empty($projectFund)) {
            $emailFindAndReplace = array_merge($emailFindAndReplace, array(
                '##BACKER##' => $projectFund['User']['username'],
                '##AMOUNT##' => $projectFund['ProjectFund']['amount'],
            ));
        }
        // send activity mail to admin
        $this->_sendEmail($template, $emailFindAndReplace, Configure::read('EmailTemplate.admin_email'));
        // activities message
        $_data = array();
        $_data['MessageContent']['subject'] = $subject;
        $_data['MessageContent']['message'] = $message;
        $this->Project->Message->MessageContent->create();
        $this->Project->Message->MessageContent->save($_data);
        $_data = array();
        $_data['Message']['project_id'] = $project['Project']['id'];
        $_data['Message']['project_type_id'] = $project['Project']['project_type_id'];
        if (!empty($data['to_project_status_id'])) {
            $_data['Message']['project_status_id'] = $data['to_project_status_id'];
        }
        if (!empty($projectFund['ProjectFund']['is_anonymous'])) {
            $_data['Message']['is_anonymous_fund'] = $projectFund['ProjectFund']['is_anonymous'];
        }
        $_data['Message']['class'] = $class;
        $_data['Message']['foreign_id'] = $foreign_id;
        $_data['Message']['message_content_id'] = $this->Project->Message->MessageContent->id;
        $_data['Message']['user_id'] = 0;
        $_data['Message']['other_user_id'] = 0;
        $_data['Message']['parent_message_id'] = 0;
        $_data['Message']['message_folder_id'] = ConstMessageFolder::Activities;
        $_data['Message']['activity_id'] = $activity_id;
        $_data['Message']['activity_user_id'] = $activity_user_id;
        $_data['Message']['is_activity'] = 1;
        $_data['Message']['is_sender'] = 0;
        $_data['Message']['is_read'] = 0;
        $_data['Message']['is_private'] = 0;
        $_data['Message']['size'] = strlen($subject) +strlen($message);
        $_data['Message']['is_hide_rejected_activity'] = $is_hide_rejected_activity;
        $this->Project->Message->create();
        $this->Project->Message->save($_data);
        // send mail to user followers
        if (isPluginEnabled('SocialMarketing') && !empty($follow_mail)) {
            App::import('Model', 'SocialMarketing.UserFollower');
            $this->UserFollower = new UserFollower();
            $this->UserFollower->send_follow_mail($project['Project']['user_id'], $follow_mail, $project);
        }
        if (in_array($activity_id, array(
            ConstProjectActivities::ProjectComment,
            ConstProjectActivities::ProjectUpdateComment,
            ConstProjectActivities::ProjectFollower,
            ConstProjectActivities::ProjectRating
        ))) {
            $data = array();
            $data['User']['id'] = $activity_user_id;
            $data['User']['is_idle'] = 0;
            $data['User']['is_engaged'] = 1;
            $this->Project->User->save($data);
        }
    }
    public function postNotifyMail($project, $activity_id)
    {
        if ($activity_id != ConstProjectActivities::AmountRepayment) {
            App::import('Model', 'EmailTemplate');
            $this->EmailTemplate = new EmailTemplate();
            if ($activity_id == ConstProjectActivities::RepaymentNotification) {
                $template = $this->EmailTemplate->selectTemplate('Repayment Notification');
                $subject = sprintf(__l('%s Repayment Notification') , Configure::read('project.alt_name_for_' . $project['Project']['ProjectType']['slug'] . '_singular_caps'));
                $message = sprintf(__l('%s Repayment Notification %s') , Configure::read('project.alt_name_for_' . $project['Project']['ProjectType']['slug'] . '_past_tense_caps') , $project['Project']['name']);
                $class = 'RepaymentNotification';
            }
            if ($activity_id == ConstProjectActivities::LateRepaymentNotification) {
                $template = $this->EmailTemplate->selectTemplate('Late Repayment Notification');
                $subject = sprintf(__l('%s Late Repayment Notification') , Configure::read('project.alt_name_for_' . $project['Project']['ProjectType']['slug'] . '_singular_caps'));
                $message = sprintf(__l('%s Repayment Notification %s') , Configure::read('project.alt_name_for_' . $project['Project']['ProjectType']['slug'] . '_past_tense_caps') , $project['Project']['name']);
                $class = 'LateRepaymentNotification';
            }
            $activity_user_id = $project['Project']['user_id'];
            $foreign_id = $project['Project']['id'];
            $emailFindAndReplace = array(
                '##PROJECT##' => $project['Project']['name'],
                '##PROJECT_OWNER_NAME##' => $project['Project']['User']['username'],
                '##DATE##' => $project['Lend']['next_repayment_date'],
                '##AMOUNT##' => $project['Lend']['next_repayment_amount'],
                '##USERNAME##' => 'admin',
                '##PROJECT_URL##' => Router::url(array(
                    'controller' => 'projects',
                    'action' => 'view',
                    $project['Project']['slug'],
                    'admin' => false
                ) , true)
            );
            // send activity mail to admin
            $this->_sendEmail($template, $emailFindAndReplace, Configure::read('EmailTemplate.admin_email'));
        } else {
            $foreign_id = $project['Project']['id'];
            $subject = __l('Amount repayment');
            $message = __l('Amount repayment done');
            $class = 'AmountRepayment';
            $activity_user_id = 0;
        }
        // activities message
        $_data = array();
        $_data['MessageContent']['subject'] = $subject;
        $_data['MessageContent']['message'] = $message;
        $this->Project->Message->MessageContent->create();
        $this->Project->Message->MessageContent->save($_data);
        $_data = array();
        $_data['Message']['project_id'] = $project['Project']['id'];
        $_data['Message']['project_type_id'] = $project['Project']['project_type_id'];
        $_data['Message']['class'] = $class;
        $_data['Message']['foreign_id'] = $foreign_id;
        $_data['Message']['message_content_id'] = $this->Project->Message->MessageContent->id;
        $_data['Message']['user_id'] = $project['Project']['user_id'];
        $_data['Message']['other_user_id'] = $project['Project']['user_id'];
        $_data['Message']['parent_message_id'] = 0;
        $_data['Message']['message_folder_id'] = ConstMessageFolder::Inbox;
        $_data['Message']['activity_id'] = $activity_id;
        $_data['Message']['activity_user_id'] = $activity_user_id;
        $_data['Message']['is_activity'] = 0;
        if ($activity_id == ConstProjectActivities::AmountRepayment) {
            $_data['Message']['is_activity'] = 1;
        }
        $_data['Message']['is_sender'] = 0;
        $_data['Message']['is_read'] = 0;
        $_data['Message']['is_private'] = 0;
        $_data['Message']['size'] = strlen($subject) +strlen($message);
        $this->Project->Message->create();
        $this->Project->Message->save($_data);
    }
    public function getProjectTypes()
    {
        $projectTypes = array();
        if (isPluginEnabled('Pledge')) {
            $projectTypes[] = ConstProjectTypes::Pledge;
        }
        if (isPluginEnabled('Donate')) {
            $projectTypes[] = ConstProjectTypes::Donate;
        }
        if (isPluginEnabled('Lend')) {
            $projectTypes[] = ConstProjectTypes::Lend;
        }
        if (isPluginEnabled('Equity')) {
            $projectTypes[] = ConstProjectTypes::Equity;
        }
        return $projectTypes;
    }
    public function deleteActivity($modelName, $id)
    {
        App::import('Model', 'Projects.Message');
        $this->Message = new Message();
        $messages = $this->Message->find('all', array(
            'conditions' => array(
                'Message.class' => $modelName,
                'Message.foreign_id' => $id
            ) ,
            'fields' => array(
                'Message.id'
            ) ,
            'recursive' => -1
        ));
        foreach($messages as $message) {
            $messageIds[] = $message['Message']['id'];
        }
        if (count($messages) > 0) {
            $this->Message->deleteAll(array(
                'Message.id' => $messageIds
            ));
        }
    }
}
