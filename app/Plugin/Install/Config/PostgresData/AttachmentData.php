<?php
/**
 *
 * @package		Crowdfunding
 * @author 		siva_063at09
 * @copyright 	Copyright (c) 2012 {@link http://www.agriya.com/ Agriya Infoway}
 * @license		http://www.agriya.com/ Agriya Infoway Licence
 * @since 		2012-07-25
 *
 */
class AttachmentData {

	public $table = 'attachments';

	public $records = array(
		array(
			'id' => '1',
			'created' => '2009-05-11 20:15:24',
			'modified' => '2009-05-11 20:15:24',
			'class' => 'UserAvatar',
			'foreign_id' => '0',
			'filename' => 'default-avatar.png',
			'dir' => 'UserAvatar/0',
			'mimetype' => 'image/png',
			'filesize' => '1087',
			'height' => '50',
			'width' => '50',
			'thumb' => '',
			'description' => '',
			'amazon_s3_thumb_url' => '',
			'amazon_s3_original_url' => ''
		),
		array(
			'id' => '2',
			'created' => '2010-04-03 08:02:05',
			'modified' => '2010-04-03 08:02:05',
			'class' => 'Project',
			'foreign_id' => '0',
			'filename' => 'project-no-image-icon.png',
			'dir' => 'Project/0',
			'mimetype' => 'image/jpeg',
			'filesize' => '',
			'height' => '',
			'width' => '',
			'thumb' => '',
			'description' => 'Project File',
			'amazon_s3_thumb_url' => '',
			'amazon_s3_original_url' => ''
		),
		array(
			'id' => '3',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'class' => 'Anonymous',
			'foreign_id' => '0',
			'filename' => 'default-anonymous.png',
			'dir' => 'Anonymous/0',
			'mimetype' => 'image/png',
			'filesize' => '1087',
			'height' => '50',
			'width' => '50',
			'thumb' => '',
			'description' => '',
			'amazon_s3_thumb_url' => '',
			'amazon_s3_original_url' => ''
		),
		array(
			'id' => '127',
			'created' => '2013-05-02 18:49:02',
			'modified' => '2013-05-02 18:49:11',
			'class' => 'Processing',
			'foreign_id' => '0',
			'filename' => 'default-processing.png',
			'dir' => 'Processing/0',
			'mimetype' => 'image/png',
			'filesize' => '1087',
			'height' => '50',
			'width' => '50',
			'thumb' => '',
			'description' => '',
			'amazon_s3_thumb_url' => '',
			'amazon_s3_original_url' => ''
		),
	);

}
