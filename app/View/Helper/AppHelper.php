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
App::uses('Helper', 'View');
class AppHelper extends Helper
{
    public function assetUrl($path, $options = array() , $cdn_path = '') 
    {
        $assetURL = Cms::dispatchEvent('Helper.HighPerformance.getAssetUrl', $this->_View, array(
            'options' => $options,
            'assetURL' => '',
        ));
        return parent::assetUrl($path, $options, $assetURL->data['assetURL']);
    }
    /**
     * Url helper function
     *
     * @param string $url
     * @param bool $full
     * @return mixed
     * @access public
     */
    public function url($url = null, $full = false) 
    {
        if (!isset($url['locale']) && isset($this->request->params['locale'])) {
            $url['locale'] = $this->request->params['locale'];
        }
        return parent::url($url, $full);
    }
    function getCurrUserContactInfo($id) 
    {
        App::import('Model', 'SocialMarketing.SocialContact');
        $this->SocialContact = new SocialContact();
        $user_contact = $this->SocialContact->find('count', array(
            'conditions' => array(
                'SocialContact.user_id' => $id,
            ) ,
            'recursive' => -1
        ));
        return $user_contact;
    }
    function getCurrUserInfo($id) 
    {
        App::import('Model', 'User');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $id,
            ) ,
            'recursive' => -1
        ));
        return $user;
    }
    function getUserAvatar($user_details, $dimension = 'medium_thumb', $is_link = true, $anonymous = '', $from = '', $isAttachment = '', $from_model = '') 
    {
        $width = Configure::read('thumb_size.' . $dimension . '.width');
        $height = Configure::read('thumb_size.' . $dimension . '.height');
        if (!empty($from) && $from == 'layout') {
            $width = '45';
            $height = '45';
			$imgClass = 'img-circle';
        }
		if($dimension == 'user_thumb') {
			$imgClass = ' img-circle img-thumbnail center-block';
		}
        $tooltipClass = 'js-tooltip';
        $title = '';
        if (!$is_link) {
            $tooltipClass = '';
            if (isset($user_details['username'])) {
                $title = $this->cText($user_details['username'], false);
            }
            if (!empty($anonymous) && ($anonymous == 'anonymous')) {
                $title = 'Anonymous';
            }
        }
        if (!empty($from_model) && $from_model == 'modal') {
            $tooltipClass = '';
        }
        if (!empty($from) && $from == 'layout') {
            $tooltipClass = '';
        }
        if (!empty($anonymous) && ($anonymous == 'anonymous')) {
            $username = __l('Anonymous');
			if($dimension == 'user_thumb') {
				$tooltipClass .= ' img-circle img-respons img-white-border hor-middle-img';
			}
            $user_image = $this->showImage('Anonymous', '', array(
                'dimension' => $dimension,
                'class' => $tooltipClass,
                'alt' => sprintf(__l('[Image: %s]') , $this->cText($username, false)) ,
                'title' => (!$is_link) ? $this->cText($username, false) : '',
            ) , null, null, false);
        } elseif (!empty($user_details['user_avatar_source_id']) && $user_details['user_avatar_source_id'] == ConstUserAvatarSource::Facebook) {
            $user_image = $this->getFacebookAvatar($user_details['facebook_user_id'], $height, $width, $user_details['username'], $is_link, $from);
        } elseif (!empty($user_details['user_avatar_source_id']) && $user_details['user_avatar_source_id'] == ConstUserAvatarSource::Twitter) {
            $user_image = $this->image($user_details['twitter_avatar_url'], array(
                'title' => $title,
                'width' => $width,
                'height' => $height,
                'border' => 0,
                'class' => $tooltipClass
            ));
        } elseif (!empty($user_details['user_avatar_source_id']) && $user_details['user_avatar_source_id'] == ConstUserAvatarSource::Linkedin) {
            $user_image = $this->image($user_details['linkedin_avatar_url'], array(
                'title' => $title,
                'width' => $width,
                'height' => $height,
                'border' => 0,
                'class' => $tooltipClass
            ));
        }else {
            if (empty($user_details['UserAvatar'])) {
                if (!empty($user_details['id'])) {
                    App::uses('User', 'Model');
                    $this->User = new User();
                    $user = $this->User->find('first', array(
                        'conditions' => array(
                            'User.id' => $user_details['id'],
                        ) ,
                        'contain' => array(
                            'UserAvatar'
                        ) ,
                        'recursive' => 0
                    ));
                    if (!empty($user['UserAvatar']['id'])) {
                        $user_details['UserAvatar'] = $user['UserAvatar'];
                    }
                }
            }
            $user_details['username'] = !empty($user_details['username']) ? $user_details['username'] : '';
            if(!empty($imgClass)) {
				$user_image = $this->image(getImageUrl('UserAvatar', (!empty($user_details['UserAvatar'])) ? $user_details['UserAvatar'] : '', array(
					'dimension' => $dimension
				)) , array(
					'width' => $width,
					'height' => $height,
					'class' => $tooltipClass . $imgClass,
					'alt' => sprintf(__l('[Image: %s]') , $this->cText($user_details['username'], false)) ,
					'title' => (!$is_link) ? $this->cText($user_details['username'], false) : '',
				));
			} else {
				$user_image = $this->image(getImageUrl('UserAvatar', (!empty($user_details['UserAvatar'])) ? $user_details['UserAvatar'] : '', array(
					'dimension' => $dimension
				)) , array(
					'width' => $width,
					'height' => $height,
					'class' => $tooltipClass,
					'alt' => sprintf(__l('[Image: %s]') , $this->cText($user_details['username'], false)) ,
					'title' => (!$is_link) ? $this->cText($user_details['username'], false) : '',
				));
			}
        }
        $before_span = $after_span = '';
        if ($from != 'facebook') {
            $span_class = '';
            if ($dimension == 'micro_thumb' && $from != 'admin') {
                $span_class = ' col-md-1';
            }
            $pr_class = '';
            if (($this->request->params['controller'] == 'blogs' && !empty($this->request->params['named']['from']) && $this->request->params['named']['from'] == 'activity') || (!empty($this->request->params['named']['load_type']) && $this->request->params['named']['load_type'] == 'modal')) {
                $pr_class = '';
            }
          //  $before_span = '<span class="' . $pr_class . '"><span class="img-thumbnail pull-left mob-clr">';
          //  $after_span = '</span></span>';
        }
        if (Configure::read('site.friend_ids') && !empty($user_details['id']) && empty($anonymous)) {
            if (in_array($user_details['id'], Configure::read('site.friend_ids'))) {
                //$user_image.= '<span class="text-center trans-bg">' . __l('Friend') . '</span>';
            }
        }
        $image = (!$is_link) ? $user_image : $this->link($user_image, array(
            'controller' => 'users',
            'action' => 'view',
            $user_details['username'],
            'admin' => false
        ) , array(
            'title' => $this->cText($user_details['username'], false) ,
            'class' => $tooltipClass . ' show',
            'escape' => false
        ));
        return $before_span . $image . $after_span;
    }
    public function isWalletEnabled() 
    {
        App::uses('PaymentGateway', 'Model');
        $this->PaymentGateway = new PaymentGateway();
        $PaymentGateway = $this->PaymentGateway->find('first', array(
            'conditions' => array(
                'PaymentGateway.id' => ConstPaymentGateways::Wallet
            ) ,
            'recursive' => -1
        ));
        if (!empty($PaymentGateway['PaymentGateway']['is_active'])) {
            return true;
        }
        return false;
    }
    public function siteCurrencyFormat($amount, $wrap = 'span') 
    {
        if (Configure::read('site.currency_symbol_place') == 'left') {
            return Configure::read('site.currency') . $this->cCurrency($amount, $wrap);
        } else {
            return $this->cCurrency($amount, $wrap) . Configure::read('site.currency');
        }
    }
    public function getLanguage() 
    {
        if (isPluginEnabled('Translation')) {
            App::import('Model', 'Translation.Translation');
            $this->Translation = new Translation();
            $languages = $this->Translation->find('all', array(
                'conditions' => array(
                    'Language.id !=' => 0
                ) ,
                'fields' => array(
                    'DISTINCT(Translation.language_id)',
                    'Language.name',
                    'Language.iso2'
                ) ,
                'order' => array(
                    'Language.name' => 'ASC'
                ) ,
                'recursive' => 0
            ));
            $languageList = array();
            if (!empty($languages)) {
                foreach($languages as $language) {
                    $languageList[$language['Language']['iso2']] = $language['Language']['name'];
                }
            }
            return $languageList;
        }
        return false;
    }
    function transactionDescription($transaction) 
    {
        $backer = $project_owner = $project = $funded = $canceled = '';
        $user = $this->getUserLink($transaction['User']);
        $fund_text = '';
        if ($transaction['TransactionType']['id'] == ConstTransactionTypes::ProjectBacked || $transaction['TransactionType']['id'] == ConstTransactionTypes::Refunded) {
            $project = $this->getProjectLink($transaction['ProjectFund']['Project']);
            if (in_array($transaction['ProjectFund']['is_anonymous'], array(
                ConstAnonymous::None,
                ConstAnonymous::FundedAmount
            ))) {
                $backer = $this->getUserLink($transaction['ProjectFund']['User']);
            } else {
                $backer = __l('Anonymous');
            }
            $project_owner = $this->getUserLink($transaction['ProjectFund']['Project']['User']);
            if ($transaction['TransactionType']['id'] == ConstTransactionTypes::Refunded) {
                $funded = Configure::read('project.alt_name_for_' . $transaction['ProjectFund']['Project']['ProjectType']['slug'] . '_singular_small');
                if ($transaction['Transaction']['payment_gateway_id'] == ConstPaymentGateways::Wallet) {
                    $canceled = __l('refunded');
                }
            } elseif ($transaction['TransactionType']['id'] == ConstTransactionTypes::ProjectBacked) {
                $funded = Configure::read('project.alt_name_for_' . $transaction['ProjectFund']['Project']['ProjectType']['slug'] . '_past_tense_small');
                switch ($transaction['ProjectFund']['project_fund_status_id']) {
                    case ConstProjectFundStatus::Captured:
                        $fund_text = ' (' . __l('Captured') . ')';
                        break;

                    case ConstProjectFundStatus::Authorized:
                        $fund_text = ' (' . __l('Authorized') . ')';
                        break;

                    case ConstProjectFundStatus::Refunded:
                        $fund_text = ' (' . __l('Refunded') . ')';
                        break;
                }
            }
        }
        if ($transaction['TransactionType']['id'] == ConstTransactionTypes::ListingFee || $transaction['TransactionType']['id'] == ConstTransactionTypes::ProjectRepayment) {
            $project = $this->getProjectLink($transaction['Project']);
            $project_owner = $this->getUserLink($transaction['Project']['User']);
        }
        $transactionReplace = array(
            '##AFFILIATE_USER##' => $user,
            '##USER##' => $user,
            '##PROJECT##' => $project,
            '##BACKER##' => $backer,
            '##PROJECT_OWNER##' => $project_owner,
            '##FUNDED##' => $funded,
            '##CANCELED##' => $canceled
        );
        if (!empty($transaction['TransactionType']['message_for_receiver']) && $transaction['Transaction']['receiver_user_id'] == $_SESSION['Auth']['User']['id']) {
            return strtr($transaction['TransactionType']['message_for_receiver'] . $fund_text, $transactionReplace);
        } elseif ($_SESSION['Auth']['User']['id'] == ConstUserIds::Admin) {
            return strtr($transaction['TransactionType']['message_for_admin'] . $fund_text, $transactionReplace);
        } else {
            return strtr($transaction['TransactionType']['message'], $transactionReplace);
        }
    }
    public function getUserLink($user_details) 
    {
        if ((!empty($user_details['role_id']) && $user_details['role_id'] == ConstUserTypes::Admin) || (!empty($user_details['role_id']) && $user_details['role_id'] == ConstUserTypes::User)) {
            return $this->link($this->cText($user_details['username'], false) , array(
                'controller' => 'users',
                'action' => 'view',
                $user_details['username'],
                'admin' => false
            ) , array(
                'title' => $this->cText($user_details['username'], false) ,
                'class' => 'js-tooltip',
                'escape' => false
            ));
        }
    }
    public function getProjectLink($project_details) 
    {
        return $this->link($this->cText($project_details['name'], false) , array(
            'controller' => 'projects',
            'action' => 'view',
            $project_details['slug'],
            'admin' => false
        ) , array(
            'title' => $this->cText($project_details['name'], false) ,
            'escape' => false
        ));
    }
    public function getFacebookAvatar($fbuser_id, $height = 35, $width = 35, $username = '', $is_link = '', $from = '') 
    {
        $tooltipClass = '';
        $title = '';
        if (!$is_link) {
            $tooltipClass = 'js-tooltip';
            $title = $username;
        }
        if (!empty($from) && $from == 'layout') {
            $tooltipClass = '';
        }
        return $this->image("http://graph.facebook.com/{$fbuser_id}/picture?type=normal&amp;width=$width&amp;height=$height", array(
            'width' => $width,
            'height' => $height,
            'border' => 0,
            'class' => $tooltipClass,
            'title' => $title
        ));
    }
    public function getUserNotification($user_id = null) 
    {
        App::import('Model', 'Projects.Message');
        $this->Message = new Message();
        $conditions = array();
        $conditions['Message.is_anonymous_fund'] = array(
            ConstAnonymous::None,
            ConstAnonymous::FundedAmount,
        );
        $conditions['Message.is_hide_from_public'] = 0;
        App::import('Model', 'Projects.User');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'recursive' => -1
        ));
        if (empty($this->request->params['prefix'])) {
            $conditions['Project.is_active'] = 1;
            $conditions['Project.is_draft'] = 0;
            if (empty($this->request->params['named']['project_id'])) {
                $conditions['Project.is_admin_suspended'] = '0';
            }
        }
        $conditions['Message.is_activity'] = 1;
        $conditions['MessageContent.is_admin_suspended'] = 0;
        if (!empty($this->request->params['named']['project_id'])) {
            $conditions['Message.project_id'] = $this->request->params['named']['project_id'];
        }
        if (isPluginEnabled('ProjectFollowers') && empty($this->request->params['prefix'])) {
            App::import('Model', 'ProjectFollowers.ProjectFollower');
            $this->ProjectFollower = new ProjectFollower();
            $projectFollowers = $this->ProjectFollower->find('list', array(
                'conditions' => array(
                    'ProjectFollower.user_id' => $user_id
                ) ,
                'fields' => array(
                    'ProjectFollower.project_id'
                ) ,
                'recursive' => -1,
            ));
            if (empty($this->request->params['named']['project_id'])) {
                if (count($projectFollowers)) {
                    $conditions['OR']['Message.project_id'] = array_values($projectFollowers);
                } else {
                    $conditions['OR']['Message.project_id'] = 0;
                }
            }
        }
        if (isPluginEnabled('SocialMarketing') && empty($this->request->params['prefix']) && empty($this->request->params['named']['project_id'])) {
            App::import('Model', 'SocialMarketing.UserFollower');
            $this->UserFollower = new UserFollower();
            if (empty($this->request->params['named']['user_id'])) {
                $userFollowers = $this->UserFollower->find('list', array(
                    'conditions' => array(
                        'UserFollower.user_id' => $user_id
                    ) ,
                    'fields' => array(
                        'UserFollower.followed_user_id'
                    ) ,
                    'recursive' => -1,
                ));
                $conditions['OR']['Message.user_id'] = array_values($userFollowers);
            }
        }
		$final_id = $this->Message->find('first', array(
            'conditions' => $conditions,
            'fields' => array(
                'Message.id'
            ) ,
            'recursive' => 0,
            'limit' => 1,
            'order' => array(
                'Message.id' => 'desc'
            ) ,
        ));
		$conditions['Message.id >'] = $user['User']['activity_message_id'];
		$response['final_id'] = $final_id['Message']['id'];
        $response['notificationCount'] = $this->Message->find('count', array(
            'conditions' => $conditions,
            'recursive' => 0
        ));
		if($response['notificationCount'] == 0) {
			$response['final_id'] = 0;
		}	
        return $response;
    }
    public function getUserUnReadMessages($user_id = null) 
    {
        App::import('Model', 'Projects.Message');
        $this->Message = new Message();
        $unread_count = $this->Message->find('count', array(
            'conditions' => array(
                'Message.is_read' => '0',
                'Message.user_id' => $user_id,
                'Message.is_sender' => '0',
                'Message.message_folder_id' => ConstMessageFolder::Inbox,
                'MessageContent.is_admin_suspended' => 0
            ) ,
            'recursive' => 0
        ));
        return $unread_count;
    }
    public function get_star_rating($current_rating) 
    {
        $current_rating_percentage = $current_rating*20;
        $rating = '<ul class="small-star star-rating"><li class="current-rating" style="width:' . $current_rating_percentage . '%;" title="' . $current_rating . '/5' . __l('Stars') . '">' . $current_rating . '/5' . __l('Stars') . '</li></ul>';
        return $rating;
    }
    function filterSuspiciousWords($replace = null, $filtered_words = null) 
    {
        if (!empty($filtered_words)) {
            $bad_words = unserialize($filtered_words);
            foreach($bad_words as $bad_word) {
                $replace = str_replace($bad_word, "<span class='filtered'>" . $bad_word . "</span>", $replace);
            }
        }
        return $replace;
    }
    public function formGooglemap($projectDetails = array() , $size = '320x320') 
    {
        $projectDetails = $projectDetails;
        $projectDetails = !empty($projectFund['Project']) ? $projectFund['Project'] : $projectDetails;
        if ((!(is_array($projectDetails))) || empty($projectDetails)) {
            return false;
        }
        $color_array = array(
            array(
                'A',
                'green'
            ) ,
            array(
                'B',
                'orange'
            ) ,
            array(
                'C',
                'blue'
            ) ,
            array(
                'D',
                'yellow'
            )
        );
        $projectDetails['map_zoom_level'] = 7;
        $mapurl = 'http://maps.google.com/maps/api/staticmap?center=';
        $mapcenter[] = str_replace(' ', '+', $projectDetails['latitude']) . ',' . $projectDetails['longitude'];
        $mapcenter[] = 'zoom=' . (!empty($projectDetails['map_zoom_level']) ? $projectDetails['map_zoom_level'] : Configure::read('GoogleMap.static_map_zoom_level'));
        $mapcenter[] = 'size=' . $size;
        $mapcenter[] = 'markers=color:pink|label:M|' . $projectDetails['latitude'] . ',' . $projectDetails['longitude'];
        $mapcenter[] = 'sensor=false';
        return $mapurl . implode('&amp;', $mapcenter);
    }
    function getAffiliateCount($user_id = null) 
    {
        App::import('Model', 'Affiliates.Affiliate');
        $this->Affiliate = new Affiliate();
        $affiliate_count = $this->Affiliate->find('count', array(
            'conditions' => array(
                'Affiliate.affliate_user_id' => $user_id
            ) ,
        ));
        return $affiliate_count;
    }
    function getCity() 
    {
        App::import('Model', 'City');
        $this->City = new City();
        $cities = $this->City->find('all', array(
            'conditions' => array(
                'City.is_approved' => 1
            ) ,
            'fields' => array(
                'City.id',
                'City.name',
                'City.slug',
                'City.project_count'
            ) ,
            'order' => array(
                'City.name' => 'asc'
            ) ,
            'recursive' => -1
        ));
        $cityList = array();
        if (!empty($cities)) {
            foreach($cities as $city) {
                $cityList[$city['City']['id']] = $city['City']['name'];
            }
        }
        return $cityList;
    }
    function getContactUserDetails($tempContact) 
    {
        switch ($tempContact['SocialContact']['social_source_id']) {
            case ConstSocialSource::google:
                $conditions['email'] = $tempContact['SocialContactDetail']['email'];
                break;

            case ConstSocialSource::yahoo:
                $conditions['email'] = $tempContact['SocialContactDetail']['email'];
                break;

            case ConstSocialSource::linkedin:
                $conditions['email'] = $tempContact['SocialContactDetail']['email'];
                break;
        }
        $user = array();
        if (!empty($conditions)) {
            App::import('Model', 'User');
            $this->User = new User();
            $user = $this->User->find('first', array(
                'conditions' => $conditions,
                'contain' => array(
                    'UserFollower' => array(
                        'fields' => array(
                            'UserFollower.followed_user_id',
                            'UserFollower.id'
                        ) ,
                        'conditions' => array(
                            'UserFollower.user_id' => $tempContact['SocialContact']['user_id']
                        )
                    )
                ) ,
                'recursive' => 1
            ));
        }
        return $user;
    }
    function getBgImage() 
    {
        App::import('Model', 'Attachment');
        $this->Attachment = new Attachment();
        $attachment = $this->Attachment->find('first', array(
            'conditions' => array(
                'Attachment.class = ' => 'Setting'
            ) ,
            'fields' => array(
                'Attachment.id',
                'Attachment.dir',
                'Attachment.foreign_id',
                'Attachment.filename',
                'Attachment.width',
                'Attachment.height',
            ) ,
            'recursive' => -1
        ));
        return $attachment;
    }
    function cCurrency($str, $wrap = 'span', $title = false, $currency_code = null) 
    {
        if (empty($currency_code)) {
            $currency_code = Configure::read('site.currency_code');
        }
        $_precision = 2;
        $changed = (($r = floatval($str)) != $str);
        $rounded = (($rt = round($r, $_precision)) != $r);
        $r = $rt;
        if ($wrap) {
            if (!$title) {
                $Numbers_Words = new Numbers_Words();
                $title = ucwords($Numbers_Words->toCurrency($r, 'en_US', $currency_code));
            }
            $r = '<' . $wrap . ' class="c' . $changed . ' cr' . $rounded . '" title="' . $title . '">' . number_format($r, $_precision, '.', ',') . '</' . $wrap . '>';
        }
        return $r;
    }
    function getUserInvitedFriendsRegisteredCount($id) 
    {
        App::import('Model', 'Subscription');
        $this->Subscription = new Subscription();
        $count = $this->Subscription->find('count', array(
            'conditions' => array(
                'Subscription.invite_user_id' => $id,
                'Subscription.user_id !=' => '',
            ) ,
            'recursive' => -1
        ));
        return $count;
    }
    function getPluginChildren($plugin, $depth, $image_title_icons) 
    {
        if (!empty($plugin['Children'])) {
            foreach($plugin['Children'] as $key => $subPlugin) {
                if (empty($subPlugin['name'])) {
                    echo $this->_View->element('plugin_head', array(
                        'key' => $key,
                        'image_title_icons' => $image_title_icons,
                        'depth' => $depth
                    ) , array(
                        'plugin' => 'Extensions'
                    ));
                } else {
                    echo $this->_View->element('plugin', array(
                        'pluginData' => $subPlugin,
                        'depth' => $depth
                    ) , array(
                        'plugin' => 'Extensions'
                    ));
                }
                if (!empty($subPlugin['Children'])) {
                    $depth++;
                    $this->getPluginChildren($subPlugin, $depth, $image_title_icons);
                    $depth = 0;
                }
            }
        }
    }
    public function beforeLayout($layoutFile) 
    {
        if ($this instanceof HtmlHelper && isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))) {
            $url = Router::url(array(
                'controller' => 'high_performances',
                'action' => 'update_content',
                'ext' => 'css'
            ) , true);
            if (Configure::read('highperformance.pids') && $this->request->params['controller'] == 'projects' && in_array($this->request->params['action'], array(
                'index',
                'discover'
            ))) {
                $pids = implode(',', Configure::read('highperformance.pids'));
                Configure::write('highperformance.pids', '');
                echo $this->Html->css($url . '?pids=' . $pids, null, array(
                    'inline' => false, 'block' => 'highperformance'
                ));
            } elseif (Configure::read('highperformance.pids') && $this->request->params['controller'] == 'projects' && $this->request->params['action'] == 'view') {
                echo $this->Html->css($url . '?pids=' . Configure::read('highperformance.pids') . '&from=project_view', null, array(
                    'inline' => false, 'block' => 'highperformance'
                ));
            } elseif (Configure::read('highperformance.uids')) {
                echo $this->Html->css($url . '?uids=' . Configure::read('highperformance.uids') , null, array(
                    'inline' => false, 'block' => 'highperformance'
                ));
            } elseif (!empty($_SESSION['Auth']['User']['id']) && $_SESSION['Auth']['User']['id'] == ConstUserIds::Admin && empty($this->request->params['prefix'])) {
                echo $this->Html->css($url . '?uids=' . $_SESSION['Auth']['User']['id'], null, array(
                    'inline' => false, 'block' => 'highperformance'
                ));
            }
            parent::beforeLayout($layoutFile);
        }
    }
	public function getUserShareDetails($project_id) 
	{
		App::import('Model', 'Project.ProjectFund');
		$ProjectFund = new ProjectFund();
		$total_shares_allocated = $ProjectFund->find('all', array(
			'conditions' => array(
				'ProjectFund.user_id' => $_SESSION['Auth']['User']['id'] ,
				'ProjectFund.project_id' => $project_id,
				'ProjectFund.project_fund_status_id' => ConstProjectFundStatus::Authorized,
			) ,
			'contain' => array(
				'EquityFund'
			) ,
			'fields' => array(
				'SUM(EquityFund.shares_allocated) as total_shares_allocated',
			) ,
			'recursive' => 0
		));
		$response['purchased_shares'] = $total_shares_allocated[0][0]['total_shares_allocated'];
		$response['remaining_shares'] = Configure::read('equity.max_share_purchase_per_user') -$total_shares_allocated[0][0]['total_shares_allocated'];
		return $response;
	}
	public function seisCheck($project_id) 
    {
		$response['is_seis_or_eis'] = 0;
		if (isPluginEnabled('Equity')) {
			App::import('Model', 'Equity.Equity');
			$equityObj = new Equity();
			$equity = $equityObj->find('first', array(
				'conditions' => array(
					'Equity.project_id' => $project_id
				) ,
				'fields' => array(
					'Equity.is_seis_or_eis'
				)
			));
			$response['is_seis_or_eis'] = 0;
			if (!empty($equity)) {
				$response['is_seis_or_eis'] = $equity['Equity']['is_seis_or_eis'];
			}
		}
		return $response['is_seis_or_eis'];		
    }
	public function onProjectAddFormLoad(){
		App::import('Model', 'Projects.ProjectType');
		$this->ProjectType = new ProjectType();
		$projectTypes = $this->ProjectType->find('all', array(
				'conditions' => array(
					'ProjectType.is_active' => 1
				) ,
				'fields' => array(
					'ProjectType.name',
					'ProjectType.slug'
				) ,
				'recursive' => -1
			));
		$projectTypeEnablecount = 0;
		$slug = '';
		$contentUrl = '';
		foreach($projectTypes as $projectType) {
			if (isPluginEnabled($projectType['ProjectType']['name'])) {
				$slug = $projectType['ProjectType']['slug'];
				$projectTypeEnablecount++;
			}
		}
		if(!empty($projectTypeEnablecount) && $projectTypeEnablecount > 1){
			$contentUrl = array(
				'controller' => 'projects',
				'action' => 'start',
				'admin' => false
			);
		} elseif ($projectTypeEnablecount == 1) {
			$contentUrl = array(
				'controller' => 'projects',
				'action' => 'add',
				'project_type' => $slug,
				'admin' => false
			);
		}
		return $contentUrl;
	}
}
?>