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
class AttachmentsController extends AppController
{
    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    public $name = 'Attachments';
    /**
     * Models used by the Controller
     *
     * @var array
     * @access public
     */
    public $uses = array(
        'Node'
    );
    /**
     * Helpers used by the Controller
     *
     * @var array
     * @access public
     */
    public $helpers = array(
        'Filemanager',
        'Text',
        'Image'
    );
    /**
     * Node type
     *
     * If the Controller uses Node model,
     * this is, most of the time, the singular of the Controller name in lowercase.
     *
     * @var string
     * @access public
     */
    public $type = 'attachment';
    /**
     * Uploads directory
     *
     * relative to the webroot.
     *
     * @var string
     * @access public
     */
    public $uploadsDir = 'uploads';
    /**
     * Before executing controller actions
     *
     * @return void
     * @access public
     */
    public function beforeFilter() 
    {
        parent::beforeFilter();
        // Comment, Category, Tag not needed
        $this->Security->validatePost = false;
        $this->Node->unbindModel(array(
            'hasMany' => array(
                'Comment'
            ) ,
            'hasAndBelongsToMany' => array(
                'Category',
                'Tag'
            )
        ));
        $this->Node->type = $this->type;
        $this->Node->Behaviors->attach('Tree', array(
            'scope' => array(
                'Node.type' => $this->type
            )
        ));
        $this->set('type', $this->type);
        if ($this->request->action == 'admin_add') {
            $this->Security->csrfCheck = false;
        }
    }
    /**
     * Admin index
     *
     * @return void
     * @access public
     */
    public function admin_index() 
    {
        $this->pageTitle = __l('Attachments');
        $this->Node->recursive = 0;
        $this->paginate['Node']['order'] = 'Node.created DESC';
        $this->set('attachments', $this->paginate());
    }
    /**
     * Admin add
     *
     * @return void
     * @access public
     */
    public function admin_add() 
    {
        $this->pageTitle = sprintf(__l('Add %s') , __l('Attachment'));
        if ($this->request->is('post') || !empty($this->request->data)) {
            if (empty($this->request->data['Node'])) {
                $this->Node->invalidate('file', __l('Upload failed. Please ensure size does not exceed the server limit.'));
                return;
            }
            $file = $this->request->data['Node']['file'];
            unset($this->request->data['Node']['file']);
            // check if file with same path exists
            $destination = WWW_ROOT . $this->uploadsDir . DS . $file['name'];
            if (file_exists($destination)) {
                $newFileName = String::uuid() . '-' . $file['name'];
                $destination = WWW_ROOT . $this->uploadsDir . DS . $newFileName;
            } else {
                $newFileName = $file['name'];
            }
            // remove the extension for title
            if (explode('.', $file['name']) > 0) {
                $fileTitleE = explode('.', $file['name']);
                array_pop($fileTitleE);
                $fileTitle = implode('.', $fileTitleE);
            } else {
                $fileTitle = $file['name'];
            }
            $this->request->data['Node']['title'] = $fileTitle;
            $this->request->data['Node']['slug'] = $newFileName;
            $this->request->data['Node']['mime_type'] = $file['type'];
            $this->request->data['Node']['path'] = '/' . $this->uploadsDir . '/' . $newFileName;
            // move the file
            $moved = move_uploaded_file($file['tmp_name'], $destination);
            $this->Node->create();
            if ($moved && $this->Node->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been added') , __l('Attachment')) , 'default', null, 'success');
                if (isset($this->request->params['named']['editor'])) {
                    $this->redirect(array(
                        'action' => 'browse'
                    ));
                } else {
                    $this->redirect(array(
                        'action' => 'index'
                    ));
                }
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Attachment')) , 'default', null, 'error');
            }
        }
    }
    /**
     * Admin edit
     *
     * @param int $id
     * @return void
     * @access public
     */
    public function admin_edit($id = null) 
    {
        $this->pageTitle = sprintf(__l('Edit %s') , __l('Attachment'));
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(sprintf(__l('Invalid %s') , __l('Attachment')) , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        if (!empty($this->request->data)) {
            if ($this->Node->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been updated') , __l('Attachment')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.') , __l('Attachment')) , 'default', null, 'error');
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->Node->read(null, $id);
        }
    }
    /**
     * Admin delete
     *
     * @param int $id
     * @return void
     * @access public
     */
    public function admin_delete($id = null) 
    {
        if (!$id) {
            $this->Session->setFlash(sprintf(__l('Invalid id for %s') , __l('Attachment')) , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        $attachment = $this->Node->find('first', array(
            'conditions' => array(
                'Node.id' => $id,
                'Node.type' => $this->type,
            ) ,
            'recursive' => 0,
        ));
        if (isset($attachment['Node'])) {
            if ($this->Node->delete($id)) {
                unlink(WWW_ROOT . $this->uploadsDir . DS . $attachment['Node']['slug']);
                $this->Session->setFlash(sprintf(__l('%s deleted') , __l('Attachment')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            }
        } else {
            $this->Session->setFlash(sprintf(__l('Invalid id for %s') , __l('Attachment')) , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
    }
}
