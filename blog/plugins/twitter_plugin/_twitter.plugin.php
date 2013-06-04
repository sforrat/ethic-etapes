<?php
/**
 * This file implements the Twitter plugin.
 *
 * For the most recent and complete Plugin API documentation
 * see {@link Plugin} in ../evocore/_plugin.class.php.
 *
 * This file is part of the b2evolution project - {@link http://b2evolution.net/}
 *
 * @copyright (c)2009 by Francois PLANQUE - {@link http://fplanque.net/}
 * @copyright (c)2007 by Lee Turner - {@link http://leeturner.org/}.
 *
 * @license GNU General Public License 2 (GPL) - http://www.opensource.org/licenses/gpl-license.php
 *
 * @package plugins
 *
 * @author Lee Turner
 * @author fplanque: Francois PLANQUE.
 *
 * @version $Id: _twitter.plugin.php,v 1.15 2009/06/29 02:14:04 fplanque Exp $
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );


/**
 * Twitter Plugin
 *
 * This plugin will post to your twitter account when you have added a post to your blog.
 *
 * @todo use OAuth -- http://www.jaisenmathai.com/blog/2009/03/31/how-to-quickly-integrate-with-twitters-oauth-api-using-php/
 * @todo Tblue> Do not use cURL, or at least do not depend on it! We could
 *              clone/modify {@link fetch_remote_page()} to be able to do
 *              HTTP POST requests.
 */
class twitter_plugin extends Plugin
{
	/**
	 * Variables below MUST be overriden by plugin implementations,
	 * either in the subclass declaration or in the subclass constructor.
	 */
	var $code = 'evo_twitter';
	var $priority = 50;
	var $version = '3.2';
	var $author = 'Lee Turner';
	var $help_url = 'http://leeturner.org/twitterlution.php';

	/*
	 * These variables MAY be overriden.
	 */
	var $apply_rendering = 'never';
	var $group = 'ping';
	var $number_of_installs = 1;


	/**
	 * Init
	 *
	 * This gets called after a plugin has been registered/instantiated.
	 */
	function PluginInit( & $params )
	{
		$this->name = T_('Twitter plugin');
		$this->short_desc = $this->T_('Post to your Twitter account when you post to your blog');
		$this->long_desc = $this->T_('Posts to your Twitter account to update Twitter.com with details of your blog post.');

		$this->ping_service_name = 'twitter.com';
		$this->ping_service_note = $this->T_('Update your twitter account with details about the new post.');
	}


	/**
	 * We require b2evo 3.2.0 or above.
	 */
	function GetDependencies()
	{
		return array(
				'requires' => array(
					'app_min' => '3.2.0-beta',
				),
			);
	}


	/**
	 * Check if the plugin can be enabled:
	 *
	 * @return string|NULL
	 */
	function BeforeEnable()
	{

		if( empty($this->code) )
		{
			return T_('The twitter plugin needs a non-empty code.');
		}

		// OK:
		return true;
	}


