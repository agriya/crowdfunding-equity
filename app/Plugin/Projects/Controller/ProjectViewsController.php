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
class ProjectViewsController extends AppController
{
    public $name = 'ProjectViews';
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'project_id',
            'q'
        ));
        $this->pageTitle = sprintf(__l('%s Views') , Configure::read('project.alt_name_for_project_singular_caps'));
        $conditions = array();
        if (!empty($this->request->params['named']['type'])) {
            if ($this->request->params['named']['type'] == 'embed') {
                $conditions['ProjectView.project_view_type_id'] = ConstViewType::EmbedView;
                $this->pageTitle.= ' - ' . __l('Embed');
            } else {
                $conditions['ProjectView.project_view_type_id'] = ConstViewType::NormalView;
                $this->pageTitle.= ' - ' . __l('Normal');
            }
        }
        if (!empty($this->request->params['named']['project'])) {
            $project = $this->ProjectView->Project->find('first', array(
                'conditions' => array(
                    'Project.slug' => $this->request->params['named']['project']
                ) ,
                'fields' => array(
                    'Project.id',
                    'Project.name'
                ) ,
                'recursive' => -1
            ));
            $conditions['ProjectView.project_id'] = $project['Project']['id'];
            $this->pageTitle.= ' - ' . $project['Project']['name'];
        }
        if (isset($this->request->params['named']['q'])) {
            $conditions['AND']['OR'][]['Project.name LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $conditions['AND']['OR'][]['User.username LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        if (!empty($this->request->params['named']['project_id'])) {
            $conditions['ProjectView.project_id'] = $this->request->params['named']['project_id'];
            $project_name = $this->ProjectView->Project->find('first', array(
                'conditions' => array(
                    'Project.id' => $this->request->params['named']['project_id'],
                ) ,
                'fields' => array(
                    'Project.name',
                ) ,
                'recursive' => -1,
            ));
            $this->pageTitle.= ' - ' . $project_name['Project']['name'];
        }
        $this->ProjectView->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'UserAvatar'
                ) ,
                'Project',
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
                        'Ip.longitude',
                        'Ip.host'
                    )
                ) ,
            ) ,
            'order' => array(
                'ProjectView.id' => 'desc'
            ) ,
        );
        $this->set('projectViews', $this->paginate());
        $moreActions = $this->ProjectView->moreActions;
        $this->set('moreActions', $moreActions);
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->ProjectView->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , sprintf(__l('%s View') , Configure::read('project.alt_name_for_project_singular_caps'))) , 'default', null, 'success');
            if (!empty($this->request->query['r'])) {
                $this->redirect(Router::url('/', true) . $this->request->query['r']);
            } else {
                $this->redirect(array(
                    'action' => 'index'
                ));
            }
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>