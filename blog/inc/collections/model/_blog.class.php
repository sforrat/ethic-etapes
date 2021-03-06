<?php
/**
 * This file implements the Blog class.
 *
 * This file is part of the evoCore framework - {@link http://evocore.net/}
 * See also {@link http://sourceforge.net/projects/evocms/}.
 *
 * @copyright (c)2003-2009 by Francois PLANQUE - {@link http://fplanque.net/}
 * Parts of this file are copyright (c)2004-2006 by Daniel HAHLER - {@link http://thequod.de/contact}.
 * Parts of this file are copyright (c)2005 by Jason Edgecombe.
 *
 * {@internal License choice
 * - If you have received this file as part of a package, please find the license.txt file in
 *   the same folder or the closest folder above for complete license terms.
 * - If you have received this file individually (e-g: from http://evocms.cvs.sourceforge.net/)
 *   then you must choose one of the following licenses before using the file:
 *   - GNU General Public License 2 (GPL) - http://www.opensource.org/licenses/gpl-license.php
 *   - Mozilla Public License 1.1 (MPL) - http://www.opensource.org/licenses/mozilla1.1.php
 * }}
 *
 * {@internal Open Source relicensing agreement:
 * Daniel HAHLER grants Francois PLANQUE the right to license
 * Daniel HAHLER's contributions to this file and the b2evolution project
 * under any OSI approved OSS license (http://www.opensource.org/licenses/).
 *
 * Jason EDGECOMBE grants Francois PLANQUE the right to license
 * Jason EDGECOMBE's contributions to this file and the b2evolution project
 * under any OSI approved OSS license (http://www.opensource.org/licenses/).
 * }}
 *
 * @package evocore
 *
 * {@internal Below is a list of authors who have contributed to design/coding of this file: }}
 * @author blueyed: Daniel HAHLER.
 * @author fplanque: Francois PLANQUE.
 * @author gorgeb: Bertrand GORGE / EPISTEMA
 * @author jeffbearer: Jeff BEARER
 * @author edgester: Jason EDGECOMBE
 *
 * @version $Id: _blog.class.php,v 1.71.2.3 2009/12/15 06:23:06 fplanque Exp $
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

load_class('_core/model/dataobjects/_dataobject.class.php');

/**
 * Blog
 *
 * Blog object with params
 *
 * @package evocore
 */
class Blog extends DataObject
{
	/**
	 * Short name for use in navigation menus
	 * @var string
	 */
	var $shortname;

	/**
	 * Complete name
	 * @var string
	 */
	var $name;

	/**
	 * Tagline to be displayed on template
	 * @var string
	 */
	var $tagline;

	var $shortdesc; // description
	var $longdesc;

	/**
	 * @var integer
	 */
	var $owner_user_ID;

	/**
	 * Lazy filled
	 * @var User
	 * @see get_owner_User()
	 * @access protected
	 */
	var $owner_User = NULL;

	var $advanced_perms = 0;

	var $locale;
	var $access_type;

	/*
	 * ?> TODO: we should have an extra DB column that either defines type of blog_siteurl
	 * OR split blog_siteurl into blog_siteurl_abs and blog_siteurl_rel (where blog_siteurl_rel could be "blog_sitepath")
	 */
	var $siteurl;
	var $stub;     // stub file (can be empty/virtual)
	var $urlname;  // used to identify blog in URLs
	var $links_blog_ID = 0;	// DEPRECATED
	var $notes;
	var $keywords;
	var $allowcomments = 'post_by_post';
	var $allowtrackbacks = 0;
	var $allowblogcss = 0;
	var $allowusercss = 0;
	var $skin_ID;
	var $in_bloglist = 1;
	var $UID;
	var $media_location = 'default';
	var $media_subdir = '';
	var $media_fullpath = '';
	var $media_url = '';

	/**
	 * Additional settings for the collection.  lazy filled.
 	 *
	 * @see Blog::get_setting()
	 * @see Blog::set_setting()
	 * @see Blog::load_CollectionSettings()
	 * Any non vital params should go into there (this includes many of the above).
	 *
	 * @var CollectionSettings
	 */
	var $CollectionSettings;


	/**
	 * Lazy filled
	 *
	 * @var integer
	 */
	var $default_cat_ID;


	/**
	 * Constructor
	 *
	 * @param object DB row
	 */
	function Blog( $db_row = NULL )
	{
		// Call parent constructor:
		parent::DataObject( 'T_blogs', 'blog_', 'blog_ID' );

		$this->delete_restrictions = array(
				array( 'table'=>'T_categories', 'fk'=>'cat_blog_ID', 'msg'=>T_('%d related categories') ),
			);

		$this->delete_cascades = array(
				array( 'table'=>'T_coll_user_perms', 'fk'=>'bloguser_blog_ID', 'msg'=>T_('%d user permission definitions') ),
				array( 'table'=>'T_coll_group_perms', 'fk'=>'bloggroup_blog_ID', 'msg'=>T_('%d group permission definitions') ),
				array( 'table'=>'T_subscriptions', 'fk'=>'sub_coll_ID', 'msg'=>T_('%d subscriptions') ),
				array( 'table'=>'T_widget', 'fk'=>'wi_coll_ID', 'msg'=>T_('%d widgets') ),
				array( 'table'=>'T_hitlog', 'fk'=>'hit_blog_ID', 'msg'=>T_('%d hits') ),
			);

		if( $db_row == NULL )
		{
			global $default_locale;
			// echo 'Creating blank blog';
			$this->owner_user_ID = 1; // DB default
			$this->set( 'locale', $default_locale );
			$this->set( 'access_type', 'index.php' );
			$this->skin_ID = 1;	// TODO: this is the DB default, but it will fail if skin #1 does not exist
		}
		else
		{
			$this->ID = $db_row->blog_ID;
			$this->shortname = $db_row->blog_shortname;
			$this->name = $db_row->blog_name;
			$this->owner_user_ID = $db_row->blog_owner_user_ID;
			$this->advanced_perms = $db_row->blog_advanced_perms;
			$this->tagline = $db_row->blog_tagline;
			$this->shortdesc = $db_row->blog_description;	// description
			$this->longdesc = $db_row->blog_longdesc;
			$this->locale = $db_row->blog_locale;
			$this->access_type = $db_row->blog_access_type;
			$this->siteurl = $db_row->blog_siteurl;
			$this->urlname = $db_row->blog_urlname;
			$this->links_blog_ID = $db_row->blog_links_blog_ID; // DEPRECATED
			$this->notes = $db_row->blog_notes;
			$this->keywords = $db_row->blog_keywords;
			$this->allowcomments = $db_row->blog_allowcomments;
			$this->allowtrackbacks = $db_row->blog_allowtrackbacks;
			$this->allowblogcss = $db_row->blog_allowblogcss;
			$this->allowusercss = $db_row->blog_allowusercss;
			$this->skin_ID = $db_row->blog_skin_ID;
			$this->in_bloglist = $db_row->blog_in_bloglist;
			$this->media_location = $db_row->blog_media_location;
			$this->media_subdir = $db_row->blog_media_subdir;
			$this->media_fullpath = $db_row->blog_media_fullpath;
			$this->media_url = $db_row->blog_media_url;
			$this->UID = $db_row->blog_UID;
		}
	}


	/**
	 * @param string
	 */
	function init_by_kind( $kind, $name = NULL, $shortname = NULL, $urlname = NULL )
	{
		switch( $kind )
		{
			case 'photo':
				$this->set( 'name', empty($name) ? T_('My photoblog') : $name );
				$this->set( 'shortname', empty($shortname) ? T_('Photoblog') : $shortname );
				$this->set( 'urlname', empty($urlname) ? 'photo' : $urlname );
				$this->set_setting( 'posts_per_page', 1 );
				$this->set_setting( 'archive_mode', 'postbypost' );
				break;

			case 'group':
				$this->set( 'name', empty($name) ? T_('Our blog') : $name );
				$this->set( 'shortname', empty($shortname) ? T_('Group') : $shortname );
				$this->set( 'urlname', empty($urlname) ? 'group' : $urlname );
				$this->set_setting( 'use_workflow', 1 );
				break;

			case 'std':
			default:
				$this->set( 'name', empty($name) ? T_('My weblog') : $name );
				$this->set( 'shortname', empty($shortname) ? T_('Blog') : $shortname );
				$this->set( 'urlname', empty($urlname) ? 'blog' : $urlname );
				break;
		}
	}


	/**
	 * @static
	 *
	 * @param string
	 * @return string
	 */
	function kind_name( $kind )
	{
  	switch( $kind )
		{
			case 'photo':
				return T_('Photoblog');

			case 'group':
				return T_('Group blog');

			case 'std':
			default:
				return T_('Standard blog');
		}
	}


