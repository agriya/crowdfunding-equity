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
class TaxonomyData {

	public $table = 'taxonomies';

	public $records = array(
		array(
			'id' => '1',
			'parent_id' => '',
			'term_id' => '1',
			'vocabulary_id' => '1',
			'lft' => '1',
			'rght' => '2'
		),
		array(
			'id' => '2',
			'parent_id' => '',
			'term_id' => '2',
			'vocabulary_id' => '1',
			'lft' => '3',
			'rght' => '4'
		),
		array(
			'id' => '3',
			'parent_id' => '',
			'term_id' => '3',
			'vocabulary_id' => '2',
			'lft' => '1',
			'rght' => '2'
		),
	);

}
