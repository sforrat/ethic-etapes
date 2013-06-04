<?php
/**
 * This file implements the UI controller for blog params management, including permissions.
 *
 * This file is part of the evoCore framework - {@link http://evocore.net/}
 * See also {@link http://sourceforge.net/projects/evocms/}.
 *
 * @copyright (c)2003-2009 by Francois PLANQUE - {@link http://fplanque.net/}
 * Parts of this file are copyright (c)2004-2006 by Daniel HAHLER - {@link http://thequod.de/contact}.
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
 * }}
 *
 * @package admin
 *
 * {@internal Below is a list of authors who have contributed to design/coding of this file: }}
 * @author fplanque: Francois PLANQUE.
 *
 * @todo (sessions) When creating a blog, provide "edit options" (3 tabs) instead of a single long "New" form (storing the new Blog object with the session data).
 * @todo Currently if you change the name of a blog it gets not reflected in the blog list buttons!
 *
 * @version $Id: coll_settings.ctrl.php,v 1.19 2009/05/26 19:31:56 fplanque Exp $
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

param_action( 'edit' );
param( 'tab', 'string', 'general', true );

// Check permissions on requested blog and autoselect an appropriate blog if necessary.
// This will prevent a fat error when switching tabs and you have restricted perms on blog properties.
if( $selected = autoselect_blog( 'blog_properties', 'edit' ) ) // Includes perm check
{	// We have a blog to work on:

	if( set_working_blog( $selected ) )	// set $blog & memorize in user prefs
	{	// Selected a new blog:
		$BlogCache = & get_Cache( 'BlogCache' );
		/**
		 * @var Blog
		 */
		$Blog = & $BlogCache->get_by_ID( $blog );
	}

	/**
	 * @var Blog
	 */
	$edited_Blog = & $Blog;
}
else
{	// We could not find a blog we have edit perms on...
	// Note: we may still have permission to edit categories!!
	// redirect to blog list:
	header_redirect( '?ctrl=collections' );
	// EXITED:
	$Messages->add( T_('Sorry, you have no permission to edit blog properties.'), 'error' );
	$action = 'nil';
	$tab = '';
}

memorize_param( 'blog', 'integer', -1 );	// Needed when generating static page for example

if( $tab == 'skin_settings' )
{
	$SkinCache = & get_Cache( 'SkinCache' );
	/**
	 * @var Skin
	 */
	$edited_Skin = & $SkinCache->get_by_ID( $Blog->skin_ID );
}


if( ( $tab == 'perm' || $tab == 'permgroup' )
	&& ( empty($blog) || ! $Blog->advanced_perms ) )
{	// We're trying to access advanced perms but they're disabled!
	$tab = 'features';	// the screen where you can enable advanced perms
	if( $action == 'update' )
	{ // make sure we don't update anything here
		$action = 'edit';
	}
}

/**
 * Perform action:
 */
