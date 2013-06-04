<?php
/**
 * @see http://phpxmlrpc.sourceforge.net/
 * @see http://xmlrpc.usefulinc.com/doc/
 * @copyright Edd Dumbill <edd@usefulinc.com> (C) 1999-2002
 *
 * @package evocore
 * @subpackage xmlrpc
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

if( CANUSEXMLRPC !== TRUE )
{
	return;
}

/**
 * Include XML-RPC for PHP SERVER library
 */
load_funcs('_ext/xmlrpc/_xmlrpcs.inc.php');


// --------------------------------------- SUPPORT FUNCTIONS ----------------------------------------


/**
 * Used for logging, only if {@link $debug_xmlrpc_logging} is true
 *
 * @return boolean Have we logged?
 */
function logIO( $msg, $newline = false )
{
	global $debug_xmlrpc_logging, $basepath, $xmlsrv_subdir;

	if( ! $debug_xmlrpc_logging )
	{
		return false;
	}

	$fp = fopen( $basepath.$xmlsrv_subdir.'xmlrpc.log', 'a+' );
	if( $newline )
	{
		$date = date('Y-m-d H:i:s ');
		fwrite( $fp, "\n\n".$date );
	}
	fwrite($fp, $msg."\n");
	fclose($fp);

	return true;
}


/**
 * Returns a string replaced by stars, for passwords.
 *
 * @param string the source string
 * @return string same length, but only stars
 */
function starify( $string )
{
	return str_repeat( '*', strlen( $string ) );
}


/**
 * Helper for {@link b2_getcategories()} and {@link mt_getPostCategories()}, because they differ
 * only in the "categoryId" case ("categoryId" (b2) vs "categoryID" (MT))
 *
 * @param string Type, either "b2" or "mt"
 * @param xmlrpcmsg XML-RPC Message
 *					0 blogid (string): Unique identifier of the blog to query
 *					1 username (string): Login for a Blogger user who is member of the blog.
 *					2 password (string): Password for said username.
 * @return xmlrpcresp XML-RPC Response
 */
function _b2_or_mt_get_categories( $type, $m )
{
	global $DB, $Settings;

	// CHECK LOGIN:
	// Tblue> Note on perms: I think an user doesn't need any special perms
	//                       to get a list of blog categories; the only
	//                       requirement for the user is to have an account
	//                       in the system.
	/**
	 * @var User
	 */
	if( ! $current_User = & xmlrpcs_login( $m, 1, 2 ) )
	{	// Login failed, return (last) error:
		return xmlrpcs_resperror();
	}

	// GET BLOG:
	/**
	 * @var Blog
	 */
	if( ! $Blog = & xmlrpcs_get_Blog( $m, 0 ) )
	{	// Login failed, return (last) error:
		return xmlrpcs_resperror();
	}

	$sql = 'SELECT *
					  FROM T_categories ';

	$BlogCache = & get_Cache('BlogCache');
	$current_Blog = $BlogCache->get_by_ID( $Blog->ID );
	$sql .= 'WHERE '.$Blog->get_sql_where_aggregate_coll_IDs('cat_blog_ID');
	if( $Settings->get('chapter_ordering') == 'manual' )
	{	// Manual order
		$sql .= ' ORDER BY cat_order';
	}
	else
	{	// Alphabetic order
		$sql .= ' ORDER BY cat_name';
	}

	$rows = $DB->get_results( $sql );
	if( $DB->error )
	{ // DB error
		return xmlrpcs_resperror( 99, 'DB error: '.$DB->last_error ); // user error 99
	}

	logIO( 'Categories: '.$DB->num_rows );

	$categoryIdName = ( $type == 'b2' ? 'categoryID' : 'categoryId' );
	$data = array();
	foreach( $rows as $row )
	{
		$data[] = new xmlrpcval( array(
				$categoryIdName => new xmlrpcval( $row->cat_ID ),
				'categoryName' => new xmlrpcval( $row->cat_name )
			//	mb_convert_encoding( $row->cat_name, "utf-8", "iso-8859-1")  )
			), 'struct' );
	}

	logIO( 'OK.' );
	return new xmlrpcresp( new xmlrpcval($data, 'array') );
}


