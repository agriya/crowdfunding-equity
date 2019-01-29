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
class TypesController extends AppController
{
    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    public $name = 'Types';
    public function beforeFilter() 
    {
        parent::beforeFilter();
        if ($this->request->action == 'admin_edit') {
            $this->Security->disabledFields = array(
                'alias'
            );
        }
    }
    public function admin_index() 
    {
        $this->pageTitle = __l('Content Types');
        $this->Type->recursive = 0;
        $this->paginate['Type']['order'] = 'Type.title ASC';
        $this->set('types', $this->paginate());
        $this->set('displayFields', $this->Type->displayFields());
    }
    public function admin_add() 
    {
        $this->pageTitle = sprintf(__l('Add %s') , __l('Type'));
        if (!empty($this->request->data)) {
            $this->Type->create();
            if ($this->Type->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been added') , __l('Type')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Type')) , 'default', null, 'error');
            }
        }
        $vocabularies = $this->Type->Vocabulary->find('list');
        $this->set(compact('vocabularies'));
    }
    public function admin_edit($id = null) 
    {
        $this->pageTitle = sprintf(__l('Edit %s') , __l('Type'));
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(sprintf(__l('Invalid %s') , __l('Type')) , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        if (!empty($this->request->data)) {
            if ($this->Type->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been updated') , __l('Type')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.') , __l('Type')) , 'default', null, 'error');
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->Type->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $vocabularies = $this->Type->Vocabulary->find('list');
        $this->set(compact('vocabularies'));
        $this->pageTitle.= ' - ' . $this->request->data['Type']['title'];
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Type->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , __l('Type')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