switch( $action )
{
	case 'edit':
	case 'filter1':
	case 'filter2':
		// Edit collection form (depending on tab):
		// Check permissions:
		$current_User->check_perm( 'blog_properties', 'edit', true, $blog );

		param( 'preset', 'string', '' );

		$edited_Blog->load_presets( $preset );

		break;

	case 'update':
		// Update DB:
		// Check permissions:
		$current_User->check_perm( 'blog_properties', 'edit', true, $blog );

		switch( $tab )
		{
			case 'general':
			case 'urls':
				if( $edited_Blog->load_from_Request( array() ) )
				{ // Commit update to the DB:
					$edited_Blog->dbupdate();
					$Messages->add( T_('The blog settings have been updated'), 'success' );
				}
				break;

			case 'features':
				if( $edited_Blog->load_from_Request( array( 'features' ) ) )
				{ // Commit update to the DB:
					$edited_Blog->dbupdate();
					$Messages->add( T_('The blog settings have been updated'), 'success' );
				}
				break;

			case 'seo':
				if( $edited_Blog->load_from_Request( array( 'seo' ) ) )
				{ // Commit update to the DB:
					$edited_Blog->dbupdate();
					$Messages->add( T_('The blog settings have been updated'), 'success' );
				}
				break;

			case 'skin':
				if( $edited_Blog->load_from_Request( array() ) )
				{ // Commit update to the DB:
					$edited_Blog->dbupdate();
					$Messages->add( T_('The blog skin has been changed.')
										.' <a href="'.$admin_url.'?ctrl=coll_settings&amp;tab=skin&amp;blog='.$edited_Blog->ID.'">'.T_('Edit...').'</a>', 'success' );
					header_redirect( $edited_Blog->gen_blogurl() );
				}
				break;

			case 'skin_settings':
				// Update params/Settings
				$edited_Skin->load_params_from_Request();

				if(	! param_errors_detected() )
				{	// Update settings:
					$edited_Skin->dbupdate_settings();
					$Messages->add( T_('Skin settings have been updated'), 'success' );
				}
				break;

			case 'plugin_settings':
				// Update Plugin params/Settings
				load_funcs('plugins/_plugin.funcs.php');

				$Plugins->restart();
				while( $loop_Plugin = & $Plugins->get_next() )
				{
					$pluginsettings = $loop_Plugin->get_coll_setting_definitions( $tmp_params = array('for_editing'=>true) );
					if( empty($pluginsettings) )
					{
						continue;
					}

					// Loop through settings for this plugin:
					foreach( $pluginsettings as $set_name => $set_meta )
					{
						autoform_set_param_from_request( $set_name, $set_meta, $loop_Plugin, 'CollSettings', $Blog );
					}
				}

				if(	! param_errors_detected() )
				{	// Update settings:
					$Blog->dbupdate();
					$Messages->add( T_('Plugin settings have been updated'), 'success' );
				}
				break;

			case 'advanced':
				$old_cache_status = $edited_Blog->get_setting('cache_enabled');
				if( $edited_Blog->load_from_Request( array( 'pings', 'cache' ) ) )
				{ // Commit update to the DB:
					$new_cache_status =  $edited_Blog->get_setting('cache_enabled');

					load_class( '_core/model/_pagecache.class.php' );
					$PageCache = & new PageCache( $edited_Blog );

					if( $old_cache_status == false && $new_cache_status == true )
					{ // Caching has been turned ON:
						if( $PageCache->cache_create() )
						{
							$Messages->add( T_('Caching has been enabled for this blog.'), 'success' );
						}
						else
						{
							$Messages->add( T_('Caching could not be enabled for this blog. Check /cache/ folder file permissions.'), 'error' );
							$edited_Blog->set_setting('cache_enabled', 0 );
						}
					}
					elseif( $old_cache_status == true && $new_cache_status == false )
					{ // Caching has been turned OFF:
						$PageCache->cache_delete();
						$Messages->add( T_('Caching has been disabled for this blog. All cache contents have been purged.'), 'note' );
					}


					$edited_Blog->dbupdate();
					$Messages->add( T_('The blog settings have been updated'), 'success' );
				}
				break;

			case 'perm':
				blog_update_perms( $blog, 'user' );
				$Messages->add( T_('The blog permissions have been updated'), 'success' );
				break;

			case 'permgroup':
				blog_update_perms( $blog, 'group' );
				$Messages->add( T_('The blog permissions have been updated'), 'success' );
				break;
		}

		break;
}

$AdminUI->set_path( 'blogs',  $tab  );


/**
 * Display page header, menus & messages:
 */
$AdminUI->set_coll_list_params( 'blog_properties', 'edit',
											array( 'ctrl' => 'coll_settings', 'tab' => $tab, 'action' => 'edit' ),
											T_('List'), '?ctrl=collections&amp;blog=0' );

// Display <html><head>...</head> section! (Note: should be done early if actions do not redirect)
$AdminUI->disp_html_head();

// Display title, menu, messages, etc. (Note: messages MUST be displayed AFTER the actions)
$AdminUI->disp_body_top();


// Begin payload block:
$AdminUI->disp_payload_begin();


// Display VIEW:
switch( $AdminUI->get_path(1) )
{
	case 'general':
		$next_action = 'update';
		$AdminUI->disp_view( 'collections/views/_coll_general.form.php' );
		break;

	case 'features':
		$AdminUI->disp_view( 'collections/views/_coll_features.form.php' );
		break;

	case 'skin':
		$AdminUI->disp_view( 'skins/views/_coll_skin.view.php' );
		break;

	case 'skin_settings':
		$AdminUI->disp_view( 'skins/views/_coll_skin_settings.form.php' );
		break;

	case 'plugin_settings':
		$AdminUI->disp_view( 'collections/views/_coll_plugin_settings.form.php' );
		break;

	case 'urls':
		$AdminUI->disp_view( 'collections/views/_coll_urls.form.php' );
		break;

	case 'seo':
		$AdminUI->disp_view( 'collections/views/_coll_seo.form.php' );
		break;

	case 'advanced':
		$AdminUI->disp_view( 'collections/views/_coll_advanced.form.php' );
		break;

	case 'perm':
		$AdminUI->disp_view( 'collections/views/_coll_user_perm.form.php' );
		break;

	case 'permgroup':
		$AdminUI->disp_view( 'collections/views/_coll_group_perm.form.php' );
		break;
}

// End payload block:
$AdminUI->disp_payload_end();


// Display body bottom, debug info and close </html>:
$AdminUI->disp_global_footer();


/*
 * $Log: coll_settings.ctrl.php,v $
 */
?>