/**
 * Get current_User for an XML-RPC request - Includes login (password) check.
 *
 * @param xmlrpcmsg XML-RPC Message
 * @param integer idx of login param in XML-RPC Message
 * @param integer idx of pass param in XML-RPC Message
 * @return User or NULL
 */
function & xmlrpcs_login( $m, $login_param, $pass_param )
{
	global $xmlrpcs_errcode, $xmlrpcs_errmsg, $xmlrpcerruser;

	$username = $m->getParam( $login_param );
	$username = $username->scalarval();

	$password = $m->getParam( $pass_param );
	$password = $password->scalarval();

  /**
	 * @var UserCache
	 */
	$UserCache = & get_Cache( 'UserCache' );
	$current_User = & $UserCache->get_by_login( $username );

	if( empty( $current_User ) || ! $current_User->check_password( $password, false ) )
	{	// User not found or password doesn't match
		$xmlrpcs_errcode = $xmlrpcerruser+1;
		$xmlrpcs_errmsg = 'Wrong username/password combination: '.$username.' / '.starify($password);
		$r = NULL;
		return $r;
	}

	logIO( 'Login OK - User: '.$current_User->ID.' - '.$current_User->login );

  // This may be needed globally for status permissions in ItemList2, etc..
	$GLOBALS['current_User'] = & $current_User;

	return $current_User;
}


/**
 * Get current Blog for an XML-RPC request.
 *
 * @param xmlrpcmsg XML-RPC Message
 * @param integer idx of blog param
 * @return Blog or NULL
 */
function & xmlrpcs_get_Blog( $m, $blog_param )
{
	global $xmlrpcs_errcode, $xmlrpcs_errmsg, $xmlrpcerruser;

	$blog = $m->getParam( $blog_param );
	$blog = $blog->scalarval();
	// waltercruz> qtm: http://qtm.blogistan.co.uk/ inserts some spacing before/after blogID.
	$blog = (int) trim($blog);
	/**
	 * @var BlogCache
	 */
	$BlogCache = & get_Cache( 'BlogCache' );
	/**
	 * @var Blog
	 */
	$Blog = & $BlogCache->get_by_ID( $blog, false, false );

	if( empty( $Blog ) )
	{	// Blog not found
		$xmlrpcs_errcode = $xmlrpcerruser+2;
		$xmlrpcs_errmsg = 'Requested blog/Collection ('.$blog.') does not exist.';
		$r = NULL;
		return $r;
	}

	logIO( 'Requested Blog: '.$Blog->ID.' - '.$Blog->name );

	return $Blog;
}


/**
 * Get current Item for an XML-RPC request.
 *
 * @param xmlrpcmsg XML-RPC Message
 * @param integer idx of postid param
 * @return Blog or NULL
 */
function & xmlrpcs_get_Item( $m, $postid_param )
{
	global $xmlrpcs_errcode, $xmlrpcs_errmsg, $xmlrpcerruser;

	$postid = $m->getParam( $postid_param );
	$postid = $postid->scalarval();

  /**
	 * @var ItemCache
	 */
	$ItemCache = & get_Cache( 'ItemCache' );
  /**
	 * @var Item
	 */
	$edited_Item = & $ItemCache->get_by_ID( $postid, false, false );

	if( empty( $edited_Item ) )
	{	// Blog not found
		$xmlrpcs_errcode = $xmlrpcerruser+6;
		$xmlrpcs_errmsg = 'Requested post/Item ('.$postid.') does not exist.';
		$r = NULL;
		return $r;
	}

	logIO( 'Requested Item: '.$edited_Item->ID.' - '.$edited_Item->title );

	return $edited_Item;
}


/**
 * If no errcode or errmsg given, will use the last one that has been set previously.
 *
 * @param integer
 * @param string
 * @return xmlrpcresp
 */