	/**
	 * Load data from Request form fields.
	 *
	 * @param array groups of params to load
	 * @return boolean true if loaded data seems valid.
	 */
	function load_from_Request( $groups = array() )
	{
		global $Messages, $default_locale, $DB;

		/**
		 * @var User
		 */
		global $current_User;

		if( param( 'blog_name', 'string', NULL ) !== NULL )
		{ // General params:
			$this->set_from_Request( 'name' );
			$this->set( 'shortname',     param( 'blog_shortname',     'string', true ) );
			$this->set( 'locale',        param( 'blog_locale',        'string', $default_locale ) );
		}


		if( param( 'archive_links',   'string', NULL ) !== NULL )
		{ // Archive link type:
			$this->set_setting( 'archive_links', get_param( 'archive_links' ) );
			$this->set_setting( 'archive_posts_per_page', param( 'archive_posts_per_page', 'integer', NULL ), true );
		}

		if( param( 'chapter_links',   'string', NULL ) !== NULL )
		{ // Chapter link type:
			$this->set_setting( 'chapter_links', get_param( 'chapter_links' ) );
		}


		if( param( 'category_prefix', 'string', NULL) !== NULL )
		{
			$category_prefix = get_param( 'category_prefix' );
			if( ! preg_match( '|^([A-Za-z0-9\-_]+(/[A-Za-z0-9\-_]+)*)?$|', $category_prefix) )
			{
				param_error( 'category_prefix', T_('Invalid category prefix.') );
			}
			$this->set_setting( 'category_prefix', $category_prefix);
		}

		if( param( 'atom_redirect', 'string', NULL ) !== NULL )
		{
			param_check_url( 'atom_redirect', 'commenting' );
			$this->set_setting( 'atom_redirect', get_param( 'atom_redirect' ) );

			param( 'rss2_redirect', 'string', NULL );
			param_check_url( 'rss2_redirect', 'commenting' );
			$this->set_setting( 'rss2_redirect', get_param( 'rss2_redirect' ) );
		}

		if( param( 'tag_links',   'string', NULL ) !== NULL )
		{ // Tag page link type:
			$this->set_setting( 'tag_links', get_param( 'tag_links' ) );
		}

		if( param( 'tag_prefix', 'string', NULL) !== NULL )
		{
			$tag_prefix = get_param( 'tag_prefix' );
			if( ! preg_match( '|^([A-Za-z0-9\-_]+(/[A-Za-z0-9\-_]+)*)?$|', $tag_prefix) )
			{
				param_error( 'tag_prefix', T_('Invalid tag prefix.') );
			}
			$this->set_setting( 'tag_prefix', $tag_prefix);
		}

		// Default to "tag", if "prefix-only" is used, but no tag_prefix was provided.
		if( get_param('tag_links') == 'prefix-only' && ! strlen(param( 'tag_prefix', 'string', NULL)) )
		{
			$this->set_setting( 'tag_prefix', 'tag' );
		}

		// Use rel="tag" attribute? (checkbox)
		$this->set_setting( 'tag_rel_attib', param('tag_rel_attib', 'integer', 0) );


		if( param( 'chapter_content', 'string', NULL ) !== NULL )
		{ // What kind of content in chapter pages?
			$this->set_setting( 'chapter_content', get_param( 'chapter_content' ) );
		}
		if( param( 'tag_content', 'string', NULL ) !== NULL )
		{ // What kind of content in chapter pages?
			$this->set_setting( 'tag_content', get_param( 'tag_content' ) );
		}
		if( param( 'archive_content', 'string', NULL ) !== NULL )
		{ // What kind of content in chapter pages?
			$this->set_setting( 'archive_content', get_param( 'archive_content' ) );
		}
		if( param( 'filtered_content', 'string', NULL ) !== NULL )
		{ // What kind of content in chapter pages?
			$this->set_setting( 'filtered_content', get_param( 'filtered_content' ) );
		}
		if( param( 'main_content', 'string', NULL ) !== NULL )
		{ // What kind of content in chapter pages?
			$this->set_setting( 'main_content', get_param( 'main_content' ) );
		}

		// Chapter posts per page:
		$this->set_setting( 'chapter_posts_per_page', param( 'chapter_posts_per_page', 'integer', NULL ), true );
		// Tag posts per page:
		$this->set_setting( 'tag_posts_per_page', param( 'tag_posts_per_page', 'integer', NULL ), true );

		if( param( 'single_links',   'string', NULL ) !== NULL )
		{ // Single post link type:
			$this->set_setting( 'single_links', get_param( 'single_links' ) );
		}


		if( param( 'blog_skin_ID', 'integer', NULL ) !== NULL )
		{	// Default blog:
			$this->set_from_Request( 'skin_ID' );
		}


		if( param( 'what_to_show',   'string', NULL ) !== NULL )
		{ // Show x days or x posts?:
			$this->set_setting( 'what_to_show', get_param( 'what_to_show' ) );

			param_integer_range( 'posts_per_page', 1, 9999, T_('Items/days per page must be between %d and %d.') );
			$this->set_setting( 'posts_per_page', get_param( 'posts_per_page' ) );

			$this->set_setting( 'archive_mode', param( 'archive_mode', 'string', true ) );

 			$this->set_setting( 'orderby', param( 'orderby', 'string', true ) );
 			$this->set_setting( 'orderdir', param( 'orderdir', 'string', true ) );
		}

		if( param( 'feed_content',   'string', NULL ) !== NULL )
		{ // How much content in feeds?
			$this->set_setting( 'feed_content', get_param( 'feed_content' ) );

			param_integer_range( 'posts_per_feed', 1, 9999, T_('Items per feed must be between %d and %d.') );
			$this->set_setting( 'posts_per_feed', get_param( 'posts_per_feed' ) );
		}

		if( param( 'require_title', 'string', NULL ) !== NULL )
		{ // Title for items required?
			$this->set_setting( 'require_title', get_param( 'require_title' ) );
		}

		if( param( 'blog_description', 'string', NULL ) !== NULL )
		{	// Description:
			$this->set_from_Request( 'shortdesc', 'blog_description' );
		}

		if( param( 'blog_keywords', 'string', NULL ) !== NULL )
		{	// Keywords:
			$this->set_from_Request( 'keywords' );
		}

		if( param( 'blog_tagline', 'html', NULL ) !== NULL )
		{	// HTML tagline:
			param_check_html( 'blog_tagline', T_('Invalid tagline') );
			$this->set( 'tagline', get_param( 'blog_tagline' ) );
		}
		if( param( 'blog_longdesc', 'html', NULL ) !== NULL )
		{	// HTML long description:
			param_check_html( 'blog_longdesc', T_('Invalid long description') );
			$this->set( 'longdesc', get_param( 'blog_longdesc' ) );
		}

		if( param( 'blog_footer_text', 'html', NULL ) !== NULL )
		{ // Blog footer:
			param_check_html( 'blog_footer_text', T_('Invalid blog footer') );
			$this->set_setting( 'blog_footer_text', get_param( 'blog_footer_text' ) );
		}
		if( param( 'single_item_footer_text', 'html', NULL ) !== NULL )
		{ // Blog footer:
			param_check_html( 'single_item_footer_text', T_('Invalid single post footer') );
			$this->set_setting( 'single_item_footer_text', get_param( 'single_item_footer_text' ) );
		}
		if( param( 'xml_item_footer_text', 'html', NULL ) !== NULL )
		{ // Blog footer:
			param_check_html( 'xml_item_footer_text', T_('Invalid RSS footer') );
			$this->set_setting( 'xml_item_footer_text', get_param( 'xml_item_footer_text' ) );
		}
		if( param( 'blog_notes', 'html', NULL ) !== NULL )
		{	// HTML notes:
			param_check_html( 'blog_notes', T_('Invalid Blog Notes') );
			$this->set( 'notes', get_param( 'blog_notes' ) );

			param_integer_range( 'max_footer_credits', 0, 3, T_('Max credits must be between %d and %d.') );
			$this->set_setting( 'max_footer_credits', get_param( 'max_footer_credits' ) );
		}


		if( in_array( 'pings', $groups ) )
		{ // we want to load the ping checkboxes:
			$blog_ping_plugins = param( 'blog_ping_plugins', 'array', array() );
			$blog_ping_plugins = array_unique($blog_ping_plugins);
			$this->set_setting('ping_plugins', implode(',', $blog_ping_plugins));
		}

		if( in_array( 'cache', $groups ) )
		{ // we want to load the cache params:
			$this->set_setting( 'cache_enabled', param( 'cache_enabled', 'integer', 0 ) );
		}

		if( in_array( 'features', $groups ) )
		{ // we want to load the workflow checkboxes:
			$this->set_setting( 'allow_subscriptions',  param( 'allow_subscriptions', 'integer', 0 ) );
			$this->set( 'advanced_perms',  param( 'advanced_perms', 'integer', 0 ) );
			$this->set_setting( 'use_workflow',  param( 'blog_use_workflow', 'integer', 0 ) );

			$this->set( 'allowblogcss', param( 'blog_allowblogcss', 'integer', 0 ) );
			$this->set( 'allowusercss', param( 'blog_allowusercss', 'integer', 0 ) );
		}

		if( param( 'blog_allowcomments',   'string', NULL ) !== NULL )
		{ // Feedback options:
			$this->set_from_Request( 'allowcomments' );
			$this->set_setting( 'new_feedback_status', param( 'new_feedback_status', 'string', 'draft' ) );
			$this->set_setting( 'allow_rating', param( 'allow_rating', 'string', 'never' ) );
			$this->set( 'allowtrackbacks', param( 'blog_allowtrackbacks', 'integer', 0 ) );

			// Public blog list
			$this->set( 'in_bloglist',   param( 'blog_in_bloglist',   'integer', 0 ) );
		}


		if( in_array( 'seo', $groups ) )
		{ // we want to load the workflow checkboxes:
			$this->set_setting( 'canonical_homepage',  param( 'canonical_homepage', 'integer', 0 ) );
			$this->set_setting( 'relcanonical_homepage',  param( 'relcanonical_homepage', 'integer', 0 ) );
			$this->set_setting( 'canonical_item_urls',  param( 'canonical_item_urls', 'integer', 0 ) );
			$this->set_setting( 'relcanonical_item_urls',  param( 'relcanonical_item_urls', 'integer', 0 ) );
			$this->set_setting( 'canonical_archive_urls',  param( 'canonical_archive_urls', 'integer', 0 ) );
			$this->set_setting( 'relcanonical_archive_urls',  param( 'relcanonical_archive_urls', 'integer', 0 ) );
			$this->set_setting( 'canonical_cat_urls',  param( 'canonical_cat_urls', 'integer', 0 ) );
			$this->set_setting( 'relcanonical_cat_urls',  param( 'relcanonical_cat_urls', 'integer', 0 ) );
			$this->set_setting( 'canonical_tag_urls',  param( 'canonical_tag_urls', 'integer', 0 ) );
			$this->set_setting( 'relcanonical_tag_urls',  param( 'relcanonical_tag_urls', 'integer', 0 ) );
			$this->set_setting( 'default_noindex',  param( 'default_noindex', 'integer', 0 ) );
			$this->set_setting( 'paged_noindex',  param( 'paged_noindex', 'integer', 0 ) );
			$this->set_setting( 'paged_nofollowto',  param( 'paged_nofollowto', 'integer', 0 ) );
			$this->set_setting( 'archive_noindex',  param( 'archive_noindex', 'integer', 0 ) );
			$this->set_setting( 'archive_nofollowto',  param( 'archive_nofollowto', 'integer', 0 ) );
			$this->set_setting( 'chapter_noindex',  param( 'chapter_noindex', 'integer', 0 ) );
			$this->set_setting( 'tag_noindex',  param( 'tag_noindex', 'integer', 0 ) );
			$this->set_setting( 'filtered_noindex',  param( 'filtered_noindex', 'integer', 0 ) );
			$this->set_setting( 'arcdir_noindex',  param( 'arcdir_noindex', 'integer', 0 ) );
			$this->set_setting( 'catdir_noindex',  param( 'catdir_noindex', 'integer', 0 ) );
			$this->set_setting( 'feedback-popup_noindex',  param( 'feedback-popup_noindex', 'integer', 0 ) );
			$this->set_setting( 'msgform_noindex',  param( 'msgform_noindex', 'integer', 0 ) );
			$this->set_setting( 'special_noindex',  param( 'special_noindex', 'integer', 0 ) );
			$this->set_setting( 'title_link_type',  param( 'title_link_type', 'string', '' ) );
			$this->set_setting( 'permalinks',  param( 'permalinks', 'string', '' ) );
			$this->set_setting( '404_response',  param( '404_response', 'string', '' ) );
			$this->set_setting( 'excerpts_meta_description', param( 'excerpts_meta_description', 'integer', 0 ) );
			$this->set_setting( 'categories_meta_description', param( 'categories_meta_description', 'integer', 0 ) );
		}


 		if( param( 'custom_double1', 'string', NULL ) !== NULL )
		{	// Description:
			for( $i = 1 ; $i <= 5; $i++ )
			{
				$this->set_setting( 'custom_double'.$i, param( 'custom_double'.$i, 'string', NULL ) );
			}
			for( $i = 1 ; $i <= 3; $i++ )
			{
				$this->set_setting( 'custom_varchar'.$i, param( 'custom_varchar'.$i, 'string', NULL ) );
			}
		}


		/*
		 * ADVANCED ADMIN SETTINGS
		 */
		if( $current_User->check_perm( 'blog_admin', 'edit', false, $this->ID ) )
		{	// We have permission to edit advanced admin settings:

			if( param( 'owner_login', 'string', NULL ) !== NULL )
			{ // Permissions:
				$UserCache = & get_Cache( 'UserCache' );
				$owner_User = & $UserCache->get_by_login( get_param('owner_login'), false, false );
				if( empty( $owner_User ) )
				{
					param_error( 'owner_login', sprintf( T_('User &laquo;%s&raquo; does not exist!'), get_param('owner_login') ) );
				}
				else
				{
					$this->set( 'owner_user_ID', $owner_User->ID );
					$this->owner_User = & $owner_User;
				}
			}


			if( param( 'blog_urlname',   'string', NULL ) !== NULL )
			{	// check urlname
				if( param_check_not_empty( 'blog_urlname', T_('You must provide an URL blog name!') ) )
				{
					$this->set_from_Request( 'urlname' );

					if( ! preg_match( '|^[A-Za-z0-9\-]+$|', $this->urlname ) )
					{
						param_error( 'blog_urlname', T_('The url name is invalid.') );
					}

					if( $DB->get_var( 'SELECT COUNT(*)
															 FROM T_blogs
															WHERE blog_urlname = '.$DB->quote($this->get( 'urlname' )).'
															  AND blog_ID <> '.$this->ID
															) )
					{ // urlname is already in use
						param_error( 'blog_urlname', T_('This URL name is already in use by another blog. Please choose another name.') );
					}
				}
			}


			if( ($access_type = param( 'blog_access_type', 'string', NULL )) !== NULL )
			{ // Blog URL parameters:
				$this->set( 'access_type', $access_type );

				if( $access_type == 'absolute' )
				{
					$blog_siteurl = param( 'blog_siteurl_absolute', 'string', true );
					if( !preg_match( '#^https?://.+#', $blog_siteurl ) )
					{
						$Messages->add( T_('Blog Folder URL').': '
														.T_('You must provide an absolute URL (starting with <code>http://</code> or <code>https://</code>)!'), 'error' );
					}
					$this->set( 'siteurl', $blog_siteurl );
				}
				elseif( $access_type == 'relative' )
				{ // relative siteurl
					$blog_siteurl = param( 'blog_siteurl_relative', 'string', true );
					if( preg_match( '#^https?://#', $blog_siteurl ) )
					{
						$Messages->add( T_('Blog Folder URL').': '
														.T_('You must provide a relative URL (without <code>http://</code> or <code>https://</code>)!'), 'error' );
					}
  				$this->set( 'siteurl', $blog_siteurl );
				}
				else
				{
  				$this->set( 'siteurl', '' );
				}
			}


			if( param( 'aggregate_coll_IDs', 'string', NULL ) !== NULL )
			{ // Aggregate list: (can be '*')
				$aggregate_coll_IDs = get_param( 'aggregate_coll_IDs' );
				// fp> TODO: check perms on each aggregated blog (if changed)
				// fp> TODO: better interface
				if( $aggregate_coll_IDs != '*' && !preg_match( '#^([0-9]+(,[0-9]+)*)?$#', $aggregate_coll_IDs ) )
				{
					param_error( 'aggregate_coll_IDs', T_('Invalid aggregate blog ID list!') );
				}
				$this->set_setting( 'aggregate_coll_IDs', $aggregate_coll_IDs );
			}

			if( param( 'source_file', 'string', NULL ) !== NULL )
			{	// Static file:
				$this->set_setting( 'source_file', get_param( 'source_file' ) );
				$this->set_setting( 'static_file', param( 'static_file', 'string', '' ) );
			}


			if( param( 'blog_media_location',  'string', NULL ) !== NULL )
			{	// Media files location:
				$this->set_from_Request(   'media_location' );
				$this->set_media_subdir(    param( 'blog_media_subdir',    'string', '' ) );
				$this->set_media_fullpath(  param( 'blog_media_fullpath',  'string', '' ) );
				$this->set_media_url(       param( 'blog_media_url',       'string', '' ) );

				// check params
				switch( $this->get( 'media_location' ) )
				{
					case 'custom': // custom path and URL
						global $demo_mode, $media_path;
						if( $this->get( 'media_fullpath' ) == '' )
						{
							param_error( 'blog_media_fullpath', T_('Media dir location').': '.T_('You must provide the full path of the media directory.') );
						}
						if( !preg_match( '#^https?://#', $this->get( 'media_url' ) ) )
						{
							param_error( 'blog_media_url', T_('Media dir location').': '
															.T_('You must provide an absolute URL (starting with <code>http://</code> or <code>https://</code>)!') );
						}
						if( $demo_mode )
						{
							$canonical_fullpath = get_canonical_path($this->get('media_fullpath'));
							if( ! $canonical_fullpath || strpos($canonical_fullpath, $media_path) !== 0 )
							{
								param_error( 'blog_media_fullpath', T_('Media dir location').': in demo mode the path must be inside of $media_path.' );
							}
						}
						break;

					case 'subdir':
						global $media_path;
						if( $this->get( 'media_subdir' ) == '' )
						{
							param_error( 'blog_media_subdir', T_('Media dir location').': '.T_('You must provide the media subdirectory.') );
						}
						else
						{ // Test if it's below $media_path (subdir!)
							$canonical_path = get_canonical_path($media_path.$this->get( 'media_subdir' ));
							if( ! $canonical_path || strpos($canonical_path, $media_path) !== 0 )
							{
								param_error( 'blog_media_subdir', T_('Media dir location').': '.sprintf(T_('Invalid subdirectory &laquo;%s&raquo;.'), format_to_output($this->get('media_subdir'))) );
							}
							else
							{
								// Validate if it's a valid directory name:
								$subdir = no_trailing_slash(substr($canonical_path, strlen($media_path)));
								if( $error = validate_dirname($subdir) )
								{
									param_error( 'blog_media_subdir', T_('Media dir location').': '.$error );
								}
							}
						}
						break;
				}
			}


		}

		return ! param_errors_detected();
	}


