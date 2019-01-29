<?php /* SVN: $Id: admin_index.ctp 2903 2010-09-02 11:57:31Z sakthivel_135at10 $ */ ?>
<?php echo $this->element('project_funds_admin_index', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id'))), array('plugin' => $projectType['ProjectType']['name'])); ?>
