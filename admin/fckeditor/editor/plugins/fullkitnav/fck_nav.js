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
 * File Name: fck_nav.js
 * 	Scripts related to the Nav dialog window (nav.php).
 * 
 * File Authors:
 * 		Laurent Achard C2iS (http://www.c2is.fr)
 */

var oEditor		= window.parent.InnerDialogLoaded() ;
var FCK			= oEditor.FCK ;
var FCKLang		= oEditor.FCKLang ;
var FCKConfig	= oEditor.FCKConfig ;

//#### Initialization Code
// oLink: The actual selected link in the editor.
var oLink = FCK.Selection.MoveToAncestorNode( 'A' ) ;
if ( oLink )
{
	FCK.Selection.SelectNode( oLink ) ;
}

window.onload = function()
{
	// Translate the dialog box texts.
	oEditor.FCKLanguageManager.TranslatePage(document) ;

	// Load the selected link information (if any).
	LoadSelection() ;

	// Activate the "OK" button.
	window.parent.SetOkButton( true ) ;
}

var bHasAnchors ;

function LoadSelection()
{
	if ( !oLink ) return ;

	var sType = 'url' ;

	// Get the actual Link href.
	//var sHRef = oLink.getAttribute('href',2) + '' ;
	//GetE('nav').value = sHRef ;
}



//#### The OK button was hit.
function Ok()
{
	var sUri ;

	sUri = GetE('nav').value ;
	sTarget = GetE('cmbTarget').value;
		
	if ( sUri.length == 0 )
	{
	   alert( FCKLang.DlnLnkMsgNoUrl ) ;
	   return false ;
    }
	
	if ( oLink )	// Modifying an existent link.
	{
		oEditor.FCKUndo.SaveUndoStep() ;
		oLink.href = sUri ;
		oLink.target = sTarget;
	}
	else			// Creating a new link.
	{
		oLink = oEditor.FCK.CreateLink( sUri ) ;
		if ( ! oLink )
			return true ;
	}

	// Target	
	SetAttribute( oLink, 'target', GetE('cmbTarget').value ) ;	
	return true ;
}