	/**
	 * Set the media folder's subdir
	 *
	 * @param string the subdirectory
	 */
	function set_media_subdir( $path )
	{
		parent::set_param( 'media_subdir', 'string', trailing_slash( $path ) );
	}


	/**
	 * Set the full path of the media folder
	 *
	 * @param string the full path
	 */
	function set_media_fullpath( $path )
	{
		parent::set_param( 'media_fullpath', 'string', trailing_slash( $path ) );
	}


	/**
	 * Set the full URL of the media folder
	 *
	 * @param string the full URL
	 */
	function set_media_url( $url )
	{
		parent::set_param( 'media_url', 'string', trailing_slash( $url ) );
	}


	/**
	 * Set param value
	 *
	 * @param string Parameter name
	 * @return boolean true, if a value has been set; false if it has not changed
	 */
	function set( $parname, $parvalue )
	{
		global $Settings;

		switch( $parname )
		{
			case 'ID':
			case 'allowtrackbacks':
			case 'blog_in_bloglist':
				return parent::set_param( $parname, 'number', $parvalue );
				break;

			case 'shortdesc':
				$this->shortdesc = $parvalue;
				return parent::set_param( 'description', 'string', $parvalue );
				break;

			default:
				return parent::set_param( $parname, 'string', $parvalue );
		}
	}


