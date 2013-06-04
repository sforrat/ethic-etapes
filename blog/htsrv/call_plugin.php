<?php
/**
 * This file gets used to access {@link Plugin} methods that are marked to be accessible this
 * way. See {@link Plugin::GetHtsrvMethods()}.
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
 * @package htsrv
 *
 * {@internal Below is a list of authors who have contributed to design/coding of this file: }}
 * @author fplanque: Francois PLANQUE
 * @author blueyed: Daniel HAHLER
 *
 * @version $Id: call_plugin.php,v 1.12 2009/03/08 23:57:36 fplanque Exp $
 */


/**
 * Initialize:
 * TODO: Don't do a full init!
 */
require_once dirname(__FILE__).'/../conf/_config.php';
require_once $inc_path.'_main.inc.php';


param( 'plugin_ID', 'integer', true );
param( 'method', 'string', '' );
param( 'params', 'string', null ); // serialized

if( is_null($params) )
{ // Default:
	$params = array();
}
else
{ // params given. This may result in "false", but this means that unserializing failed.
	$params = @unserialize($params);
}


if( $plugin_ID )
{
	$Plugin = & $Plugins->get_by_ID( $plugin_ID );

	if( ! $Plugin )
	{
		debug_die( 'Invalid Plugin!' );
	}


	if( method_exists( $Plugin, 'get_htsrv_methods' ) )
	{ // TODO: get_htsrv_methods is deprecated, but should stay here for transformation! (blueyed, 2006-04-27)
		if( ! in_array( $method, $Plugin->get_htsrv_methods() ) )
		{
			debug_die( 'Call to non-htsrv Plugin method!' );
		}
	}
	else
	if( ! in_array( $method, $Plugin->GetHtsrvMethods() ) )
	{
		debug_die( 'Call to non-htsrv Plugin method!' );
	}
	elseif( ! method_exists( $Plugin, 'htsrv_'.$method ) )
	{
		debug_die( 'htsrv method does not exist!' );
	}

	// Call the method:
	$Plugins->call_method( $Plugin->ID, 'htsrv_'.$method, $params );
}


/* {{{ Revision log:
 * $Log: call_plugin.php,v $
 */
?>