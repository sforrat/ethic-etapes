<?php
/**
 * This files instantiates the global {@link $DB} object and connects to the database.
 *
 * This file is part of the evoCore framework - {@link http://evocore.net/}
 * See also {@link http://sourceforge.net/projects/evocms/}.
 *
 * @copyright (c)2003-2009 by Francois PLANQUE - {@link http://fplanque.net/}
 *
 * @version $Id: _connect_db.inc.php,v 1.12 2009/03/08 23:57:38 fplanque Exp $
 */

/**
 * Load configuration
 * NOTE: fp> config should always be loaded as a whole because of the prequire"_once" stuff not working very well on Windows
 */
// require_once dirname(__FILE__).'/../conf/_config.php';

/**
 * Load DB class
 */
require_once dirname(__FILE__).'/_core/model/db/_db.class.php';

/**
 * Database connection (connection opened here)
 *
 * @global DB $DB
 */
$DB = & new DB( $db_config );

/*
 * $Log: _connect_db.inc.php,v $
 */
?>