	/**
	 * Generate blog URL
	 *
	 * @param string default|dynamic|static
	 */
	function gen_blogurl( $type = 'default' )
	{
		global $baseurl, $basedomain, $Settings;

		if( $type == 'static' )
		{ // We want the static page, there is no access type option here:
			debug_die( 'static page currently not supported' );
		}

		if( $type == 'dynamic' )
		{ // We want to force a dynamic page
			debug_die( 'dynamic page currently not supported' );
		}

		switch( $this->access_type )
		{
			case 'default':
				// Access through index.php: match absolute URL or call default blog
				if( ( $Settings->get('default_blog_ID') == $this->ID )
					|| preg_match( '#^https?://#', $this->siteurl ) )
				{ // Safety check! We only do that kind of linking if this is really the default blog...
					// or if we call by absolute URL
					return $baseurl.$this->siteurl.'index.php';
				}
				// ... otherwise, we add the blog ID:

			case 'index.php':
				// Access through index.php + blog qualifier
				return $baseurl.$this->siteurl.'index.php?blog='.$this->ID;

			case 'extrapath':
				// We want to use extra path info, use the blog urlname:
				return $baseurl.$this->siteurl.'index.php/'.$this->urlname.'/';

			case 'relative':
				return $baseurl.$this->siteurl;

			case 'subdom':
				return 'http://'.$this->urlname.'.'.$basedomain.'/';

			case 'absolute':
				return $this->siteurl;

			default:
				debug_die( 'Unhandled Blog access type ['.$this->access_type.']' );
		}
	}


	/**
	 * Generate the baseurl of the blog (URL of the folder where the blog lives)
	 *
	 * @todo test
	 */
	function gen_baseurl()
	{
		global $baseurl, $basedomain;

		switch( $this->access_type )
		{
			case 'default':
			case 'index.php':
				return $baseurl.$this->siteurl;

			case 'extrapath':
				// We want to use extra path info, use the blog urlname:
				return $baseurl.$this->siteurl.'index.php/'.$this->urlname.'/';

			case 'relative':
				$url = $baseurl.$this->siteurl;
				break;

			case 'subdom':
				return 'http://'.$this->urlname.'.'.$basedomain.'/';

			case 'absolute':
				$url = $this->siteurl;
				break;

			default:
				debug_die( 'Unhandled Blog access type ['.$this->access_type.']' );
		}

		// For case relative and absolute:
		return preg_replace( '�^(.+)/[^/]$�', '$1/', $url );

	}


