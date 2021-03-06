<?php
/**
 * This is the account validation form. It gets included if the user needs to validate his account.
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
 * Daniel HAHLER grants Francois PLANQUE the right to license
 * Daniel HAHLER's contributions to this file and the b2evolution project
 * under any OSI approved OSS license (http://www.opensource.org/licenses/).
 * }}
 *
 * @package htsrv
 *
 * {@internal Below is a list of authors who have contributed to design/coding of this file: }}
 * @author blueyed: Daniel HAHLER
 * @author fplanque: Francois PLANQUE.
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

/**
 * Include page header:
 */
$page_title = T_('Email address validation');
$page_icon = 'icon_register.gif';
require dirname(__FILE__).'/_html_header.inc.php';

$Form = & new Form( $htsrv_url_sensitive.'login.php', 'form_validatemail', 'post', 'fieldset' );

$Form->begin_form( 'fform' );

$Form->hidden( 'action', 'req_validatemail');
$Form->hidden( 'redirect_to', url_rel_to_same_host($redirect_to, $htsrv_url_sensitive) );
$Form->hidden( 'req_validatemail_submit', 1 ); // to know if the form has been submitted

$Form->begin_fieldset( T_('Email address validation') );

	echo '<ol>';
	echo '<li>'.T_('Please confirm your email address below.').'</li>';
	echo '<li>'.T_('An email will be sent to this address immediately.').'</li>';
	echo '<li>'.T_('As soon as you receive the email, click on the link therein to activate your account.').'</li>';
	echo '</ol>';

	$Form->text_input( 'email', $email, 16, T_('Email'), '', array( 'maxlength'=>255, 'class'=>'input_text', 'required'=>true ) );

	$Plugins->trigger_event( 'DisplayValidateAccountFormFieldset', array( 'Form' => & $Form ) );

// TODO: the form submit value is too wide (in Konqueror and most probably in IE!)
$Form->end_form( array(array( 'name'=>'form_validatemail_submit', 'value'=>T_('Send me an email now!'), 'class'=>'ActionButton' )) ); // display hidden fields etc


if( $current_User->group_ID == 1 )
{ // allow admin users to validate themselves by a single click:
	$Form = & new Form( $htsrv_url_sensitive.'login.php', 'form_validatemail', 'post', 'fieldset' );
	$Form->begin_form( 'fform' );

	$Form->hidden( 'action', 'validatemail');
	$Form->hidden( 'redirect_to', url_rel_to_same_host($redirect_to, $htsrv_url_sensitive) );
	$Form->hidden( 'reqID', 1 );
	$Form->hidden( 'sessID', $Session->ID );

	$Form->begin_fieldset();
	echo '<p>'.sprintf( T_('Since you are an admin user, you can validate your email address (%s) by a single click.' ), $current_User->email ).'</p>';
	// TODO: the form submit value is too wide (in Konqueror and most probably in IE!)
	$Form->end_form( array(array( 'name'=>'form_validatemail_admin_submit', 'value'=>T_('Activate my account!'), 'class'=>'ActionButton' )) ); // display hidden fields etc
}
?>

<div style="text-align:right">
	<?php
	user_logout_link();
	?>
</div>

<?php
require dirname(__FILE__).'/_html_footer.inc.php';


/*
 * $Log: _validate_form.main.php,v $
 */
?>