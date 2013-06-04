<?php
/**
 * This file implements the xyz Widget class.
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
 * @package evocore
 *
 * {@internal Below is a list of authors who have contributed to design/coding of this file: }}
 * @author fplanque: Francois PLANQUE.
 *
 * @version $Id: _menu_link.widget.php,v 1.14 2009/07/02 00:50:59 fplanque Exp $
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

load_class( 'widgets/model/_widget.class.php' );

global $menu_link_widget_link_types;
$menu_link_widget_link_types = array(
		'home' => T_('Blog home'),
		'arcdir' => T_('Archive directory'),
		'catdir' => T_('Category directory'),
		'latestcomments' => T_('Latest comments'),
		'ownercontact' => T_('Blog owner contact form'),
		'login' => T_('Log in form')
	);

/**
 * ComponentWidget Class
 *
 * A ComponentWidget is a displayable entity that can be placed into a Container on a web page.
 *
 * @package evocore
 */
class menu_link_Widget extends ComponentWidget
{
	/**
	 * Constructor
	 */
	function menu_link_Widget( $db_row = NULL )
	{
		// Call parent constructor:
		parent::ComponentWidget( $db_row, 'core', 'menu_link' );
	}


	/**
	 * Get name of widget
	 */
	function get_name()
	{
		return T_('Menu link');
	}


	/**
	 * Get a very short desc. Used in the widget list.
	 */
	function get_short_desc()
	{
		global $menu_link_widget_link_types;

		$this->load_param_array();

		if( !empty($this->param_array['link_type']) )
		{
			// TRANS: %s is the link type, e. g. "Blog home" or "Log in form"
			return sprintf( T_( '%s link' ), $menu_link_widget_link_types[$this->param_array['link_type']] );
		}
		else
		{
			return $this->get_name();
		}
	}



  /**
	 * Get short description
	 */
	function get_desc()
	{
		return T_('Display a configurable menu entry/link');
	}


  /**
   * Get definitions for editable params
   *
	 * @see Plugin::GetDefaultSettings()
	 * @param local params like 'for_editing' => true
	 */
	function get_param_definitions( $params )
	{
		global $menu_link_widget_link_types;

		$r = array_merge( array(
				'link_type' => array(
					'label' => T_( 'Link Type' ),
					'note' => T_('What do you want to link to?'),
					'type' => 'select',
					'options' => $menu_link_widget_link_types,
					'defaultvalue' => 'home',
				),
			), parent::get_param_definitions( $params )	);

		return $r;
	}


	/**
	 * Display the widget!
	 *
	 * @param array MUST contain at least the basic display params
	 */
	function display( $params )
	{
		global $Blog;

		$this->init_display( $params );

		switch(	$this->disp_params['link_type'] )
		{
			case 'arcdir':
				$url = $Blog->get('arcdirurl');
				$text = T_('Archives');
				break;

			case 'catdir':
				$url = $Blog->get('catdirurl');
				$text = T_('Categories');
				break;

			case 'latestcomments':
				$url = $Blog->get('lastcommentsurl');
				$text = T_('Latest comments');
				break;

			case 'ownercontact':
				$Blog->get_owner_User();
				// fp> TODO: move this test into $Blog->get_contact_url( true ); 
				if( ! $Blog->owner_User->allow_msgform )
				{ // user does not allow contact form
					return;
				}
				$url = $Blog->get_contact_url( true );
				$text = T_('Contact');
				break;

			case 'login':
				if( is_logged_in() ) return false;
				$url = get_login_url();
				$text = T_('Log in');
				break;

			case 'home':
			default:
				$url = $Blog->get('url');
				$text = T_('Home');
		}

		echo $this->disp_params['block_start'];
		echo $this->disp_params['list_start'];

		echo $this->disp_params['item_start'];
		echo '<a href="'.$url.'">'.$text.'</a>';
		echo $this->disp_params['item_end'];

		echo $this->disp_params['list_end'];
		echo $this->disp_params['block_end'];

		return true;
	}
}


/*
 * $Log: _menu_link.widget.php,v $
 */
?>