	/**
	 * Load presets
	 *
	 * @param string
	 */
	function load_presets( $set_name )
	{
		switch( $set_name )
		{
			case 'awall':
				$this->set_setting( 'archive_links', 'extrapath' );
				$this->set_setting( 'archive_posts_per_page', NULL );
				$this->set_setting( 'chapter_links', 'chapters' );
				$this->set_setting( 'chapter_posts_per_page', NULL );
				$this->set_setting( 'tag_posts_per_page', NULL );
				$this->set_setting( 'tag_links', 'colon' );
				$this->set_setting( 'single_links', 'short' );

				$this->set_setting( 'canonical_homepage', 1 );
				$this->set_setting( 'relcanonical_homepage', 1 );
				$this->set_setting( 'canonical_item_urls', 1 );
				$this->set_setting( 'relcanonical_item_urls', 1 );
				$this->set_setting( 'canonical_archive_urls', 1 );
				$this->set_setting( 'relcanonical_archive_urls', 1 );
				$this->set_setting( 'canonical_cat_urls', 1 );
				$this->set_setting( 'relcanonical_cat_urls', 1 );
				$this->set_setting( 'canonical_tag_urls', 1 );
				$this->set_setting( 'relcanonical_tag_urls', 1 );

				$this->set_setting( 'category_prefix', '' );
				$this->set_setting( 'tag_prefix', '' );

				$this->set_setting( 'default_noindex', 0 );
				$this->set_setting( 'paged_noindex', 1 );
				$this->set_setting( 'paged_nofollowto', 0 );
				$this->set_setting( 'archive_noindex', 1 );
				$this->set_setting( 'archive_nofollowto', 0 );
				$this->set_setting( 'chapter_noindex', 0 );
				$this->set_setting( 'tag_noindex', 0 );
				$this->set_setting( 'filtered_noindex', 1 ); // temporary

				$this->set_setting( 'arcdir_noindex', 1 );
				$this->set_setting( 'catdir_noindex', 0 );
				$this->set_setting( 'feedback-popup_noindex', 1 );
				$this->set_setting( 'msgform_noindex', 1 );
				$this->set_setting( 'special_noindex', 1 ); // temporary

				$this->set_setting( 'permalinks', 'single' );
				$this->set_setting( 'title_link_type', 'permalink' );
				break;

			case 'abeal':
				$this->set_setting( 'archive_links', 'extrapath' );
				$this->set_setting( 'archive_posts_per_page', 10 );
				$this->set_setting( 'chapter_links', 'subchap' );
				$this->set_setting( 'chapter_posts_per_page', 10 );
				$this->set_setting( 'tag_posts_per_page', 10 );
				$this->set_setting( 'tag_links', 'colon' );
				$this->set_setting( 'single_links', 'short' );

				$this->set_setting( 'canonical_homepage', 1 );
				$this->set_setting( 'relcanonical_homepage', 1 );
				$this->set_setting( 'canonical_item_urls', 1 );
				$this->set_setting( 'relcanonical_item_urls', 1 );
				$this->set_setting( 'canonical_archive_urls', 1 );
				$this->set_setting( 'relcanonical_archive_urls', 1 );
				$this->set_setting( 'canonical_cat_urls', 1 );
				$this->set_setting( 'relcanonical_cat_urls', 1 );
				$this->set_setting( 'canonical_tag_urls', 1 );
				$this->set_setting( 'relcanonical_tag_urls', 1 );

				$this->set_setting( 'category_prefix', '' );
				$this->set_setting( 'tag_prefix', '' );

				$this->set_setting( 'default_noindex', 0 );
				$this->set_setting( 'paged_noindex', 1 );
				$this->set_setting( 'paged_nofollowto', 0 );
				$this->set_setting( 'archive_noindex', 1 );
				$this->set_setting( 'archive_nofollowto', 0 );
				$this->set_setting( 'chapter_noindex', 1 );
				$this->set_setting( 'tag_noindex', 1 );
				$this->set_setting( 'filtered_noindex', 1 ); // temporary

				$this->set_setting( 'arcdir_noindex', 0 );
				$this->set_setting( 'catdir_noindex', 0 );
				$this->set_setting( 'feedback-popup_noindex', 0 );
				$this->set_setting( 'msgform_noindex', 1 );
				$this->set_setting( 'special_noindex', 1 ); // temporary

				$this->set_setting( 'permalinks', 'single' );
				$this->set_setting( 'title_link_type', 'permalink' );
				break;

			case 'mgray':
				$this->set_setting( 'archive_links', 'extrapath' );
				$this->set_setting( 'archive_posts_per_page', 20 );
				$this->set_setting( 'chapter_links', 'chapters' );
				$this->set_setting( 'chapter_posts_per_page', 20 );
				$this->set_setting( 'tag_posts_per_page', 20 );
				$this->set_setting( 'tag_links', 'colon' );
				$this->set_setting( 'single_links', 'chapters' );

				$this->set_setting( 'canonical_homepage', 1 );
				$this->set_setting( 'relcanonical_homepage', 1 );
				$this->set_setting( 'canonical_item_urls', 1 );
				$this->set_setting( 'relcanonical_item_urls', 1 );
				$this->set_setting( 'canonical_archive_urls', 1 );
				$this->set_setting( 'relcanonical_archive_urls', 1 );
				$this->set_setting( 'canonical_cat_urls', 1 );
				$this->set_setting( 'relcanonical_cat_urls', 1 );
				$this->set_setting( 'canonical_tag_urls', 1 );
				$this->set_setting( 'relcanonical_tag_urls', 1 );

				$this->set_setting( 'category_prefix', '' );
				$this->set_setting( 'tag_prefix', '' );

				$this->set_setting( 'default_noindex', 0 );
				$this->set_setting( 'paged_noindex', 1 );
				$this->set_setting( 'paged_nofollowto', 0 );
				$this->set_setting( 'archive_noindex', 1 );
				$this->set_setting( 'archive_nofollowto', 0 );
				$this->set_setting( 'chapter_noindex', 0 );
				$this->set_setting( 'tag_noindex', 1 );
				$this->set_setting( 'filtered_noindex', 1 ); // temporary

				$this->set_setting( 'arcdir_noindex', 1 );
				$this->set_setting( 'catdir_noindex', 0 );
				$this->set_setting( 'feedback-popup_noindex', 1 );
				$this->set_setting( 'msgform_noindex', 1 );
				$this->set_setting( 'special_noindex', 1 ); // temporary

				$this->set_setting( 'permalinks', 'single' );
				$this->set_setting( 'title_link_type', 'permalink' );
				break;

			case 'rfishkin':
				$this->set_setting( 'archive_links', 'extrapath' );
				$this->set_setting( 'archive_posts_per_page', 75 );
				$this->set_setting( 'chapter_links', 'chapters' );
				$this->set_setting( 'chapter_posts_per_page', 75 );
				$this->set_setting( 'tag_posts_per_page', 75 );
				$this->set_setting( 'tag_links', 'colon' );
				$this->set_setting( 'single_links', 'short' );

				$this->set_setting( 'canonical_homepage', 1 );
				$this->set_setting( 'relcanonical_homepage', 1 );
				$this->set_setting( 'canonical_item_urls', 1 );
				$this->set_setting( 'relcanonical_item_urls', 1 );
				$this->set_setting( 'canonical_archive_urls', 1 );
				$this->set_setting( 'relcanonical_archive_urls', 1 );
				$this->set_setting( 'canonical_cat_urls', 1 );
				$this->set_setting( 'relcanonical_cat_urls', 1 );
				$this->set_setting( 'canonical_tag_urls', 1 );
				$this->set_setting( 'relcanonical_tag_urls', 1 );

				$this->set_setting( 'category_prefix', '' );
				$this->set_setting( 'tag_prefix', '' );

				$this->set_setting( 'default_noindex', 0 );
				$this->set_setting( 'paged_noindex', 1 );
				$this->set_setting( 'paged_nofollowto', 1 );
				$this->set_setting( 'archive_noindex', 1 );
				$this->set_setting( 'archive_nofollowto', 1 );
				$this->set_setting( 'chapter_noindex', 0 );
				$this->set_setting( 'tag_noindex', 0 );
				$this->set_setting( 'filtered_noindex', 1 ); // temporary

				$this->set_setting( 'arcdir_noindex', 1 );
				$this->set_setting( 'catdir_noindex', 1 );
				$this->set_setting( 'feedback-popup_noindex', 0 );
				$this->set_setting( 'msgform_noindex', 1 );
				$this->set_setting( 'special_noindex', 1 ); // temporary

				$this->set_setting( 'permalinks', 'single' );
				$this->set_setting( 'title_link_type', 'permalink' );

				$this->set_setting( 'excerpts_meta_description', '1' );
				$this->set_setting( '404_response', '301' );
				break;

			case 'sspencer':
				$this->set_setting( 'archive_links', 'extrapath' );
				$this->set_setting( 'archive_posts_per_page', 10 );
				$this->set_setting( 'chapter_links', 'chapters' );
				$this->set_setting( 'chapter_posts_per_page', 10 );
				$this->set_setting( 'tag_posts_per_page', 10 );
				$this->set_setting( 'tag_links', 'colon' );
				$this->set_setting( 'single_links', 'chapters' );

				$this->set_setting( 'canonical_homepage', 1 );
				$this->set_setting( 'relcanonical_homepage', 1 );
				$this->set_setting( 'canonical_item_urls', 1 );
				$this->set_setting( 'relcanonical_item_urls', 1 );
				$this->set_setting( 'canonical_archive_urls', 1 );
				$this->set_setting( 'relcanonical_archive_urls', 1 );
				$this->set_setting( 'canonical_cat_urls', 1 );
				$this->set_setting( 'relcanonical_cat_urls', 1 );
				$this->set_setting( 'canonical_tag_urls', 1 );
				$this->set_setting( 'relcanonical_tag_urls', 1 );

				$this->set_setting( 'category_prefix', 'category' );
				$this->set_setting( 'tag_prefix', 'tag' );

				$this->set_setting( 'default_noindex', 0 );
				$this->set_setting( 'paged_noindex', 1 );
				$this->set_setting( 'paged_nofollowto', 1 );
				$this->set_setting( 'archive_noindex', 1 );
				$this->set_setting( 'archive_nofollowto', 1 );
				$this->set_setting( 'chapter_noindex', 0 );
				$this->set_setting( 'tag_noindex', 0 );
				$this->set_setting( 'filtered_noindex', 1 ); // temporary

				$this->set_setting( 'arcdir_noindex', 1 );
				$this->set_setting( 'catdir_noindex', 0 );
				$this->set_setting( 'feedback-popup_noindex', 1 );
				$this->set_setting( 'msgform_noindex', 1 );
				$this->set_setting( 'special_noindex', 1 ); // temporary

				$this->set_setting( 'permalinks', 'single' );
				$this->set_setting( 'title_link_type', 'permalink' );
				break;
		}
	}


	/**
	 * Generate archive page URL
	 *
	 * Note: there ate two similar functions here.
	 * @see Blog::get_archive_url()
	 *
	 * @param string year
	 * @param string month
	 * @param string day
	 * @param string week
	 */
	function gen_archive_url( $year, $month = NULL, $day = NULL, $week = NULL, $glue = '&amp;', $paged = 1 )
	{
		$blogurl = $this->gen_blogurl();

		$archive_links = $this->get_setting('archive_links');

		if( $archive_links == 'param' )
		{	// We reference by Query
			$separator = '';
		}
		else
		{	// We reference by extra path info
			$separator = '/';
		}

		$datestring = $separator.$year.$separator;

		if( !empty( $month ) )
		{
			$datestring .= zeroise($month,2).$separator;
			if( !empty( $day ) )
			{
				$datestring .= zeroise($day,2).$separator;
			}
		}
		elseif( !is_null($week) && $week !== '' )  // Note: week # can be 0 !
		{
			if( $archive_links == 'param' )
			{	// We reference by Query
				$datestring .= $glue.'w='.$week;
			}
			else
			{	// extra path info
				$datestring .= 'w'.zeroise($week,2).'/';
			}
		}

		if( $archive_links == 'param' )
		{	// We reference by Query
			$link = url_add_param( $blogurl, 'm='.$datestring, $glue );

			$archive_posts_per_page = $this->get_setting( 'archive_posts_per_page' );
			if( !empty($archive_posts_per_page) && $archive_posts_per_page != $this->get_setting( 'posts_per_page' ) )
			{	// We want a specific post per page count:
				$link = url_add_param( $link, 'posts='.$archive_posts_per_page, $glue );
			}
		}
		else
		{	// We reference by extra path info
			$link = url_add_tail( $blogurl, $datestring ); // there may already be a slash from a siteurl like 'http://example.com/'
		}

		if( $paged > 1 )
		{	// We want a specific page:
			$link = url_add_param( $link, 'paged='.$paged, $glue );
		}

		return $link;
	}


	/**
	 * Generate link to archive
	 * @uses Blog::gen_archive_url()
	 * @return string HTML A tag
	 */
	function gen_archive_link( $text, $title, $year, $month = NULL, $day = NULL, $week = NULL, $glue = '&amp;', $paged = 1 )
	{
		$link = '<a';

		if( $this->get_setting( 'archive_nofollowto' ) )
		{
			$link .= ' rel="nofollow"';
		}

 		if( !empty($title) )
		{
			$link .= ' title="'.format_to_output( $title, 'htmlattr' ).'"';
		}

		$link .= ' href="'.$this->gen_archive_url( $year, $month, $day, $week, $glue, $paged ).'" >';
		$link .= format_to_output( $text );
		$link .= '</a>';

		return $link;
	}


