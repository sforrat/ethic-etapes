<?php
/**
 * This file implements the PLugin settings form.
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
 * @package admin
 *
 * @author fplanque: Francois PLANQUE.
 *
 * @version $Id: _coll_plugin_settings.form.php,v 1.3.2.1 2009/08/09 19:15:17 fplanque Exp $
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

/**
 * @var Blog
 */
global $Blog;

/**
 * @var Plugins
 */
global $Plugins;


$Form = & new Form( NULL, 'plugin_settings_checkchanges' );

// PluginUserSettings
load_funcs('plugins/_plugin.funcs.php');

$have_plugins = false;
$Plugins->restart();
while( $loop_Plugin = & $Plugins->get_next() )
{
	$Form->begin_form( 'fform' );

		$Form->hidden_ctrl();
		$Form->hidden( 'tab', 'plugin_settings' );
		$Form->hidden( 'action', 'update' );
		$Form->hidden( 'blog', $Blog->ID );

	// We use output buffers here to display the fieldset only if there's content in there
	ob_start();

	$Form->begin_fieldset( $loop_Plugin->name );

	ob_start();

	$plugin_settings = $loop_Plugin->get_coll_setting_definitions( $tmp_params = array('for_editing'=>true) );
	if( is_array($plugin_settings) )
	{
		foreach( $plugin_settings as $l_name => $l_meta )
		{
			// Display form field for this setting:
			autoform_display_field( $l_name, $l_meta, $Form, 'CollSettings', $loop_Plugin, $Blog );
		}
	}

	$has_contents = strlen( ob_get_contents() );

	$Form->end_fieldset();

	if( $has_contents )
	{
		ob_end_flush();
		ob_end_flush();

		$have_plugins = true;
	}
	else
	{ // No content, discard output buffers:
		ob_end_clean();
		ob_end_clean();
	}
}

if( $have_plugins )
{	// End form:
	$Form->end_form( array( array( 'submit', 'submit', T_('Update'), 'SaveButton' ),
															array( 'reset', '', T_('Reset'), 'ResetButton' ) ) );
}
else
{	// Display a message:
	echo '<p>', T_( 'There are no plugins providing blog-specific settings.' ), '</p>';
	$Form->end_form();
}

/*
 * $Log: _coll_plugin_settings.form.php,v $
 */
?>