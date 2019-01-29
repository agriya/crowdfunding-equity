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
class SubmissionField extends AppModel
{
    public $name = 'SubmissionField';
    public $validate = array(
        //'submission_id' => array('numeric'),
        //'form_field' => array('notempty')
        
    );
    public $belongsTo = array(
        'Submission' => array(
            'className' => 'Projects.Submission',
            'foreignKey' => 'submission_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'FormField' => array(
            'className' => 'Projects.FormField',
            'foreignKey' => 'form_field_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    public $hasOne = array(
        'ProjectCloneThumb' => array(
            'className' => 'Attachment',
            'foreignKey' => 'foreign_id',
            'dependent' => false,
            'conditions' => array(
                'ProjectCloneThumb.class' => 'ProjectCloneThumb',
            ) ,
            'fields' => '',
            'order' => ''
        ) ,
        'SubmissionThumb' => array(
            'className' => 'Projects.SubmissionThumb',
            'foreignKey' => 'foreign_id',
            'dependent' => false,
            'conditions' => array(
                'SubmissionThumb.class' => 'SubmissionThumb',
            ) ,
            'fields' => '',
            'order' => ''
        )
    );
}
?>