	/**
	 * Get archive page URL
	 *
	 * Note: there are two similar functions here.
	 *
	 * @uses Blog::gen_archive_url()
	 *
	 * @param string monthly, weekly, daily
	 */
	function get_archive_url( $date, $glue = '&amp;' )
	{
		switch( $this->get_setting('archive_mode') )
		{
			case 'weekly':
				global $cacheweekly, $DB;
				if((!isset($cacheweekly)) || (empty($cacheweekly[$date])))
				{
					$cacheweekly[$date] = $DB->get_var( 'SELECT '.$DB->week( $DB->quote($date), locale_startofweek() ) );
				}
				return $this->gen_archive_url( substr( $date, 0, 4 ), NULL, NULL, $cacheweekly[$date], $glue );
				break;

			case 'daily':
				return $this->gen_archive_url( substr( $date, 0, 4 ), substr( $date, 5, 2 ), substr( $date, 8, 2 ), NULL, $glue );
				break;

			case 'monthly':
			default:
				return $this->gen_archive_url( substr( $date, 0, 4 ), substr( $date, 5, 2 ), NULL, NULL, $glue );
		}
	}


	/**
	 * Generate a tag url on this blog
	 */
	function gen_tag_url( $tag, $paged = 1, $glue = '&amp;' )
	{
		$link_type = $this->get_setting( 'tag_links' );
		switch( $link_type )
		{
			case 'param':
				$r = url_add_param( $this->gen_blogurl(), 'tag='.urlencode( $tag ) );

				$tag_posts_per_page = $this->get_setting( 'tag_posts_per_page' );
				if( !empty($tag_posts_per_page) && $tag_posts_per_page != $this->get_setting( 'posts_per_page' ) )
				{	// We want a specific post per page count:
					$r = url_add_param( $r, 'posts='.$tag_posts_per_page, $glue );
				}
				break;

			default:
				switch( $link_type )
				{
					case 'dash':
						$trailer = '-';
						break;
					case 'semicol': // dh> TODO: old value. I had this in my DB. Convert this during upgrade?
					case 'semicolon':
						$trailer = ';';
						break;
					case 'colon':
						$trailer = ':';
						break;
					case 'prefix-only':
					default:
						$trailer = '';
				}
				$tag_prefix = $this->get_setting('tag_prefix');
				if( !empty( $tag_prefix ) )
				{
					$r = url_add_tail( $this->gen_blogurl(), '/'.$tag_prefix.'/'.urlencode( $tag ).$trailer );
				}
				else
				{
					$r = url_add_tail( $this->gen_blogurl(), '/'.urlencode( $tag ).$trailer );
				}
		}

		if( $paged > 1 )
		{	// We want a specific page:
			$r = url_add_param( $r, 'paged='.$paged, $glue );
		}

		return $r;
	}


	/**
	 * Get a link (<a href>) to the tag page of a given tag.
	 *
	 * @param string Tag
	 * @param string Link text (defaults to tag name)
	 * @param array Additional attributes for the A tag (href gets overridden).
	 * @return string The <a href> link
	 */
	function get_tag_link( $tag, $text = NULL, $attribs = array() )
	{
		if( $this->get_setting('tag_rel_attrib') && $this->get_setting('tag_links') == 'prefix-only' )
		{	// add rel=tag attrib -- valid only if the last part of the url is the tag name
			if( ! isset($attribs['rel']) )
				$attribs['rel'] = 'tag';
			else
				$attribs['rel'] .= ' tag';
		}
		$attribs['href'] = $this->gen_tag_url( $tag );

		if( is_null($text) )
		{
			$text = $tag;
		}

		return '<a '.get_field_attribs_as_string($attribs).'>'.$text.'</a>';
	}


	/**
	 * Get allowed post status for current user in this blog
	 *
	 * @todo make default a Blog param
	 *
	 * @param string status to start with. Empty to use default.
	 * @return string authorized status; NULL if none
	 */
	function get_allowed_item_status( $status = NULL )
	{
		/**
		 * @var User
		 */
		global $current_User;

		if( empty( $status ) )
		{
			$status = 'draft';
		}
		if( ! $current_User->check_perm( 'blog_post!'.$status, 'edit', false, $this->ID ) )
		{ // We need to find another one:
			$status = NULL;

			if( $current_User->check_perm( 'blog_post!published', 'edit', false, $this->ID ) )
				$status = 'published';
			elseif( $current_User->check_perm( 'blog_post!protected', 'edit', false, $this->ID ) )
				$status = 'protected';
			elseif( $current_User->check_perm( 'blog_post!private', 'edit', false, $this->ID ) )
				$status = 'private';
			elseif( $current_User->check_perm( 'blog_post!draft', 'edit', false, $this->ID ) )
				$status = 'draft';
			elseif( $current_User->check_perm( 'blog_post!deprecated', 'edit', false, $this->ID ) )
				$status = 'deprecated';
			elseif( $current_User->check_perm( 'blog_post!redirected', 'edit', false, $this->ID ) )
				$status = 'redirected';
		}
		return $status;
	}


	/**
	 * Get default category for current blog
	 *
	 * @todo fp> this is a super lame stub, but it's still better than nothing. Should be user configurable.
	 *
	 */
	function get_default_cat_ID()
	{
		global $DB, $Settings;

		if( empty( $this->default_cat_ID ) )
		{
			if( $default_cat_ID = $this->get_setting('default_cat_ID') )
			{	// A specific cat has previosuly been configured as the default:
				// Try to get it from the DB (to make sure it exists and is in teh right blog):
				$sql = 'SELECT cat_ID
				          FROM T_categories
				         WHERE cat_blog_ID = '.$this->ID.'
				         	 AND cat_ID = '.$default_cat_ID;
				$this->default_cat_ID = $DB->get_var( $sql, 0, 0, 'Get default category' );
			}
		}

		if( empty( $this->default_cat_ID ) )
		{	// If the previous query has returned NULL
			$sql = 'SELECT cat_ID
			          FROM T_categories
			         WHERE cat_blog_ID = '.$this->ID;
			if( $Settings->get('chapter_ordering') == 'manual' )
			{	// Manual order
				$sql .= ' ORDER BY cat_order';
			}
			else
			{	// Alphabetic order
				$sql .= ' ORDER BY cat_name';
			}
			$sql .= ' LIMIT 1';

			$this->default_cat_ID = $DB->get_var( $sql, 0, 0, 'Get default category' );
		}

		return $this->default_cat_ID;
	}


	/**
	 * Get the blog's media directory (and create it if necessary).
	 *
	 * If we're {@link is_admin_page() on an admin page}, it adds status messages.
	 * @todo These status messages should rather go to a "syslog" and not be displayed to a normal user
	 * @todo dh> refactor this into e.g. create_media_dir() and use it for Blog::get_media_dir, too.
	 *
	 * @param boolean Create the directory, if it does not exist yet?
	 * @return string path string on success, false if the dir could not be created
	 */
	function get_media_dir( $create = true )
	{
		global $media_path, $Messages, $Settings, $Debuglog;

		if( ! $Settings->get( 'fm_enable_roots_blog' ) )
		{ // User directories are disabled:
			$Debuglog->add( 'Attempt to access blog media dir, but this feature is globally disabled', 'files' );
			return false;
		}

		switch( $this->media_location )
		{
			case 'default':
				$mediadir = get_canonical_path( $media_path.'blogs/'.$this->urlname.'/' );
				break;

			case 'subdir':
				$mediadir = get_canonical_path( $media_path.$this->media_subdir );
				break;

			case 'custom':
				$mediadir = get_canonical_path( $this->media_fullpath );
				break;

			case 'none':
			default:
				$Debuglog->add( 'Attempt to access blog media dir, but this feature is disabled for this blog', 'files' );
				return false;
		}

		// TODO: use a File object here (to access perms, ..), using FileCache::get_by_root_and_path().
		if( $create && ! is_dir( $mediadir ) )
		{
			// TODO: Link to some help page(s) with errors!
			if( ! is_writable( dirname($mediadir) ) )
			{ // add error
				if( is_admin_page() )
				{
					$Messages->add( sprintf( T_("The blog's media directory &laquo;%s&raquo; could not be created, because the parent directory is not writable or does not exist."), rel_path_to_base($mediadir) )
								.get_manual_link('media_file_permission_errors'), 'error' );
				}
				return false;
			}
			elseif( !@mkdir( $mediadir ) )
			{ // add error
				if( is_admin_page() )
				{
					$Messages->add( sprintf( T_("The blog's media directory &laquo;%s&raquo; could not be created."), rel_path_to_base($mediadir) )
								.get_manual_link('directory_creation_error'), 'error' );
				}
				return false;
			}
			else
			{ // chmod and add note:
				$chmod = $Settings->get('fm_default_chmod_dir');
				if( !empty($chmod) )
				{
					@chmod( $mediadir, octdec($chmod) );
				}
				if( is_admin_page() )
				{
					$Messages->add( sprintf( T_("The blog's media directory &laquo;%s&raquo; has been created with permissions %s."), rel_path_to_base($mediadir), substr( sprintf('%o', fileperms($mediadir)), -3 ) ), 'success' );
				}
			}
		}

		return $mediadir;
	}


