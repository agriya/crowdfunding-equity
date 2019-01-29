<?php 
class AppSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $acl_link_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $acl_links = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true),
		'controller' => array('type' => 'string', 'null' => true),
		'action' => array('type' => 'string', 'null' => true),
		'named_key' => array('type' => 'string', 'null' => true),
		'named_value' => array('type' => 'string', 'null' => true),
		'pass_value' => array('type' => 'string', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $acl_links_roles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'role_id' => array('type' => 'integer', 'null' => true),
		'acl_link_id' => array('type' => 'integer', 'null' => true),
		'acl_link_status_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'acl_links_roles_acl_link_id_idx' => array('unique' => false, 'column' => 'acl_link_id'),
			'acl_links_roles_acl_link_status_id_idx' => array('unique' => false, 'column' => 'acl_link_status_id'),
			'acl_links_roles_role_id_idx' => array('unique' => false, 'column' => 'role_id')
		),
		'tableParameters' => array()
	);
	public $affiliate_cash_withdrawal_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $affiliate_cash_withdrawals = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'affiliate_cash_withdrawal_status_id' => array('type' => 'integer', 'null' => true),
		'amount' => array('type' => 'float', 'null' => true),
		'commission_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'payment_gateway_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'affiliate_cash_withdrawals_payment_gateway_id_idx' => array('unique' => false, 'column' => 'payment_gateway_id'),
			'affiliate_cash_withdrawals_user_id_idx' => array('unique' => false, 'column' => 'user_id'),
			'iliate_cash_withdrawals_affiliate_cash_withdrawal_status_id_idx' => array('unique' => false, 'column' => 'affiliate_cash_withdrawal_status_id')
		),
		'tableParameters' => array()
	);
	public $affiliate_commission_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true),
		'description' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $affiliate_requests = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'site_name' => array('type' => 'string', 'null' => true, 'default' => null),
		'site_description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'site_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'site_category_id' => array('type' => 'integer', 'null' => true),
		'why_do_you_want_affiliate' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'is_web_site_marketing' => array('type' => 'boolean', 'null' => true),
		'is_search_engine_marketing' => array('type' => 'boolean', 'null' => true),
		'is_email_marketing' => array('type' => 'boolean', 'null' => true),
		'special_promotional_method' => array('type' => 'string', 'null' => true, 'default' => null),
		'special_promotional_description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'is_approved' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'affiliate_requests_site_category_id_idx' => array('unique' => false, 'column' => 'site_category_id'),
			'affiliate_requests_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $affiliate_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'date', 'null' => true),
		'modified' => array('type' => 'date', 'null' => true),
		'name' => array('type' => 'string', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $affiliate_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true),
		'model_name' => array('type' => 'string', 'null' => true),
		'commission' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'affiliate_commission_type_id' => array('type' => 'integer', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true),
		'plugin_name' => array('type' => 'string', 'null' => true, 'length' => 220),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'affiliate_types_affiliate_commission_type_id_idx' => array('unique' => false, 'column' => 'affiliate_commission_type_id'),
			'affiliate_types_plugin_name_idx' => array('unique' => false, 'column' => 'plugin_name')
		),
		'tableParameters' => array()
	);
	public $affiliates = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'class' => array('type' => 'string', 'null' => true),
		'foreign_id' => array('type' => 'integer', 'null' => true),
		'affiliate_type_id' => array('type' => 'integer', 'null' => true),
		'affliate_user_id' => array('type' => 'integer', 'null' => true),
		'affiliate_status_id' => array('type' => 'integer', 'null' => true),
		'commission_amount' => array('type' => 'float', 'null' => true),
		'commission_holding_start_date' => array('type' => 'date', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'affiliates_affiliate_status_id_idx' => array('unique' => false, 'column' => 'affiliate_status_id'),
			'affiliates_affiliate_type_id_idx' => array('unique' => false, 'column' => 'affiliate_type_id'),
			'affiliates_affliate_user_id_idx' => array('unique' => false, 'column' => 'affliate_user_id'),
			'affiliates_class_idx' => array('unique' => false, 'column' => 'class'),
			'affiliates_foreign_id_idx' => array('unique' => false, 'column' => 'foreign_id')
		),
		'tableParameters' => array()
	);
	public $attachments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'class' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'foreign_id' => array('type' => 'integer', 'null' => true),
		'filename' => array('type' => 'string', 'null' => true, 'default' => null),
		'dir' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'mimetype' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'filesize' => array('type' => 'integer', 'null' => true),
		'height' => array('type' => 'integer', 'null' => true),
		'width' => array('type' => 'integer', 'null' => true),
		'thumb' => array('type' => 'boolean', 'null' => true),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'amazon_s3_thumb_url' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'amazon_s3_original_url' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'attachments_class_idx' => array('unique' => false, 'column' => 'class'),
			'attachments_foreign_id_idx' => array('unique' => false, 'column' => 'foreign_id')
		),
		'tableParameters' => array()
	);
	public $banned_ips = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'address' => array('type' => 'string', 'null' => true, 'default' => null),
		'range' => array('type' => 'string', 'null' => true, 'default' => null),
		'referer_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'reason' => array('type' => 'string', 'null' => true, 'default' => null),
		'redirect' => array('type' => 'string', 'null' => true, 'default' => null),
		'thetime' => array('type' => 'integer', 'null' => true),
		'timespan' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'banned_ips_address_idx' => array('unique' => false, 'column' => 'address'),
			'banned_ips_range_idx' => array('unique' => false, 'column' => 'range')
		),
		'tableParameters' => array()
	);
	public $blocks = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'region_id' => array('type' => 'integer', 'null' => true),
		'title' => array('type' => 'string', 'null' => true, 'length' => 100),
		'alias' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'body' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'show_title' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'class' => array('type' => 'string', 'null' => true, 'default' => null),
		'status' => array('type' => 'boolean', 'null' => true),
		'weight' => array('type' => 'integer', 'null' => true),
		'element' => array('type' => 'string', 'null' => true, 'default' => null),
		'visibility_roles' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'visibility_paths' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'visibility_php' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'params' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'modified' => array('type' => 'datetime', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true),
		'plugin_name' => array('type' => 'string', 'null' => true, 'length' => 220),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'blocks_alias_key' => array('unique' => true, 'column' => 'alias'),
			'blocks_plugin_name_idx' => array('unique' => false, 'column' => 'plugin_name'),
			'blocks_region_id_idx' => array('unique' => false, 'column' => 'region_id')
		),
		'tableParameters' => array()
	);
	public $blog_comments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'blog_id' => array('type' => 'integer', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'project_id' => array('type' => 'integer', 'null' => true),
		'project_type_id' => array('type' => 'integer', 'null' => true),
		'comment' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'is_admin_suspended' => array('type' => 'boolean', 'null' => true),
		'is_system_flagged' => array('type' => 'boolean', 'null' => true),
		'detected_suspicious_words' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'blog_comments_blog_id_idx' => array('unique' => false, 'column' => 'blog_id'),
			'blog_comments_ip_id_idx' => array('unique' => false, 'column' => 'ip_id'),
			'blog_comments_is_admin_suspended_idx' => array('unique' => false, 'column' => 'is_admin_suspended'),
			'blog_comments_is_system_flagged_idx' => array('unique' => false, 'column' => 'is_system_flagged'),
			'blog_comments_project_id_idx' => array('unique' => false, 'column' => 'project_id'),
			'blog_comments_project_type_id_idx' => array('unique' => false, 'column' => 'project_type_id'),
			'blog_comments_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $blog_tags = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 110),
		'blog_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'blog_tags_slug_idx' => array('unique' => false, 'column' => 'slug')
		),
		'tableParameters' => array()
	);
	public $blog_views = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'blog_id' => array('type' => 'integer', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'blog_views_blog_id_idx' => array('unique' => false, 'column' => 'blog_id'),
			'blog_views_ip_id_idx' => array('unique' => false, 'column' => 'ip_id'),
			'blog_views_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $blogs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'title' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250),
		'content' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 260),
		'project_id' => array('type' => 'integer', 'null' => true),
		'project_type_id' => array('type' => 'integer', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'detected_suspicious_words' => array('type' => 'string', 'null' => true, 'default' => null),
		'blog_comment_count' => array('type' => 'integer', 'null' => true),
		'blog_view_count' => array('type' => 'integer', 'null' => true),
		'blog_tag_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'is_admin_suspended' => array('type' => 'boolean', 'null' => true),
		'is_published' => array('type' => 'boolean', 'null' => true),
		'is_system_flagged' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'blogs_project_id_idx' => array('unique' => false, 'column' => 'project_id'),
			'blogs_project_type_id_idx' => array('unique' => false, 'column' => 'project_type_id'),
			'blogs_slug_idx' => array('unique' => false, 'column' => 'slug'),
			'blogs_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $blogs_blog_tags = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'blog_id' => array('type' => 'integer', 'null' => true),
		'blog_tag_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'blogs_blog_tags_blog_id_idx' => array('unique' => false, 'column' => 'blog_id'),
			'blogs_blog_tags_blog_tag_id_idx' => array('unique' => false, 'column' => 'blog_tag_id')
		),
		'tableParameters' => array()
	);
	public $cake_sessions = array(
		'id' => array('type' => 'string', 'null' => false, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'data' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'expires' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'cake_sessions_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $cities = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'country_id' => array('type' => 'integer', 'null' => true),
		'state_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45),
		'latitude' => array('type' => 'float', 'null' => true),
		'longitude' => array('type' => 'float', 'null' => true),
		'timezone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10),
		'dma_id' => array('type' => 'integer', 'null' => true),
		'county' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 25),
		'code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 4),
		'is_approved' => array('type' => 'boolean', 'null' => true),
		'project_count' => array('type' => 'integer', 'null' => true),
		'language_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'cities_country_id_idx' => array('unique' => false, 'column' => 'country_id'),
			'cities_dma_id_idx' => array('unique' => false, 'column' => 'dma_id'),
			'cities_is_approved_idx' => array('unique' => false, 'column' => 'is_approved'),
			'cities_language_id_idx' => array('unique' => false, 'column' => 'language_id'),
			'cities_slug_idx' => array('unique' => false, 'column' => 'slug'),
			'cities_state_id_idx' => array('unique' => false, 'column' => 'state_id')
		),
		'tableParameters' => array()
	);
	public $comments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true),
		'node_id' => array('type' => 'integer', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'website' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200),
		'ip' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'title' => array('type' => 'string', 'null' => true, 'default' => null),
		'body' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'rating' => array('type' => 'integer', 'null' => true),
		'status' => array('type' => 'boolean', 'null' => true),
		'notify' => array('type' => 'boolean', 'null' => true),
		'type' => array('type' => 'string', 'null' => true, 'length' => 100),
		'comment_type' => array('type' => 'string', 'null' => true, 'default' => 'comment', 'length' => 100),
		'lft' => array('type' => 'integer', 'null' => true),
		'rght' => array('type' => 'integer', 'null' => true),
		'updated' => array('type' => 'datetime', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'comments_lft_idx' => array('unique' => false, 'column' => 'lft'),
			'comments_node_id_idx' => array('unique' => false, 'column' => 'node_id'),
			'comments_parent_id_idx' => array('unique' => false, 'column' => 'parent_id'),
			'comments_rght_idx' => array('unique' => false, 'column' => 'rght'),
			'comments_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $contacts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'first_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'last_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'email' => array('type' => 'string', 'null' => true, 'default' => null),
		'subject' => array('type' => 'string', 'null' => true, 'default' => null),
		'message' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'telephone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'contacts_ip_id_idx' => array('unique' => false, 'column' => 'ip_id'),
			'contacts_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $countries = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'iso_alpha2' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 2),
		'iso_alpha3' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 3),
		'iso_numeric' => array('type' => 'integer', 'null' => true),
		'fips_code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 3),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200),
		'capital' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200),
		'areainsqkm' => array('type' => 'float', 'null' => true),
		'population' => array('type' => 'integer', 'null' => true),
		'continent' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 2),
		'tld' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 3),
		'currency' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 3),
		'currencyname' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'phone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10),
		'postalcodeformat' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'postalcoderegex' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'languages' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200),
		'geonameid' => array('type' => 'integer', 'null' => true),
		'neighbours' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'equivalentfipscode' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $credit_scores = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true),
		'interest_rate' => array('type' => 'float', 'null' => true),
		'suggested_interest_rate' => array('type' => 'float', 'null' => true),
		'is_approved' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'credit_scores_name_idx' => array('unique' => false, 'column' => 'name')
		),
		'tableParameters' => array()
	);
	public $donate_project_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 265),
		'donate_count' => array('type' => 'integer', 'null' => true),
		'is_approved' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'donate_project_categories_name_idx' => array('unique' => false, 'column' => 'name'),
			'donate_project_categories_slug_idx' => array('unique' => false, 'column' => 'slug')
		),
		'tableParameters' => array()
	);
	public $donate_project_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'donate_count' => array('type' => 'integer', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true),
		'message' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'donate_project_statuses_is_active_idx' => array('unique' => false, 'column' => 'is_active')
		),
		'tableParameters' => array()
	);
	public $educations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'education' => array('type' => 'string', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $email_templates = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'from' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500),
		'reply_to' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'subject' => array('type' => 'string', 'null' => true, 'default' => null),
		'email_text_content' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'email_html_content' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'email_variables' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1000),
		'is_html' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'email_templates_name_idx' => array('unique' => false, 'column' => 'name')
		),
		'tableParameters' => array()
	);
	public $employments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'employment' => array('type' => 'string', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $equity_project_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 265),
		'equity_count' => array('type' => 'integer', 'null' => true),
		'is_approved' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'equity_project_categories_name_idx' => array('unique' => false, 'column' => 'name'),
			'equity_project_categories_slug_idx' => array('unique' => false, 'column' => 'slug')
		),
		'tableParameters' => array()
	);
	public $equity_project_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'equity_count' => array('type' => 'integer', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true),
		'message' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'equity_project_statuses_is_active_idx' => array('unique' => false, 'column' => 'is_active')
		),
		'tableParameters' => array()
	);
	public $facebook_comments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'facebook_user_id' => array('type' => 'string', 'null' => true, 'length' => 50),
		'facebook_comment_id' => array('type' => 'string', 'null' => true, 'length' => 50),
		'facebook_comment_creater_name' => array('type' => 'string', 'null' => true),
		'comment_content' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'href' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'facebook_comments_facebook_comment_id_idx' => array('unique' => false, 'column' => 'facebook_comment_id'),
			'facebook_comments_facebook_user_id_idx' => array('unique' => false, 'column' => 'facebook_user_id')
		),
		'tableParameters' => array()
	);
	public $form_field_groups = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true),
		'slug' => array('type' => 'string', 'null' => true),
		'project_type_id' => array('type' => 'integer', 'null' => true),
		'form_field_step_id' => array('type' => 'integer', 'null' => true),
		'info' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'order' => array('type' => 'integer', 'null' => true),
		'class' => array('type' => 'string', 'null' => true),
		'is_deletable' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_editable' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'form_field_groups_form_field_step_id_idx' => array('unique' => false, 'column' => 'form_field_step_id'),
			'form_field_groups_project_type_id_idx' => array('unique' => false, 'column' => 'project_type_id'),
			'form_field_groups_slug_idx' => array('unique' => false, 'column' => 'slug')
		),
		'tableParameters' => array()
	);
	public $form_field_steps = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true),
		'slug' => array('type' => 'string', 'null' => true),
		'project_type_id' => array('type' => 'integer', 'null' => true),
		'info' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'order' => array('type' => 'integer', 'null' => true),
		'is_deletable' => array('type' => 'boolean', 'null' => true),
		'is_splash' => array('type' => 'boolean', 'null' => true),
		'additional_info' => array('type' => 'string', 'null' => true),
		'is_payment_step' => array('type' => 'boolean', 'null' => true),
		'is_editable' => array('type' => 'boolean', 'null' => true),
		'is_payout_step' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'form_field_steps_project_type_id_idx' => array('unique' => false, 'column' => 'project_type_id'),
			'form_field_steps_slug_idx' => array('unique' => false, 'column' => 'slug')
		),
		'tableParameters' => array()
	);
	public $form_fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true),
		'display_text' => array('type' => 'string', 'null' => true, 'default' => null),
		'label' => array('type' => 'string', 'null' => true, 'default' => null),
		'type' => array('type' => 'string', 'null' => true, 'length' => 45),
		'info' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'project_type_id' => array('type' => 'integer', 'null' => true),
		'required' => array('type' => 'boolean', 'null' => true),
		'depends_on' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45),
		'depends_value' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45),
		'order' => array('type' => 'integer', 'null' => true),
		'options' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'form_field_group_id' => array('type' => 'integer', 'null' => true),
		'is_deletable' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_dynamic_field' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_active' => array('type' => 'boolean', 'null' => true),
		'is_show_display_text_field' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_editable' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'form_fields_form_field_group_id_idx' => array('unique' => false, 'column' => 'form_field_group_id'),
			'form_fields_project_type_id_idx' => array('unique' => false, 'column' => 'project_type_id')
		),
		'tableParameters' => array()
	);
	public $genders = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'length' => 100),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $income_ranges = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'income' => array('type' => 'string', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $ips = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'ip' => array('type' => 'string', 'null' => true, 'default' => null),
		'host' => array('type' => 'string', 'null' => true),
		'city_id' => array('type' => 'integer', 'null' => true),
		'state_id' => array('type' => 'integer', 'null' => true),
		'country_id' => array('type' => 'integer', 'null' => true),
		'timezone_id' => array('type' => 'integer', 'null' => true),
		'latitude' => array('type' => 'float', 'null' => true),
		'longitude' => array('type' => 'float', 'null' => true),
		'user_agent' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'ips_city_id_idx' => array('unique' => false, 'column' => 'city_id'),
			'ips_country_id_idx' => array('unique' => false, 'column' => 'country_id'),
			'ips_state_id_idx' => array('unique' => false, 'column' => 'state_id'),
			'ips_timezone_id_idx' => array('unique' => false, 'column' => 'timezone_id')
		),
		'tableParameters' => array()
	);
	public $jobs_act_entries = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'net_worth' => array('type' => 'float', 'null' => true),
		'annual_income_individual' => array('type' => 'float', 'null' => true),
		'annual_income_with_spouse' => array('type' => 'float', 'null' => true),
		'total_asset' => array('type' => 'float', 'null' => true),
		'household_income' => array('type' => 'float', 'null' => true),
		'annual_expenses' => array('type' => 'float', 'null' => true),
		'liquid_net_worth' => array('type' => 'float', 'null' => true),
		'number_of_dependents' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'jobs_act_entries_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $languages = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'length' => 80),
		'iso2' => array('type' => 'string', 'null' => true, 'length' => 5),
		'iso3' => array('type' => 'string', 'null' => true, 'length' => 5),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'languages_name_idx' => array('unique' => false, 'column' => 'name')
		),
		'tableParameters' => array()
	);
	public $lend_names = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'string', 'null' => true),
		'amount' => array('type' => 'float', 'null' => true),
		'average_rate' => array('type' => 'float', 'null' => true),
		'total_repayment_amount' => array('type' => 'float', 'null' => true),
		'total_repayment_percentage' => array('type' => 'float', 'null' => true),
		'total_repayment_interest_amount' => array('type' => 'float', 'null' => true),
		'project_fund_count' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'lend_names_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $lend_names_credit_scores = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'lend_name_id' => array('type' => 'integer', 'null' => true),
		'credit_score_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'lend_names_credit_scores_credit_score_id_idx' => array('unique' => false, 'column' => 'credit_score_id'),
			'lend_names_credit_scores_lend_name_id_idx' => array('unique' => false, 'column' => 'lend_name_id')
		),
		'tableParameters' => array()
	);
	public $lend_names_lend_project_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'lend_name_id' => array('type' => 'integer', 'null' => true),
		'lend_project_category_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'lend_names_lend_project_categories_lend_name_id_idx' => array('unique' => false, 'column' => 'lend_name_id'),
			'lend_names_lend_project_categories_lend_project_category_id_idx' => array('unique' => false, 'column' => 'lend_project_category_id')
		),
		'tableParameters' => array()
	);
	public $lend_names_loan_terms = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'lend_name_id' => array('type' => 'integer', 'null' => true),
		'loan_term_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'lend_names_loan_terms_lend_name_id_idx' => array('unique' => false, 'column' => 'lend_name_id'),
			'lend_names_loan_terms_loan_term_id_idx' => array('unique' => false, 'column' => 'loan_term_id')
		),
		'tableParameters' => array()
	);
	public $lend_project_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 265),
		'lend_count' => array('type' => 'integer', 'null' => true),
		'is_approved' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'lend_project_categories_name_idx' => array('unique' => false, 'column' => 'name'),
			'lend_project_categories_slug_idx' => array('unique' => false, 'column' => 'slug')
		),
		'tableParameters' => array()
	);
	public $lend_project_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'lend_count' => array('type' => 'integer', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true),
		'message' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'lend_project_statuses_is_active_idx' => array('unique' => false, 'column' => 'is_active')
		),
		'tableParameters' => array()
	);
	public $links = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true),
		'menu_id' => array('type' => 'integer', 'null' => true),
		'title' => array('type' => 'string', 'null' => true),
		'class' => array('type' => 'string', 'null' => true),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'link' => array('type' => 'string', 'null' => true),
		'target' => array('type' => 'string', 'null' => true, 'default' => null),
		'rel' => array('type' => 'string', 'null' => true, 'default' => null),
		'status' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'lft' => array('type' => 'integer', 'null' => true),
		'rght' => array('type' => 'integer', 'null' => true),
		'visibility_roles' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'params' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'modified' => array('type' => 'datetime', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'links_lft_idx' => array('unique' => false, 'column' => 'lft'),
			'links_menu_id_idx' => array('unique' => false, 'column' => 'menu_id'),
			'links_parent_id_idx' => array('unique' => false, 'column' => 'parent_id'),
			'links_rght_idx' => array('unique' => false, 'column' => 'rght')
		),
		'tableParameters' => array()
	);
	public $loan_terms = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true),
		'months' => array('type' => 'integer', 'null' => true),
		'is_approved' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $menus = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true),
		'alias' => array('type' => 'string', 'null' => true),
		'class' => array('type' => 'string', 'null' => true),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'status' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'weight' => array('type' => 'integer', 'null' => true),
		'link_count' => array('type' => 'integer', 'null' => true),
		'params' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'modified' => array('type' => 'datetime', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'menus_alias_key' => array('unique' => true, 'column' => 'alias')
		),
		'tableParameters' => array()
	);
	public $message_contents = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'subject' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'message' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'is_admin_suspended' => array('type' => 'boolean', 'null' => true),
		'is_system_flagged' => array('type' => 'boolean', 'null' => true),
		'detected_suspicious_words' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $message_filters = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'from_user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'to_user_id' => array('type' => 'integer', 'null' => true),
		'subject' => array('type' => 'string', 'null' => true, 'default' => null),
		'has_words' => array('type' => 'string', 'null' => true, 'default' => null),
		'does_not_has_words' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'message_filters_from_user_id_idx' => array('unique' => false, 'column' => 'from_user_id'),
			'message_filters_subject_idx' => array('unique' => false, 'column' => 'subject'),
			'message_filters_to_user_id_idx' => array('unique' => false, 'column' => 'to_user_id'),
			'message_filters_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $message_folders = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'message_folders_name_idx' => array('unique' => false, 'column' => 'name')
		),
		'tableParameters' => array()
	);
	public $messages = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'class' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'foreign_id' => array('type' => 'integer', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'other_user_id' => array('type' => 'integer', 'null' => true),
		'parent_message_id' => array('type' => 'integer', 'null' => true),
		'message_content_id' => array('type' => 'integer', 'null' => true),
		'message_folder_id' => array('type' => 'integer', 'null' => true),
		'is_sender' => array('type' => 'boolean', 'null' => true),
		'is_starred' => array('type' => 'boolean', 'null' => true),
		'is_read' => array('type' => 'boolean', 'null' => true),
		'is_private' => array('type' => 'boolean', 'null' => true),
		'is_deleted' => array('type' => 'boolean', 'null' => true),
		'is_archived' => array('type' => 'boolean', 'null' => true),
		'is_communication' => array('type' => 'boolean', 'null' => true),
		'size' => array('type' => 'integer', 'null' => true),
		'project_id' => array('type' => 'integer', 'null' => true),
		'project_type_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'project_status_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'root' => array('type' => 'integer', 'null' => true),
		'freshness_ts' => array('type' => 'datetime', 'null' => true, 'default' => 'now()'),
		'depth' => array('type' => 'integer', 'null' => true),
		'path' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'materialized_path' => array('type' => 'string', 'null' => true, 'length' => 256),
		'activity_id' => array('type' => 'integer', 'null' => true),
		'activity_user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'is_activity' => array('type' => 'boolean', 'null' => true),
		'is_anonymous_fund' => array('type' => 'boolean', 'null' => true),
		'is_hide_from_public' => array('type' => 'boolean', 'null' => true),
		'is_child_replied' => array('type' => 'boolean', 'null' => true),
		'is_hide_rejected_activity' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'messages_activity_id_idx' => array('unique' => false, 'column' => 'activity_id'),
			'messages_activity_user_id_idx' => array('unique' => false, 'column' => 'activity_user_id'),
			'messages_depth_idx' => array('unique' => false, 'column' => 'depth'),
			'messages_foreign_id_idx' => array('unique' => false, 'column' => 'foreign_id'),
			'messages_freshness_ts_idx' => array('unique' => false, 'column' => 'freshness_ts'),
			'messages_materialized_path_idx' => array('unique' => false, 'column' => 'materialized_path'),
			'messages_message_content_id_idx' => array('unique' => false, 'column' => 'message_content_id'),
			'messages_message_folder_id_idx' => array('unique' => false, 'column' => 'message_folder_id'),
			'messages_other_user_id_idx' => array('unique' => false, 'column' => 'other_user_id'),
			'messages_parent_message_id_idx' => array('unique' => false, 'column' => 'parent_message_id'),
			'messages_project_id_idx' => array('unique' => false, 'column' => 'project_id'),
			'messages_project_status_id_idx' => array('unique' => false, 'column' => 'project_status_id'),
			'messages_project_type_id_idx' => array('unique' => false, 'column' => 'project_type_id'),
			'messages_root_idx' => array('unique' => false, 'column' => 'root'),
			'messages_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $meta = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'model' => array('type' => 'string', 'null' => true, 'default' => 'Node'),
		'foreign_key' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'string', 'null' => true),
		'value' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'weight' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $money_transfer_accounts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'payment_gateway_id' => array('type' => 'integer', 'null' => true),
		'account' => array('type' => 'string', 'null' => true, 'length' => 100),
		'is_default' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'money_transfer_accounts_payment_gateway_id_idx' => array('unique' => false, 'column' => 'payment_gateway_id'),
			'money_transfer_accounts_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $nodes = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'title' => array('type' => 'string', 'null' => true),
		'slug' => array('type' => 'string', 'null' => true),
		'body' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'excerpt' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'status' => array('type' => 'boolean', 'null' => true),
		'mime_type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'comment_status' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'comment_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'promote' => array('type' => 'boolean', 'null' => true),
		'path' => array('type' => 'string', 'null' => true),
		'terms' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'sticky' => array('type' => 'boolean', 'null' => true),
		'lft' => array('type' => 'integer', 'null' => true),
		'rght' => array('type' => 'integer', 'null' => true),
		'visibility_roles' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'type' => array('type' => 'string', 'null' => true, 'default' => 'node', 'length' => 100),
		'type_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'updated' => array('type' => 'datetime', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true),
		'plugin_name' => array('type' => 'string', 'null' => true, 'length' => 220),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'nodes_lft_idx' => array('unique' => false, 'column' => 'lft'),
			'nodes_parent_id_idx' => array('unique' => false, 'column' => 'parent_id'),
			'nodes_plugin_name_idx' => array('unique' => false, 'column' => 'plugin_name'),
			'nodes_rght_idx' => array('unique' => false, 'column' => 'rght'),
			'nodes_slug_idx' => array('unique' => false, 'column' => 'slug'),
			'nodes_type_id_idx' => array('unique' => false, 'column' => 'type_id'),
			'nodes_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $nodes_taxonomies = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'node_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'taxonomy_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'nodes_taxonomies_node_id_idx' => array('unique' => false, 'column' => 'node_id'),
			'nodes_taxonomies_taxonomy_id_idx' => array('unique' => false, 'column' => 'taxonomy_id')
		),
		'tableParameters' => array()
	);
	public $payment_gateway_settings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'payment_gateway_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 256),
		'type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 8),
		'options' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'test_mode_value' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'live_mode_value' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'payment_gateway_settings_payment_gateway_id_idx' => array('unique' => false, 'column' => 'payment_gateway_id')
		),
		'tableParameters' => array()
	);
	public $payment_gateways = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'display_name' => array('type' => 'string', 'null' => true),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'gateway_fees' => array('type' => 'float', 'null' => true),
		'transaction_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'payment_gateway_setting_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'is_test_mode' => array('type' => 'boolean', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true),
		'is_mass_pay_enabled' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'payment_gateways_name_idx' => array('unique' => false, 'column' => 'name')
		),
		'tableParameters' => array()
	);
	public $persistent_logins = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'series' => array('type' => 'string', 'null' => true, 'length' => 50),
		'token' => array('type' => 'string', 'null' => true, 'length' => 50),
		'expires' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'persistent_logins_ip_id_idx' => array('unique' => false, 'column' => 'ip_id'),
			'persistent_logins_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $pledge_project_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 265),
		'pledge_count' => array('type' => 'integer', 'null' => true),
		'is_approved' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'pledge_project_categories_name_idx' => array('unique' => false, 'column' => 'name'),
			'pledge_project_categories_slug_idx' => array('unique' => false, 'column' => 'slug')
		),
		'tableParameters' => array()
	);
	public $pledge_project_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'pledge_count' => array('type' => 'integer', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true),
		'message' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $project_donate_fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'project_id' => array('type' => 'integer', 'null' => true),
		'donate_project_status_id' => array('type' => 'integer', 'null' => true),
		'donate_project_category_id' => array('type' => 'integer', 'null' => true),
		'pledge_type_id' => array('type' => 'integer', 'null' => true, 'default' => '1'),
		'min_amount_to_fund' => array('type' => 'string', 'null' => true),
		'project_donate_goal_reached_date' => array('type' => 'datetime', 'null' => true),
		'is_allow_over_donating' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'project_donate_fields_donate_project_category_id_idx' => array('unique' => false, 'column' => 'donate_project_category_id'),
			'project_donate_fields_donate_project_status_id_idx' => array('unique' => false, 'column' => 'donate_project_status_id'),
			'project_donate_fields_pledge_type_id_idx' => array('unique' => false, 'column' => 'pledge_type_id'),
			'project_donate_fields_project_id_idx' => array('unique' => false, 'column' => 'project_id'),
			'project_donate_fields_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $project_equity_fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'project_id' => array('type' => 'integer', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'equity_project_status_id' => array('type' => 'integer', 'null' => true),
		'equity_project_category_id' => array('type' => 'integer', 'null' => true),
		'project_fund_goal_reached_date' => array('type' => 'datetime', 'null' => true),
		'total_shares' => array('type' => 'integer', 'null' => true),
		'shares_allocated' => array('type' => 'integer', 'null' => true),
		'is_seis_or_eis' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'project_equity_fields_equity_project_category_id_idx' => array('unique' => false, 'column' => 'equity_project_category_id'),
			'project_equity_fields_equity_project_status_id_idx' => array('unique' => false, 'column' => 'equity_project_status_id'),
			'project_equity_fields_project_id_idx' => array('unique' => false, 'column' => 'project_id'),
			'project_equity_fields_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $project_feeds = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'project_id' => array('type' => 'integer', 'null' => true),
		'project_type_id' => array('type' => 'integer', 'null' => true),
		'favicon' => array('type' => 'string', 'null' => true),
		'sitename' => array('type' => 'string', 'null' => true),
		'title' => array('type' => 'string', 'null' => true),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'link' => array('type' => 'string', 'null' => true),
		'date' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'project_feeds_date_idx' => array('unique' => false, 'column' => 'date'),
			'project_feeds_project_id_idx' => array('unique' => false, 'column' => 'project_id'),
			'project_feeds_project_type_id_idx' => array('unique' => false, 'column' => 'project_type_id')
		),
		'tableParameters' => array()
	);
	public $project_flag_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'date', 'null' => true),
		'modified' => array('type' => 'date', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250),
		'project_flag_count' => array('type' => 'integer', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'project_flag_categories_name_idx' => array('unique' => false, 'column' => 'name')
		),
		'tableParameters' => array()
	);
	public $project_flags = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'date', 'null' => true),
		'modified' => array('type' => 'date', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'project_id' => array('type' => 'integer', 'null' => true),
		'project_type_id' => array('type' => 'integer', 'null' => true),
		'project_flag_category_id' => array('type' => 'integer', 'null' => true),
		'message' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'project_flags_ip_id_idx' => array('unique' => false, 'column' => 'ip_id'),
			'project_flags_project_flag_category_id_idx' => array('unique' => false, 'column' => 'project_flag_category_id'),
			'project_flags_project_id_idx' => array('unique' => false, 'column' => 'project_id'),
			'project_flags_project_type_id_idx' => array('unique' => false, 'column' => 'project_type_id'),
			'project_flags_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $project_followers = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'project_id' => array('type' => 'integer', 'null' => true),
		'project_type_id' => array('type' => 'integer', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'project_followers_project_id_idx' => array('unique' => false, 'column' => 'project_id'),
			'project_followers_project_type_id_idx' => array('unique' => false, 'column' => 'project_type_id'),
			'project_followers_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $project_fund_donate_fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'project_fund_id' => array('type' => 'integer', 'null' => true),
		'description' => array('type' => 'string', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'project_fund_donate_fields_project_fund_id_idx' => array('unique' => false, 'column' => 'project_fund_id')
		),
		'tableParameters' => array()
	);
	public $project_fund_equity_fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'project_fund_id' => array('type' => 'integer', 'null' => true),
		'shares_allocated' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'project_fund_equity_fields_project_fund_id_idx' => array('unique' => false, 'column' => 'project_fund_id')
		),
		'tableParameters' => array()
	);
	public $project_fund_lend_fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'project_fund_id' => array('type' => 'integer', 'null' => true),
		'interest_rate' => array('type' => 'float', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'project_fund_lend_fields_project_fund_id_idx' => array('unique' => false, 'column' => 'project_fund_id')
		),
		'tableParameters' => array()
	);
	public $project_fund_pledge_fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'project_fund_id' => array('type' => 'integer', 'null' => true),
		'project_reward_id' => array('type' => 'integer', 'null' => true),
		'shipping_address' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'shipping_address1' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'city_id' => array('type' => 'integer', 'null' => true),
		'state_id' => array('type' => 'integer', 'null' => true),
		'country_id' => array('type' => 'integer', 'null' => true),
		'zip_code' => array('type' => 'string', 'null' => true, 'length' => 100),
		'additional_info' => array('type' => 'string', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'project_fund_pledge_fields_city_id_idx' => array('unique' => false, 'column' => 'city_id'),
			'project_fund_pledge_fields_country_id_idx' => array('unique' => false, 'column' => 'country_id'),
			'project_fund_pledge_fields_project_fund_id_idx' => array('unique' => false, 'column' => 'project_fund_id'),
			'project_fund_pledge_fields_project_reward_id_idx' => array('unique' => false, 'column' => 'project_reward_id'),
			'project_fund_pledge_fields_state_id_idx' => array('unique' => false, 'column' => 'state_id')
		),
		'tableParameters' => array()
	);
	public $project_fund_repayments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'owner_user_id' => array('type' => 'integer', 'null' => true),
		'project_id' => array('type' => 'integer', 'null' => true),
		'project_fund_id' => array('type' => 'integer', 'null' => true),
		'project_repayment_id' => array('type' => 'integer', 'null' => true),
		'amount' => array('type' => 'float', 'null' => true),
		'interest' => array('type' => 'float', 'null' => true),
		'interest_rate' => array('type' => 'float', 'null' => true),
		'term' => array('type' => 'integer', 'null' => true),
		'is_late' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'project_fund_repayments_owner_user_id_idx' => array('unique' => false, 'column' => 'owner_user_id'),
			'project_fund_repayments_project_fund_id_idx' => array('unique' => false, 'column' => 'project_fund_id'),
			'project_fund_repayments_project_id_idx' => array('unique' => false, 'column' => 'project_id'),
			'project_fund_repayments_project_repayment_id_idx' => array('unique' => false, 'column' => 'project_repayment_id'),
			'project_fund_repayments_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $project_funds = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'owner_user_id' => array('type' => 'integer', 'null' => true),
		'referred_by_user_id' => array('type' => 'integer', 'null' => true),
		'payment_gateway_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'project_id' => array('type' => 'integer', 'null' => true),
		'project_type_id' => array('type' => 'integer', 'null' => true),
		'lend_name_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'site_fee' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'is_anonymous' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'project_fund_status_id' => array('type' => 'integer', 'null' => true, 'default' => '4'),
		'is_canceled_from_gateway' => array('type' => 'boolean', 'null' => true),
		'auth_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'auth_amount' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'commission_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'admin_commission_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'affiliate_commission_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'mc_currency' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10),
		'latitude' => array('type' => 'string', 'null' => true),
		'longitude' => array('type' => 'string', 'null' => true),
		'coupon_code' => array('type' => 'string', 'null' => true),
		'unique_coupon_code' => array('type' => 'string', 'null' => true),
		'is_given' => array('type' => 'boolean', 'null' => true),
		'reward_given_date' => array('type' => 'datetime', 'null' => true),
		'project_reward_id' => array('type' => 'integer', 'null' => true),
		'project_widget_id' => array('type' => 'integer', 'null' => true),
		'canceled_by_user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'is_collection' => array('type' => 'boolean', 'null' => true),
		'sudopay_gateway_id' => array('type' => 'integer', 'null' => true),
		'sudopay_payment_id' => array('type' => 'integer', 'null' => true),
		'sudopay_pay_key' => array('type' => 'string', 'null' => true, 'length' => 100),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'project_funds_auth_id_idx' => array('unique' => false, 'column' => 'auth_id'),
			'project_funds_canceled_by_user_id_idx' => array('unique' => false, 'column' => 'canceled_by_user_id'),
			'project_funds_lend_name_id_idx' => array('unique' => false, 'column' => 'lend_name_id'),
			'project_funds_owner_user_id_idx' => array('unique' => false, 'column' => 'owner_user_id'),
			'project_funds_payment_gateway_id_idx' => array('unique' => false, 'column' => 'payment_gateway_id'),
			'project_funds_project_fund_status_id_idx' => array('unique' => false, 'column' => 'project_fund_status_id'),
			'project_funds_project_id_idx' => array('unique' => false, 'column' => 'project_id'),
			'project_funds_project_reward_id_idx' => array('unique' => false, 'column' => 'project_reward_id'),
			'project_funds_project_type_id_idx' => array('unique' => false, 'column' => 'project_type_id'),
			'project_funds_project_widget_id_idx' => array('unique' => false, 'column' => 'project_widget_id'),
			'project_funds_referred_by_user_id_idx' => array('unique' => false, 'column' => 'referred_by_user_id'),
			'project_funds_sudopay_gateway_id_idx' => array('unique' => false, 'column' => 'sudopay_gateway_id'),
			'project_funds_sudopay_pay_key_idx' => array('unique' => false, 'column' => 'sudopay_pay_key'),
			'project_funds_sudopay_payment_id_idx' => array('unique' => false, 'column' => 'sudopay_payment_id'),
			'project_funds_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $project_lend_fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'project_id' => array('type' => 'integer', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'lend_project_status_id' => array('type' => 'integer', 'null' => true),
		'lend_project_category_id' => array('type' => 'integer', 'null' => true),
		'credit_score_id' => array('type' => 'integer', 'null' => true),
		'loan_term_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'repayment_schedule_id' => array('type' => 'integer', 'null' => true),
		'project_fund_goal_reached_date' => array('type' => 'datetime', 'null' => true),
		'target_interest_rate' => array('type' => 'float', 'null' => true),
		'next_repayment_date' => array('type' => 'date', 'null' => true),
		'next_repayment_amount' => array('type' => 'float', 'null' => true),
		'repayment_amount' => array('type' => 'float', 'null' => true),
		'repayment_percentage' => array('type' => 'float', 'null' => true),
		'repayment_interest_amount' => array('type' => 'float', 'null' => true),
		'is_repayment_notified' => array('type' => 'boolean', 'null' => true),
		'is_late_repayment_notified' => array('type' => 'boolean', 'null' => true),
		'is_collection' => array('type' => 'boolean', 'null' => true),
		'repayment_count' => array('type' => 'integer', 'null' => true),
		'late_repayment_count' => array('type' => 'integer', 'null' => true),
		'total_arrear_count' => array('type' => 'integer', 'null' => true),
		'total_no_of_repayment' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'project_lend_fields_credit_score_id_idx' => array('unique' => false, 'column' => 'credit_score_id'),
			'project_lend_fields_lend_project_category_id_idx' => array('unique' => false, 'column' => 'lend_project_category_id'),
			'project_lend_fields_lend_project_status_id_idx' => array('unique' => false, 'column' => 'lend_project_status_id'),
			'project_lend_fields_loan_term_id_idx' => array('unique' => false, 'column' => 'loan_term_id'),
			'project_lend_fields_project_id_idx' => array('unique' => false, 'column' => 'project_id'),
			'project_lend_fields_repayment_schedule_id_idx' => array('unique' => false, 'column' => 'repayment_schedule_id'),
			'project_lend_fields_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $project_pledge_fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'project_id' => array('type' => 'integer', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'pledge_project_status_id' => array('type' => 'integer', 'null' => true),
		'pledge_project_category_id' => array('type' => 'integer', 'null' => true),
		'pledge_type_id' => array('type' => 'integer', 'null' => true, 'default' => '1'),
		'min_amount_to_fund' => array('type' => 'string', 'null' => true),
		'project_fund_goal_reached_date' => array('type' => 'datetime', 'null' => true),
		'is_allow_over_funding' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'project_pledge_fields_pledge_project_category_id_idx' => array('unique' => false, 'column' => 'pledge_project_category_id'),
			'project_pledge_fields_pledge_project_status_id_idx' => array('unique' => false, 'column' => 'pledge_project_status_id'),
			'project_pledge_fields_pledge_type_id_idx' => array('unique' => false, 'column' => 'pledge_type_id'),
			'project_pledge_fields_project_id_idx' => array('unique' => false, 'column' => 'project_id'),
			'project_pledge_fields_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $project_ratings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'project_id' => array('type' => 'integer', 'null' => true),
		'project_type_id' => array('type' => 'integer', 'null' => true),
		'rating' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'project_ratings_ip_id_idx' => array('unique' => false, 'column' => 'ip_id'),
			'project_ratings_project_id_idx' => array('unique' => false, 'column' => 'project_id'),
			'project_ratings_project_type_id_idx' => array('unique' => false, 'column' => 'project_type_id'),
			'project_ratings_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $project_repayments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'project_id' => array('type' => 'integer', 'null' => true),
		'amount' => array('type' => 'float', 'null' => true),
		'late_fee' => array('type' => 'float', 'null' => true),
		'interest' => array('type' => 'float', 'null' => true),
		'term' => array('type' => 'integer', 'null' => true),
		'is_late' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'project_repayments_project_id_idx' => array('unique' => false, 'column' => 'project_id'),
			'project_repayments_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $project_rewards = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'project_id' => array('type' => 'integer', 'null' => true),
		'pledge_amount' => array('type' => 'float', 'null' => true),
		'reward' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'estimated_delivery_date' => array('type' => 'date', 'null' => true),
		'pledge_max_user_limit' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'project_fund_count' => array('type' => 'integer', 'null' => true),
		'is_shipping' => array('type' => 'boolean', 'null' => true),
		'is_having_additional_info' => array('type' => 'boolean', 'null' => true),
		'additional_info_label' => array('type' => 'string', 'null' => true, 'length' => 50),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'project_rewards_project_id_idx' => array('unique' => false, 'column' => 'project_id')
		),
		'tableParameters' => array()
	);
	public $project_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'length' => 45),
		'slug' => array('type' => 'string', 'null' => true),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'project_count' => array('type' => 'integer', 'null' => true),
		'form_field_count' => array('type' => 'integer', 'null' => true),
		'form_field_step_count' => array('type' => 'integer', 'null' => true),
		'form_field_group_count' => array('type' => 'integer', 'null' => true),
		'project_fund_count' => array('type' => 'integer', 'null' => true),
		'project_fund_amount' => array('type' => 'float', 'null' => true),
		'site_revenue' => array('type' => 'float', 'null' => true),
		'commission_percentage' => array('type' => 'float', 'null' => true),
		'commission_percentage_not_reached_need_amount' => array('type' => 'float', 'null' => true),
		'listing_fee' => array('type' => 'float', 'null' => true),
		'listing_fee_type' => array('type' => 'integer', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'funder_slug' => array('type' => 'string', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'project_types_is_active_idx' => array('unique' => false, 'column' => 'is_active'),
			'project_types_slug_idx' => array('unique' => false, 'column' => 'slug')
		),
		'tableParameters' => array()
	);
	public $project_view_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'project_view_types_name_idx' => array('unique' => false, 'column' => 'name')
		),
		'tableParameters' => array()
	);
	public $project_views = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'project_id' => array('type' => 'integer', 'null' => true),
		'project_type_id' => array('type' => 'integer', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'project_view_type_id' => array('type' => 'integer', 'null' => true, 'default' => '1'),
		'project_widget_id' => array('type' => 'integer', 'null' => true),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'project_views_ip_id_idx' => array('unique' => false, 'column' => 'ip_id'),
			'project_views_project_id_idx' => array('unique' => false, 'column' => 'project_id'),
			'project_views_project_type_id_idx' => array('unique' => false, 'column' => 'project_type_id'),
			'project_views_project_view_type_id_idx' => array('unique' => false, 'column' => 'project_view_type_id'),
			'project_views_project_widget_id_idx' => array('unique' => false, 'column' => 'project_widget_id'),
			'project_views_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $project_widgets = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'string', 'null' => true),
		'url' => array('type' => 'string', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'project_widgets_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $projects = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null),
		'hash' => array('type' => 'string', 'null' => true),
		'short_description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'parent_id' => array('type' => 'integer', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'referred_by_user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'project_type_id' => array('type' => 'integer', 'null' => true),
		'payment_method_id' => array('type' => 'integer', 'null' => true),
		'city_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'state_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'country_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'address' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500),
		'address1' => array('type' => 'string', 'null' => true, 'length' => 500),
		'latitude' => array('type' => 'string', 'null' => true),
		'longitude' => array('type' => 'string', 'null' => true),
		'project_start_date' => array('type' => 'date', 'null' => true),
		'project_end_date' => array('type' => 'date', 'null' => true),
		'project_cancelled_date' => array('type' => 'datetime', 'null' => true),
		'collected_amount' => array('type' => 'float', 'null' => true),
		'collected_percentage' => array('type' => 'float', 'null' => true),
		'needed_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'fee_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'commission_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'admin_commission_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'affiliate_commission_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'sudopay_payment_id' => array('type' => 'integer', 'null' => true),
		'sudopay_pay_key' => array('type' => 'string', 'null' => true, 'default' => null),
		'feed_url' => array('type' => 'string', 'null' => true),
		'facebook_feed_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'twitter_feed_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'video_embed_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'total_ratings' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'actual_rating' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'mean_rating' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'project_rating_count' => array('type' => 'integer', 'null' => true),
		'project_view_count' => array('type' => 'integer', 'null' => true),
		'project_feed_count' => array('type' => 'integer', 'null' => true),
		'project_fund_count' => array('type' => 'integer', 'null' => true),
		'project_flag_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'project_comment_count' => array('type' => 'integer', 'null' => true),
		'blog_count' => array('type' => 'integer', 'null' => true),
		'project_follower_count' => array('type' => 'integer', 'null' => true),
		'message_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'embed_view_count' => array('type' => 'integer', 'null' => true),
		'referred_purchase_count' => array('type' => 'integer', 'null' => true),
		'facebook_share_count' => array('type' => 'integer', 'null' => true),
		'twitter_share_count' => array('type' => 'integer', 'null' => true),
		'gmail_share_count' => array('type' => 'integer', 'null' => true),
		'linkedin_share_count' => array('type' => 'integer', 'null' => true),
		'rewarded_count' => array('type' => 'integer', 'null' => true),
		'reward_given_count' => array('type' => 'integer', 'null' => true),
		'detected_suspicious_words' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 512),
		'is_admin_suspended' => array('type' => 'boolean', 'null' => true),
		'is_system_flagged' => array('type' => 'boolean', 'null' => true),
		'is_user_flagged' => array('type' => 'boolean', 'null' => true),
		'is_draft' => array('type' => 'boolean', 'null' => true),
		'is_private' => array('type' => 'boolean', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true),
		'is_featured' => array('type' => 'boolean', 'null' => true),
		'is_paid' => array('type' => 'boolean', 'null' => true),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'is_successful' => array('type' => 'boolean', 'null' => true),
		'tracked_steps' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'is_pending_action_to_admin' => array('type' => 'boolean', 'null' => true),
		'angelist_startup_id' => array('type' => 'integer', 'null' => true),
		'project_reward_count' => array('type' => 'integer', 'null' => true),
		'sudopay_gateway_id' => array('type' => 'integer', 'null' => true),
		'sudopay_revised_amount' => array('type' => 'float', 'null' => true),
		'sudopay_token' => array('type' => 'string', 'null' => true, 'length' => 250),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'projects_angelist_startup_id_idx' => array('unique' => false, 'column' => 'angelist_startup_id'),
			'projects_city_id_idx' => array('unique' => false, 'column' => 'city_id'),
			'projects_country_id_idx' => array('unique' => false, 'column' => 'country_id'),
			'projects_ip_id_idx' => array('unique' => false, 'column' => 'ip_id'),
			'projects_name_idx' => array('unique' => false, 'column' => 'name'),
			'projects_parent_id_idx' => array('unique' => false, 'column' => 'parent_id'),
			'projects_payment_method_id_idx' => array('unique' => false, 'column' => 'payment_method_id'),
			'projects_project_type_id_idx' => array('unique' => false, 'column' => 'project_type_id'),
			'projects_referred_by_user_id_idx' => array('unique' => false, 'column' => 'referred_by_user_id'),
			'projects_slug_idx' => array('unique' => false, 'column' => 'slug'),
			'projects_state_id_idx' => array('unique' => false, 'column' => 'state_id'),
			'projects_sudopay_pay_key_idx' => array('unique' => false, 'column' => 'sudopay_pay_key'),
			'projects_sudopay_payment_id_idx' => array('unique' => false, 'column' => 'sudopay_payment_id'),
			'projects_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $projects_users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'project_id' => array('type' => 'integer', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'projects_users_project_id_idx' => array('unique' => false, 'column' => 'project_id'),
			'projects_users_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $regions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true, 'length' => 100),
		'alias' => array('type' => 'string', 'null' => true, 'length' => 100),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'block_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'regions_alias_key' => array('unique' => true, 'column' => 'alias')
		),
		'tableParameters' => array()
	);
	public $relationships = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'relationship' => array('type' => 'string', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $repayment_schedules = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true),
		'day' => array('type' => 'integer', 'null' => true),
		'is_particular_day_of_month' => array('type' => 'boolean', 'null' => true),
		'is_approved' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $roles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'roles_name_idx' => array('unique' => false, 'column' => 'name')
		),
		'tableParameters' => array()
	);
	public $security_questions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true),
		'slug' => array('type' => 'string', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'security_questions_name_idx' => array('unique' => false, 'column' => 'name'),
			'security_questions_slug_idx' => array('unique' => false, 'column' => 'slug')
		),
		'tableParameters' => array()
	);
	public $seis_entries = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'project_id' => array('type' => 'integer', 'null' => true),
		'company_name' => array('type' => 'string', 'null' => true),
		'number_of_employees' => array('type' => 'integer', 'null' => true),
		'year_of_founding' => array('type' => 'datetime', 'null' => true),
		'total_asset' => array('type' => 'float', 'null' => true),
		'is_seis_or_eis' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'seis_entries_project_id_idx' => array('unique' => false, 'column' => 'project_id'),
			'seis_entries_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $setting_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'plugin_name' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'setting_categories_name_idx' => array('unique' => false, 'column' => 'name'),
			'setting_categories_parent_id_idx' => array('unique' => false, 'column' => 'parent_id'),
			'setting_categories_plugin_name_idx' => array('unique' => false, 'column' => 'plugin_name')
		),
		'tableParameters' => array()
	);
	public $settings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'setting_category_id' => array('type' => 'integer', 'null' => true),
		'setting_category_parent_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'value' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 8),
		'options' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'label' => array('type' => 'string', 'null' => true, 'default' => null),
		'order' => array('type' => 'integer', 'null' => true),
		'plugin_name' => array('type' => 'string', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'settings_name_idx' => array('unique' => false, 'column' => 'name'),
			'settings_plugin_name_idx' => array('unique' => false, 'column' => 'plugin_name'),
			'settings_setting_category_id_idx' => array('unique' => false, 'column' => 'setting_category_id')
		),
		'tableParameters' => array()
	);
	public $site_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 265),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'site_categories_slug_idx' => array('unique' => false, 'column' => 'slug')
		),
		'tableParameters' => array()
	);
	public $social_contact_details = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'length' => 250),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250),
		'facebook_user_id' => array('type' => 'string', 'null' => true, 'length' => 150),
		'twitter_user_id' => array('type' => 'string', 'null' => true, 'length' => 150),
		'googleplus_user_id' => array('type' => 'string', 'null' => true, 'length' => 150),
		'angellist_user_id' => array('type' => 'string', 'null' => true, 'length' => 150),
		'linkedin_user_id' => array('type' => 'string', 'null' => true, 'length' => 150),
		'social_contact_count' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'social_contact_details_facebook_user_id_idx' => array('unique' => false, 'column' => 'facebook_user_id'),
			'social_contact_details_twitter_user_id_idx' => array('unique' => false, 'column' => 'twitter_user_id')
		),
		'tableParameters' => array()
	);
	public $social_contacts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'social_source_id' => array('type' => 'integer', 'null' => true),
		'social_contact_detail_id' => array('type' => 'integer', 'null' => true),
		'social_user_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'social_contacts_social_contact_detail_id_idx' => array('unique' => false, 'column' => 'social_contact_detail_id'),
			'social_contacts_social_source_id_idx' => array('unique' => false, 'column' => 'social_source_id'),
			'social_contacts_social_user_id_idx' => array('unique' => false, 'column' => 'social_user_id'),
			'social_contacts_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $states = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'country_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45),
		'code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 8),
		'adm1code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 4),
		'is_approved' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'states_country_id_idx' => array('unique' => false, 'column' => 'country_id')
		),
		'tableParameters' => array()
	);
	public $submission_fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'submission_id' => array('type' => 'integer', 'null' => true),
		'form_field_id' => array('type' => 'integer', 'null' => true),
		'form_field' => array('type' => 'string', 'null' => true),
		'response' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'type' => array('type' => 'string', 'null' => true, 'length' => 50),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'submission_fields_form_field_id_idx' => array('unique' => false, 'column' => 'form_field_id'),
			'submission_fields_submission_id_idx' => array('unique' => false, 'column' => 'submission_id')
		),
		'tableParameters' => array()
	);
	public $submissions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'project_type_id' => array('type' => 'integer', 'null' => true),
		'project_id' => array('type' => 'integer', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true),
		'ip' => array('type' => 'integer', 'null' => true),
		'email' => array('type' => 'string', 'null' => true),
		'page' => array('type' => 'string', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'submissions_project_id_idx' => array('unique' => false, 'column' => 'project_id'),
			'submissions_project_type_id_idx' => array('unique' => false, 'column' => 'project_type_id')
		),
		'tableParameters' => array()
	);
	public $subscriptions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'email' => array('type' => 'string', 'null' => true, 'length' => 100),
		'is_subscribed' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'unsubscribed_on' => array('type' => 'date', 'null' => true),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'invite_hash' => array('type' => 'string', 'null' => true, 'default' => null),
		'site_state_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'is_sent_private_beta_mail' => array('type' => 'boolean', 'null' => true),
		'is_social_like' => array('type' => 'boolean', 'null' => true),
		'is_invite' => array('type' => 'boolean', 'null' => true),
		'invite_user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'is_email_verified' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'subscriptions_email_idx' => array('unique' => false, 'column' => 'email'),
			'subscriptions_invite_user_id_idx' => array('unique' => false, 'column' => 'invite_user_id'),
			'subscriptions_ip_id_idx' => array('unique' => false, 'column' => 'ip_id'),
			'subscriptions_site_state_id_idx' => array('unique' => false, 'column' => 'site_state_id'),
			'subscriptions_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $sudopay_ipn_logs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'ip' => array('type' => 'integer', 'null' => true),
		'post_variable' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $sudopay_payment_gateways = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'sudopay_gateway_name' => array('type' => 'string', 'null' => true),
		'sudopay_gateway_id' => array('type' => 'integer', 'null' => true),
		'sudopay_payment_group_id' => array('type' => 'integer', 'null' => true),
		'sudopay_gateway_details' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'is_marketplace_supported' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'sudopay_payment_gateways_sudopay_gateway_id_idx' => array('unique' => false, 'column' => 'sudopay_gateway_id'),
			'sudopay_payment_gateways_sudopay_payment_group_id_idx' => array('unique' => false, 'column' => 'sudopay_payment_group_id')
		),
		'tableParameters' => array()
	);
	public $sudopay_payment_gateways_users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'sudopay_payment_gateway_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $sudopay_payment_groups = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'sudopay_group_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'length' => 200),
		'thumb_url' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $sudopay_transaction_logs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'amount' => array('type' => 'float', 'null' => true),
		'payment_id' => array('type' => 'integer', 'null' => true),
		'class' => array('type' => 'string', 'null' => true, 'length' => 50),
		'foreign_id' => array('type' => 'integer', 'null' => true),
		'sudopay_pay_key' => array('type' => 'string', 'null' => true, 'default' => null),
		'merchant_id' => array('type' => 'integer', 'null' => true),
		'gateway_id' => array('type' => 'integer', 'null' => true),
		'gateway_name' => array('type' => 'string', 'null' => true),
		'status' => array('type' => 'string', 'null' => true, 'length' => 50),
		'payment_type' => array('type' => 'string', 'null' => true, 'length' => 50),
		'buyer_id' => array('type' => 'integer', 'null' => true),
		'buyer_email' => array('type' => 'string', 'null' => true),
		'buyer_address' => array('type' => 'string', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $taxonomies = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true),
		'term_id' => array('type' => 'integer', 'null' => true),
		'vocabulary_id' => array('type' => 'integer', 'null' => true),
		'lft' => array('type' => 'integer', 'null' => true),
		'rght' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'taxonomies_lft_idx' => array('unique' => false, 'column' => 'lft'),
			'taxonomies_parent_id_idx' => array('unique' => false, 'column' => 'parent_id'),
			'taxonomies_rght_idx' => array('unique' => false, 'column' => 'rght'),
			'taxonomies_term_id_idx' => array('unique' => false, 'column' => 'term_id'),
			'taxonomies_vocabulary_id_idx' => array('unique' => false, 'column' => 'vocabulary_id')
		),
		'tableParameters' => array()
	);
	public $terms = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true),
		'slug' => array('type' => 'string', 'null' => true),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'updated' => array('type' => 'datetime', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'terms_slug_key' => array('unique' => true, 'column' => 'slug')
		),
		'tableParameters' => array()
	);
	public $timezones = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'code' => array('type' => 'string', 'null' => true),
		'name' => array('type' => 'string', 'null' => true),
		'gmt_offset' => array('type' => 'string', 'null' => true, 'length' => 10),
		'dst_offset' => array('type' => 'string', 'null' => true, 'length' => 10),
		'raw_offset' => array('type' => 'string', 'null' => true, 'length' => 10),
		'hasdst' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $transaction_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'is_credit' => array('type' => 'boolean', 'null' => true),
		'is_credit_to_receiver' => array('type' => 'boolean', 'null' => true),
		'is_credit_to_admin' => array('type' => 'boolean', 'null' => true),
		'message' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'message_for_admin' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'message_for_receiver' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'transaction_variables' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $transactions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'receiver_user_id' => array('type' => 'integer', 'null' => true),
		'foreign_id' => array('type' => 'integer', 'null' => true),
		'class' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 25),
		'transaction_type_id' => array('type' => 'integer', 'null' => true),
		'amount' => array('type' => 'float', 'null' => true),
		'payment_gateway_id' => array('type' => 'integer', 'null' => true),
		'project_type_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'gateway_fees' => array('type' => 'float', 'null' => true),
		'remarks' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'transactions_class_idx' => array('unique' => false, 'column' => 'class'),
			'transactions_foreign_id_idx' => array('unique' => false, 'column' => 'foreign_id'),
			'transactions_payment_gateway_id_idx' => array('unique' => false, 'column' => 'payment_gateway_id'),
			'transactions_project_type_id_idx' => array('unique' => false, 'column' => 'project_type_id'),
			'transactions_receiver_user_id_idx' => array('unique' => false, 'column' => 'receiver_user_id'),
			'transactions_transaction_type_id_idx' => array('unique' => false, 'column' => 'transaction_type_id'),
			'transactions_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $translations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'language_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'lang_text' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'is_translated' => array('type' => 'boolean', 'null' => true),
		'is_google_translate' => array('type' => 'boolean', 'null' => true),
		'is_verified' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'translations_language_id_idx' => array('unique' => false, 'column' => 'language_id')
		),
		'tableParameters' => array()
	);
	public $types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true),
		'alias' => array('type' => 'string', 'null' => true),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'format_show_author' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'format_show_date' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'comment_status' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'comment_approve' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'comment_spam_protection' => array('type' => 'boolean', 'null' => true),
		'comment_captcha' => array('type' => 'boolean', 'null' => true),
		'params' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'plugin' => array('type' => 'string', 'null' => true, 'default' => null),
		'updated' => array('type' => 'datetime', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'types_alias_key' => array('unique' => true, 'column' => 'alias')
		),
		'tableParameters' => array()
	);
	public $types_vocabularies = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'type_id' => array('type' => 'integer', 'null' => true),
		'vocabulary_id' => array('type' => 'integer', 'null' => true),
		'weight' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'types_vocabularies_vocabulary_id_idx' => array('unique' => false, 'column' => 'vocabulary_id')
		),
		'tableParameters' => array()
	);
	public $user_add_wallet_amounts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'amount' => array('type' => 'float', 'null' => true),
		'payment_gateway_id' => array('type' => 'integer', 'null' => true),
		'is_success' => array('type' => 'boolean', 'null' => true),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'sudopay_gateway_id' => array('type' => 'integer', 'null' => true),
		'sudopay_payment_id' => array('type' => 'integer', 'null' => true),
		'sudopay_pay_key' => array('type' => 'string', 'null' => true, 'default' => null),
		'sudopay_revised_amount' => array('type' => 'float', 'null' => true),
		'sudopay_token' => array('type' => 'string', 'null' => true, 'length' => 250),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'user_add_wallet_amounts_payment_gateway_id_idx' => array('unique' => false, 'column' => 'payment_gateway_id'),
			'user_add_wallet_amounts_sudopay_gateway_id_idx' => array('unique' => false, 'column' => 'sudopay_gateway_id'),
			'user_add_wallet_amounts_sudopay_pay_key_idx' => array('unique' => false, 'column' => 'sudopay_pay_key'),
			'user_add_wallet_amounts_sudopay_payment_id_idx' => array('unique' => false, 'column' => 'sudopay_payment_id'),
			'user_add_wallet_amounts_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $user_cash_withdrawals = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'withdrawal_status_id' => array('type' => 'integer', 'null' => true),
		'amount' => array('type' => 'float', 'null' => true),
		'remark' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'payment_gateway_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'user_cash_withdrawals_payment_gateway_id_idx' => array('unique' => false, 'column' => 'payment_gateway_id'),
			'user_cash_withdrawals_user_id_idx' => array('unique' => false, 'column' => 'user_id'),
			'user_cash_withdrawals_withdrawal_status_id_idx' => array('unique' => false, 'column' => 'withdrawal_status_id')
		),
		'tableParameters' => array()
	);
	public $user_followers = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'followed_user_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'user_followers_followed_user_id_idx' => array('unique' => false, 'column' => 'followed_user_id'),
			'user_followers_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $user_logins = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'persistent_login_id' => array('type' => 'integer', 'null' => true),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'user_agent' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'user_logins_ip_id_idx' => array('unique' => false, 'column' => 'ip_id'),
			'user_logins_persistent_login_id_idx' => array('unique' => false, 'column' => 'persistent_login_id'),
			'user_logins_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $user_openids = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'openid' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'user_openids_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $user_profiles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'language_id' => array('type' => 'integer', 'null' => true),
		'first_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'last_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'middle_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'gender_id' => array('type' => 'integer', 'null' => true),
		'dob' => array('type' => 'date', 'null' => true),
		'about_me' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'address' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500),
		'address1' => array('type' => 'string', 'null' => true, 'length' => 500),
		'city_id' => array('type' => 'integer', 'null' => true),
		'state_id' => array('type' => 'integer', 'null' => true),
		'country_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'zip_code' => array('type' => 'integer', 'null' => true),
		'education_id' => array('type' => 'integer', 'null' => true),
		'employment_id' => array('type' => 'integer', 'null' => true),
		'income_range_id' => array('type' => 'integer', 'null' => true),
		'relationship_id' => array('type' => 'integer', 'null' => true),
		'message_page_size' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'message_signature' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'user_profiles_city_id_idx' => array('unique' => false, 'column' => 'city_id'),
			'user_profiles_country_id_idx' => array('unique' => false, 'column' => 'country_id'),
			'user_profiles_education_id_idx' => array('unique' => false, 'column' => 'education_id'),
			'user_profiles_employment_id_idx' => array('unique' => false, 'column' => 'employment_id'),
			'user_profiles_gender_id_idx' => array('unique' => false, 'column' => 'gender_id'),
			'user_profiles_income_range_id_idx' => array('unique' => false, 'column' => 'income_range_id'),
			'user_profiles_relationship_id_idx' => array('unique' => false, 'column' => 'relationship_id'),
			'user_profiles_state_id_idx' => array('unique' => false, 'column' => 'state_id'),
			'user_profiles_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $user_views = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'viewing_user_id' => array('type' => 'integer', 'null' => true),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'user_views_ip_id_idx' => array('unique' => false, 'column' => 'ip_id'),
			'user_views_user_id_idx' => array('unique' => false, 'column' => 'user_id'),
			'user_views_viewing_user_id_idx' => array('unique' => false, 'column' => 'viewing_user_id')
		),
		'tableParameters' => array()
	);
	public $user_websites = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'website' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 512),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'user_websites_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'role_id' => array('type' => 'integer', 'null' => true),
		'username' => array('type' => 'string', 'null' => true),
		'email' => array('type' => 'string', 'null' => true),
		'password' => array('type' => 'string', 'null' => true, 'length' => 100),
		'available_wallet_amount' => array('type' => 'float', 'null' => true),
		'blocked_amount' => array('type' => 'float', 'null' => true),
		'facebook_user_id' => array('type' => 'integer', 'null' => true),
		'timezone_id' => array('type' => 'integer', 'null' => true),
		'auto_detected_timezone_id' => array('type' => 'integer', 'null' => true),
		'user_openid_count' => array('type' => 'integer', 'null' => true),
		'user_login_count' => array('type' => 'integer', 'null' => true),
		'user_view_count' => array('type' => 'integer', 'null' => true),
		'project_fund_count' => array('type' => 'integer', 'null' => true),
		'project_count' => array('type' => 'integer', 'null' => true),
		'project_flag_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'project_follower_count' => array('type' => 'integer', 'null' => true),
		'project_comment_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'project_rating_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'blog_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'blog_comment_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'unique_project_fund_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'cookie_hash' => array('type' => 'string', 'null' => true, 'length' => 50),
		'cookie_time_modified' => array('type' => 'datetime', 'null' => true),
		'is_openid_register' => array('type' => 'boolean', 'null' => true),
		'is_agree_terms_conditions' => array('type' => 'boolean', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true),
		'is_email_confirmed' => array('type' => 'boolean', 'null' => true),
		'is_affiliate_user' => array('type' => 'boolean', 'null' => true),
		'total_commission_pending_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'total_commission_canceled_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'total_commission_completed_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'commission_line_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'commission_withdraw_request_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'commission_paid_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'total_amount_withdrawn' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'referred_purchase_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'referred_project_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'affiliate_refer_purchase_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'last_login_ip_id' => array('type' => 'integer', 'null' => true),
		'last_logged_in_time' => array('type' => 'datetime', 'null' => true),
		'twitter_access_token' => array('type' => 'string', 'null' => true, 'default' => null),
		'twitter_user_id' => array('type' => 'string', 'null' => true, 'default' => null),
		'twitter_access_key' => array('type' => 'integer', 'null' => true),
		'linkedin_user_id' => array('type' => 'string', 'null' => true),
		'linkedin_access_token' => array('type' => 'string', 'null' => true),
		'is_linkedin_register' => array('type' => 'boolean', 'null' => true),
		'is_angellist_register' => array('type' => 'boolean', 'null' => true),
		'is_angellist_connected' => array('type' => 'boolean', 'null' => true),
		'angellist_user_id' => array('type' => 'integer', 'null' => true),
		'angellist_access_token' => array('type' => 'string', 'null' => true, 'default' => null),
		'angellist_avatar_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'openid_user_id' => array('type' => 'string', 'null' => true, 'length' => 200),
		'facebook_access_token' => array('type' => 'string', 'null' => true, 'default' => null),
		'google_user_id' => array('type' => 'string', 'null' => true),
		'google_access_token' => array('type' => 'string', 'null' => true),
		'yahoo_user_id' => array('type' => 'string', 'null' => true),
		'yahoo_access_token' => array('type' => 'string', 'null' => true),
		'is_google_register' => array('type' => 'boolean', 'null' => true),
		'is_yahoo_register' => array('type' => 'boolean', 'null' => true),
		'is_facebook_register' => array('type' => 'boolean', 'null' => true),
		'is_twitter_register' => array('type' => 'boolean', 'null' => true),
		'is_facebook_connected' => array('type' => 'boolean', 'null' => true),
		'is_twitter_connected' => array('type' => 'boolean', 'null' => true),
		'is_google_connected' => array('type' => 'boolean', 'null' => true),
		'is_yahoo_connected' => array('type' => 'boolean', 'null' => true),
		'is_linkedin_connected' => array('type' => 'boolean', 'null' => true),
		'twitter_avatar_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'is_paid' => array('type' => 'boolean', 'null' => true),
		'site_state_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'sudopay_pay_key' => array('type' => 'string', 'null' => true, 'default' => null),
		'sudopay_payment_id' => array('type' => 'integer', 'null' => true),
		'latitude' => array('type' => 'string', 'null' => true),
		'longitude' => array('type' => 'string', 'null' => true),
		'referred_by_user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'referred_by_user_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'pwd_reset_token' => array('type' => 'string', 'null' => true),
		'pwd_reset_requested_date' => array('type' => 'datetime', 'null' => true),
		'security_question_id' => array('type' => 'integer', 'null' => true),
		'security_answer' => array('type' => 'string', 'null' => true),
		'total_withdraw_request_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'is_accredited_investor' => array('type' => 'boolean', 'null' => true),
		'mobile_app_hash' => array('type' => 'string', 'null' => true, 'default' => null),
		'mobile_app_time_modified' => array('type' => 'datetime', 'null' => true),
		'fb_friends_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'twitter_followers_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'linkedin_contacts_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'google_contacts_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'yahoo_contacts_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'is_skipped_fb' => array('type' => 'boolean', 'null' => true),
		'is_skipped_twitter' => array('type' => 'boolean', 'null' => true),
		'is_skipped_linkedin' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_skipped_google' => array('type' => 'boolean', 'null' => true),
		'is_skipped_yahoo' => array('type' => 'boolean', 'null' => true),
		'is_send_activities_mail' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'total_needed_amount' => array('type' => 'float', 'null' => true),
		'total_collected_amount' => array('type' => 'float', 'null' => true),
		'total_funded_amount' => array('type' => 'float', 'null' => true),
		'site_revenue' => array('type' => 'float', 'null' => true),
		'invite_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'user_avatar_source_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'googleplus_user_id' => array('type' => 'string', 'null' => true),
		'is_googleplus_register' => array('type' => 'boolean', 'null' => true),
		'is_googleplus_connected' => array('type' => 'boolean', 'null' => true),
		'googleplus_contacts_count' => array('type' => 'integer', 'null' => true),
		'googleplus_avatar_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'withdrawn_no_of_loans' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'withdrawn_average_rate' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'withdrawn_total_lent' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'withdrawn_total_capital_returned' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'withdrawn_total_interest_returned' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'collection_no_of_loans' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'collection_average_rate' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'collection_total_lent' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'collection_total_capital_returned' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'collection_total_interest_returned' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'closed_no_of_loans' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'closed_average_rate' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'closed_total_lent' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'closed_total_capital_returned' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'closed_total_interest_returned' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'default_no_of_loans' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'default_average_rate' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'default_total_lent' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'default_total_capital_returned' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'default_total_interest_returned' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'is_idle' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_funded' => array('type' => 'boolean', 'null' => true),
		'is_project_posted' => array('type' => 'boolean', 'null' => true),
		'is_engaged' => array('type' => 'boolean', 'null' => true),
		'google_avatar_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'linkedin_avatar_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'angellist_contacts_count' => array('type' => 'integer', 'null' => true),
		'activity_message_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'sudopay_gateway_id' => array('type' => 'integer', 'null' => true),
		'sudopay_receiver_account_id' => array('type' => 'integer', 'null' => true),
		'sudopay_revised_amount' => array('type' => 'float', 'null' => true),
		'sudopay_token' => array('type' => 'string', 'null' => true, 'length' => 250),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'users_angellist_user_id_idx' => array('unique' => false, 'column' => 'angellist_user_id'),
			'users_auto_detected_timezone_id_idx' => array('unique' => false, 'column' => 'auto_detected_timezone_id'),
			'users_email_idx' => array('unique' => false, 'column' => 'email'),
			'users_facebook_user_id_idx' => array('unique' => false, 'column' => 'facebook_user_id'),
			'users_google_user_id_idx' => array('unique' => false, 'column' => 'google_user_id'),
			'users_googleplus_user_id_idx' => array('unique' => false, 'column' => 'googleplus_user_id'),
			'users_ip_id_idx' => array('unique' => false, 'column' => 'ip_id'),
			'users_last_login_ip_id_idx' => array('unique' => false, 'column' => 'last_login_ip_id'),
			'users_linkedin_user_id_idx' => array('unique' => false, 'column' => 'linkedin_user_id'),
			'users_openid_user_id_idx' => array('unique' => false, 'column' => 'openid_user_id'),
			'users_referred_by_user_id_idx' => array('unique' => false, 'column' => 'referred_by_user_id'),
			'users_role_id_idx' => array('unique' => false, 'column' => 'role_id'),
			'users_security_question_id_idx' => array('unique' => false, 'column' => 'security_question_id'),
			'users_site_state_id_idx' => array('unique' => false, 'column' => 'site_state_id'),
			'users_sudopay_gateway_id_idx' => array('unique' => false, 'column' => 'sudopay_gateway_id'),
			'users_sudopay_pay_key_idx' => array('unique' => false, 'column' => 'sudopay_pay_key'),
			'users_sudopay_payment_id_idx' => array('unique' => false, 'column' => 'sudopay_payment_id'),
			'users_sudopay_receiver_account_id_idx' => array('unique' => false, 'column' => 'sudopay_receiver_account_id'),
			'users_timezone_id_idx' => array('unique' => false, 'column' => 'timezone_id'),
			'users_twitter_user_id_idx' => array('unique' => false, 'column' => 'twitter_user_id'),
			'users_user_avatar_source_id_idx' => array('unique' => false, 'column' => 'user_avatar_source_id'),
			'users_username_idx' => array('unique' => false, 'column' => 'username'),
			'users_yahoo_user_id_idx' => array('unique' => false, 'column' => 'yahoo_user_id')
		),
		'tableParameters' => array()
	);
	public $vocabularies = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true),
		'alias' => array('type' => 'string', 'null' => true),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'required' => array('type' => 'boolean', 'null' => true),
		'multiple' => array('type' => 'boolean', 'null' => true),
		'tags' => array('type' => 'boolean', 'null' => true),
		'plugin' => array('type' => 'string', 'null' => true, 'default' => null),
		'weight' => array('type' => 'integer', 'null' => true),
		'updated' => array('type' => 'datetime', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'vocabularies_alias_key' => array('unique' => true, 'column' => 'alias')
		),
		'tableParameters' => array()
	);
	public $withdrawal_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true),
		'user_cash_withdrawal_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
}