function xmlrpcs_resperror( $errcode = NULL, $errmsg = NULL )
{
	global $xmlrpcs_errcode, $xmlrpcs_errmsg, $xmlrpcerruser;

	if( !empty($errcode) )
	{ // Transform into user error code
		$xmlrpcs_errcode = $xmlrpcerruser + $errcode;
	}

	if( !empty($errmsg) )
	{	// Custom message
		$xmlrpcs_errmsg = $errmsg;
	}
	elseif( empty( $xmlrpcs_errmsg ) )
	{	// Use a standard messsage
		switch( $errcode )
		{
			case 3:
				$xmlrpcs_errmsg = 'Permission denied.';
				break;

			case 11:
				$xmlrpcs_errmsg = 'Requested category not found in requested blog.';
				break;

			case 12:
				$xmlrpcs_errmsg = 'No default category found for requested blog.';
				break;

			case 21:
				$xmlrpcs_errmsg = 'Invalid post title.';
				break;

			case 22:
				$xmlrpcs_errmsg = 'Invalid post contents.';
				break;

			case 99:
				$xmlrpcs_errmsg = 'Database error.';
				break;

			default:
				$xmlrpcs_errmsg = 'Unknown error.';
		}
	}

	logIO( 'ERROR: '.$xmlrpcs_errcode.' - '.$xmlrpcs_errmsg );

  return new xmlrpcresp( 0, $xmlrpcs_errcode, $xmlrpcs_errmsg );
}


/**
 * Create a new Item and return an XML-RPC response
 *
 * @param string HTML
 * @param string HTML
 * @param string date
 * @param integer main category
 * @param array of integers : extra categories
 * @param string status
 * @return xmlrpcmsg
 */
function xmlrpcs_new_item( $post_title, $content, $post_date, $main_cat, $cat_IDs, $status )
{
  /**
	 * @var User
	 */
	global $current_User;

	global $Messages;
	global $DB;

	// CHECK HTML SANITY:
	if( ($post_title = check_html_sanity( $post_title, 'xmlrpc_posting' )) === false )
	{
		return xmlrpcs_resperror( 21, $Messages->get_string( 'Invalid post title, please correct these errors:', '' ) );
	}
	if( ($content = check_html_sanity( $content, 'xmlrpc_posting' )) === false  )
	{
		return xmlrpcs_resperror( 22, $Messages->get_string( 'Invalid post contents, please correct these errors:'."\n", '', NULL, "  //  \n", 'xmlrpc' ) );
	}

	// INSERT NEW POST INTO DB:
	load_class( 'items/model/_item.class.php' );
	$edited_Item = & new Item();
	$edited_Item->set( 'title', $post_title );
	$edited_Item->set( 'content', $content );
	$edited_Item->set( 'datestart', $post_date );
	$edited_Item->set( 'main_cat_ID', $main_cat );
	$edited_Item->set( 'extra_cat_IDs', $cat_IDs );
	$edited_Item->set( 'status', $status);
	$edited_Item->set( 'locale', $current_User->locale );
	$edited_Item->set_creator_User( $current_User );
	$edited_Item->dbinsert();
	if( empty($edited_Item->ID) )
	{ // DB error
		return xmlrpcs_resperror( 99, 'Error while inserting item: '.$DB->last_error );
	}
	logIO( 'Posted with ID: '.$edited_Item->ID );

	// Execute or schedule notifications & pings:
	logIO( 'Handling notifications...' );
	$edited_Item->handle_post_processing();

 	logIO( 'OK.' );
	return new xmlrpcresp(new xmlrpcval($edited_Item->ID));
}


/**
 * Edit an Item and return an XML-RPC response
 *
 * @param Item
 * @param string HTML
 * @param string HTML
 * @param string date
 * @param integer main category
 * @param array of integers : extra categories
 * @param string status
 * @return xmlrpcmsg
 */
function xmlrpcs_edit_item( & $edited_Item, $post_title, $content, $post_date, $main_cat, $cat_IDs, $status )
{
  /**
	 * @var User
	 */
	global $current_User;

	global $Messages;
	global $DB;

	// CHECK HTML SANITY:
	if( ($post_title = check_html_sanity( $post_title, 'xmlrpc_posting' )) === false )
	{
		return xmlrpcs_resperror( 21, $Messages->get_string( 'Invalid post title, please correct these errors:', '' ) );
	}
	if( ($content = check_html_sanity( $content, 'xmlrpc_posting' )) === false  )
	{
		return xmlrpcs_resperror( 22, $Messages->get_string( 'Invalid post contents, please correct these errors:'."\n", '', NULL, "  //  \n", 'xmlrpc' ) );
	}

	// UPDATE POST IN DB:
	$edited_Item->set( 'title', $post_title );
	$edited_Item->set( 'content', $content );
	$edited_Item->set( 'status', $status );
	if( !empty($post_date) )
	{
		$edited_Item->set( 'issue_date', $post_date );
	}
	if( !empty($main_cat) )
	{ // Update cats:
		$edited_Item->set('main_cat_ID', $main_cat);
	}
	if( !empty($cat_IDs) )
	{ // Extra-Cats:
		$edited_Item->set('extra_cat_IDs', $cat_IDs);
	}
	$edited_Item->dbupdate();
	if( $DB->error )
	{ // DB error
		return xmlrpcs_resperror( 99, 'Error while updating item: '.$DB->last_error );
	}

	// Execute or schedule notifications & pings:
	logIO( 'Handling notifications...' );
	$edited_Item->handle_post_processing();

	logIO( 'OK.' );
	return new xmlrpcresp( new xmlrpcval( 1, 'boolean' ) );
}


