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
 * @version $Id: __core.install.php,v 1.24.2.4 2009/09/29 13:56:07 tblue246 Exp $
 */
if( !defined('EVO_CONFIG_LOADED') ) die( 'Please, do not access this page directly.' );


global $db_storage_charset;
// fp> TODO: upgrade procedure should check for proper charset. (and for ENGINE too)
// fp> TODO: we should actually use a DEFAULT COLLATE, maybe have a DD::php_to_mysql_collate( $php_charset ) -> returning a Mysql collation


/**
 * The b2evo database scheme.
 *
 * This gets updated through {@link db_delta()} which generates the queries needed to get
 * to this scheme.
 *
 * Please see {@link db_delta()} for things to take care of.
 */
$schema_queries = array(
	'T_groups' => array(
		'Creating table for Groups',
		"CREATE TABLE T_groups (
			grp_ID int(11) NOT NULL auto_increment,
			grp_name varchar(50) NOT NULL default '',
			grp_perm_admin enum('none','hidden','visible') NOT NULL default 'visible',
			grp_perm_blogs enum('user','viewall','editall') NOT NULL default 'user',
			grp_perm_bypass_antispam         TINYINT(1) NOT NULL DEFAULT 0,
			grp_perm_xhtmlvalidation         VARCHAR(10) NOT NULL default 'always',
			grp_perm_xhtmlvalidation_xmlrpc  VARCHAR(10) NOT NULL default 'always',
			grp_perm_xhtml_css_tweaks        TINYINT(1) NOT NULL DEFAULT 0,
			grp_perm_xhtml_iframes           TINYINT(1) NOT NULL DEFAULT 0,
			grp_perm_xhtml_javascript        TINYINT(1) NOT NULL DEFAULT 0,
			grp_perm_xhtml_objects           TINYINT(1) NOT NULL DEFAULT 0,
			grp_perm_stats enum('none','user','view','edit') NOT NULL default 'none',
			grp_perm_spamblacklist enum('none','view','edit') NOT NULL default 'none',
			grp_perm_options enum('none','view','edit') NOT NULL default 'none',
			grp_perm_users enum('none','view','edit') NOT NULL default 'none',
			grp_perm_templates TINYINT NOT NULL DEFAULT 0,
			grp_perm_files enum('none','view','add','edit','all') NOT NULL default 'none',
			PRIMARY KEY grp_ID (grp_ID)
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_settings' => array(
		'Creating table for Settings',
		"CREATE TABLE T_settings (
			set_name VARCHAR( 30 ) NOT NULL ,
			set_value VARCHAR( 255 ) NULL ,
			PRIMARY KEY ( set_name )
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_global__cache' => array(
		'Creating table for Caches',
		"CREATE TABLE T_global__cache (
			cach_name VARCHAR( 30 ) NOT NULL ,
			cach_cache MEDIUMBLOB NULL ,
			PRIMARY KEY ( cach_name )
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_users' => array(
		'Creating table for Users',
		"CREATE TABLE T_users (
			user_ID int(11) unsigned NOT NULL auto_increment,
			user_login varchar(20) NOT NULL,
			user_pass CHAR(32) NOT NULL,
			user_firstname varchar(50) NULL,
			user_lastname varchar(50) NULL,
			user_nickname varchar(50) NULL,
			user_icq int(11) unsigned NULL,
			user_email varchar(255) NOT NULL,
			user_url varchar(255) NULL,
			user_ip varchar(15) NULL,
			user_domain varchar(200) NULL,
			user_browser varchar(200) NULL,
			dateYMDhour datetime NOT NULL DEFAULT '2000-01-01 00:00:00',
			user_level int unsigned DEFAULT 0 NOT NULL,
			user_aim varchar(50) NULL,
			user_msn varchar(100) NULL,
			user_yim varchar(50) NULL,
			user_locale varchar(20) DEFAULT 'en-EU' NOT NULL,
			user_idmode varchar(20) NOT NULL DEFAULT 'login',
			user_allow_msgform TINYINT NOT NULL DEFAULT '1',
			user_notify tinyint(1) NOT NULL default 1,
			user_showonline tinyint(1) NOT NULL default 1,
			user_grp_ID int(4) NOT NULL default 1,
			user_validated tinyint(1) NOT NULL DEFAULT 0,
			user_avatar_file_ID int(10) unsigned default NULL,
			PRIMARY KEY user_ID (user_ID),
			UNIQUE user_login (user_login),
			KEY user_grp_ID (user_grp_ID)
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_users__fielddefs' => array(
		'Creating table for User field definitions',
		"CREATE TABLE T_users__fielddefs (
			ufdf_ID int(10) unsigned NOT NULL,
			ufdf_type char(8) NOT NULL,
			ufdf_name varchar(255) NOT NULL,
			PRIMARY KEY (ufdf_ID)
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_users__fields' => array(
		'Creating table for User fields',
		"CREATE TABLE T_users__fields (
		  uf_ID      int(10) unsigned NOT NULL auto_increment,
		  uf_user_ID int(10) unsigned NOT NULL,
		  uf_ufdf_ID int(10) unsigned NOT NULL,
		  uf_varchar varchar(255) NOT NULL,
		  PRIMARY KEY (uf_ID)
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_skins__skin' => array(
		'Creating table for installed skins',
		"CREATE TABLE T_skins__skin (
				skin_ID      int(10) unsigned      NOT NULL auto_increment,
				skin_name    varchar(32)           NOT NULL,
				skin_type    enum('normal','feed') NOT NULL default 'normal',
				skin_folder  varchar(32)           NOT NULL,
				PRIMARY KEY skin_ID (skin_ID),
				UNIQUE skin_folder( skin_folder ),
				KEY skin_name( skin_name )
			) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_skins__container' => array(
		'Creating table for skin containers',
		"CREATE TABLE T_skins__container (
				sco_skin_ID   int(10) unsigned      NOT NULL,
				sco_name      varchar(40)           NOT NULL,
				PRIMARY KEY (sco_skin_ID, sco_name)
			) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_blogs' => array(
		'Creating table for Blogs',
		"CREATE TABLE T_blogs (
			blog_ID              int(11) unsigned NOT NULL auto_increment,
			blog_shortname       varchar(255) NULL default '',
			blog_name            varchar(255) NOT NULL default '',
			blog_owner_user_ID   int(11) unsigned NOT NULL default 1,
			blog_advanced_perms  TINYINT(1) NOT NULL default 0,
			blog_tagline         varchar(250) NULL default '',
			blog_description     varchar(250) NULL default '',
			blog_longdesc        TEXT NULL DEFAULT NULL,
			blog_locale          VARCHAR(20) NOT NULL DEFAULT 'en-EU',
			blog_access_type     VARCHAR(10) NOT NULL DEFAULT 'index.php',
			blog_siteurl         varchar(120) NOT NULL default '',
			blog_urlname         VARCHAR(255) NOT NULL DEFAULT 'urlname',
			blog_notes           TEXT NULL,
			blog_keywords        tinytext,
			blog_allowcomments   VARCHAR(20) NOT NULL default 'post_by_post',
			blog_allowtrackbacks TINYINT(1) NOT NULL default 0,
			blog_allowblogcss    TINYINT(1) NOT NULL default 1,
			blog_allowusercss    TINYINT(1) NOT NULL default 1,
			blog_skin_ID         INT(10) UNSIGNED NOT NULL DEFAULT 1,
			blog_in_bloglist     TINYINT(1) NOT NULL DEFAULT 1,
			blog_links_blog_ID   INT(11) NULL DEFAULT NULL,
			blog_media_location  ENUM( 'default', 'subdir', 'custom', 'none' ) DEFAULT 'default' NOT NULL,
			blog_media_subdir    VARCHAR( 255 ) NULL,
			blog_media_fullpath  VARCHAR( 255 ) NULL,
			blog_media_url       VARCHAR( 255 ) NULL,
			blog_UID             VARCHAR(20),
			PRIMARY KEY blog_ID (blog_ID),
			UNIQUE KEY blog_urlname (blog_urlname)
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_coll_settings' => array(
		'Creating collection settings table',
		"CREATE TABLE T_coll_settings (
			cset_coll_ID INT(11) UNSIGNED NOT NULL,
			cset_name    VARCHAR( 30 ) NOT NULL,
			cset_value   VARCHAR( 255 ) NULL,
			PRIMARY KEY ( cset_coll_ID, cset_name )
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_widget' => array(
		'Creating components table',
		"CREATE TABLE T_widget (
			wi_ID					INT(10) UNSIGNED auto_increment,
			wi_coll_ID    INT(11) UNSIGNED NOT NULL,
			wi_sco_name   VARCHAR( 40 ) NOT NULL,
			wi_order      INT(10) NOT NULL,
			wi_enabled    TINYINT(1) NOT NULL DEFAULT 1,
			wi_type       ENUM( 'core', 'plugin' ) NOT NULL DEFAULT 'core',
			wi_code       VARCHAR(32) NOT NULL,
			wi_params     TEXT NULL,
			PRIMARY KEY ( wi_ID ),
			UNIQUE wi_order( wi_coll_ID, wi_sco_name, wi_order )
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_categories' => array(
		'Creating table for Categories',
		"CREATE TABLE T_categories (
			cat_ID          int(10) unsigned NOT NULL auto_increment,
			cat_parent_ID   int(10) unsigned NULL,
			cat_name        varchar(255) NOT NULL,
			cat_urlname     varchar(255) NOT NULL,
			cat_blog_ID     int(10) unsigned NOT NULL default 2,
			cat_description varchar(255) NULL DEFAULT NULL,
			cat_order       int(11) NULL DEFAULT NULL,
			PRIMARY KEY cat_ID (cat_ID),
			UNIQUE cat_urlname( cat_urlname ),
			KEY cat_blog_ID (cat_blog_ID),
			KEY cat_parent_ID (cat_parent_ID),
			KEY cat_order (cat_order)
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_items__item' => array(
		'Creating table for Posts',
		"CREATE TABLE T_items__item (
			post_ID                     int(11) unsigned NOT NULL auto_increment,
			post_parent_ID              int(11) unsigned NULL,
			post_creator_user_ID        int(11) unsigned NOT NULL,
			post_lastedit_user_ID       int(11) unsigned NULL,
			post_assigned_user_ID       int(11) unsigned NULL,
			post_datestart              DATETIME NOT NULL DEFAULT '2000-01-01 00:00:00',
			post_datedeadline           datetime NULL,
			post_datecreated            datetime NULL,
			post_datemodified           DATETIME NOT NULL DEFAULT '2000-01-01 00:00:00',
			post_status                 enum('published','deprecated','protected','private','draft','redirected') NOT NULL default 'published',
			post_pst_ID                 int(11) unsigned NULL,
			post_ptyp_ID                int(10) unsigned NOT NULL DEFAULT 1,
			post_locale                 VARCHAR(20) NOT NULL DEFAULT 'en-EU',
			post_content                MEDIUMTEXT NULL,
			post_excerpt                text NULL,
			post_title                  text NOT NULL,
			post_urltitle               VARCHAR(210) NULL DEFAULT NULL,
			post_titletag               VARCHAR(255) NULL DEFAULT NULL,
			post_metadesc               VARCHAR(255) NULL DEFAULT NULL,
			post_metakeywords           VARCHAR(255) NULL DEFAULT NULL,
			post_url                    VARCHAR(255) NULL DEFAULT NULL,
			post_main_cat_ID            int(11) unsigned NOT NULL,
			post_notifications_status   ENUM('noreq','todo','started','finished') NOT NULL DEFAULT 'noreq',
			post_notifications_ctsk_ID  INT(10) unsigned NULL DEFAULT NULL,
			post_views                  INT(11) UNSIGNED NOT NULL DEFAULT 0,
			post_wordcount              int(11) default NULL,
			post_comment_status         ENUM('disabled', 'open', 'closed') NOT NULL DEFAULT 'open',
			post_commentsexpire         DATETIME DEFAULT NULL,
			post_renderers              TEXT NOT NULL,
			post_priority               int(11) unsigned null COMMENT 'Task priority in workflow',
			post_featured               tinyint(1) NOT NULL DEFAULT 0,
			post_order                  DOUBLE NULL,
			post_double1                DOUBLE NULL COMMENT 'Custom double value 1',
			post_double2                DOUBLE NULL COMMENT 'Custom double value 2',
			post_double3                DOUBLE NULL COMMENT 'Custom double value 3',
			post_double4                DOUBLE NULL COMMENT 'Custom double value 4',
			post_double5                DOUBLE NULL COMMENT 'Custom double value 5',
			post_varchar1               VARCHAR(255) NULL COMMENT 'Custom varchar value 1',
			post_varchar2               VARCHAR(255) NULL COMMENT 'Custom varchar value 2',
			post_varchar3               VARCHAR(255) NULL COMMENT 'Custom varchar value 3',
			post_editor_code						VARCHAR(32) NULL COMMENT 'Plugin code of the editor used to edit this post',
			PRIMARY KEY post_ID( post_ID ),
			UNIQUE post_urltitle( post_urltitle ),
			INDEX post_datestart( post_datestart ),
			INDEX post_main_cat_ID( post_main_cat_ID ),
			INDEX post_creator_user_ID( post_creator_user_ID ),
			INDEX post_status( post_status ),
			INDEX post_parent_ID( post_parent_ID ),
			INDEX post_assigned_user_ID( post_assigned_user_ID ),
			INDEX post_ptyp_ID( post_ptyp_ID ),
			INDEX post_pst_ID( post_pst_ID ),
			INDEX post_order( post_order )
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_postcats' => array(
		'Creating table for Categories-to-Posts relationships',
		"CREATE TABLE T_postcats (
			postcat_post_ID int(11) unsigned NOT NULL,
			postcat_cat_ID int(11) unsigned NOT NULL,
			PRIMARY KEY postcat_pk (postcat_post_ID,postcat_cat_ID),
			UNIQUE catpost ( postcat_cat_ID, postcat_post_ID )
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_comments' => array(	// Note: pingbacks no longer supported, but previous pingbacks are to be preserved in the DB
		'Creating table for Comments',
		"CREATE TABLE T_comments (
			comment_ID            int(11) unsigned NOT NULL auto_increment,
			comment_post_ID       int(11) unsigned NOT NULL default '0',
			comment_type          enum('comment','linkback','trackback','pingback') NOT NULL default 'comment',
			comment_status        ENUM('published','deprecated','protected','private','draft','redirected') DEFAULT 'published' NOT NULL,
			comment_author_ID     int unsigned NULL default NULL,
			comment_author        varchar(100) NULL,
			comment_author_email  varchar(255) NULL,
			comment_author_url    varchar(255) NULL,
			comment_author_IP     varchar(23) NOT NULL default '',
			comment_date          datetime NOT NULL DEFAULT '2000-01-01 00:00:00',
			comment_content       text NOT NULL,
			comment_rating        TINYINT(1) NULL DEFAULT NULL,
			comment_featured      TINYINT(1) NOT NULL DEFAULT 0,
			comment_nofollow      TINYINT(1) NOT NULL DEFAULT 1,
			comment_karma         INT(11) NOT NULL DEFAULT 0,
			comment_spam_karma    TINYINT NULL,
			comment_allow_msgform TINYINT NOT NULL DEFAULT 0,
			PRIMARY KEY comment_ID (comment_ID),
			KEY comment_post_ID (comment_post_ID),
			KEY comment_date (comment_date),
			KEY comment_type (comment_type)
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_locales' => array(
		'Creating table for Locales',
		"CREATE TABLE T_locales (
			loc_locale varchar(20) NOT NULL default '',
			loc_charset varchar(15) NOT NULL default 'iso-8859-1',
			loc_datefmt varchar(20) NOT NULL default 'y-m-d',
			loc_timefmt varchar(20) NOT NULL default 'H:i:s',
			loc_startofweek TINYINT UNSIGNED NOT NULL DEFAULT 1,
			loc_name varchar(40) NOT NULL default '',
			loc_messages varchar(20) NOT NULL default '',
			loc_priority tinyint(4) UNSIGNED NOT NULL default '0',
			loc_enabled tinyint(4) NOT NULL default '1',
			PRIMARY KEY loc_locale( loc_locale )
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset COMMENT='saves available locales'
		" ),

	'T_antispam' => array(
		'Creating table for Antispam Blacklist',
		"CREATE TABLE T_antispam (
			aspm_ID bigint(11) NOT NULL auto_increment,
			aspm_string varchar(80) NOT NULL,
			aspm_source enum( 'local','reported','central' ) NOT NULL default 'reported',
			PRIMARY KEY aspm_ID (aspm_ID),
			UNIQUE aspm_string (aspm_string)
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_usersettings' => array(
		'Creating user settings table',
		"CREATE TABLE T_usersettings (
			uset_user_ID INT(11) UNSIGNED NOT NULL,
			uset_name    VARCHAR( 30 ) NOT NULL,
			uset_value   VARCHAR( 255 ) NULL,
			PRIMARY KEY ( uset_user_ID, uset_name )
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_items__prerendering' => array(
		'Creating item prerendering cache table',
		"CREATE TABLE T_items__prerendering(
			itpr_itm_ID                   INT(11) UNSIGNED NOT NULL,
			itpr_format                   ENUM('htmlbody','entityencoded','xml','text') NOT NULL,
			itpr_renderers                TEXT NOT NULL,
			itpr_content_prerendered      MEDIUMTEXT NULL,
			itpr_datemodified             TIMESTAMP NOT NULL,
			PRIMARY KEY (itpr_itm_ID, itpr_format)
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_items__version' => array(	// fp> made iver_edit_user_ID NULL because of INSERT INTO SELECT statement that can try to write NULL
		'Creating item versions table',
		"CREATE TABLE T_items__version (
			iver_itm_ID        INT UNSIGNED NOT NULL ,
			iver_edit_user_ID  INT UNSIGNED NULL ,
			iver_edit_datetime DATETIME NOT NULL ,
			iver_status        ENUM('published','deprecated','protected','private','draft','redirected') NULL ,
			iver_title         TEXT NULL ,
			iver_content       MEDIUMTEXT NULL ,
			INDEX iver_itm_ID ( iver_itm_ID )
		) ENGINE = innodb ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_items__status' => array(
		'Creating table for Post Statuses',
		"CREATE TABLE T_items__status (
			pst_ID   int(11) unsigned not null AUTO_INCREMENT,
			pst_name varchar(30)      not null,
			primary key ( pst_ID )
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_items__type' => array(
		'Creating table for Post Types',
		"CREATE TABLE T_items__type (
			ptyp_ID   int(11) unsigned not null AUTO_INCREMENT,
			ptyp_name varchar(30)      not null,
			primary key (ptyp_ID)
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_items__tag' => array(
		'Creating table for Tags',
		"CREATE TABLE T_items__tag (
			tag_ID   int(11) unsigned not null AUTO_INCREMENT,
			tag_name varchar(50)      not null,
			primary key (tag_ID),
			UNIQUE tag_name( tag_name )
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_items__itemtag' => array(
		'Creating table for Post-to-Tag relationships',
		"CREATE TABLE T_items__itemtag (
			itag_itm_ID int(11) unsigned NOT NULL,
			itag_tag_ID int(11) unsigned NOT NULL,
			PRIMARY KEY (itag_itm_ID, itag_tag_ID),
			UNIQUE tagitem ( itag_tag_ID, itag_itm_ID )
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_files' => array(
		'Creating table for File Meta Data',
		"CREATE TABLE T_files (
			file_ID        int(11) unsigned  not null AUTO_INCREMENT,
			file_root_type enum('absolute','user','collection','shared','skins') not null default 'absolute',
			file_root_ID   int(11) unsigned  not null default 0,
			file_path      varchar(255)      not null default '',
			file_title     varchar(255),
			file_alt       varchar(255),
			file_desc      text,
			primary key (file_ID),
			unique file (file_root_type, file_root_ID, file_path)
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_subscriptions' => array(
		'Creating table for subscriptions',
		"CREATE TABLE T_subscriptions (
			sub_coll_ID     int(11) unsigned    not null,
			sub_user_ID     int(11) unsigned    not null,
			sub_items       tinyint(1)          not null,
			sub_comments    tinyint(1)          not null,
			primary key (sub_coll_ID, sub_user_ID)
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_coll_user_perms' => array(
		'Creating table for Blog-User permissions',
		"CREATE TABLE T_coll_user_perms (
			bloguser_blog_ID           int(11) unsigned NOT NULL default 0,
			bloguser_user_ID           int(11) unsigned NOT NULL default 0,
			bloguser_ismember          tinyint NOT NULL default 0,
			bloguser_perm_poststatuses set('published','deprecated','protected','private','draft','redirected') NOT NULL default '',
			bloguser_perm_edit         ENUM('no','own','lt','le','all','redirected') NOT NULL default 'no',
			bloguser_perm_delpost      tinyint NOT NULL default 0,
			bloguser_perm_comments     tinyint NOT NULL default 0,
			bloguser_perm_cats         tinyint NOT NULL default 0,
			bloguser_perm_properties   tinyint NOT NULL default 0,
			bloguser_perm_admin        tinyint NOT NULL default 0,
			bloguser_perm_media_upload tinyint NOT NULL default 0,
			bloguser_perm_media_browse tinyint NOT NULL default 0,
			bloguser_perm_media_change tinyint NOT NULL default 0,
			PRIMARY KEY bloguser_pk (bloguser_blog_ID,bloguser_user_ID)
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_coll_group_perms' => array(
		'Creating table for blog-group permissions',
		"CREATE TABLE T_coll_group_perms (
			bloggroup_blog_ID           int(11) unsigned NOT NULL default 0,
			bloggroup_group_ID          int(11) unsigned NOT NULL default 0,
			bloggroup_ismember          tinyint NOT NULL default 0,
			bloggroup_perm_poststatuses set('published','deprecated','protected','private','draft','redirected') NOT NULL default '',
			bloggroup_perm_edit         ENUM('no','own','lt','le','all','redirected') NOT NULL default 'no',
			bloggroup_perm_delpost      tinyint NOT NULL default 0,
			bloggroup_perm_comments     tinyint NOT NULL default 0,
			bloggroup_perm_cats         tinyint NOT NULL default 0,
			bloggroup_perm_properties   tinyint NOT NULL default 0,
			bloggroup_perm_admin        tinyint NOT NULL default 0,
			bloggroup_perm_media_upload tinyint NOT NULL default 0,
			bloggroup_perm_media_browse tinyint NOT NULL default 0,
			bloggroup_perm_media_change tinyint NOT NULL default 0,
			PRIMARY KEY bloggroup_pk (bloggroup_blog_ID,bloggroup_group_ID)
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_links' => array(
		'Creating table for Post Links',
		"CREATE TABLE T_links (
			link_ID               int(11) unsigned  not null AUTO_INCREMENT,
			link_datecreated      datetime          not null DEFAULT '2000-01-01 00:00:00',
			link_datemodified     datetime          not null DEFAULT '2000-01-01 00:00:00',
			link_creator_user_ID  int(11) unsigned  not null,
			link_lastedit_user_ID int(11) unsigned  not null,
			link_itm_ID           int(11) unsigned  NOT NULL,
			link_dest_itm_ID      int(11) unsigned  NULL,
			link_file_ID          int(11) unsigned  NULL,
			link_ltype_ID         int(11) unsigned  NOT NULL default 1,
			link_external_url     VARCHAR(255)      NULL,
			link_title            TEXT              NULL,
			PRIMARY KEY (link_ID),
			INDEX link_itm_ID( link_itm_ID ),
			INDEX link_dest_itm_ID (link_dest_itm_ID),
			INDEX link_file_ID (link_file_ID)
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_filetypes' => array(
		'Creating table for file types',
		"CREATE TABLE T_filetypes (
			ftyp_ID int(11) unsigned NOT NULL auto_increment,
			ftyp_extensions varchar(30) NOT NULL,
			ftyp_name varchar(30) NOT NULL,
			ftyp_mimetype varchar(50) NOT NULL,
			ftyp_icon varchar(20) default NULL,
			ftyp_viewtype varchar(10) NOT NULL,
			ftyp_allowed tinyint(1) NOT NULL default 0,
			PRIMARY KEY (ftyp_ID)
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_plugins' => array(
		'Creating plugins table',
		"CREATE TABLE T_plugins (
			plug_ID              INT(11) UNSIGNED NOT NULL auto_increment,
			plug_priority        TINYINT NOT NULL default 50,
			plug_classname       VARCHAR(40) NOT NULL default '',
			plug_code            VARCHAR(32) NULL,
			plug_apply_rendering ENUM( 'stealth', 'always', 'opt-out', 'opt-in', 'lazy', 'never' ) NOT NULL DEFAULT 'never',
			plug_version         VARCHAR(42) NOT NULL default '0',
			plug_name            VARCHAR(255) NULL default NULL,
			plug_shortdesc       VARCHAR(255) NULL default NULL,
			plug_status          ENUM( 'enabled', 'disabled', 'needs_config', 'broken' ) NOT NULL,
			plug_spam_weight     TINYINT UNSIGNED NOT NULL DEFAULT 1,
			PRIMARY KEY ( plug_ID ),
			UNIQUE plug_code( plug_code ),
			INDEX plug_status( plug_status )
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_pluginsettings' => array(
		'Creating plugin settings table',
		"CREATE TABLE T_pluginsettings (
			pset_plug_ID INT(11) UNSIGNED NOT NULL,
			pset_name VARCHAR( 30 ) NOT NULL,
			pset_value TEXT NULL,
			PRIMARY KEY ( pset_plug_ID, pset_name )
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_pluginusersettings' => array(
		'Creating plugin user settings table',
		"CREATE TABLE T_pluginusersettings (
			puset_plug_ID INT(11) UNSIGNED NOT NULL,
			puset_user_ID INT(11) UNSIGNED NOT NULL,
			puset_name VARCHAR( 30 ) NOT NULL,
			puset_value TEXT NULL,
			PRIMARY KEY ( puset_plug_ID, puset_user_ID, puset_name )
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_pluginevents' => array(
		'Creating plugin events table',
		"CREATE TABLE T_pluginevents(
			pevt_plug_ID INT(11) UNSIGNED NOT NULL,
			pevt_event VARCHAR(40) NOT NULL,
			pevt_enabled TINYINT NOT NULL DEFAULT 1,
			PRIMARY KEY( pevt_plug_ID, pevt_event )
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_cron__task' => array(
		'Creating cron tasks table',
		"CREATE TABLE T_cron__task(
			ctsk_ID              int(10) unsigned      not null AUTO_INCREMENT,
			ctsk_start_datetime  datetime              not null DEFAULT '2000-01-01 00:00:00',
			ctsk_repeat_after    int(10) unsigned,
			ctsk_name            varchar(50)           not null,
			ctsk_controller      varchar(50)           not null,
			ctsk_params          text,
			PRIMARY KEY (ctsk_ID)
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),

	'T_cron__log' => array(
		'Creating cron tasks table',
		"CREATE TABLE T_cron__log(
			clog_ctsk_ID              int(10) unsigned   not null,
			clog_realstart_datetime   datetime           not null DEFAULT '2000-01-01 00:00:00',
			clog_realstop_datetime    datetime,
			clog_status               enum('started','finished','error','timeout') not null default 'started',
			clog_messages             text,
			PRIMARY KEY (clog_ctsk_ID)
		) ENGINE = innodb DEFAULT CHARSET = $db_storage_charset" ),
);


/*
 * $Log: __core.install.php,v $
 */
?>