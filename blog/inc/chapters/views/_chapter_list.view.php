<?php
/**
 * This file implements the recursive chapter list.
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
 * @package admin
 *
 * {@internal Below is a list of authors who have contributed to design/coding of this file: }}
 * @author fplanque: Francois PLANQUE.
 *
 * @version $Id: _chapter_list.view.php,v 1.18 2009/07/06 23:52:24 sam2kb Exp $
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );
//____________________ Callbacks functions to display categories list _____________________

/**
 * @var Blog
 */
global $Blog;

global $Settings;

global $GenericCategoryCache;

global $line_class;

global $permission_to_edit;

global $subset_ID;

global $result_fadeout;

global $current_default_cat_ID;

$current_default_cat_ID = $Blog->get_setting('default_cat_ID');

$line_class = 'odd';


/**
 * Generate category line when it has children
 *
 * @param Chapter generic category we want to display
 * @param int level of the category in the recursive tree
 * @return string HTML
 */
function cat_line( $Chapter, $level )
{
	global $line_class, $result_fadeout, $permission_to_edit, $current_User, $Settings;
	global $GenericCategoryCache, $current_default_cat_ID;


	$line_class = $line_class == 'even' ? 'odd' : 'even';

	$r = '<tr id="tr-'.$Chapter->ID.'"class="'.$line_class.
					' chapter_parent_'.( $Chapter->parent_ID ? $Chapter->parent_ID : '0' ).
					// Fadeout?
					( isset($result_fadeout[$GenericCategoryCache->dbIDname]) && in_array( $Chapter->ID, $result_fadeout[$GenericCategoryCache->dbIDname] ) ? ' fadeout-ffff00': '' ).'">
					<td class="firstcol shrinkwrap">'.
						$Chapter->ID.'
				</td>';

	$makedef_url = regenerate_url( 'action,cat_ID', 'cat_ID='.$Chapter->ID.'&amp;action=make_default' );
	$makedef_title = T_('Click to make this the default category');

	if( $current_default_cat_ID == $Chapter->ID )
	{
		$makedef_icon = 'enabled';
	}
	else
	{
		$makedef_icon = 'disabled';
	}
	$r .= '<td class="center"><a href="'.$makedef_url.'" title="'.$makedef_title.'">'.get_icon($makedef_icon, 'imgtag').'</a></td>';

	if( $permission_to_edit )
	{	// We have permission permission to edit:
		$edit_url = regenerate_url( 'action,cat_ID', 'cat_ID='.$Chapter->ID.'&amp;action=edit' );
		$r .= '<td>
						<strong style="padding-left: '.($level).'em;"><a href="'.$edit_url.'" title="'.T_('Edit...').'">'.$Chapter->dget('name').'</a></strong>
					 </td>';
	}
	else
	{
		$r .= '<td>
						 <strong style="padding-left: '.($level).'em;">'.$Chapter->dget('name').'</strong>
					 </td>';
	}

	$r .= '<td>'.$Chapter->dget('urlname').'</td>';

	if( $Settings->get('chapter_ordering') == 'manual' )
	{
		$r .= '<td class="center">'.$Chapter->dget('order').'</td>';
	}

	$r .= '<td class="lastcol shrinkwrap">';
	if( $permission_to_edit )
	{	// We have permission permission to edit, so display action column:
		$r .= '<a href="'.$makedef_url.'" title="'.$makedef_title.'">'.get_icon('activate', 'imgtag').'</a>';
		$r .= action_icon( T_('Edit...'), 'edit', $edit_url );
		if( $Settings->get('allow_moving_chapters') )
		{ // If moving cats between blogs is allowed:
			$r .= action_icon( T_('Move to a different blog...'), 'file_move', regenerate_url( 'action,cat_ID', 'cat_ID='.$Chapter->ID.'&amp;action=move' ), T_('Move') );
		}
		$r .= action_icon( T_('New...'), 'new', regenerate_url( 'action,cat_ID,cat_parent_ID', 'cat_parent_ID='.$Chapter->ID.'&amp;action=new' ) )
					.action_icon( T_('Delete...'), 'delete', regenerate_url( 'action,cat_ID', 'cat_ID='.$Chapter->ID.'&amp;action=delete' ) );
	}
	$r .= '</td>';
	$r .=	'</tr>';

	return $r;
}


