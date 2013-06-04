/*
 * FCKeditor - The text editor for internet
 * Copyright (C) 2003-2005 Frederico Caldeira Knabben
 * 
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 * 
 * For further information visit:
 * 		http://www.fckeditor.net/
 * 
 * File Name: fckplugin.js
 * 	This plugin register the required Toolbar items to be able to insert the
 * 	toolbar commands in the toolbar.
 * 
 * File Authors:
 * 		Laurent Achard C2iS (http://www.c2is.fr)
 */

// Register the related command.
FCKCommands.RegisterCommand( 'Nav', new FCKDialogCommand( 'Nav', FCKLang.NavDlgTitle, FCKPlugins.Items['fullkitnav'].Path + 'nav.php', 700, 200 ) ) ;

// Create the "Nav" toolbar button.
var oNavItem = new FCKToolbarButton( 'Nav', FCKLang.NavBtn ) ;
oNavItem.IconPath = FCKPlugins.Items['fullkitnav'].Path + 'arbo.gif' ;
FCKToolbarItems.RegisterItem( 'Nav', oNavItem ) ;
