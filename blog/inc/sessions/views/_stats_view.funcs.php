<?php
/**
 * This file implements the UI view for the browser hits summary.
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
 * @version $Id: _stats_view.funcs.php,v 1.6 2009/03/08 23:57:45 fplanque Exp $
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

/**
 * Helper function for "Requested URI" column
 * @param integer Blog ID
 * @param string Requested URI
 * @return string
 */
function stats_format_req_URI( $hit_blog_ID, $hit_uri, $max_len = 40 )
{
	if( !empty( $hit_blog_ID ) )
	{
		$BlogCache = & get_Cache( 'BlogCache' );
		$tmp_Blog = & $BlogCache->get_by_ID( $hit_blog_ID );
		$full_url = $tmp_Blog->get('baseurlroot').$hit_uri;
	}
	else
	{
		$full_url = $hit_uri;
	}

	if( strlen($hit_uri) > $max_len )
	{
		$hit_uri = '...'.substr( $hit_uri, -$max_len );
	}

	return '<a href="'.$full_url.'">'.$hit_uri.'</a>';
}



function stat_session_login( $login, $link = false )
{
	if( empty($login) )
	{
		return '<span class="note">'.T_('Anon.').'</span>';
	}
	elseif( $link )
	{
		return '<strong><a href="?ctrl=stats&amp;tab=sessions&amp;tab3=sessid&amp;user='.$login.'">'.$login.'</a></strong>';
	}
	else
	{
		return '<strong>'.$login.'</strong>';
	}
}


/*
 * $Log: _stats_view.funcs.php,v $
 */
?>