/**
 * Generate category line when it has no children
 *
 * @param Chapter generic category we want to display
 * @param int level of the category in the recursive tree
 * @return string HTML
 */
function cat_no_children( $Chapter, $level )
{
	return '';
}


/**
 * Generate code when entering a new level
 *
 * @param int level of the category in the recursive tree
 * @return string HTML
 */
function cat_before_level( $level )
{
	return '';
}

/**
 * Generate code when exiting from a level
 *
 * @param int level of the category in the recursive tree
 * @return string HTML
 */
function cat_after_level( $level )
{
	return '';
}


$callbacks = array(
	'line' 			 	 => 'cat_line',
	'no_children'  => 'cat_no_children',
	'before_level' => 'cat_before_level',
	'after_level'	 => 'cat_after_level'
);

//____________________________________ Display generic categories _____________________________________

$Table = & new Table();

$Table->title = sprintf( T_('Categories for blog: %s'), $Blog->get_maxlen_name( 50 ) );

$Table->global_icon( T_('Create a new category...'), 'new', regenerate_url( 'action,'.$GenericCategoryCache->dbIDname, 'action=new' ), T_('New category').' &raquo;', 3, 4  );

$Table->cols[] = array(
						'th' => T_('ID'),
					);
$Table->cols[] = array(
						'th' => T_('Default'),
						'th_class' => 'shrinkwrap',
					);
$Table->cols[] = array(
						'th' => T_('Name'),
					);
$Table->cols[] = array(
						'th' => T_('URL "slug"'),
					);

if( $Settings->get('chapter_ordering') == 'manual' )
{
	$Table->cols[] = array(
							'th' => T_('Order'),
							'th_class' => 'shrinkwrap',
						);
}

if( $permission_to_edit )
{	// We have permission permission to edit, so display action column:
	$Table->cols[] = array(
							'th' => T_('Actions'),
						);
}

$Table->display_init( NULL, $result_fadeout );

// add an id for jquery to hook into
// TODO: fp> Awfully dirty. This should be handled by the Table object
$Table->params['head_title'] = str_replace( '<table', '<table id="chapter_list"', $Table->params['head_title'] );

$Table->display_list_start();

$Table->display_head();

$Table->display_body_start();

echo $GenericCategoryCache->recurse( $callbacks, $subset_ID );

$Table->display_body_end();

$Table->display_list_end();


/* fp> TODO: maybe... (a general group move of posts would be more useful actually)
echo '<p class="note">'.T_('<strong>Note:</strong> Deleting a category does not delete posts from that category. It will just assign them to the parent category. When deleting a root category, posts will be assigned to the oldest remaining category in the same collection (smallest category number).').'</p>';
*/

global $Settings, $dispatcher;
if( ! $Settings->get('allow_moving_chapters') )
{	// TODO: check perm
	echo '<p class="note">'.sprintf( T_('<strong>Note:</strong> Moving categories across blogs is currently disabled in the %sglobal settings%s.'), '<a href="'.$dispatcher.'?ctrl=features#categories">', '</a>' ).'</p> ';
}

echo '<p class="note">'.sprintf( T_('<strong>Note:</strong> Ordering of categories is currently set to %s in the %sglobal settings%s.'),
	$Settings->get('chapter_ordering') == 'manual' ? /* TRANS: Manual here = "by hand" */ T_('Manual ') : T_('Alphabetical'), '<a href="'.$dispatcher.'?ctrl=features#categories">', '</a>' ).'</p> ';


/*
 * $Log: _chapter_list.view.php,v $
 */
?>