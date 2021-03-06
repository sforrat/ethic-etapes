<?php
/**
 * This file implements the Goal form.
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
 * @version $Id: _goal.form.php,v 1.3 2009/05/16 00:28:04 fplanque Exp $
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

/**
 * @var Goal
 */
global $edited_Goal;

// Determine if we are creating or updating...
global $action;
$creating = is_create_action( $action );

// These params need to be memorized and passed through regenerated urls: (this allows to come back to the right list order & page)
param( 'results_goals_page', 'integer', '', true );
param( 'results_goals_order', 'string', '', true );

$Form = & new Form( NULL, 'goal_checkchanges', 'post', 'compact' );

$Form->global_icon( T_('Delete this goal!'), 'delete', regenerate_url( 'action', 'action=delete' ) );
$Form->global_icon( T_('Cancel editing!'), 'close', regenerate_url( 'action' ) );

$Form->begin_form( 'fform', $creating ?  T_('New goal') : T_('Goal') );

	$Form->hidden( 'action', $creating ? 'create' : 'update' );
	$Form->hiddens_by_key( get_memorized( 'action' ) ); // (this allows to come back to the right list order & page)

	if( ! $creating ) $Form->hidden( 'goal_ID', $edited_Goal->ID );

	$Form->text_input( 'goal_name', $edited_Goal->name, 40, T_('Name'), '', array( 'maxlength'=> 50, 'required'=>true ) );

	$Form->text_input( 'goal_key', $edited_Goal->key, 32, T_('Key'), T_('Should be URL friendly'), array( 'required'=>true ) );

	$Form->text_input( 'goal_redir_url', $edited_Goal->redir_url, 60, T_('Redirection URL'), '', array( 'maxlength'=> 255, 'class'=>'large' ) );

	$Form->text_input( 'goal_default_value', $edited_Goal->default_value, 15, T_('Default value'), '' );

if( $creating )
{
	$Form->end_form( array( array( 'submit', 'submit', T_('Record'), 'SaveButton' ),
													array( 'submit', 'submit', T_('Record, then Create New'), 'SaveButton' ),
													array( 'submit', 'submit', T_('Record, then Create Similar'), 'SaveButton' ),
													array( 'reset', '', T_('Reset'), 'ResetButton' ) ) );
}
else
{
	$Form->end_form( array( array( 'submit', 'submit', T_('Update'), 'SaveButton' ),
													array( 'reset', '', T_('Reset'), 'ResetButton' ) ) );
}


/*
 * $Log: _goal.form.php,v $
 */
?>