	/**
	 * Post to Twitter.
	 *
	 * @return boolean Was the ping successful?
	 */
	function ItemSendPing( & $params )
	{
    /**
		 * @var Blog
		 */
		$item_Blog = $params['Item']->get_Blog();

		// Try to get twitter account for Blog:
		$username = $this->get_coll_setting( 'twitter_username', $item_Blog );
		$password = $this->get_coll_setting( 'twitter_password', $item_Blog );
		if( empty($username) || empty($password) )
		{ // Not found, fallback to Trying to get twitter account for User:
			$username = $this->UserSettings->get( 'twitter_username' );
			$password = $this->UserSettings->get( 'twitter_password' );
			if( empty($username) || empty($password) )
			{	// Still no twitter account found:
				$params['xmlrpcresp'] = T_('You must configure a twitter username/password before you can post to twitter.');
				return false;
			}
			else
				{	// Get additional params from User Setttings:
				$msg = $this->UserSettings->get( 'twitter_msg_format' );
			}
		}
		else
		{	// Get additional params from Blog Setttings:
			$msg = $this->get_coll_setting( 'twitter_msg_format', $item_Blog );
		}

		$title =  $params['Item']->dget('title', 'xml');
		$excerpt =  $params['Item']->dget('excerpt', 'xml');
		$url = $params['Item']->get_permanent_url();

		$msg = str_replace( '$title$', $title, $msg );
		$msg = str_replace( '$excerpt$', $excerpt, $msg );
		$msg = str_replace( '$url$', $url, $msg );

		if( extension_loaded( 'curl' ) )
		{ // CURL available
			$session = curl_init();
			curl_setopt( $session, CURLOPT_URL, 'http://twitter.com/statuses/update.xml' );
			curl_setopt( $session, CURLOPT_POSTFIELDS, 'status='.urlencode($msg));
			curl_setopt( $session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
			curl_setopt( $session, CURLOPT_HEADER, false );
			curl_setopt( $session, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt( $session, CURLOPT_USERPWD, $username.':'.$password );
			curl_setopt( $session, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $session, CURLOPT_POST, 1);
			$result = curl_exec ( $session ); // will be an XML message
			curl_close( $session );
		}
		else
		{ // fallback to fsockopen
			$host = 'twitter.com';
			$url = '/statuses/update.xml?status='.urlencode( $msg );
			// Build the header
			$header  = 'POST '.$url.' HTTP/1.0'."\r\n";
			$header .= 'Host: '.$host."\r\n";
			$header .= 'Authorization: Basic '.base64_encode( $username.':'.$password )."\r\n";
			$header .= 'Connection: Close'."\r\n\r\n";
			if( $fp = fsockopen($host, 80) )
			{
				fputs($fp, $header );
				$result = '';
				while( !feof( $fp ) )
				{
					$result .= fgets( $fp, 1024 );
				}
				fclose($fp);
			}
			else
			{ // unable to tweet
				$params['xmlrpcresp'] = T_('No ping method available, please contact your host about using CURL or fsockopen');
			}
		}

		if( empty($result) )
		{
			return false;
		}
		elseif( preg_match( '¤<error>(.*)</error>¤', $result, $matches ) )
		{
			$params['xmlrpcresp'] = $matches[1];
			return false;
		}

		$params['xmlrpcresp'] = T_('Posted to account: @').$username;
		return true;
	}

	/**
	 * Allowing the user to specify their twitter account name and password.
	 *
	 * @return array See {@link Plugin::GetDefaultSettings()}.
	 */
	function GetDefaultUserSettings( & $params )
	{
		return array(
				'twitter_username' => array(
					'label' => T_( 'Twitter username' ),
					'type' => 'text',
				),
				'twitter_password' => array(
					'label' => T_( 'Twitter password' ),
					'type' => 'password',
				),
				'twitter_msg_format' => array(
					'label' => T_( 'Message format' ),
					'type' => 'text',
					'size' => 30,
					'maxlength' => 140,
					'defaultvalue' => T_( 'Just posted $title$ $url$ #b2p' ),
					'note' => T_('$title$, $excerpt$ and $url$ will be replaced appropriately.'),
				),
			);
	}


	/**
	 * Define here default collection/blog settings that are to be made available in the backoffice.
	 *
	 * @todo: ideally we'd want a warning if the twitter ping is not enabled
	 *
	 * @return array See {@link Plugin::GetDefaultSettings()}.
	 */
	function get_coll_setting_definitions( & $params )
	{
		return array(
				'twitter_username' => array(
					'label' => T_( 'Twitter username' ),
					'type' => 'text',
				),
				'twitter_password' => array(
					'label' => T_( 'Twitter password' ),
					'type' => 'password',
				),
				'twitter_msg_format' => array(
					'label' => T_( 'Message format' ),
					'type' => 'text',
					'size' => 30,
					'maxlength' => 140,
					'defaultvalue' => T_( 'Just posted $title$ $url$ #b2p' ),
					'note' => T_('$title$, $excerpt$ and $url$ will be replaced appropriately.'),
				),
			);
	}

}

/*
 * $Log: _twitter.plugin.php,v $
 */
?>