/**
 * Check that an User can view a specific Item.
 *
 * @param object The Item (by reference).
 * @param object The User (by reference).
 * @return boolean True if permission granted, false otherwise.
 */
function xmlrpcs_can_view_item( & $Item, & $current_User )
{
	$can_view_post = false;
	switch( $Item->status )
	{
		case 'published':
		case 'redirected':
			$can_view_post = true;
			break;
		case 'protected':
		case 'draft':
		case 'deprecated':
			$can_view_post = $current_User->check_perm( 'blog_ismember', 'view', false, $Item->get_blog_ID() );
			break;
		case 'private':
			$can_view_post = ( $Item->creator_user_ID == $current_User->ID );
			break;
	}

	logIO( 'xmlrpcs_can_view_item(): Post status: '.$Item->status );
	logIO( 'xmlrpcs_can_view_item( Item(#'.$Item->ID.'), User(#'.$current_User->ID.') ): Permission '.( $can_view_post ? 'granted' : 'DENIED' ) );
	return $can_view_post;
}


/**
 * Check whether the main category and the extra categories are valid
 * in a Blog's context and try to fix errors.
 *
 * @author Tilman BLUMENBACH / Tblue
 * 
 * @param integer The main category to check (by reference).
 * @param object The Blog to which the category is supposed to belong to (by reference).
 * @param array Extra categories for the post (by reference).
 *
 * @return boolean False on error (use xmlrpcs_resperror() to return it), true on success.
 */
function xmlrpcs_check_cats( & $maincat, & $Blog, & $extracats )
{
	global $allow_cross_posting, $xmlrpcs_errcode, $xmlrpcs_errmsg, $xmlrpcerruser;

	// Trim $maincat and $extracats (qtm sends whitespace before the cat IDs):
	$maincat   = trim( $maincat );
	$extracats = array_map( 'trim', $extracats );

	$ChapterCache = & get_Cache( 'ChapterCache' );

	// ---- CHECK MAIN CATEGORY ----
	if( $ChapterCache->get_by_ID( $maincat, false ) === false )
	{	// Category does not exist!
		// Remove old category from extra cats:
		if( ( $key = array_search( $maincat, $extracats ) ) !== false )
		{
			unset( $extracats[$key] );
		}

		// Set new category (blog default):
		$maincat = $Blog->get_default_cat_ID();
		logIO( 'Invalid main cat ID - new ID: '.$maincat );
	}
	else if( $allow_cross_posting < 3 && get_catblog( $maincat ) != $Blog->ID )
	{	// We cannot use a maincat of another blog than the current one:
		$xmlrpcs_errcode = $xmlrpcerruser + 11;
		$xmlrpcs_errmsg = 'Current crossposting setting does not allow moving posts to a different blog.';
		return false;
	}

	// ---- CHECK EXTRA CATEGORIES ----
	foreach( $extracats as $ecat )
	{
		if( $ecat == $maincat )
		{	// We already checked the maincat above (or reset it):
			continue;
		}

		logIO( 'Checking cat: '.$ecat );
		if( $ChapterCache->get_by_ID( $ecat, false ) === false )
		{	// Extra cat does not exist:
			$xmlrpcs_errcode = $xmlrpcerruser + 11;
			$xmlrpcs_errmsg  = 'Extra category '.(int)$ecat.' not found in requested blog.';
			return false;
		}
	}

	if( ! in_array( $maincat, $extracats ) )
	{
		logIO( '$maincat was not found in $extracats array - adding.' );
		$extracats[] = $maincat;
	}

	return true;
}


/*
 * $Log: _xmlrpcs.funcs.php,v $
 */
?>