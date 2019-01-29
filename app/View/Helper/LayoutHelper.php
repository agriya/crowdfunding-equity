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
class LayoutHelper extends AppHelper
{
    /**
     * Other helpers used by this helper
     *
     * @var array
     * @access public
     */
    public $helpers = array(
        'Html',
        'Form',
        'Session',
        'Js',
    );
    /**
     * Current Node
     *
     * @var array
     * @access public
     */
    public $node = null;
    /**
     * Core helpers
     *
     * Extra supported callbacks, like beforeNodeInfo() and afterNodeInfo(),
     * won't be called for these helpers.
     *
     * @var array
     * @access public
     */
    public $coreHelpers = array();
    /**
     * Javascript variables
     *
     * Shows cms.js file along with useful information like the applications's basePath, etc.
     *
     * Also merges Configure::read('Js') with the Cms js variable.
     * So you can set javascript info anywhere like Configure::write('Js.my_var', 'my value'),
     * and you can access it like 'Cms.my_var' in your javascript.
     *
     * @return string
     */
    public function js() 
    {
        $cms = array();
        if (isset($this->request->params['locale'])) {
            $cms['basePath'] = Router::url('/' . $this->request->params['locale'] . '/');
        } else {
            $cms['basePath'] = Router::url('/');
        }
        $cms['params'] = array(
            'controller' => $this->request->params['controller'],
            'action' => $this->request->params['action'],
            'named' => $this->request->params['named'],
        );
        $cms['cfg'] = array(
            'path_relative' => Router::url('/') ,
            'path_absolute' => Router::url('/', true) ,
            'site_name' => Configure::read('site.name') ,
            'timezone' => date('Z') /(60*60) ,
            'date_format' => 'M d, Y',
            'today_date' => date('Y-m-d')
        );
        if (is_array(Configure::read('Js'))) {
            $cms = Set::merge($cms, Configure::read('Js'));
        }
        return $cms;
    }
    /**
     * Status
     *
     * instead of 0/1, show tick/cross
     *
     * @param integer $value 0 or 1
     * @return string formatted img tag
     */
    public function status($value) 
    {
        if ($value == 1) {
            $output = '<i class="fa fa-check"></i>';
        } else {
            $output = '<i class="fa fa-times"></i>';
        }
        return $output;
    }
    /**
     * Show flash message
     *
     * @return string
     */
    public function sessionFlash() 
    {
        $messages = $this->Session->read('Message');
        $output = '';
        if (is_array($messages) && !empty($messages)) {
            $output = '<div class="js-flash-message">';
            foreach(array_keys($messages) AS $key) {
                $output.= $this->Session->flash($key);
            }
            $output.= '</div>';
        }
        return $output;
    }
    /**
     * Show flash message
     *
     * @return string
     */
    public function sessionSubscriptionFlash() 
    {
        $messages = $this->Session->read('Message');
        $output = '';
        if (is_array($messages) && !empty($messages)) {
            $output = '<div class="text">';
            foreach($messages AS $key => $message) {
                $output.= '<div class="' . $key . '">' . $message['message'] . '</div>';
            }
            $output.= '</div>';
        }
        return $output;
    }
    /**
     * Meta tags
     *
     * @return string
     */
    public function meta($metaForLayout = array()) 
    {
        $_metaForLayout = array();
        if (is_array(Configure::read('meta'))) {
            $_metaForLayout = Configure::read('meta');
        }
        if (count($metaForLayout) == 0 && isset($this->_View->viewVars['node']['CustomFields']) && count($this->_View->viewVars['node']['CustomFields']) > 0) {
            $metaForLayout = array();
            foreach($this->_View->viewVars['node']['CustomFields'] AS $key => $value) {
                if (strstr($key, 'meta_')) {
                    $key = str_replace('meta_', '', $key);
                    $metaForLayout[$key] = $value;
                }
            }
        }
        $metaForLayout = array_merge($_metaForLayout, $metaForLayout);
        $output = '';
        foreach($metaForLayout AS $name => $content) {
            $output.= '<meta name="' . $name . '" content="' . $content . '" />';
        }
        return $output;
    }
    /**
     * isLoggedIn
     *
     * if User is logged in
     *
     * @return boolean
     */
    public function isLoggedIn() 
    {
        if ($this->Session->check('Auth.User.id')) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Feed
     *
     * RSS feeds
     *
     * @param boolean $returnUrl if true, only the URL will be returned
     * @return string
     */
    public function feed($returnUrl = false) 
    {
        if (Configure::read('Site.feed_url')) {
            $url = Configure::read('Site.feed_url');
        } else {
            $url = '/nodes/promoted.rss';
        }
        if ($returnUrl) {
            $output = $url;
        } else {
            $url = Router::url($url);
            $output = '<link href="' . $url . '" type="application/rss+xml" rel="alternate" title="RSS 2.0" />';
            return $output;
        }
        return $output;
    }
    /**
     * Get Role ID
     *
     * @return integer
     */
    public function getRoleId() 
    {
        if ($this->isLoggedIn()) {
            $roleId = $this->Session->read('Auth.User.role_id');
        } else {
            // Public
            $roleId = 3;
        }
        return $roleId;
    }
    /**
     * Region is empty
     *
     * returns true if Region has no Blocks.
     *
     * @param string $regionAlias Region alias
     * @return boolean
     */
    public function regionIsEmpty($regionAlias) 
    {
        if (isset($this->_View->viewVars['blocks_for_layout'][$regionAlias]) && count($this->_View->viewVars['blocks_for_layout'][$regionAlias]) > 0) {
            return false;
        } else {
            return true;
        }
    }
    /**
     * Show Blocks for a particular Region
     *
     * @param string $regionAlias Region alias
     * @param array $options
     * @return string
     */
    public function blocks($regionAlias, $options = array()) 
    {
        $output = '';
        if (!$this->regionIsEmpty($regionAlias)) {
            $blocks = $this->_View->viewVars['blocks_for_layout'][$regionAlias];
            foreach($blocks AS $block) {
                $plugin = false;
                if ($block['Block']['element'] != null) {
                    if (strstr($block['Block']['element'], '.')) {
                        $plugin_element = explode('.', $block['Block']['element']);
                        $plugin = $plugin_element[0];
                        $element = $plugin_element[1];
                    } else {
                        $element = $block['Block']['element'];
                    }
                } else {
                    $element = 'block';
                }
                $_options = array(
                    'block' => $block
                );
                $options = array_merge($_options, $options);
                $blockOutput = '';
                if ($plugin) {
                    if (isPluginEnabled($plugin)) {
                        $blockOutput = $this->_View->element($element, $options, array(
                            'plugin' => $plugin
                        ));
                    }
                } else {
                    $blockOutput = $this->_View->element($element, $options);
                }
                $enclosure = isset($block['Params']['enclosure']) ? $block['Params']['enclosure'] === "true" : true;
                if ($element != 'block' && $enclosure) {
                    $block['Block']['body'] = $blockOutput;
                    $block['Block']['element'] = null;
                    $output.= $this->_View->element('block', array(
                        'block' => $block
                    ));
                } else {
                    $output.= $blockOutput;
                }
            }
        }
        return $output;
    }
    /**
     * Show Menu by Alias
     *
     * @param string $menuAlias Menu alias
     * @param array $options (optional)
     * @return string
     */
    public function menu($menuAlias, $options = array()) 
    {
		if($menuAlias == 'footer1' || $menuAlias == 'footer2' || $menuAlias == 'footer3') {
			$_options = array(
				'tag' => 'ul',
				'tagAttributes' => array(
					'class' => 'list-unstyled text-capitalize h3  resp-foo-menu colps',
					'id' => 'sub-menu'
				) ,
				'selected' => '',
				'dropdown' => false,
				'dropdownClass' => '',
				'element' => 'menu',
			);
		} else {
			$_options = array(
				'tag' => 'ul',
				'tagAttributes' => array(
					'class' => 'list-unstyled clearfix'
				) ,
				'selected' => 'selected',
				'dropdown' => false,
				'dropdownClass' => 'sf-menu',
				'element' => 'menu',
			);
		}
        $options = array_merge($_options, $options);
        if (!isset($this->_View->viewVars['menus_for_layout'][$menuAlias])) {
            return false;
        }
        $menu = $this->_View->viewVars['menus_for_layout'][$menuAlias];
        $output = $this->_View->element($options['element'], array(
            'menu' => $menu,
            'options' => $options,
        ));
        return $output;
    }
    /**
     * Nested Links
     *
     * @param array $links model output (threaded)
     * @param array $options (optional)
     * @param integer $depth depth level
     * @return string
     */
    public function nestedLinks($links, $options = array() , $depth = 1) 
    {
        $_options = array();
        $options = array_merge($_options, $options);
        $output = '';
        if ((isPluginEnabled('Blog')) && Configure::read('is_enable_to_show_blog_link')) {
            $blog_link_arr = array(
                'Link' => array(
                    'id' => count($links) +1,
                    'rel' => '',
                    'target' => 'blank',
                    'title' => 'Blog',
                    'class' => 'pull-left',
                    'link' => '/blog',
                )
            );
            array_push($links, $blog_link_arr);
        }
        foreach($links AS $link) {
            $linkAttr = array(
                'id' => 'link-' . $link['Link']['id'],
                'rel' => $link['Link']['rel'],
                'target' => $link['Link']['target'],
                'title' => __l($link['Link']['title']),
                'class' => 'pull-left js-no-pjax ' . $link['Link']['class'],
            );
            foreach($linkAttr AS $attrKey => $attrValue) {
                if ($attrValue == null) {
                    unset($linkAttr[$attrKey]);
                }
            }
            // if link is in the format: controller:contacts/action:view
            if (strstr($link['Link']['link'], 'controller:')) {
                $link['Link']['link'] = $this->linkStringToArray($link['Link']['link']);
            }
            if (is_array($link['Link']['link']) && !in_array('admin', array_keys($link['Link']['link']))) {
                $link['Link']['link'] = array_merge($link['Link']['link'], array(
                    'admin' => false
                ));
            }
            // Remove locale part before comparing links
            if (!empty($this->request->params['locale'])) {
                $currentUrl = substr($this->_View->request->url, strlen($this->request->params['locale']));
            } else {
                $currentUrl = $this->_View->request->url;
            }
            if (Router::url($link['Link']['link']) == Router::url('/' . $currentUrl)) {
                if (!isset($linkAttr['class'])) {
                    $linkAttr['class'] = '';
                }
                $linkAttr['class'].= ' ' . $options['selected'];
            }
            $linkOutput = $this->Html->link(__l($link['Link']['title']), $link['Link']['link'], $linkAttr);
            if (isset($link['children']) && count($link['children']) > 0) {
                $linkOutput.= $this->nestedLinks($link['children'], $options, $depth+1);
            }
            $linkOutput = $this->Html->tag('li', $linkOutput, array('class' => 'h5 clearfix'));
            $output.= $linkOutput;
        }
        if ($output != null) {
            $tagAttr = $options['tagAttributes'];
            if ($options['dropdown'] && $depth == 1) {
                $tagAttr['class'] = $options['dropdownClass'];
            }
            $output = $this->Html->tag($options['tag'], $output, $tagAttr);
        }
        return $output;
    }
    /**
     * Converts strings like controller:abc/action:xyz/ to arrays
     *
     * @param string $link link
     * @return array
     */
    public function linkStringToArray($link) 
    {
        $link = explode('/', $link);
        $linkArr = array();
        foreach($link AS $linkElement) {
            if ($linkElement != null) {
                $linkElementE = explode(':', $linkElement);
                if (isset($linkElementE['1'])) {
                    $linkArr[$linkElementE['0']] = $linkElementE['1'];
                } else {
                    $linkArr[] = $linkElement;
                }
            }
        }
        if (!isset($linkArr['plugin'])) {
            $linkArr['plugin'] = false;
        }
        return $linkArr;
    }
    /**
     * Show Vocabulary by Alias
     *
     * @param string $vocabularyAlias Vocabulary alias
     * @param array $options (optional)
     * @return string
     */
    public function vocabulary($vocabularyAlias, $options = array()) 
    {
        $_options = array(
            'tag' => 'ul',
            'tagAttributes' => array() ,
            'type' => null,
            'link' => true,
            'controller' => 'nodes',
            'action' => 'term',
            'element' => 'vocabulary',
        );
        $options = array_merge($_options, $options);
        $output = '';
        if (isset($this->_View->viewVars['vocabularies_for_layout'][$vocabularyAlias]['threaded'])) {
            $vocabulary = $this->_View->viewVars['vocabularies_for_layout'][$vocabularyAlias];
            $output.= $this->_View->element($options['element'], array(
                'vocabulary' => $vocabulary,
                'options' => $options,
            ));
        }
        return $output;
    }
    /**
     * Nested Terms
     *
     * @param array   $terms
     * @param array   $options
     * @param integer $depth
     */
    public function nestedTerms($terms, $options, $depth = 1) 
    {
        $_options = array();
        $options = array_merge($_options, $options);
        $output = '';
        foreach($terms AS $term) {
            if ($options['link']) {
                $termAttr = array(
                    'id' => 'term-' . $term['Term']['id'],
                );
                $termOutput = $this->Html->link($term['Term']['title'], array(
                    'controller' => $options['controller'],
                    'action' => $options['action'],
                    'type' => $options['type'],
                    'slug' => $term['Term']['slug'],
                ) , $termAttr);
            } else {
                $termOutput = $term['Term']['title'];
            }
            if (isset($term['children']) && count($term['children']) > 0) {
                $termOutput.= $this->nestedTerms($term['children'], $options, $depth+1);
            }
            $termOutput = $this->Html->tag('li', $termOutput);
            $output.= $termOutput;
        }
        if ($output != null) {
            $output = $this->Html->tag($options['tag'], $output, $options['tagAttributes']);
        }
        return $output;
    }
    /**
     * Show nodes list
     *
     * @param string $alias Node query alias
     * @param array $options (optional)
     * @return string
     */
    public function nodeList($alias, $options = array()) 
    {
        $_options = array(
            'link' => true,
            'controller' => 'nodes',
            'action' => 'view',
            'element' => 'node_list',
        );
        $options = array_merge($_options, $options);
        $output = '';
        if (isset($this->_View->viewVars['nodes_for_layout'][$alias])) {
            $nodes = $this->_View->viewVars['nodes_for_layout'][$alias];
            $output = $this->_View->element($options['element'], array(
                'alias' => $alias,
                'nodesList' => $this->_View->viewVars['nodes_for_layout'][$alias],
                'options' => $options,
            ));
        }
        return $output;
    }
    /**
     * Filter content
     *
     * Replaces bbcode-like element tags
     *
     * @param string $content content
     * @return string
     */
    public function filter($content) 
    {
        $content = $this->filterElements($content);
        $content = $this->filterMenus($content);
        $content = $this->filterVocabularies($content);
        $content = $this->filterNodes($content);
        return $content;
    }
    /**
     * Filter content for elements
     *
     * Original post by Stefan Zollinger: http://bakery.cakephp.org/articles/view/element-helper
     * [element:element_name] or [e:element_name]
     *
     * @param string $content
     * @return string
     */
    public function filterElements($content) 
    {
        preg_match_all('/\[(element|e):([A-Za-z0-9_\-\/]*)(.*?)\]/i', $content, $tagMatches);
        $validOptions = array(
            'plugin',
            'cache',
            'callbacks'
        );
        for ($i = 0; $i < count($tagMatches[1]); $i++) {
            $regex = '/(\S+)=[\'"]?((?:.(?![\'"]?\s+(?:\S+)=|[>\'"]))*.)[\'"]?/i';
            preg_match_all($regex, $tagMatches[3][$i], $attributes);
            $element = $tagMatches[2][$i];
            $data = $options = array();
            for ($j = 0; $j < count($attributes[0]); $j++) {
                if (in_array($attributes[1][$j], $validOptions)) {
                    $options = Set::merge($options, array(
                        $attributes[1][$j] => $attributes[2][$j]
                    ));
                } else {
                    $data[$attributes[1][$j]] = $attributes[2][$j];
                }
            }
            if (!empty($this->_View->viewVars['block'])) {
                $data['block'] = $this->_View->viewVars['block'];
            }
            $content = str_replace($tagMatches[0][$i], $this->_View->element($element, $data, $options) , $content);
        }
        return $content;
    }
    /**
     * Filter content for Menus
     *
     * Replaces [menu:menu_alias] or [m:menu_alias] with Menu list
     *
     * @param string $content
     * @return string
     */
    public function filterMenus($content) 
    {
        preg_match_all('/\[(menu|m):([A-Za-z0-9_\-]*)(.*?)\]/i', $content, $tagMatches);
        for ($i = 0; $i < count($tagMatches[1]); $i++) {
            $regex = '/(\S+)=[\'"]?((?:.(?![\'"]?\s+(?:\S+)=|[>\'"]))+.)[\'"]?/i';
            preg_match_all($regex, $tagMatches[3][$i], $attributes);
            $menuAlias = $tagMatches[2][$i];
            $options = array();
            for ($j = 0; $j < count($attributes[0]); $j++) {
                $options[$attributes[1][$j]] = $attributes[2][$j];
            }
            $content = str_replace($tagMatches[0][$i], $this->menu($menuAlias, $options) , $content);
        }
        return $content;
    }
    /**
     * Filter content for Vocabularies
     *
     * Replaces [vocabulary:vocabulary_alias] or [v:vocabulary_alias] with Terms list
     *
     * @param string $content
     * @return string
     */
    public function filterVocabularies($content) 
    {
        preg_match_all('/\[(vocabulary|v):([A-Za-z0-9_\-]*)(.*?)\]/i', $content, $tagMatches);
        for ($i = 0; $i < count($tagMatches[1]); $i++) {
            $regex = '/(\S+)=[\'"]?((?:.(?![\'"]?\s+(?:\S+)=|[>\'"]))+.)[\'"]?/i';
            preg_match_all($regex, $tagMatches[3][$i], $attributes);
            $vocabularyAlias = $tagMatches[2][$i];
            $options = array();
            for ($j = 0; $j < count($attributes[0]); $j++) {
                $options[$attributes[1][$j]] = $attributes[2][$j];
            }
            $content = str_replace($tagMatches[0][$i], $this->vocabulary($vocabularyAlias, $options) , $content);
        }
        return $content;
    }
    /**
     * Filter content for Nodes
     *
     * Replaces [node:unique_name_for_query] or [n:unique_name_for_query] with Nodes list
     *
     * @param string $content
     * @return string
     */
    public function filterNodes($content) 
    {
        preg_match_all('/\[(node|n):([A-Za-z0-9_\-]*)(.*?)\]/i', $content, $tagMatches);
        for ($i = 0; $i < count($tagMatches[1]); $i++) {
            $regex = '/(\S+)=[\'"]?((?:.(?![\'"]?\s+(?:\S+)=|[>\'"]))+.)[\'"]?/i';
            preg_match_all($regex, $tagMatches[3][$i], $attributes);
            $alias = $tagMatches[2][$i];
            $options = array();
            for ($j = 0; $j < count($attributes[0]); $j++) {
                $options[$attributes[1][$j]] = $attributes[2][$j];
            }
            $content = str_replace($tagMatches[0][$i], $this->nodeList($alias, $options) , $content);
        }
        return $content;
    }
    /**
     * Meta field: with key/value fields
     *
     * @param string $key (optional) key
     * @param string $value (optional) value
     * @param integer $id (optional) ID of Meta
     * @param array $options (optional) options
     * @return string
     */
    public function metaField($key = '', $value = null, $id = null, $options = array()) 
    {
        $_options = array(
            'key' => array(
                'label' => __l('Name') ,
                'value' => $key,
            ) ,
            'value' => array(
                'label' => __l('Value') ,
                'value' => $value,
            ) ,
        );
        $options = Set::merge($_options, $options);
        $uuid = String::uuid();
        $fields = '';
        if ($id != null) {
            $fields.= $this->Form->input('Meta.' . $uuid . '.id', array(
                'type' => 'hidden',
                'value' => $id
            ));
        }
        $fields.= $this->Form->input('Meta.' . $uuid . '.name', $options['key']);
        $fields.= $this->Form->input('Meta.' . $uuid . '.value', $options['value']);
        $fields = $this->Html->tag('div', $fields, array(
            'class' => 'fields'
        ));
        $actions = $this->Html->link(__l('Remove') , is_null($id) ? '#' : array(
            'plugin' => null,
            'controller' => 'nodes',
            'action' => 'delete_meta',
            $id
        ) , array(
            'class' => 'remove-meta remove grid_right',
            'rel' => $id
        ));
        $actions = $this->Html->tag('div', $actions, array(
            'class' => 'actions'
        ));
        $output = $this->Html->tag('div', $actions . $fields, array(
            'class' => 'meta'
        ));
        return $output;
    }
    /**
     * Show links under Actions column
     *
     * @param integer $id
     * @param array $options
     * @return string
     */
    public function adminRowActions($id) 
    {
        $output = '';
        $rowActions = Configure::read('Admin.rowActions.' . Inflector::camelize($this->request->params['controller']) . '/' . $this->request->params['action']);
        if (is_array($rowActions)) {
            foreach($rowActions AS $title => $rowAction) {
                if ($output != '') {
                    $output.= ' ';
                }
                $link = $this->linkStringToArray(str_replace(':id', $id, $rowAction['url']));
                $output.= $this->Html->tag('li', $this->Html->link($title, $link, $rowAction['options']));
            }
        }
        return $output;
    }
    /**
     * Show tabs
     *
     * @return string
     */
    public function adminTabs($show = null) 
    {
        if (!isset($this->adminTabs)) {
            $this->adminTabs = false;
        }
        $output = '';
        $tabs = Configure::read('Admin.tabs.' . Inflector::camelize($this->request->params['controller']) . '/' . $this->request->params['action']);
        if (is_array($tabs)) {
            foreach($tabs AS $title => $tab) {
                if (!isset($tab['options']['type']) || (isset($tab['options']['type']) && (in_array($this->_View->viewVars['typeAlias'], $tab['options']['type'])))) {
                    $domId = strtolower(Inflector::singularize($this->request->params['controller'])) . '-' . strtolower($title);
                    if ($this->adminTabs) {
                        if (strstr($tab['element'], '.')) {
                            $elementE = explode('.', $tab['element']);
                            $plugin = $elementE['0'];
                            $element = $elementE['1'];
                        } else {
                            $plugin = null;
                        }
                        $output.= '<div id="' . $domId . '">';
                        $output.= $this->_View->element($element, array() , array(
                            'plugin' => $plugin,
                        ));
                        $output.= '</div>';
                    } else {
                        $output.= '<li><a href="#' . $domId . '">' . $title . '</a></li>';
                    }
                }
            }
        }
        $this->adminTabs = true;
        return $output;
    }
    /**
     * Set current Node
     *
     * @param array $node
     * @return void
     */
    public function setNode($node) 
    {
        $this->node = $node;
        $this->hook('afterSetNode');
    }
    /**
     * Set value of a field
     *
     * @param string $field
     * @param string $value
     * @return void
     */
    public function setNodeField($field, $value) 
    {
        $model = 'Node';
        if (strstr($field, '.')) {
            $fieldE = explode('.', $field);
            $model = $fieldE['0'];
            $field = $fieldE['1'];
        }
        $this->node[$model][$field] = $value;
    }
    /**
     * Get value of a Node field
     *
     * @param string $field
     * @return string
     */
    public function node($field = 'id') 
    {
        $model = 'Node';
        if (strstr($field, '.')) {
            $fieldE = explode('.', $field);
            $model = $fieldE['0'];
            $field = $fieldE['1'];
        }
        if (isset($this->node[$model][$field])) {
            return $this->node[$model][$field];
        } else {
            return false;
        }
    }
    /**
     * Node info
     *
     * @param array $options
     * @return string
     */
    public function nodeInfo($options = array()) 
    {
        $_options = array(
            'element' => 'node_info',
        );
        $options = array_merge($_options, $options);
        $output = $this->hook('beforeNodeInfo');
        $output.= $this->_View->element($options['element']);
        $output.= $this->hook('afterNodeInfo');
        return $output;
    }
    /**
     * Node excerpt (summary)
     *
     * @param array $options
     * @return string
     */
    public function nodeExcerpt($options = array()) 
    {
        $_options = array(
            'element' => 'node_excerpt',
        );
        $options = array_merge($_options, $options);
        $output = $this->hook('beforeNodeExcerpt');
        $output.= $this->_View->element($options['element']);
        $output.= $this->hook('afterNodeExcerpt');
        return $output;
    }
    /**
     * Node body
     *
     * @param array $options
     * @return string
     */
    public function nodeBody($options = array()) 
    {
        $_options = array(
            'element' => 'node_body',
        );
        $options = array_merge($_options, $options);
        $output = $this->hook('beforeNodeBody');
        $output.= $this->_View->element($options['element']);
        $output.= $this->hook('afterNodeBody');
        return $output;
    }
    /**
     * Node more info
     *
     * @param array $options
     * @return string
     */
    public function nodeMoreInfo($options = array()) 
    {
        $_options = array(
            'element' => 'node_more_info',
        );
        $options = array_merge($_options, $options);
        $output = $this->hook('beforeNodeMoreInfo');
        $output.= $this->_View->element($options['element']);
        $output.= $this->hook('afterNodeMoreInfo');
        return $output;
    }
    /**
     * Hook
     *
     * Used for calling hook methods from other HookHelpers
     *
     * @param string $methodName
     * @return string
     */
    public function hook($methodName) 
    {
        $output = '';
        foreach($this->_View->helpers AS $helper => $settings) {
            if (!is_string($helper) || in_array($helper, $this->coreHelpers)) {
                continue;
            }
            if (strstr($helper, '.')) {
                $helperE = explode('.', $helper);
                $helper = $helperE['1'];
            }
            if (isset($this->_View->{$helper}) && method_exists($this->_View->{$helper}, $methodName)) {
                $output.= $this->_View->{$helper}->$methodName();
            }
        }
        return $output;
    }
    /** Generate Admin menus added by CmsNav::add()
     *
     * @param array $menus
     * @param array $options
     * @return string menu html tags
     */
    function adminMenus($menus, $options = array()) 
    {
        $options = Set::merge(array(
            'children' => true,
            'htmlAttributes' => array(
                'class' => 'sf-menu',
            ) ,
        ) , $options);
        $out = null;
        $oyt = null;
        $sorted = Set::sort($menus, '{[a-zA-Z _-]+}.weight', 'ASC');
		$admin_url = Router::url(array('admin' => true,'controller' => 'users','action' => 'stats'), true); 
        $out = '<div class="row bot-headr parnt-accord">
					<div class="col-sm-2 col-md-2 col-lg-2 col-xs-8 navbar-btn list-group-item-text  col-lg-02">
						<div class="well-sm">
							<button type="button" class="navbar-toggle hidden" data-target=".navbar-collapse" data-toggle="collapse"> 
								<span class="sr-only">Toggle navigation</span> 
                                <span class="icon-bar"></span> 
                                <span class="icon-bar"></span> 
                                <span class="icon-bar"></span> 
                            </button>
							<h1 class="navbar-btn">
							
								<a href="'.$admin_url.'" title="'.$this->Html->cText(Configure::read('site.name'), false).'">'
									. $this->Html->image('logo-admin.png', array(
										'class' => 'img-responsive',
										'title' => $this->Html->cText(Configure::read('site.name'), false),
										'alt' => '[Image: '.$this->Html->cText(Configure::read('site.name'), false).']'
									)) . '
								</a>
							</h1>
						</div>
					</div>
					<div class="menubar openmenu menubar-2 menubari visble-sm hidden-md hidden-lg pull-right" id="menubari2" onClick="menuFunc()">
						<i class="fa fa-angle-double-left fa-2x" id="openmenud2"></i>
                        <!-- <i class="fa fa-times " id="closemenud"></i>-->
                    </div>
					<div class="header-sm-xs hedr header-sm-2">
						<div class="col-xs-12 col-md-10">													
							<ul class="nav nav-pills main-nav menu-nav">';
								$icon_class = '';
								$intHeader = 0;
								$intSubMenu = 1;
								foreach($sorted as $menu) {
									if ($menu['icon-class'] == 'align-justify') {
										$menu['children'] = Set::sort($menu['children'], '{[a-zA-Z _-]+}.weight', 'ASC');
										foreach($menu['children'] as $childmenu) {
											if (empty($childmenu['url'])) {
												$intHeader++;
											}
											$arrFlag[$intHeader] = $intSubMenu;
											$intSubMenu++;
										}
									}
								}
								$intHalfCount = ceil($intSubMenu/2);
								$intColumn = 9;
								foreach($arrFlag as $intValue) {
									if ($intValue < $intHalfCount) {
										continue;
									} else {
										$intColumn = $intValue-1;
										break;
									}
								}
								foreach($sorted as $menu) {
									if ($menu['icon-class'] == 'align-justify') {
										$menu['column_1'] = $intColumn;
									}
									$controller_arr = array();
									$action_arr = array();
									if (is_array($menu['url'])) {
										$controller_arr[] = $menu['url']['controller'];
										$action_arr[] = $menu['url']['action'];
									}
									if (!empty($menu['children'])) {
										$menu['children'] = Set::sort($menu['children'], '{[a-zA-Z _-]+}.weight', 'ASC');
										foreach($menu['children'] as $child) {
											if (!empty($child['url']['controller'])) {
												$controller_arr[] = $child['url']['controller'];
											}
											if (!empty($child['url']['action'])) {
												$action_arr[] = $child['url']['action'];
											}
										}
									}
									$controller_arr = array_unique($controller_arr);
									if (!empty($menu['allowedControllers'])) {
										$controller_arr = array_merge($controller_arr, $menu['allowedControllers']);
									}
									$action_arr = array_unique($action_arr);
									if (empty($menu['htmlAttributes']['class'])) {
										$menuClass = Inflector::slug(strtolower('menu-' . $menu['title']) , '-');
										$menu['htmlAttributes'] = Set::merge(array(
											'class' => $menuClass
										) , $menu['htmlAttributes']);
									}
									$link = $this->Html->link($menu['title'], $menu['url'], $menu['htmlAttributes']);
									$active_class = '';
									$project_active = '';
									$payment_active = '';
									if (empty($menu['allowedActions'])) {
										$menu['allowedActions'] = array(
											$this->request->params['action']
										);
									}
									if (empty($menu['notAllowedActions'])) {
										$menu['notAllowedActions'] = array();
									}
									if ($this->request->params['controller'] == 'settings' && in_array($menu['icon-class'], array(
										'bullhorn',
										'group',
										'cogs'
									)) && !empty($this->request->params['pass']['0'])) {
										if ($this->request->params['pass']['0'] == '85' && $menu['icon-class'] == 'bullhorn') {
											$active_class = 'active';
										} elseif ($this->request->params['pass']['0'] == '21' && $menu['icon-class'] == 'group') {
											$active_class = 'active';
										} elseif ($menu['icon-class'] == 'cogs' && $this->request->params['pass']['0'] != '21') {
											$active_class = 'active';
										}
									} else {
										if (!empty($menu['allowedActions']) || !empty($menu['notAllowedActions'])) {
											$active_class = (in_array($this->request->params['controller'], $controller_arr) && in_array($this->request->params['action'], $menu['allowedActions']) && !in_array($this->request->params['action'], $menu['notAllowedActions'])) ? 'active' : null;
											if (($menu['title'] == 'Analytics' && $this->request->params['controller'] == 'insights' && $this->request->params['action'] == 'admin_project_stats') || ($menu['title'] == 'Projects' && $this->request->params['controller'] == 'insights' && $this->request->params['action'] == 'admin_index')) {
												$active_class = '';
											}  
											if (($menu['title'] == 'Projects' && $this->request->params['controller'] == 'insights' && $this->request->params['action'] == 'admin_project_stats') || ($menu['title'] == 'Analytics' && $this->request->params['controller'] == 'insights' && $this->request->params['action'] == 'admin_index')) {
												$active_class = 'active';
											}
											if (empty($icon_class) && !empty($active_class)) {
												$icon_class = (in_array($this->request->params['controller'], $controller_arr) && in_array($this->request->params['action'], $menu['allowedActions']) && !in_array($this->request->params['action'], $menu['notAllowedActions'])) ? $menu['title'] : null;
												Configure::write('admin_heading_class', 'icon-' . $menu['icon-class']);
											}
										} else {
											$active_class = (in_array($this->request->params['controller'], $controller_arr)) ? ' active' : null;
											if (empty($icon_class) && !empty($active_class)) {
												$icon_class = (in_array($this->request->params['controller'], $controller_arr)) ? $menu['title'] : null;
												Configure::write('admin_heading_class', 'icon-' . $menu['icon-class']);
											}
										}
									}
									$class = '';
									if ($menu['icon-class'] == 'align-justify') {
										$class = " ";
									}
									if ($menu['icon-class'] == 'admin-payment' && ($this->request->params['controller'] == 'pledges' || $this->request->params['controller'] == 'donates' || $this->request->params['controller'] == 'lends' || $this->request->params['controller'] == 'equities') && $this->request->params['action'] == 'admin_funds') {
										$payment_active = 'active';
										$project_active = '';
										$out.= '<li class="text-center list-group-item-text dropdown ' . $payment_active . $class . ' ">';
									} else if ($menu['icon-class'] == 'file' && ($this->request->params['controller'] == 'pledges' || $this->request->params['controller'] == 'donates' || $this->request->params['controller'] == 'lends' || $this->request->params['controller'] == 'equities') && $this->request->params['action'] == 'admin_index') {
										$project_active = 'active';
										$payment_active = '';
										$out.= '<li class="text-center list-group-item-text dropdown ' . $project_active . $class . ' ">';
									} else if ($menu['icon-class'] == 'cogs' && $this->request->params['controller'] == 'settings' && isset($this->request->params['pass'][0]) && $this->request->params['pass'][0] == '21') {
										$project_active = '';
										$payment_active = 'active';
										$out.= '<li class="text-center list-group-item-text dropdown ' . $payment_active . $class . ' ">';
									} else {
										if ($menu['title'] == 'Payments' && ($this->request->params['controller'] == 'pledges' || $this->request->params['controller'] == 'donates' || $this->request->params['controller'] == 'lends' || $this->request->params['controller'] == 'equities' || $this->request->params['controller'] == 'settings')) {
											$active_class = '';
										}
										if ($menu['title'] == 'Projects' && ($this->request->params['controller'] == 'pledges' || $this->request->params['controller'] == 'donates' || $this->request->params['controller'] == 'lends' || $this->request->params['controller'] == 'equities')) {
											$active_class = '';
										}
										if ($menu['title'] == 'Payments' && $this->request->params['controller'] == 'settings') {
											$active_class = '';
										}
										if ($this->request->params['controller'] == 'project_types' && $menu['icon-class'] == 'random') {
											$active_class = 'active';
										}
										$out.= '<li class="text-center list-group-item-text dropdown ' . $active_class . $class . ' ">';
									}
									$tour_main_class = $tour_class = '';
									if (($this->request->params['controller'] == 'users') && ($this->request->params['action'] == 'admin_stats')) {
										$tour_main_class = " bootstro";
										$data_bootstro_step = empty($menu['data-bootstro-step']) ? '' : $menu['data-bootstro-step'];
										$data_bootstro_content = empty($menu['data-bootstro-content']) ? '' : __l($menu['data-bootstro-content']);
										$data_bootstro_title = empty($menu['title']) ? '' : __l($menu['title']);
										$tour_class = 'data-bootstro-step=' . $data_bootstro_step . ' data-bootstro-content="' . $data_bootstro_content . '" data-bootstro-title="' . $data_bootstro_title . '" data-bootstro-placement="left"';
									}
									$out.= '<a class="dropdown-toggle js-no-pjax ' . $tour_main_class . '"  data-toggle="dropdown" data-hover="dropdown"  href="#" ' . $tour_class . ' >';
									if ($menu['icon-class'] == 'admin-payment') {
										$out.= '<span class="show center-block navbar-btn fa-black"><i class="fa fa-credit-card"></i></span>';
									} else {
										$out.= '<span class="show center-block navbar-btn"><i class="fa fa-' . $menu['icon-class'] . '"></i></span>';
									}
									$out.= '<span class="panel-title">';
									$out.= __l($menu['title']);
									$out.= '</span></a>';
									if ($menu['icon-class'] == 'random') {
										$out.= '<ul class="dropdown-menu cl-sb-5 pull-right dl drp-aft-rght">';
										$out.= '<li class="col-sm-12 page-header">';
										$out.= '<h3 class="h4"><strong>';
										$out.= sprintf(__l('%s Type Builder') , Configure::read('project.alt_name_for_project_singular_caps'));
										$out.= '</strong></h3>';
										$out.= '<h2 class="h4">';
										$out.= $this->Html->link(sprintf(__l('%s Form and Pricing for Types') , Configure::read('project.alt_name_for_project_singular_caps')) , array(
											'controller' => 'project_types',
											'action' => 'index'
										));
										$out.= "</h2>";
										$out.= '<h6><spav class="ver-space"><i class="fa fa-exclamation-circle fa-fw"></i>';
										$out.= sprintf(__l('Customize %s form and pricing for %s, Donate, Lending and Equity') , Configure::read('project.alt_name_for_project_singular_small') , Configure::read('project.alt_name_for_pledge_singular_small'));
										$out.= "</span></h6>";
										$out.= "</li>";
										$out.= '<li class="col-sm-12 page-header">';
										$out.= '<h3 class="h4"><strong>';
										$out.= __l('Theme Manager');
										$out.= "</strong></h3>";
										$out.= '<p class="h5">';
										$out.= $this->Html->link(__l('Themes') , array(
											'controller' => 'extensions_themes',
											'action' => 'index'
										) , array(
											'class' => '',
											'escape' => false
										));
										$out.= '</p>';
										$out.= '<h6><span class="ver-space"><i class="fa fa-exclamation-circle fa-fw"></i>';
										$out.= __l('Manage your site themes');
										$out.= "</span></h6>";
										$out.= "</li>";
										$out.= '<li class="col-sm-12 page-header cms-builder">';
										$out.= '<h3 class="h4"><strong>';
										$out.= __l('CMS Builder');
										$out.= "</strong> </h3>";
										$out.= '<div>';
										$out.= '<p class="h5 col-sm-6">';
										$out.= $this->Html->link(__l('Contents') , array(
											'controller' => 'nodes',
											'action' => 'index'
										));
										$out.= "</p>";
										$out.= '<p class="h5 col-sm-6">';
										$out.= $this->Html->link(__l('Menus') , array(
											'controller' => 'menus',
											'action' => 'index'
										));
										$out.= '</p>';
										$out.= '<p class="h5 col-sm-6 ">';
										$out.= $this->Html->link(__l('Blocks') , array(
											'controller' => 'blocks',
											'action' => 'index'
										) , array(
											'class' => '',
											'escape' => false
										));
										$out.= '</p>';
										$out.= '<h6 class="col-sm-6"><span class="ver-space"><i class="fa fa-exclamation-circle fa-fw"></i>';
										$out.= __l('Menus for CMS contents');
										$out.= "</span></h6>";
										$out.= '<h6 class="col-sm-12"><span class="ver-space"><i class="fa fa-exclamation-circle fa-fw"></i>';
										$out.= __l('Blocks are reusable');
										$out.= "</span></h6>";
										$out.= '<h4 class="col-sm-12">';
										$out.= __l('chunks for contents');
										$out.= "</h4>";
										$out.= '</div>';
										$out.= '</li>';
										$out.= "</ul>";
									} else {
										if (!empty($menu['children'])) {
											if (!empty($menu['column']) && $menu['column'] > 1) {
												$out.= '<ul class="dropdown-menu pull-right cl-set-5 dl drp-aft-rght">';
												$out.= '<li class="col-sm-6 no-mar">';
												if (empty($menu['is_hide_title'])) {
													$out.= '<h4><strong>' . __l($menu['title']) . '</strong></h4>';
												}
												$out.= '</li>';
												$out.= '<li class="clearfix col-sm-6 no-pad">';
												if ($menu['icon-class'] == 'cogs') {
													$out.= '<div class="hor-space">';
													$out.= $this->Html->link('<h4 class="no-mar"><span class="pull-left"><i class="fa fa-cog fa-fw"></i></span><strong>' . __l('Settings Overview') . '</strong></h4>', array(
														'controller' => 'settings',
														'action' => 'index'
													) , array(
														'class' => '',
														'escape' => false,
														'title' => __l('Settings Overview')
													));
													$out.= '</div>';
												}
												if ($menu['icon-class'] == 'admin-masters') {
													$out.= '<li>';
													$out.= '<div class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i><span class="text-center">';
													$out.= __l('Warning! Please edit with caution.');
													$out.= '</span></div></li>';
												}
												$out.= '</li>';
												
												$out.= '<li  class="well-sm col-xs-12 no-pad">';
												if ($menu['column'] == 3) {
													$out.= '<div class="col-sm-4">';
												}else if ($menu['column'] == 2) {
													$out.= '<div class="col-sm-6">';
												}
												for ($i = 1; $i <= $menu['column']; $i++) {
													if ($i == 1) {
														$from = 0;
														$to = round(count($menu['children']) /$menu['column']);
														$li_class = '';
													}
													else if ($i == 2 && $menu['column'] == 3) {
														 $out.= '</div><div class="col-sm-4">';
														$from = $to+1;
														$to = $to + floor(count($menu['children']) /$menu['column']);
														$li_class = '';
													}else {
														if ($menu['column'] == 3) {
															$out.= '</div><div class="col-sm-4">';
														}else if ($menu['column'] == 2) {
															$out.= '</div><div class="col-sm-6">';
														}
														$from = $to+1;
														$to = count($menu['children']);
														$li_class = '';
													}
													$out.= '<ul class="list-unstyled h2 no-mar admin-menu">';
													$out.= $this->_getLinks($menu, $from, $to);
													$out.= '</ul>';
												}
												$out.= '</div>';
												$out.= '</li></ul>';
											} else {
												$out.= '<ul class="dropdown-menu dl admin-menu">';
												$out.= $this->_getLinks($menu);
												$out.= '</ul>';
											}
										}
									}
									$out.= '</li>';
									}
							$out.= '</ul>							
						</div>
					</div>
				</div>';
        return $out;
    }
    function _getLinks($menu, $from = 0, $to = 0) 
    {
        $out = '';
        $i = 0;
        foreach($menu['children'] as $child) {
            if ((empty($from) && empty($to)) || ($i >= $from && $i <= $to)) {
                if (empty($child['htmlAttributes']['title'])) {
                    $child['htmlAttributes']['title'] = __l($child['title']);
                }
                $child['htmlAttributes']['escape'] = false;
                if($menu['title'] == 'Settings' || $menu['title'] == 'Masters'){
					if($menu['title'] == 'Masters' && empty($child['url'])){
						$out.= '<li class="h5"><h4><strong>';
					} else {
						$out.= '<li class="h5">';
					}
				} else {
					$out.= '<li>';
				}
                $icon = '';
                if (!empty($child['url']['controller']) && $child['url']['controller'] == 'payment_gateways') {
                    $icon.= '<i class="fa fa-cog fa-fw"></i>';
                }
				if(($child['title'] == 'Affiliates' || $child['title'] == 'Projects Funded' || $child['title'] == 'Withdraw Fund Request') && empty($child['url'])) {
					$out.= '<h4 class="ver-space no-mar">';
				}
                if (!empty($child['url'])) {
                    if ($child['url']['action'] == 'stats') {
                        $child['htmlAttributes']['class'] = 'js-no-pjax';
                    }
                    $out.= $this->Html->link($icon . __l($child['title']), $child['url'], $child['htmlAttributes']);
                } else {
                    $out.= __l($child["title"]);
                }
				if(($child['title'] == 'Affiliates' || $child['title'] == 'Projects Funded' || $child['title'] == 'Withdraw Fund Request') && empty($child['url'])) {
					$out.= '</h4>';
				}
				if($menu['title'] == 'Masters' && empty($child['url'])){
					$out.= '</strong></h4></li>';
				} else {
					$out.= '</li>';
				}
            }
            $i++;
        }
        return $out;
    }
}
?>