	/**
	 * Get the URL to the media folder
	 *
	 * @return string the URL
	 */
	function get_media_url()
	{
		global $media_url, $Settings, $Debuglog;

		if( ! $Settings->get( 'fm_enable_roots_blog' ) )
		{ // User directories are disabled:
			$Debuglog->add( 'Attempt to access blog media URL, but this feature is disabled', 'files' );
			return false;
		}

		switch( $this->media_location )
		{
			case 'default':
				return $media_url.'blogs/'.$this->urlname.'/';

			case 'subdir':
				return $media_url.$this->media_subdir;
				break;

			case 'custom':
				return $this->media_url;

			case 'none':
			default:
				$Debuglog->add( 'Attempt to access blog media url, but this feature is disabled for this blog', 'files' );
				return false;
		}
	}


	/**
 	 * Get link to edit files
 	 *
 	 * @param string link (false on error)
	 */
	function get_filemanager_link()
	{
		global $dispatcher;
		
		load_class('/files/model/_fileroot.class.php');
		return $dispatcher.'?ctrl=files&amp;root='.FileRoot::gen_ID( 'collection', $this->ID );
	}


	/**
	 * Get URL to display the blog with a temporary skin.
	 *
	 * This is used to construct the various RSS/Atom feeds
	 *
	 * @param string
	 * @param string
	 * @param boolean
	 */
	function get_tempskin_url( $skin_folder_name, $additional_params = '', $halt_on_error = false )
	{
		/**
		 * @var SkinCache
		 */
	 	$SkinCache = & get_Cache( 'SkinCache' );
		if( ! $Skin = & $SkinCache->get_by_folder( $skin_folder_name, $halt_on_error ) )
		{
			return NULL;
		}

		return url_add_param( $this->gen_blogurl( 'default' ), 'tempskin='.$skin_folder_name );
	}


	/**
	 * Get URL to display the blog posts in an XML feed.
	 *
	 * @param string
	 */
	function get_item_feed_url( $skin_folder_name )
	{
		return $this->get_tempskin_url( $skin_folder_name );
	}


	/**
	 * Get URL to display the blog comments in an XML feed.
	 *
	 * @param string
	 */
	function get_comment_feed_url( $skin_folder_name )
	{
		return url_add_param( $this->get_tempskin_url( $skin_folder_name ), 'disp=comments' );
	}


	/**
	 * Callback function for footer_text()
	 * @param array
	 * @return string
	 */
	function replace_callback( $matches )
	{
		global $localtimenow;

		switch( $matches[1] )
		{
			case 'year':
				// for copyrigth year
				return date( 'Y', $localtimenow );

			case 'owner':
				/**
				 * @var User
				 */
				$owner_User = $this->get_owner_User();
				// Full name gets priority over prefered name because it makes more sense for DEFAULT copyright.
				// Blog owner can set WHATEVER footer text she wants through the admin interface.
				$owner = $owner_User->get( 'fullname' );
				if( empty($owner) )
				{
					$owner = $owner_User->get_preferred_name();
				}
				return $owner;

			default:
				return $matches[1];
		}
	}


	/**
	 * Get a param.
	 *
	 * @param string Parameter name
	 * @return false|string The value as string or false in case of error (e.g. media dir is disabled).
	 */
	function get( $parname )
	{
		global $xmlsrv_url, $baseurl, $basepath, $media_url, $current_User, $Settings, $Debuglog;

		switch( $parname )
		{
			case 'blogurl':		// Deprecated
			case 'link':  		// Deprecated
			case 'url':
				return $this->gen_blogurl( 'default' );

			case 'dynurl':
				return $this->gen_blogurl( 'dynamic' );

			case 'staticurl':
				return $this->gen_blogurl( 'static' );

			case 'dynfilepath':
				// Source file for static page:
				return $basepath.$this->get_setting('source_file');

			case 'staticfilepath':
				// Destiantion file for static page:
				return $basepath.$this->get_setting('static_file');

			case 'baseurl':
				return $this->gen_baseurl();

			case 'baseurlroot':
				// fp>> TODO: cleanup
				if( preg_match( '#^(https?://(.+?)(:.+?)?)/#', $this->gen_baseurl(), $matches ) )
				{
					// TODO: shouldn't that include a trailing slash?:
					return $matches[1];
				}
				debug_die( 'Blog::get(baseurl)/baseurlroot - assertion failed [baseurl: '.$this->gen_baseurl().'].' );

			case 'lastcommentsurl':
				return url_add_param( $this->gen_blogurl(), 'disp=comments' );

			case 'arcdirurl':
				return url_add_param( $this->gen_blogurl(), 'disp=arcdir' );

			case 'catdirurl':
				return url_add_param( $this->gen_blogurl(), 'disp=catdir' );

			case 'mediaidxurl':
				return url_add_param( $this->gen_blogurl(), 'disp=mediaidx' );

			case 'msgformurl':
				return url_add_param( $this->gen_blogurl(), 'disp=msgform' );

			case 'description':			// RSS wording
			case 'shortdesc':
				return $this->shortdesc;

			case 'rdf_url':
				return $this->get_item_feed_url( '_rdf' );

			case 'rss_url':
				return $this->get_item_feed_url( '_rss' );

			case 'rss2_url':
				return $this->get_item_feed_url( '_rss2' );

			case 'atom_url':
				return $this->get_item_feed_url( '_atom' );

			case 'comments_rdf_url':
				return $this->get_comment_feed_url( '_rdf' );

			case 'comments_rss_url':
				return $this->get_comment_feed_url( '_rss' );

			case 'comments_rss2_url':
				return $this->get_comment_feed_url( '_rss2' );

			case 'comments_atom_url':
				return $this->get_comment_feed_url( '_atom' );


			/* Add the html for a blog-specified stylesheet
			 * All stylesheets will be included if the blog settings allow it
			 * and the file "style.css" exists. CSS rules say that the latter style sheets can
			 * override earlier stylesheets.
			 */
			case 'blog_css':
				if( $this->allowblogcss
					&& file_exists( $this->get_media_dir(false).'style.css' ) )
				{
					return '<link rel="stylesheet" href="'.$this->get_media_url().'style.css" type="text/css" />';
				}
				else
				{
					return '';
				}

			/* Add the html for a user-specified stylesheet
			 * All stylesheets will be included if the blog settings allow it
			 * and the file "style.css" exists. CSS rules say that the latter style sheets can
			 * override earlier stylesheets. A user-specified stylesheet will
			 * override a blog-specified stylesheet which will override a skin stylesheet.
			 */
			case 'user_css':
				if( $this->allowusercss
					&& isset( $current_User )
					&& file_exists( $current_User->get_media_dir(false).'style.css' ) )
				{
					return '<link rel="stylesheet" href="'.$current_User->get_media_url().'style.css" type="text/css" />';
				}
				else
				{
					return '';
				}


			default:
				// All other params:
				return parent::get( $parname );
		}
	}


 	/**
	 * Get a setting.
	 *
	 * @return string|false|NULL value as string on success; NULL if not found; false in case of error
	 */
	function get_setting( $parname )
	{
		$this->load_CollectionSettings();

		return $this->CollectionSettings->get( $this->ID, $parname );
	}


 	/**
	 * Set a setting.
	 *
	 * @return boolean true, if the value has been set, false if it has not changed.
	 */
	function set_setting( $parname, $value, $make_null = false )
	{
	 	// Make sure collection settings are loaded
		$this->load_CollectionSettings();

		if( $make_null && empty($value) )
		{
			$value = NULL;
		}

		return $this->CollectionSettings->set( $this->ID, $parname, $value );
	}


	/**
	 * Make sure collection settings are loaded
	 */
	function load_CollectionSettings()
	{
		if( ! isset( $this->CollectionSettings ) )
		{
			load_class('collections/model/_collsettings.class.php');
			$this->CollectionSettings = new CollectionSettings(); // COPY (function)
		}
	}


 	/**
	 * Insert into the DB
	 */
	function dbinsert()
	{
		global $DB;

		$DB->begin();

		if( parent::dbinsert() )
		{
			if( isset( $this->CollectionSettings ) )
			{
				// So far all settings have been saved to collection #0 !
				// Update the settings: hackish but the base class should not even store this value actually...
				// dh> what do you mean? What "base class"? Is there a problem with CollectionSettings?
				$this->CollectionSettings->cache[$this->ID] = $this->CollectionSettings->cache[0];
				unset( $this->CollectionSettings->cache[0] );

				$this->CollectionSettings->dbupdate();
			}
		}

		$DB->commit();
	}


	/**
	 * Update the DB based on previously recorded changes
	 */
	function dbupdate()
	{
		global $DB;

		$DB->begin();

		parent::dbupdate();

		if( isset( $this->CollectionSettings ) )
		{
			$this->CollectionSettings->dbupdate();
		}

		$DB->commit();
	}


