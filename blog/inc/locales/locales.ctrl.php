<?php
/**
 * This file implements the UI controller for settings management.
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
 * @author blueyed: Daniel HAHLER
 * @author fplanque: Francois PLANQUE
 *
 * @version $Id: locales.ctrl.php,v 1.5 2009/03/08 23:57:45 fplanque Exp $
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );


// Check minimum permission:
$current_User->check_perm( 'options', 'view', true );


$AdminUI->set_path( 'options', 'regional' );

param( 'action', 'string' );
param( 'edit_locale', 'string' );
param( 'loc_transinfo', 'integer', 0 );


// Load all available locale defintions:
locales_load_available_defs();


if( in_array( $action, array( 'update', 'reset', 'updatelocale', 'createlocale', 'deletelocale', 'extract', 'prioup', 'priodown' )) )
{ // We have an action to do..
	// Check permission:
	$current_User->check_perm( 'options', 'edit', true );
	// clear settings cache
	$cache_settings = '';

	switch( $action )
	{ // switch between regional actions
		// UPDATE regional settings
		case 'update':
			param( 'newdefault_locale', 'string', true);
			$Settings->set( 'default_locale', $newdefault_locale );

			param( 'newtime_difference', 'string', '' );
			$newtime_difference = trim($newtime_difference);
			if( $newtime_difference == '' )
			{
				$newtime_difference = 0;
			}
			if( strpos($newtime_difference, ':') !== false )
			{ // hh:mm:ss format:
				$ntd = explode(':', $newtime_difference);
				if( count($ntd) > 3 )
				{
					param_error( 'newtime_difference', T_('Invalid time format.') );
				}
				else
				{
					$newtime_difference = $ntd[0]*3600 + ($ntd[1]*60);

					if( count($ntd) == 3 )
					{ // add seconds:
						$newtime_difference += $ntd[2];
					}
				}
			}
			else
			{ // just hours:
				$newtime_difference = $newtime_difference*3600;
			}

			$Settings->set( 'time_difference', $newtime_difference );

			if( ! $Messages->count('error') )
			{
				locale_updateDB();
				$Settings->dbupdate();
				$Messages->add( T_('Regional settings updated.'), 'success' );
			}
			break;


		// CREATE/EDIT locale
		case 'updatelocale':
		case 'createlocale':
			param( 'newloc_locale', 'string', true );
			param( 'newloc_enabled', 'integer', 0);
			param( 'newloc_name', 'string', true);
			param( 'newloc_charset', 'string', true);
			param( 'newloc_datefmt', 'string', true);
			param( 'newloc_timefmt', 'string', true);
			param( 'newloc_startofweek', 'integer', true);
			param( 'newloc_priority', 'integer', 1);
			param( 'newloc_messages', 'string', true);

			if( $action == 'updatelocale' )
			{
				param( 'oldloc_locale', 'string', true);

				$query = "SELECT loc_locale FROM T_locales WHERE loc_locale = '$oldloc_locale'";
				if( $DB->get_var($query) )
				{ // old locale exists in DB
					if( $oldloc_locale != $newloc_locale )
					{ // locale key was renamed, we delete the old locale in DB and remember to create the new one
						$q = $DB->query( 'DELETE FROM T_locales
																WHERE loc_locale = "'.$oldloc_locale.'"' );
						if( $DB->rows_affected )
						{
							$Messages->add( sprintf(T_('Deleted settings for locale &laquo;%s&raquo; in database.'), $oldloc_locale), 'success' );
						}
					}
				}
				else
				{ // old locale is not in DB yet. Insert it.
					$query = "INSERT INTO T_locales
										( loc_locale, loc_charset, loc_datefmt, loc_timefmt, loc_startofweek, loc_name, loc_messages, loc_priority, loc_enabled )
										VALUES ( '$oldloc_locale',
										'{$locales[$oldloc_locale]['charset']}', '{$locales[$oldloc_locale]['datefmt']}',
										'{$locales[$oldloc_locale]['timefmt']}', '{$locales[$oldloc_locale]['startofweek']}',
										'{$locales[$oldloc_locale]['name']}', '{$locales[$oldloc_locale]['messages']}',
										'{$locales[$oldloc_locale]['priority']}',";
					if( $oldloc_locale != $newloc_locale )
					{ // disable old locale
						$query .= ' 0)';
						$Messages->add( sprintf(T_('Inserted (and disabled) locale &laquo;%s&raquo; into database.'), $oldloc_locale), 'success' );
					}
					else
					{ // keep old state
						$query .= ' '.$locales[$oldloc_locale]['enabled'].')';
						$Messages->add( sprintf(T_('Inserted locale &laquo;%s&raquo; into database.'), $oldloc_locale), 'success' );
					}
					$q = $DB->query($query);
				}
			}

			$query = 'REPLACE INTO T_locales
								( loc_locale, loc_charset, loc_datefmt, loc_timefmt, loc_startofweek, loc_name, loc_messages, loc_priority, loc_enabled )
								VALUES ( '.$DB->quote($newloc_locale).', '.$DB->quote($newloc_charset).', '.$DB->quote($newloc_datefmt).', '
									.$DB->quote($newloc_timefmt).', '.$DB->quote($newloc_startofweek).', '.$DB->quote($newloc_name).', '
									.$DB->quote($newloc_messages).', '.$DB->quote($newloc_priority).', '.$DB->quote($newloc_enabled).' )';
			$q = $DB->query($query);
			$Messages->add( sprintf(T_('Saved locale &laquo;%s&raquo;.'), $newloc_locale), 'success' );

			// reload locales: an existing one could have been renamed (but we keep $evo_charset, which may have changed)
			$old_evo_charset = $evo_charset;
			unset( $locales );
			include $conf_path.'_locales.php';
			if( file_exists($conf_path.'_overrides_TEST.php') )
			{ // also overwrite settings again:
				include $conf_path.'_overrides_TEST.php';
			}
			$evo_charset = $old_evo_charset;

			// Load all available locale defintions:
			locales_load_available_defs();

			break;


		// RESET locales in DB
		case 'reset':
			// reload locales from files
			unset( $locales );
			include $conf_path.'_locales.php';
			if( file_exists($conf_path.'_overrides_TEST.php') )
			{ // also overwrite settings again:
				include $conf_path.'_overrides_TEST.php';
			}

			// delete everything from locales table
			$q = $DB->query( 'DELETE FROM T_locales WHERE 1=1' );

			if( !isset( $locales[$current_locale] ) )
			{ // activate default locale
				locale_activate( $default_locale );
			}

			// reset default_locale
			$Settings->set( 'default_locale', $default_locale );
			$Settings->dbupdate();

			// Load all available locale defintions:
			locales_load_available_defs();

			$Messages->add( T_('Locale definitions reset to defaults. (<code>/conf/_locales.php</code>)'), 'success' );
			break;


		// EXTRACT locale
		case 'extract':
			// Get PO file for that edit_locale:
			$AdminUI->append_to_titlearea( 'Extracting language file for '.$edit_locale.'...' );

			$po_file = $locales_path.$locales[$edit_locale]['messages'].'/LC_MESSAGES/messages.po';
			if( ! is_file( $po_file ) )
			{
				$Messages->add( sprintf(T_('File <code>%s</code> not found.'), '/'.$locales_subdir.$locales[$edit_locale]['messages'].'/LC_MESSAGES/messages.po'), 'error' );
				break;
			}

			$outfile = $locales_path.$locales[$edit_locale]['messages'].'/_global.php';
			if( !is_writable($outfile) )
			{
				$Messages->add( sprintf( 'The file &laquo;%s&raquo; is not writable.', $outfile ) );
				break;
			}


			load_class( 'locales/_pofile.class.php' );
			$POFile = new POFile($po_file);
			$POFile->read(true); // adds info about sources to $Messages
			$POFile->write_evo_trans($outfile, $locales[$edit_locale]['messages']);
			break;

		case 'deletelocale':
			// --- DELETE locale from DB
			if( $DB->query( 'DELETE FROM T_locales WHERE loc_locale = "'.$DB->escape( $edit_locale ).'"' ) )
			{
				$Messages->add( sprintf(T_('Deleted locale &laquo;%s&raquo; from database.'), $edit_locale), 'success' );
			}

			// reload locales
			unset( $locales );
			require $conf_path.'_locales.php';
			if( file_exists($conf_path.'_overrides_TEST.php') )
			{ // also overwrite settings again:
				include $conf_path.'_overrides_TEST.php';
			}

			// Load all available locale defintions:
			locales_load_available_defs();

			break;

		// --- SWITCH PRIORITIES -----------------
		case 'prioup':
		case 'priodown':
			$switchcond = '';
			if( $action == 'prioup' )
			{
				$switchcond = 'return ($lval[\'priority\'] > $i && $lval[\'priority\'] < $locales[ $edit_locale ][\'priority\']);';
				$i = -1;
			}
			elseif( $action == 'priodown' )
			{
				$switchcond = 'return ($lval[\'priority\'] < $i && $lval[\'priority\'] > $locales[ $edit_locale ][\'priority\']);';
				$i = 256;
			}

			if( !empty($switchcond) )
			{ // we want to switch priorities

				foreach( $locales as $lkey => $lval )
				{ // find nearest priority
					if( eval($switchcond) )
					{
						// remember it
						$i = $lval['priority'];
						$lswitchwith = $lkey;
					}
				}
				if( $i > -1 && $i < 256 )
				{ // switch
					#echo 'Switching prio '.$locales[ $lswitchwith ]['priority'].' with '.$locales[ $lswitch ]['priority'].'<br />';
					$locales[ $lswitchwith ]['priority'] = $locales[ $edit_locale ]['priority'];
					$locales[ $edit_locale ]['priority'] = $i;

					$query = "REPLACE INTO T_locales ( loc_locale, loc_charset, loc_datefmt, loc_timefmt, loc_name, loc_messages, loc_priority, loc_enabled )	VALUES
						( '$edit_locale', '{$locales[ $edit_locale ]['charset']}', '{$locales[ $edit_locale ]['datefmt']}', '{$locales[ $edit_locale ]['timefmt']}', '{$locales[ $edit_locale ]['name']}', '{$locales[ $edit_locale ]['messages']}', '{$locales[ $edit_locale ]['priority']}', '{$locales[ $edit_locale ]['enabled']}'),
						( '$lswitchwith', '{$locales[ $lswitchwith ]['charset']}', '{$locales[ $lswitchwith ]['datefmt']}', '{$locales[ $lswitchwith ]['timefmt']}', '{$locales[ $lswitchwith ]['name']}', '{$locales[ $lswitchwith ]['messages']}', '{$locales[ $lswitchwith ]['priority']}', '{$locales[ $lswitchwith ]['enabled']}')";
					$q = $DB->query( $query );

					$Messages->add( T_('Switched priorities.'), 'success' );
				}

			}
			break;
	}
	locale_overwritefromDB();
}



// Display <html><head>...</head> section! (Note: should be done early if actions do not redirect)
$AdminUI->disp_html_head();

// Display title, menu, messages, etc. (Note: messages MUST be displayed AFTER the actions)
$AdminUI->disp_body_top();

// Begin payload block:
$AdminUI->disp_payload_begin();

// Display VIEW:
$AdminUI->disp_view( 'locales/_locale_settings.form.php' );

// End payload block:
$AdminUI->disp_payload_end();

// Display body bottom, debug info and close </html>:
$AdminUI->disp_global_footer();


/*
 * $Log: locales.ctrl.php,v $
 */
?>