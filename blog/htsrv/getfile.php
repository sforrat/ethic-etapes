<?php
/**
 * This file implements the File view (including resizing of images)
 *
 * This file is part of the evoCore framework - {@link http://evocore.net/}
 * See also {@link http://sourceforge.net/projects/evocms/}.
 *
 * @copyright (c)2003-2009 by Francois PLANQUE - {@link http://fplanque.net/}
 * Parts of this file are copyright (c)2005-2006 by PROGIDISTRI - {@link http://progidistri.com/}.
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
 * PROGIDISTRI S.A.S. grants Francois PLANQUE the right to license
 * PROGIDISTRI S.A.S.'s contributions to this file and the b2evolution project
 * under any OSI approved OSS license (http://www.opensource.org/licenses/).
 * }}
 *
 * @package htsrv
 *
 * @todo dh> Add support for ETag / If-Modified-Since. Maybe send "Expires", too? (to "force" caching)
 *       fp> for more efficient caching (like creating a thumbnail on view 1 then displaying the thumbnail again on view 2), this should probably redirect to the static file right after creating it (when $public_access_to_media=true OF COURSE)
 *       dh> this would add another redirect/HTTP request and no cache handling, assuming
 *           that the server is not configured for smart caching.
 *           Additionally, it does not help for non-public access, which is the meat of this file.
 *           I've added "Expires: in ten years" now, but not for thumbs (see comment there).
 *
 * {@internal Below is a list of authors who have contributed to design/coding of this file: }}
 * @author blueyed: Daniel HAHLER
 * @author fplanque: Francois PLANQUE.
 * @author mbruneau: Marc BRUNEAU / PROGIDISTRI
 */


/**
 * Load config, init and get the {@link $mode mode param}.
 */
require_once dirname(__FILE__).'/../conf/_config.php';
require_once $inc_path.'/_main.inc.php';


// Check permission:
if( ! $public_access_to_media )
{
	if( ! isset($current_User) )
	{
		debug_die( 'No permission to get file (not logged in)!', array('status'=>'403 Forbidden') );
	}
	$current_User->check_perm( 'files', 'view', true );
	// fp> TODO: check specific READ perm for requested fileroot
}

// Load params:
param( 'root', 'string', true );	// the root directory from the dropdown box (user_X or blog_X; X is ID - 'user' for current user (default))
param( 'path', 'string', true );
param( 'size', 'string', NULL );	// Can be used for images.
param( 'mtime', 'integer', 0 );     // used for unique URLs (that never expire).

if ( false !== strpos( urldecode( $path ), '..' ) )
{
	debug_die( 'Relative pathnames not allowed!' );
}

// Load fileroot info:
$FileRootCache = & get_Cache( 'FileRootCache' );
$FileRoot = & $FileRootCache->get_by_ID( $root );

// Load file object (not the file content):
$File = & new File( $FileRoot->type, $FileRoot->in_type_ID, $path );

if( !empty($size) && $File->is_image() )
{	// We want a thumbnail:
	// This will do all the magic:
	$File->thumbnail( $size );
	// fp> TODO: for more efficient caching, this should probably redirect to the static file right after creating it (when $public_access_to_media=true OF COURSE)
	// TODO: dh> it would be nice, if the above would not do all the magic, but return
	//       image data and error code instead, allowing us to send "Expires" for given
	//       "mtime" like below. We do not want to send it for error images after all.
}
else
{	// We want the regular file:
	// Headers to display the file directly in the browser
	if( ! is_readable($File->get_full_path()) )
	{
		debug_die( sprintf('File "%s" is not readable!', rel_path_to_base($File->get_full_path())) );
	}

	$Filetype = & $File->get_Filetype();
	if( ! empty($Filetype) )
	{
		header('Content-type: '.$Filetype->mimetype );
		if( $Filetype->viewtype == 'download' )
		{
			header('Content-disposition: attachment; filename="'
				.addcslashes($File->get_name(), '\\"').'"' ); // escape quotes and slashes, according to RFC
		}
	}
	$file_path = $File->get_full_path();
	header('Content-Length: '.filesize( $file_path ) );

	// The URL refers to this specific file, therefore we can tell the browser that
	// it does not expire anytime soon.
	if( $mtime && $mtime == $File->get_lastmod_ts() ) // TODO: dh> use salt here?!
	{
		header('Expires: '.date('r', time()+315360000)); // 86400*365*10 (10 years)
	}

	// Display the content of the file
	readfile( $file_path );
}

/*
 * $Log: getfile.php,v $
 */
?>