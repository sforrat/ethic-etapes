<?php
/**
 * This is the install file for the core modules
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
 * }}
 *
 * @package evocore
 *
 * {@internal Below is a list of authors who have contributed to design/coding of this file: }}
 * @author fplanque: Francois PLANQUE.
 *
 * @version $Id: _sessions.install.php,v 1.11.2.1 2009/07/12 23:23:16 fplanque Exp $
 */
if( !defined('EVO_CONFIG_LOADED') ) die( 'Please, do not access this page directly.' );


global $db_storage_charset;


/**
 * The b2evo database scheme.
 *
 * This gets updated through {@link db_delta()} which generates the queries needed to get
 * to this scheme.
 *
 * Please see {@link db_delta()} for things to take care of.
 */
$schema_queries['T_sessions'] = array(
		'Creating table for active sessions',
		"CREATE TABLE T_sessions (
			sess_ID        INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
			sess_key       CHAR(32) NULL,
			sess_hitcount  INT(10) UNSIGNED NOT NULL DEFAULT 1,
			sess_lastseen  DATETIME NOT NULL DEFAULT '2000-01-01 00:00:00',
			sess_ipaddress VARCHAR(15) NOT NULL DEFAULT '',
			sess_user_ID   INT(10) DEFAULT NULL,
			sess_data      MEDIUMBLOB DEFAULT NULL,
			PRIMARY KEY      ( sess_ID ),
		  KEY sess_user_ID (sess_user_ID)
		) ENGINE = myisam DEFAULT CHARACTER SET = $db_storage_charset" );
		// NOTE: sess_lastseen is only relevant/used by Sessions class (+ stats) and results in a quite large index (file size wise)
		// NOTE: sess_data is (MEDIUM)BLOB because e.g. serialize() does not completely convert binary data to text

$schema_queries['T_basedomains'] = array(
		'Creating table for base domains',
		"CREATE TABLE T_basedomains (
			dom_ID     INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
			dom_name   VARCHAR(250) NOT NULL DEFAULT '',
			dom_status ENUM('unknown','whitelist','blacklist') NOT NULL DEFAULT 'unknown',
			dom_type   ENUM('unknown','normal','searcheng','aggregator') NOT NULL DEFAULT 'unknown',
			PRIMARY KEY     (dom_ID),
			UNIQUE dom_name (dom_name),
			INDEX dom_type  (dom_type)
		) ENGINE = myisam DEFAULT CHARACTER SET = $db_storage_charset" );

// fp> TODO: this table is crap. It has to go.
$schema_queries['T_useragents'] = array(
		'Creating table for user agents',
		"CREATE TABLE T_useragents (
			agnt_ID        INT UNSIGNED NOT NULL AUTO_INCREMENT,
			agnt_signature VARCHAR(250) NOT NULL,
			agnt_type      ENUM('rss','robot','browser','unknown') DEFAULT 'unknown' NOT NULL ,
			PRIMARY KEY (agnt_ID),
			INDEX agnt_type ( agnt_type )
		) ENGINE = myisam DEFAULT CHARACTER SET = $db_storage_charset" );

$schema_queries['T_track__keyphrase'] = array(
		'Creating table for Hit-Logs',
		"CREATE TABLE T_track__keyphrase (
			keyp_ID      INT UNSIGNED NOT NULL AUTO_INCREMENT,
			keyp_phrase  VARCHAR( 255 ) NOT NULL,
			PRIMARY KEY        ( keyp_ID ),
			UNIQUE keyp_phrase ( keyp_phrase )
		) ENGINE = myisam DEFAULT CHARACTER SET = $db_storage_charset" );


$schema_queries['T_hitlog'] = array(
		'Creating table for Hit-Logs',
		"CREATE TABLE T_hitlog (
			hit_ID                INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
			hit_sess_ID           INT UNSIGNED,
			hit_datetime          DATETIME NOT NULL DEFAULT '2000-01-01 00:00:00',
			hit_uri               VARCHAR(250) DEFAULT NULL,
			hit_referer_type      ENUM('search','blacklist','spam','referer','direct','self','admin') NOT NULL,
			hit_referer           VARCHAR(250) DEFAULT NULL,
			hit_referer_dom_ID    INT UNSIGNED DEFAULT NULL,
			hit_keyphrase_keyp_ID INT UNSIGNED DEFAULT NULL,
			hit_serprank					INT UNSIGNED DEFAULT NULL,
			hit_blog_ID           int(11) UNSIGNED NULL DEFAULT NULL,
			hit_remote_addr       VARCHAR(40) DEFAULT NULL,
			hit_agnt_ID           INT UNSIGNED NULL,
			PRIMARY KEY              (hit_ID),
			INDEX hit_agnt_ID        ( hit_agnt_ID ),
			INDEX hit_blog_ID        ( hit_blog_ID ),
			INDEX hit_uri            ( hit_uri ),
			INDEX hit_referer_dom_ID ( hit_referer_dom_ID ),
			INDEX hit_remote_addr    ( hit_remote_addr ),
			INDEX hit_sess_ID        ( hit_sess_ID )
		) ENGINE = myisam DEFAULT CHARACTER SET = $db_storage_charset" );
		// Note: hit_remote_addr is used for goal matching stats
		// fp> needed? 			INDEX hit_keyphrase_keyp_ID( hit_keyphrase_keyp_ID ),
		// dh> There appear too many indexes here, which makes inserting hits rather
		//     slow! If the indexes need to stay, would it be possible to queue
		//     the hit logs and let them get handled by cron?!
		//     Well, converting the table to MyISAM (from InnoDB) helped a lot..
		// fp> Yes we do have a chronic problem with the hitlogging
		//     The best solution would indeed be to write to a non indexed MyISAM table
		//     and then to consolidate the data once per day/hour (not sure) to tables that will be used for viewing stats
		//     ALSO ideally we would not keep all the hit data but only CONSOLIDATED data
		//     needed for reports, e-g: this date = this many hits of type browser/robot/rss etc but not necessarilly the detail
		//     MAYBE a 2 step process would make sense?
		//      1) write to MyISAM and cron every x minutes to replicate to indexed table
		//      2) consolidate once a day

$schema_queries['T_track__goal'] = array(
		'Creating goals table',
		"CREATE TABLE T_track__goal(
		  goal_ID int(10) unsigned NOT NULL auto_increment,
		  goal_name varchar(50) default NULL,
		  goal_key varchar(32) default NULL,
		  goal_redir_url varchar(255) default NULL,
		  goal_default_value double default NULL,
		  PRIMARY KEY (goal_ID),
		  UNIQUE KEY goal_key (goal_key)
		) ENGINE = myisam DEFAULT CHARACTER SET = $db_storage_charset" );

$schema_queries['T_track__goalhit'] = array(
		'Creating goal hits table',
		"CREATE TABLE T_track__goalhit (
		  ghit_ID int(10) unsigned NOT NULL auto_increment,
		  ghit_goal_ID    int(10) unsigned NOT NULL,
		  ghit_hit_ID     int(10) unsigned NOT NULL,
		  ghit_params     TEXT default NULL,
		  PRIMARY KEY  (ghit_ID),
		  KEY ghit_goal_ID (ghit_goal_ID),
		  KEY ghit_hit_ID (ghit_hit_ID)
   ) ENGINE = myisam DEFAULT CHARACTER SET = $db_storage_charset" );


/*
 * $Log: _sessions.install.php,v $
 */
?>