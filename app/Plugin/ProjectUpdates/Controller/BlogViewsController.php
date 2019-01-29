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
class BlogViewsController extends AppController
{
    public $name = 'BlogViews';
    public function admin_index() 
    {
        $this->_redirectGET2Named(array(
            'q'
        ));
        $this->pageTitle = __l('Update Views');
        $conditions = array();
        if (!empty($this->request->params['named']['blog'])) {
            $blog = $this->{$this->modelClass}->Blog->find('first', array(
                'conditions' => array(
                    'Blog.id' => $this->request->params['named']['blog']
                ) ,
                'fields' => array(
                    'Blog.id',
                    'Blog.title',
                    'Blog.slug'
                ) ,
                'recursive' => -1
            ));
            if (empty($blog)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['Blog.id'] = $blog['Blog']['id'];
            $this->pageTitle.= sprintf(__l(' - Update - %s') , $blog['Blog']['title']);
        }
        if (!empty($this->request->params['named']['q'])) {
            $this->request->data['BlogView']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->BlogView->recursive = 2;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.username'
                    ) ,
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.dir',
                            'UserAvatar.filename',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    )
                ) ,
                'Blog' => array(
                    'fields' => array(
                        'Blog.title',
                        'Blog.slug'
                    )
                ) ,
                'Ip' => array(
                    'City' => array(
                        'fields' => array(
                            'City.name',
                        )
                    ) ,
                    'State' => array(
                        'fields' => array(
                            'State.name',
                        )
                    ) ,
                    'Country' => array(
                        'fields' => array(
                            'Country.name',
                            'Country.iso_alpha2',
                        )
                    ) ,
                    'fields' => array(
                        'Ip.ip',
                        'Ip.latitude',
                        'Ip.longitude'
                    )
                ) ,
            ) ,
            'order' => array(
                'BlogView.id' => 'desc'
            ) ,
        );
        if (!empty($this->request->data['BlogView']['q'])) {
            $this->paginate = array_merge($this->paginate, array(
                'search' => $this->request->data['BlogView']['q']
            ));
        }
        $this->set('blogViews', $this->paginate());
        $moreActions = $this->BlogView->moreActions;
        $this->set('moreActions', $moreActions);
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->BlogView->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s Update View deleted') , Configure::read('project.alt_name_for_project_singular_caps')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>