	/**
	 * Delete a blog and dependencies from database
	 *
	 * Includes WAY TOO MANY requests because we try to be compatible with MySQL 3.23, bleh!
	 *
	 * @param boolean true if you want to try to delete the static file
	 * @param boolean true if you want to echo progress
	 */
	function dbdelete($delete_static_file = false, $echo = false )
	{
		global $DB, $Messages;

		// Note: No need to localize the status messages...
		if( $echo ) echo '<p>MySQL 3.23 compatibility mode!';

		// Get list of cats that are going to be deleted (3.23)
		if( $echo ) echo '<br />Getting category list to delete... ';
		$cat_list = implode( ',', $DB->get_col( "
				SELECT cat_ID
				  FROM T_categories
				 WHERE cat_blog_ID = $this->ID" ) );

		if( empty( $cat_list ) )
		{ // There are no cats to delete
			if( $echo ) echo 'None!';
		}
		else
		{ // Delete the cats & dependencies

			// Get list of posts that are going to be deleted (3.23)
			if( $echo ) echo '<br />Getting post list to delete... ';
			$post_list = implode( ',', $DB->get_col( "
					SELECT postcat_post_ID
					  FROM T_postcats
					 WHERE postcat_cat_ID IN ($cat_list)" ) );

			if( empty( $post_list ) )
			{ // There are no posts to delete
				if( $echo ) echo 'None!';
			}
			else
			{ // Delete the posts & dependencies

				// TODO: There's also a constraint FK_post_parent_ID..

				// Delete postcats
				if( $echo ) echo '<br />Deleting post-categories... ';
				$ret = $DB->query(	"DELETE FROM T_postcats
															WHERE postcat_cat_ID IN ($cat_list)" );
				if( $echo ) printf( '(%d rows)', $ret );
				$Messages->add( T_('Deleted post-categories'), 'success' );

				// Delete comments
				if( $echo ) echo '<br />Deleting comments on blog\'s posts... ';
				$ret = $DB->query( "DELETE FROM T_comments
														WHERE comment_post_ID IN ($post_list)" );
				if( $echo ) printf( '(%d rows)', $ret );
				$Messages->add( T_('Deleted comments on blog\'s posts'), 'success' );


				// Delete posts
				if( $echo ) echo '<br />Deleting blog\'s posts... ';
				$ret = $DB->query(	"DELETE FROM T_items__item
															WHERE post_ID IN ($post_list)" );
				if( $echo ) printf( '(%d rows)', $ret );
				$Messages->add( T_('Deleted blog\'s posts'), 'success' );

			} // / are there posts?

			// Delete categories
			if( $echo ) echo '<br />Deleting blog\'s categories... ';
			$ret = $DB->query( "DELETE FROM T_categories
													WHERE cat_blog_ID = $this->ID" );
			if( $echo ) printf( '(%d rows)', $ret );
			$Messages->add( T_('Deleted blog\'s categories'), 'success' );

		} // / are there cats?


		if( $delete_static_file )
		{ // Delete static file
			if( $echo ) echo '<br />Trying to delete static file... ';
			if( ! @unlink( $this->get('staticfilepath') ) )
			{
				if( $echo )
				{
					echo '<span class="error">';
					printf(	T_('ERROR! Could not delete! You will have to delete the file [%s] by hand.'),
									$this->get('staticfilepath') );
					echo '</span>';
				}
				$Messages->add( sprintf( T_('Could not delete static file [%s]'), $this->get('staticfilepath') ), 'error' );
			}
			else
			{
				if( $echo ) echo 'OK.';
				$Messages->add( T_('Deleted blog\'s static file'), 'success' );
			}
		}

		// Unset cache entry:
		// TODO

		// Delete main (blog) object:
		parent::dbdelete();

		if( $echo ) echo '<br />Done.</p>';
	}


	/*
	 * Template function: display name of blog
	 *
	 * Template tag
	 */
	function name( $params = array() )
	{
		// Make sure we are not missing any param:
		$params = array_merge( array(
				'before'      => ' ',
				'after'       => ' ',
				'format'      => 'htmlbody',
			), $params );

		if( !empty( $this->name ) )
		{
			echo $params['before'];
			$this->disp( 'name', $params['format'] );
			echo $params['after'];
		}
	}


	/*
	 * Template function: display name of blog
	 *
	 * Template tag
	 */
	function tagline( $params = array() )
	{
		// Make sure we are not missing any param:
		$params = array_merge( array(
				'before'      => ' ',
				'after'       => ' ',
				'format'      => 'htmlbody',
			), $params );

		if( !empty( $this->tagline ) )
		{
			echo $params['before'];
			$this->disp( 'tagline', $params['format'] );
			echo $params['after'];
		}
	}


	/*
	 * Template function: display name of blog
	 *
	 * Template tag
	 */
	function longdesc( $params = array() )
	{
		// Make sure we are not missing any param:
		$params = array_merge( array(
				'before'      => ' ',
				'after'       => ' ',
				'format'      => 'htmlbody',
			), $params );

		if( !empty( $this->longdesc ) )
		{
			echo $params['before'];
			$this->disp( 'longdesc', $params['format'] );
			echo $params['after'];
		}
	}


	/**
	 * Get the name of the blog
	 *
	 * @return string
	 */
	function get_name()
	{
		return $this->name;
	}


	function get_maxlen_name( $maxlen = 50 )
	{
		return strmaxlen( $this->get_name(), $maxlen );
	}

	/**
	 * Resolve user ID of owner
	 *
	 * @return User
	 */
	function & get_owner_User()
	{
		if( !isset($this->owner_User) )
		{
			$UserCache = & get_Cache( 'UserCache' );
			$this->owner_User = & $UserCache->get_by_ID($this->owner_user_ID);
		}

		return $this->owner_User;
	}


	/**
	 * Template tag: display a link leading to the contact form for the owner of the current Blog.
	 *
	 * @param array (empty default array is provided for compatibility with v 1.10)
	 */
	function contact_link( $params = array() )
	{
		$this->get_owner_User();
		if( ! $this->owner_User->allow_msgform )
		{
			return false;
		}

		// Make sure we are not missing any param:
		$params = array_merge( array(
				'before'      => ' ',
				'after'       => ' ',
				'text'        => 'Contact', // Note: left untranslated, should be translated in skin anyway
				'title'       => 'Send a message to the owner of this blog...',
			), $params );


		echo $params['before'];
		echo '<a href="'.$this->get_contact_url(true).'" title="'.$params['title'].'" class="contact_link">'
					.$params['text'].'</a>';
		echo $params['after'];

		return true;
	}


	/**
	 * Template tag: display footer text for the current Blog.
	 *
	 * @param array
	 * @return boolean true if something has been displayed
	 */
	function footer_text( $params )
	{
		// Make sure we are not missing any param:
		$params = array_merge( array(
				'before'      => ' ',
				'after'       => ' ',
			), $params );

		$text = $this->get_setting( 'blog_footer_text' );
		$text = preg_replace_callback( '�\$([a-z]+)\$�', array( $this, 'replace_callback' ), $text );

		if( empty($text) )
		{
			return false;
		}

		echo $params['before'];
		echo $text;
		echo $params['after'];

		return true;
	}


	/**
	 * @param boolean do we want to redirect back to where we came from after message?
	 */
	function get_contact_url( $with_redirect = true )
	{
		$r = url_add_param( $this->get('msgformurl'), 'recipient_id='.$this->owner_user_ID );

		if( $with_redirect )
		{
			$r .= '&amp;redirect_to='
					// The URL will be made relative on the next page (this is needed when $htsrv_url is on another domain! -- multiblog situation )
					.rawurlencode( regenerate_url('','','','&') );
		}

		return $r;
	}


	/**
	 * Get SQL expression to match the list of aggregates collection IDs.
	 *
	 * This resolves as follows:
	 *  - empty: current blog only
	 *  - "*": all blogs (returns "1" as in "WHERE 1")
	 *  - other: as present in DB
	 *
	 * @param string SQL field name
	 * @return string e.g. "$field IN (1,5)"
	 */
	function get_sql_where_aggregate_coll_IDs( $field )
	{
		$aggregate_coll_IDs = $this->get_setting('aggregate_coll_IDs');
		if( empty( $aggregate_coll_IDs ) )
		{	// We only want posts from the current blog:
			return " $field = $this->ID ";
		}
		elseif( $aggregate_coll_IDs == '*' )
		{
			return " 1 ";
		}
		else
		{	// We are aggregating posts from several blogs:
			return " $field IN ($aggregate_coll_IDs)";
		}
	}


	/**
	 * Get # of posts for a given tag
	 */
	function get_tag_post_count( $tag )
	{
		global $DB;

		$sql = 'SELECT COUNT(DISTINCT itag_itm_ID)
						  FROM T_items__tag INNER JOIN T_items__itemtag ON itag_tag_ID = tag_ID
					  				INNER JOIN T_postcats ON itag_itm_ID = postcat_post_ID
					  				INNER JOIN T_categories ON postcat_cat_ID = cat_ID
						 WHERE cat_blog_ID = '.$this->ID.'
						 	 AND tag_name = '.$DB->quote( strtolower($tag) );

		return $DB->get_var( $sql );

	}
}

/*
 * $Log: _blog.class.php,v $
 */
?>