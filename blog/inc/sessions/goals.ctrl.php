<?php
/**
 * This file implements the goals.
 *
 * b2evolution - {@link http://b2evolution.net/}
 * Released under GNU GPL License - {@link http://b2evolution.net/about/license.html}
 *
 * @copyright (c)2003-2009 by Francois PLANQUE - {@link http://fplanque.com/}
 *
 * @package admin
 *
 * {@internal Below is a list of authors who have contributed to design/coding of this file: }}
 * @author fplanque: Francois PLANQUE.
 *
 * @version $Id: goals.ctrl.php,v 1.5.2.1 2009/08/30 00:43:03 fplanque Exp $
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

load_class( 'sessions/model/_goal.class.php' );
load_funcs('sessions/model/_hitlog.funcs.php');

/**
 * @var User
 */
global $current_User;

global $dispatcher;

$blog = 0;

// Do we have permission to view all stats (aggregated stats) ?
$current_User->check_perm( 'stats', 'view', true );

$tab3 = param( 'tab3', 'string', 'goals', true );
$AdminUI->set_path( 'stats', 'goals', $tab3 );

param( 'action', 'string' );

if( param( 'goal_ID', 'integer', '', true) )
{// Load file type:
	$GoalCache = & get_Cache( 'GoalCache' );
	if( ($edited_Goal = & $GoalCache->get_by_ID( $goal_ID, false )) === false )
	{	// We could not find the goal to edit:
		unset( $edited_Goal );
		forget_param( 'goal_ID' );
		$Messages->head = T_('Cannot edit goal!');
		$Messages->add( T_('Requested goal does not exist any longer.'), 'error' );
		$action = 'nil';
	}
}

switch( $action )
{

	case 'new':
		// Check permission:
		$current_User->check_perm( 'stats', 'edit', true );

		$edited_Goal = & new Goal();
		break;

	case 'copy':
		// Check permission:
		$current_User->check_perm( 'stats', 'edit', true );

		// Duplicate a file type by prefilling create form:
		param( 'goal_ID', 'integer', true );
		$new_Goal = $edited_Goal;	// COPY
		$new_Goal->ID = 0;
		$edited_Goal = & $new_Goal;
		break;

	case 'edit':
		// Edit file type form...:

		// Check permission:
		$current_User->check_perm( 'stats', 'edit', true );

		// Make sure we got an ftyp_ID:
		param( 'goal_ID', 'integer', true );
 		break;

	case 'create':
		// Insert new file type...:
		$edited_Goal = & new Goal();

		// Check permission:
		$current_User->check_perm( 'stats', 'edit', true );

		// load data from request
		if( $edited_Goal->load_from_Request() )
		{	// We could load data from form without errors:
			// Insert in DB:
			$edited_Goal->dbinsert();
			$Messages->add( T_('New goal created.'), 'success' );

			// What next?
			param( 'submit', 'string', true );
			if( $submit == T_('Record, then Create Similar') ) // TODO: do not use submit value for this!
			{
				$action = 'new';
			}
			elseif( $submit == T_('Record, then Create New') ) // TODO: do not use submit value for this!
			{
				$action = 'new';
				$edited_Goal = & new Goal();
			}
			else
			{
				$action = 'list';
			}
		}
		break;

	case 'update':
		// Edit file type form...:

		// Check permission:
		$current_User->check_perm( 'options', 'edit', true );

		// Make sure we got an ftyp_ID:
		param( 'goal_ID', 'integer', true );

		// load data from request
		if( $edited_Goal->load_from_Request() )
		{	// We could load data from form without errors:
			// Update in DB:
			$edited_Goal->dbupdate();
			$Messages->add( T_('Goal updated.'), 'success' );
			$action = 'list';
		}
		break;

	case 'delete':
		// Delete file type:

		// Check permission:
		$current_User->check_perm( 'stats', 'edit', true );

		// Make sure we got an ftyp_ID:
		param( 'goal_ID', 'integer', true );

		if( param( 'confirm', 'integer', 0 ) )
		{ // confirmed, Delete from DB:
			$msg = sprintf( T_('Goal &laquo;%s&raquo; deleted.'), $edited_Goal->dget('name') );
			$edited_Goal->dbdelete( true );
			unset( $edited_Goal );
			forget_param( 'goal_ID' );
			$Messages->add( $msg, 'success' );
			$action = 'list';
		}
		else
		{	// not confirmed, Check for restrictions:
			if( ! $edited_Goal->check_delete( sprintf( T_('Cannot delete goal &laquo;%s&raquo;'), $edited_Goal->dget('name') ) ) )
			{	// There are restrictions:
				$action = 'view';
			}
		}
		break;

}

// Display <html><head>...</head> section! (Note: should be done early if actions do not redirect)
$AdminUI->disp_html_head();

// Display title, menu, messages, etc. (Note: messages MUST be displayed AFTER the actions)
$AdminUI->disp_body_top();

$AdminUI->disp_payload_begin();

echo $AdminUI->get_html_menu( array( 'stats', 'goals' ), 'menu3' );

/**
 * Display payload:
 */
switch( $action )
{
	case 'nil':
		// Do nothing
		break;


	case 'delete':
		// We need to ask for confirmation:
		$edited_Goal->confirm_delete(
				sprintf( T_('Delete goal &laquo;%s&raquo;?'), $edited_Goal->dget('name') ),
				$action, get_memorized( 'action' ) );
		/* no break */
	case 'new':
	case 'copy':
	case 'create':	// we return in this state after a validation error
	case 'edit':
	case 'update':	// we return in this state after a validation error
		$AdminUI->disp_view( 'sessions/views/_goal.form.php' );
		break;


	default:
		// No specific request, list all file types:
		switch( $tab3 )
		{
			case 'goals':
				// Cleanup context:
				forget_param( 'goal_ID' );
				// Display goals list:
				$AdminUI->disp_view( 'sessions/views/_stats_goals.view.php' );
				break;

			case 'stats':
				$AdminUI->disp_view( 'sessions/views/_goal_hitsummary.view.php' );
				break;
		}

}

$AdminUI->disp_payload_end();

// Display body bottom, debug info and close </html>:
$AdminUI->disp_global_footer();

/*
 * $Log: goals.ctrl.php,v $
 */
?>