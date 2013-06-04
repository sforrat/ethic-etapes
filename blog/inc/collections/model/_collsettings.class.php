<?php
/**
 * This file implements the CollectionSettings class which handles
 * coll_ID/name/value triplets for collections/blogs.
 *
 * This file is part of the evoCore framework - {@link http://evocore.net/}
 * See also {@link http://sourceforge.net/projects/evocms/}.
 *
 * @copyright (c)2003-2009 by Francois PLANQUE - {@link http://fplanque.net/}
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
 * }}
 *
 * @package evocore
 *
 * {@internal Below is a list of authors who have contributed to design/coding of this file: }}
 * @author fplanque: Francois PLANQUE
 *
 * @version $Id: _collsettings.class.php,v 1.34 2009/05/26 17:36:41 fplanque Exp $
 *
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

load_class('settings/model/_abstractsettings.class.php');

/**
 * Class to handle the settings for collections/blogs
 *
 * @package evocore
 */
class CollectionSettings extends AbstractSettings
{
	/**
	 * The default settings to use, when a setting is not defined in the database.
	 *
	 * @access protected
	 */
	var $_defaults = array(
		// Home page settings:
			'what_to_show'           => 'posts',        // posts, days
			'main_content'           => 'normal',
			'posts_per_page'         => '5',
			'canonical_homepage'     => 1,					// Redirect homepage to its canonical Url?
			'relcanonical_homepage'  => 1,				// If no 301, fall back to rel="canoncial" ?
			'default_noindex'        => '0',						// META NOINDEX on Default blog page
			// the following are actually general params but are probably best understood if being presented with the home page params
			'orderby'         => 'datestart',
			'orderdir'        => 'DESC',
			'title_link_type' => 'permalink',
			'permalinks'      => 'single',				// single, archive, subchap

		// Page 2,3,4..; settings:
			'paged_noindex' => '1',							// META NOINDEX on following blog pages
			'paged_nofollowto' => '0',          // NOFOLLOW on links to following blog pages

		// Single post settings:
			'canonical_item_urls' => 1,					// Redirect posts to their canonical Url?
			'relcanonical_item_urls' => 1,			// If no 301, fall back to rel="canoncial" ?
			'single_links'   => 'ymd',
			'single_item_footer_text' => '',

		// Comment settings:
			'new_feedback_status' => 'draft',  	// 'draft', 'published' or 'deprecated'
			'allow_rating'   => 'never',

		// Archive settings:
			'arcdir_noindex' => '1',						// META NOINDEX on Archive directory
			'archive_mode'   => 'monthly',			// monthly, weekly, daily, postbypost
			'archive_links'  => 'extrapath',		// param, extrapath
			'canonical_archive_urls' => 1,					// Redirect archives to their canonical URL?
			'relcanonical_archive_urls' => 1,				// If no 301, fall back to rel="canoncial" ?
			'archive_content'   => 'excerpt',
			'archive_posts_per_page' => '100',
			'archive_noindex' => '1',						// META NOINDEX on Archive pages
			'archive_nofollowto' => '0',        // NOFOLLOW on links to archive pages

		// Chapter/Category settings:
			'catdir_noindex' => '1',						// META NOINDEX on Category directory
			'chapter_links'  => 'chapters',			// 'param_num', 'subchap', 'chapters'
			'canonical_cat_urls' => 1,					// Redirect categories to their canonical URL?
			'relcanonical_cat_urls' => 1,				// If no 301, fall back to rel="canoncial" ?
			'chapter_content'   => 'excerpt',
			'chapter_posts_per_page' => NULL,
			'chapter_noindex'   => '1',						// META NOINDEX on Category pages
			'category_prefix'   => '',

		// Tag page settings:
			'tag_links'  => 'colon',						// 'param', 'semicolon' -- fp> we want this changed to prefix only for new blogs only
			'canonical_tag_urls' => 1,					// Redirect tag pages to their canonical Url?
			'relcanonical_tag_urls' => 1,				// If no 301, fall back to rel="canoncial" ?
			'tag_content'       => 'excerpt',
			'tag_posts_per_page' => NULL,
			'tag_noindex' => '1',				      	// META NOINDEX on Tag pages
			'tag_prefix' => '',									// fp> fp> we want this changed to prefix only for new blogs only
			'tag_rel_attrib' => 1,              // rel="tag" attribute for tag links (http://microformats.org/wiki/rel-tag) -- valid only in prefix-only mode

		// Other filtered pages:
			'filtered_noindex' => '1',					// META NOINDEX on other filtered pages
			'filtered_content'  => 'excerpt',

		// Other pages:
			'feedback-popup_noindex' => '1',		// META NOINDEX on Feedback popups
			'msgform_noindex' => '1',						// META NOINDEX on Message forms
			'special_noindex' => '1',						// META NOINDEX on other special pages
			'404_response' => '404',

		// Feed settings: (should probably be duplicated for comment feed, category feeds, etc...)
			'atom_redirect' => '',
			'rss2_redirect' => '',
			'feed_content'   => 'normal',
			'posts_per_feed' => '8',
			'xml_item_footer_text' => '<p><small><a href="$item_perm_url$">Original post</a> blogged on <a href="http://b2evolution.net/">b2evolution</a>.</small></p>',

		// General settings:
			'cache_enabled' => 0,
			'default_cat_ID' => NULL,						// Default Cat for new posts
			'require_title' => 'required',  		// Is a title for items required ("required", "optional", "none")
			'ping_plugins'   => 'ping_pingomatic,ping_b2evonet,evo_twitter', // ping plugin codes, separated by comma
			'allow_subscriptions' => 0,					// Don't all email subscriptions by default
			'use_workflow' => 0,								// Don't use workflow by default
			'aggregate_coll_IDs' => '',
			'blog_footer_text' => '&copy;$year$ by $owner$',
			'max_footer_credits' => 3,

		);


	/**
	 * Constructor
	 */
	function CollectionSettings()
	{
		parent::AbstractSettings( 'T_coll_settings', array( 'cset_coll_ID', 'cset_name' ), 'cset_value', 1 );
	}

	/**
	 * Loads the settings. Not meant to be called directly, but gets called
	 * when needed.
	 *
	 * @access protected
	 * @param string First column key
	 * @param string Second column key
	 * @return boolean
	 */
	function _load( $coll_ID, $arg )
	{
		if( empty( $coll_ID ) )
		{
			return false;
		}

		return parent::_load( $coll_ID, $arg );
	}

}


/*
 * $Log: _collsettings.class.php,v $
 */
?>