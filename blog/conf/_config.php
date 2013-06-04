<?php
/**
 * This is b2evolution's main config file, which just includes all the other
 * config files.
 *
 * This file should not be edited. You should edit the sub files instead.
 *
 * See {@link _basic_config.php} for the basic settings.
 *
 * @package conf
 */

if( defined('EVO_CONFIG_LOADED') )
{
	return;
}

/**
 * This makes sure the config does not get loaded twice in Windows
 * (when the /conf file is in a path containing uppercase letters as in /Blog/conf).
 */
define( 'EVO_CONFIG_LOADED', true );

// basic settings
if( file_exists(dirname(__FILE__).'/_basic_config.php') )
{	// Use configured base config:
	require_once  dirname(__FILE__).'/_basic_config.php';
}
else
{	// Use default template:
	require_once  dirname(__FILE__).'/_basic_config.template.php';
}

// DEPRECATED -- You can now have a _basic_config.php file that will not be overwritten by new releases
if( file_exists(dirname(__FILE__).'/_config_TEST.php') )
{ // Put testing conf in there (For testing, you can also set $install_password here):
	include_once dirname(__FILE__).'/_config_TEST.php';   	// FOR TESTING / DEVELOPMENT OVERRIDES
}

require_once  dirname(__FILE__).'/_advanced.php';       	// advanced settings
require_once  dirname(__FILE__).'/_locales.php';        	// locale settings
require_once  dirname(__FILE__).'/_formatting.php';     	// formatting settings
require_once  dirname(__FILE__).'/_admin.php';          	// admin settings
require_once  dirname(__FILE__).'/_stats.php';          	// stats/hitlogging settings
require_once  dirname(__FILE__).'/_application.php';    	// application settings
if( file_exists(dirname(__FILE__).'/_overrides_TEST.php') )
{ // Override for testing in there:
	include_once dirname(__FILE__).'/_overrides_TEST.php';	// FOR TESTING / DEVELOPMENT OVERRIDES
}

// Load modules:
foreach( $modules as $module )
{
	require_once $inc_path.$module.'/_'.$module.'.init.php';
}

/*
 * $Log: _config.php,v $
 */
?>