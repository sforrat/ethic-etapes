// moock fpi [f.lash p.layer i.nspector]
// version: 1.3.7
// written by colin moock
// code maintained at: http://www.moock.org/webdesign/flash/detection/moockfpi/
// terms of use posted at: http://www.moock.org/terms/

// =============================================================================
// These are the user defined globals.
// Modify the following variables to customize the inspection behaviour.

var requiredVersion = 7;   // Version the user needs to view site (max 9, min 2)
var useRedirect = false;    // Flag indicating whether or not to load a separate
                           // page based on detection results. Set to true to
                           // load a separate page. Set to false to embed the
                           // movie or alternate html directly into this page.
                           
// =============================================================================



// *************
// Everything below this point is internal until after the BODY tag.
// Do not modify! Proceed to the BODY tag for further instructions.
// *************

// System globals
var flash2Installed = false;    // boolean. true if flash 2 is installed
var flash3Installed = false;    // boolean. true if flash 3 is installed
var flash4Installed = false;    // boolean. true if flash 4 is installed
var flash5Installed = false;    // boolean. true if flash 5 is installed
var flash6Installed = false;    // boolean. true if flash 6 is installed
var flash7Installed = false;    // boolean. true if flash 7 is installed
var flash8Installed = false;    // boolean. true if flash 8 is installed
var flash9Installed = false;    // boolean. true if flash 9 is installed
var maxVersion = 9;             // highest version we can actually detect
var actualVersion = 0;          // version the user really has
var hasRightVersion = false;    // boolean. true if it's safe to embed the flash movie in the page
var jsVersion = 1.0;            // the version of javascript supported

// Check the browser...we're looking for ie/win, but not aol
var isIE  = (navigator.appVersion.indexOf("MSIE") != -1) ? true : false;    // true if we're on ie
var isWin = (navigator.appVersion.toLowerCase().indexOf("win") != -1) ? true : false; // true if we're on windows


// This is a js1.1 code block, so make note that js1.1 is supported.
jsVersion = 1.1;

// Write vbscript detection on ie win. IE on Windows doesn't support regular
// JavaScript plugins array detection.
if(isIE && isWin){
  document.write('<SCR' + 'IPT LANGUAGE=VBScript\> \n');
  document.write('on error resume next \n');
  document.write('flash2Installed = (IsObject(CreateObject("ShockwaveFlash.ShockwaveFlash.2"))) \n');
  document.write('flash3Installed = (IsObject(CreateObject("ShockwaveFlash.ShockwaveFlash.3"))) \n');
  document.write('flash4Installed = (IsObject(CreateObject("ShockwaveFlash.ShockwaveFlash.4"))) \n');
  document.write('flash5Installed = (IsObject(CreateObject("ShockwaveFlash.ShockwaveFlash.5"))) \n');  
  document.write('flash6Installed = (IsObject(CreateObject("ShockwaveFlash.ShockwaveFlash.6"))) \n');  
  document.write('flash7Installed = (IsObject(CreateObject("ShockwaveFlash.ShockwaveFlash.7"))) \n');
  document.write('flash8Installed = (IsObject(CreateObject("ShockwaveFlash.ShockwaveFlash.8"))) \n');
  document.write('flash9Installed = (IsObject(CreateObject("ShockwaveFlash.ShockwaveFlash.9"))) \n');
  document.write('<\/SCR' + 'IPT\> \n'); // break up end tag so it doesn't end our script
}

// Next comes the standard javascript detection that uses the 
// navigator.plugins array. We pack the detector into a function so that 
// it preloads before being run.

function detectFlash() {  
  // If navigator.plugins exists...
  if (navigator.plugins) {
    // ...then check for flash 2 or flash 3+.
    if (navigator.plugins["Shockwave Flash 2.0"]
        || navigator.plugins["Shockwave Flash"]) {

      // Some version of Flash was found. Time to figure out which.
      
      // Set convenient references to flash 2 and the plugin description.
      var isVersion2 = navigator.plugins["Shockwave Flash 2.0"] ? " 2.0" : "";
      var flashDescription = navigator.plugins["Shockwave Flash" + isVersion2].description;

      // DEBUGGING: uncomment next line to see the actual description.
      // alert("Flash plugin description: " + flashDescription);
      
      // A flash plugin-description looks like this: Shockwave Flash 4.0 r5
      // We can get the major version by grabbing the character before the period
      // note that we don't bother with minor version detection. 
      // Do that in your movie with $version or getVersion().
      var flashVersion = parseInt(flashDescription.substring(16));

      // We found the version, now set appropriate version flags. Make sure
      // to use >= on the highest version so we don't prevent future version
      // users from entering the site.
      flash2Installed = flashVersion == 2;    
      flash3Installed = flashVersion == 3;
      flash4Installed = flashVersion == 4;
      flash5Installed = flashVersion == 5;
      flash6Installed = flashVersion == 6;
      flash7Installed = flashVersion == 7;
      flash8Installed = flashVersion == 8;
      flash9Installed = flashVersion >= 9;
    }
  }
  
  // Loop through all versions we're checking, and
  // set actualVersion to highest detected version.
  for (var i = 2; i <= maxVersion; i++) {  
    if (eval("flash" + i + "Installed") == true) actualVersion = i;
  }
  
  // If we're on msntv (formerly webtv), the version supported is 4 (as of
  // January 1, 2004). Note that we don't bother sniffing varieties
  // of msntv. You could if you were sadistic...
  if(navigator.userAgent.indexOf("WebTV") != -1) actualVersion = 4;  

  // If the user has a new enough version...
  if (actualVersion >= requiredVersion) {
    hasRightVersion = true;                
  }
}

detectFlash();  // call our detector now that it's safely loaded. 

//Cette fonction genere le code du bandeau en flash ou en gif

function bandeauFlash(cible, urlFlash, larg, haut) {
  if(hasRightVersion) {  // if we've detected an acceptable version
    var oeTags = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" width="'+larg+'" height="'+haut+'">'
           +' <param name=movie value="'+urlFlash+'">'
           +' <param name=quality value=high/>'
           +' <embed src="'+urlFlash+'" quality=high pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="'+larg+'" height="'+haut+'">'
           +' </embed>'
         +'</object>'
	cible = document.getElementById(cible);
	cible.innerHTML=oeTags;
  } 
}
