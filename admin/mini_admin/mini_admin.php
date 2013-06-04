<?
/*
 * MySQL Interface Web Version FR1.0
 * -------------------------------
 * Kevin Gallot 2003 (kevin@global-dev.com)
 * Version originale par SooMin Kim
 * License : GNU Public License (GPL) - gratuit
 * Web FR : http://www.global-dev.com/mysqlphp/
 */

$HOSTNAME = "localhost";

function logon() {
	global $PHP_SELF;

	setcookie( "mysql_web_admin_username" );
	setcookie( "mysql_web_admin_password" );
	echo "<html>\n";
	echo "<head>\n";
	echo "<title>Interface web - Gestion MySQL</title>\n";
	echo "</head>\n";
	echo "<body>\n";
	echo "<center><font face=verdana size=1>Bienvenue dans l'outil <b>mysql.php</b> version française : FR 1.0<br>Vous pouvez gérer et administrer vos bases de données MySQL<br>&nbsp;<br>&nbsp;</font></center>\n";
	echo "<table width=100%><tr><td><center>\n";
	echo "<table cellpadding=2><tr><td bgcolor=#a4a260><center>\n";
	echo "<table cellpadding=20><tr><td bgcolor=#ffffff><center>\n";
	echo "<font face=verdana size=3 color=#A4A260>Interface web - <b>Gestion MySQL</b></font>\n";
	echo "<form action='$PHP_SELF'>\n";
	echo "<input type=hidden name=action value=logon_submit>\n";
	echo "<table cellpadding=5 cellspacing=1>\n";
	echo "<tr><td><font face=verdana size=1>Nom d'utilisateur : </font></td><td> <input type=text name=username></td></tr>\n";
	echo "<tr><td><font face=verdana size=1>Mot de passe : </font></td><td> <input type=password name=password></td></tr>\n";
	echo "</table><p>\n";
	echo "<input type=submit value='Entrer'>\n";
	echo "<input type=reset value='Annuler'><br>\n";
	echo "</form>\n";
	echo "</center></td></tr></table>\n";
	echo "</center></td></tr></table>\n";
	echo "<p><hr width=300 nosade>\n";
	echo "<font face=verdana size=1>\n";
	echo "<b>Informations de connexion</b> : Le nom d'utilisateur et mot de passe sont ceux que vous avez utilisés lorsque vous avez activé votre base MySQL <br>-ou l'identifiant communiqué par votre hébergeur en cas de serveur mutualisé-. <br>Sinon, vous pouvez saisir les informations suivantes : nom d'utilisateur :  'success'  et laisser le champ mot de passe vide.<br><br>\n";
	echo "<hr width=300 nosade>\n";
	echo "&copy; vers. originale SooMin Kim 1999 - version FR 1.0 Kevin Gallot 2003,\n";
	echo "<a href='http://www.global-dev.com/mysqlphp/'>Page d'accueil France et support<a><br>";
	echo "</font>\n";
	echo "</center></td></tr></table>\n";
	echo "</body>\n";
	echo "</html>\n";
}

function logon_submit() {
	global $username, $password, $PHP_SELF;

	setcookie( "mysql_web_admin_username", $username );
	setcookie( "mysql_web_admin_password", $password );
	echo "<html>";
	echo "<head>";
	echo "<META HTTP-EQUIV=Refresh CONTENT='0; URL=$PHP_SELF?action=listDBs'>";
	echo "</head>";
	echo "</html>";
}

function echoQueryResult() {
	global $queryStr, $errMsg;

	if( $errMsg == "" ) $errMsg = "Succes";
	if( $queryStr != "" ) {
		echo "<table cellpadding=5>\n";
		echo "<tr><td><font face=verdana size=1>Requete : </font></td><td><font face=verdana size=1>$queryStr</font></td></tr>\n";
		echo "<tr><td><font face=verdana size=1>Resultat :</font></td><td><font face=verdana size=1>$errMsg</font></td></tr>\n";
		echo "</table><p>\n";
	}
}

function listDatabases() {
	global $mysqlHandle, $PHP_SELF;

	echo "<font face=verdana size=3 color=#A4A260>Liste des bases de données</font><br><font face=verdana size=1>Choisissez la table que vous souhaitez administrer ou créer une base de données</font>\n";

	echo "<form action='$PHP_SELF'>\n";
	echo "<input type=hidden name=action value=createDB>\n";
	echo "<input type=text name=dbname>\n";
	echo "<input type=submit value='Creer la base'>\n";
	echo "</form>\n";
	echo "<hr>\n";

	echo "<table cellspacing=1 cellpadding=5>\n";

	$pDB = mysql_list_dbs( $mysqlHandle );
	$num = mysql_num_rows( $pDB );
	for( $i = 0; $i < $num; $i++ ) {
		$dbname = mysql_dbname( $pDB, $i );
		echo "<tr>\n";
		echo "<td><font face=verdana size=1>$dbname</font></td>\n";
		echo "<td><font face=verdana size=1><a href='$PHP_SELF?action=listTables&dbname=$dbname'>Details de la base</a></font></td>\n";
		echo "<td><font face=verdana size=1><a href='$PHP_SELF?action=dropDB&dbname=$dbname' onClick=\"return confirm('ATTENTION : voulez vous supprimer la base \'$dbname\'?')\">Supprimer</a></font></td>\n";
		echo "<td><font face=verdana size=1><a href='$PHP_SELF?action=dumpDB&dbname=$dbname'>Exporter (DUMP)</a></font></td>\n";
		echo "</tr>\n";
	}
	echo "</table>\n";
}

function createDatabase() {
	global $mysqlHandle, $dbname, $PHP_SELF;

	mysql_create_db( $dbname, $mysqlHandle );
	listDatabases();
}

function dropDatabase() {
	global $mysqlHandle, $dbname, $PHP_SELF;

	mysql_drop_db( $dbname, $mysqlHandle );
	listDatabases();
}

function listTables() {
	global $mysqlHandle, $dbname, $PHP_SELF;

	echo "<font face=verdana size=3 color=#A4A260>Details de la base</font>\n";
	echo "<br><font face=verdana size=1>Base active : <b>$dbname</b></font><p></p>\n";
	echoQueryResult();
	echo "<form action='$PHP_SELF'>\n";
	echo "<input type=hidden name=action value=createTable>\n";
	echo "<input type=hidden name=dbname value=$dbname>\n";
	echo "<input type=text name=tablename>\n";
	echo "<input type=submit value='Creer la table'>\n";
	echo "</form>\n";
	echo "<form action='$PHP_SELF'>\n";
	echo "<input type=hidden name=action value=query>\n";
	echo "<input type=hidden name=dbname value=$dbname>\n";
	echo "<input type=text size=40 name=queryStr>\n";
	//echo "<textarea cols=30 rows=3 name=queryStr></textarea><br>";
	echo "<input type=submit value='Requete'>\n";
	echo "</form>\n";
	echo "<hr>\n";

	$pTable = mysql_list_tables( $dbname );

	if( $pTable == 0 ) {
		$msg  = mysql_error();
		echo "<font face=verdana size=2><font face=verdana>Erreur : <b>$msg</b></font></font><p>\n";
		return;
	}
	$num = mysql_num_rows( $pTable );

	echo "<table cellspacing=1 cellpadding=5>\n";

	for( $i = 0; $i < $num; $i++ ) {
		$tablename = mysql_tablename( $pTable, $i );

		echo "<tr>\n";
		echo "<td>\n";
		echo "<font face=verdana size=1>$tablename</font>\n";
		echo "</td>\n";
		echo "<td>\n";
		echo "<font face=verdana size=1><a href='$PHP_SELF?action=viewSchema&dbname=$dbname&tablename=$tablename'>Structure</a></font>\n";
		echo "</td>\n";
		echo "<td>\n";
		echo "<font face=verdana size=1><a href='$PHP_SELF?action=viewData&dbname=$dbname&tablename=$tablename'>Donnees-Enregistrements</a></font>\n";
		echo "</td>\n";
		echo "<td>\n";
		echo "<font face=verdana size=1><a href='$PHP_SELF?action=dropTable&dbname=$dbname&tablename=$tablename' onClick=\"return confirm('ATTENTION : voulez vous supprimer \'$dbname\'?')\">Supprimer</a></font>\n";
		echo "</td>\n";
		echo "<td>\n";
		echo "<font face=verdana size=1><a href='$PHP_SELF?action=dumpTable&dbname=$dbname&tablename=$tablename'>Exporter (DUMP)</a></font>\n";
		echo "</td>\n";
		echo "</tr>\n";
	}

	echo "</table>";
}

function createTable() {
	global $mysqlHandle, $dbname, $tablename, $PHP_SELF, $queryStr, $errMsg;

	$queryStr = "CREATE TABLE $tablename ( no INT )";
	mysql_select_db( $dbname, $mysqlHandle );
	mysql_query( $queryStr, $mysqlHandle );
	$errMsg = mysql_error();

	listTables();
}

function dropTable() {
	global $mysqlHandle, $dbname, $tablename, $PHP_SELF, $queryStr, $errMsg;

	$queryStr = "DROP TABLE $tablename";
	mysql_select_db( $dbname, $mysqlHandle );
	mysql_query( $queryStr, $mysqlHandle );
	$errMsg = mysql_error();

	listTables();
}

function viewSchema() {
	global $mysqlHandle, $dbname, $tablename, $PHP_SELF, $queryStr, $errMsg;

	echo "<font face=verdana size=3 color=#A4A260>Structure de la table <b>$tablename</b></font>\n";
	echo "<br><font face=verdana size=1>Base/Table active : <b>$dbname &gt; $tablename</b></font><p></p>\n";

	echoQueryResult();

	echo "<font face=verdana size=1><a href='$PHP_SELF?action=addField&dbname=$dbname&tablename=$tablename'>Ajouter un champ</a> | </font>\n";
	echo "<font face=verdana size=1><a href='$PHP_SELF?action=viewData&dbname=$dbname&tablename=$tablename'>Voir les enregistrements</a></font>\n";
	echo "<hr>\n";

	$pResult = mysql_db_query( $dbname, "SHOW fields FROM $tablename" );
	$num = mysql_num_rows( $pResult );

	echo "<table cellspacing=1 cellpadding=5>\n";
	echo "<tr>\n";
	echo "<th><font face=verdana size=1>Champ</font></th>\n";
	echo "<th><font face=verdana size=1>Type</font></th>\n";
	echo "<th><font face=verdana size=1>Null</font></th>\n";
	echo "<th><font face=verdana size=1>Clef (KEY)</font></th>\n";
	echo "<th><font face=verdana size=1>Default</font></th>\n";
	echo "<th><font face=verdana size=1>Extra</font></th>\n";
	echo "<th colspan=2><font face=verdana size=1>Action</font></th>\n";
	echo "</tr>\n";

	for( $i = 0; $i < $num; $i++ ) {
		$field = mysql_fetch_array( $pResult );
		echo "<tr>\n";
		echo "<td><font face=verdana size=1>".$field["Field"]."</font></td>\n";
		echo "<td><font face=verdana size=1>".$field["Type"]."</font></td>\n";
		echo "<td><font face=verdana size=1>".$field["Null"]."</font></td>\n";
		echo "<td><font face=verdana size=1>".$field["Key"]."</font></td>\n";
		echo "<td><font face=verdana size=1>".$field["Default"]."</font></td>\n";
		echo "<td><font face=verdana size=1>".$field["Extra"]."</font></td>\n";
		$fieldname = $field["Field"];
		echo "<td><font face=verdana size=1><a href='$PHP_SELF?action=editField&dbname=$dbname&tablename=$tablename&fieldname=$fieldname'>Editer</a></font></td>\n";
		echo "<td><font face=verdana size=1><a href='$PHP_SELF?action=dropField&dbname=$dbname&tablename=$tablename&fieldname=$fieldname' onClick=\"return confirm('ATTENTION voulez vous supprimer le champ \'$fieldname\'?')\">Supprimer</a></font></td>\n";
		echo "</tr>\n";
	}
	echo "</table>\n";
}

function manageField( $cmd ) {
	global $mysqlHandle, $dbname, $tablename, $fieldname, $PHP_SELF;

	if( $cmd == "add" )
		echo "<font face=verdana size=3 color=#A4A260>Ajouter un champ</font>\n";
	else if( $cmd == "edit" ) {
		echo "<font face=verdana size=3 color=#A4A260>Edition des champs</font>\n";
		$pResult = mysql_db_query( $dbname, "SHOW fields FROM $tablename" );
		$num = mysql_num_rows( $pResult );
		for( $i = 0; $i < $num; $i++ ) {
			$field = mysql_fetch_array( $pResult );
			if( $field["Field"] == $fieldname ) {
				$fieldtype = $field["Type"];
				$fieldkey = $field["Key"];
				$fieldextra = $field["Extra"];
				$fieldnull = $field["Null"];
				$fielddefault = $field["Default"];
				break;
			}
		}
		$type = strtok( $fieldtype, " (,)\n" );
		if( strpos( $fieldtype, "(" ) ) {
			if( $type == "enum" | $type == "set" ) {
				$valuelist = strtok( " ()\n" );
			} else {
				$M = strtok( " (,)\n" );
				if( strpos( $fieldtype, "," ) )
					$D = strtok( " (,)\n" );
			}
		}
	}

	echo "<br><font face=verdana size=1>Base/Table active : <b>$dbname &gt; $tablename</b></font><p></p>\n";
	echo "<form action=$PHP_SELF>\n";

	if( $cmd == "add" )
		echo "<input type=hidden name=action value=addField_submit>\n";
	else if( $cmd == "edit" ) {
		echo "<input type=hidden name=action value=editField_submit>\n";
		echo "<input type=hidden name=old_name value=$fieldname>\n";
	}
	echo "<input type=hidden name=dbname value=$dbname>\n";
	echo "<input type=hidden name=tablename value=$tablename>\n";

	echo "<font face=verdana size=1><b>Nom</b> du champ :</font>\n";
	echo "<input type=text name=name value=$fieldname><p>\n";
?>

<font face=verdana size=1><b>Type</b> du champ :</font>

<br><font face=verdana size=1>
* `M' indique la taille maximum d'affichage.<br>
* `D' s'applique aux types 'floating-point' et indique le nombre de chiffres après la virgule.<br>
</font>

<table>
<tr>
<th>Type</th><th>&nbspM&nbsp</th><th>&nbspD&nbsp</th><th>unsigned</th><th>zerofill</th><th>binary</th>
</tr>
<tr>
<td><input type=radio name=type value="TINYINT" <? if( $type == "tinyint" ) echo "checked";?>><font face=verdana size=1>TINYINT (-128 ~ 127)</font></td>
<td align=center>O</td>
<td>&nbsp</td>
<td align=center>O</td>
<td align=center>O</td>
<td>&nbsp</td>
</tr>
<tr>
<td><input type=radio name=type value="SMALLINT" <? if( $type == "smallint" ) echo "checked";?>><font face=verdana size=1>SMALLINT (-32768 ~ 32767)</font></td>
<td align=center>O</td>
<td>&nbsp</td>
<td align=center>O</td>
<td align=center>O</td>
<td>&nbsp</td>
</tr>
<tr>
<td><input type=radio name=type value="MEDIUMINT" <? if( $type == "mediumint" ) echo "checked";?>><font face=verdana size=1>MEDIUMINT (-8388608 ~ 8388607)</font></td>
<td align=center>O</td>
<td>&nbsp</td>
<td align=center>O</td>
<td align=center>O</td>
<td>&nbsp</td>
</tr>
<tr>
<td><input type=radio name=type value="INT" <? if( $type == "int" ) echo "checked";?>><font face=verdana size=1>INT (-2147483648 ~ 2147483647)</font></td>
<td align=center>O</td>
<td>&nbsp</td>
<td align=center>O</td>
<td align=center>O</td>
<td>&nbsp</td>
</tr>
<tr>
<td><input type=radio name=type value="BIGINT" <? if( $type == "bigint" ) echo "checked";?>><font face=verdana size=1>BIGINT (-9223372036854775808 ~ 9223372036854775807)</font></td>
<td align=center>O</td>
<td>&nbsp</td>
<td align=center>O</td>
<td align=center>O</td>
<td>&nbsp</td>
</tr>
<tr>
<td><input type=radio name=type value="FLOAT" <? if( $type == "float" ) echo "checked";?>><font face=verdana size=1>FLOAT</font></td>
<td align=center>O</td>
<td align=center>O</td>
<td>&nbsp</td>
<td align=center>O</td>
<td>&nbsp</td>
</tr>
<tr>
<td><input type=radio name=type value="DOUBLE" <? if( $type == "double" ) echo "checked";?>><font face=verdana size=1>DOUBLE</font></td>
<td align=center>O</td>
<td align=center>O</td>
<td>&nbsp</td>
<td align=center>O</td>
<td>&nbsp</td>
</tr>
<tr>
<td><input type=radio name=type value="DECIMAL" <? if( $type == "decimal" ) echo "checked";?>><font face=verdana size=1>DECIMAL(NUMERIC)</font></td>
<td align=center>O</td>
<td align=center>O</td>
<td>&nbsp</td>
<td align=center>O</td>
<td>&nbsp</td>
</tr>
<tr>
<td><input type=radio name=type value="DATE" <? if( $type == "date" ) echo "checked";?>><font face=verdana size=1>DATE (1000-01-01 ~ 9999-12-31, YYYY-MM-DD)</font></td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
</tr>
<tr>
<td><input type=radio name=type value="DATETIME" <? if( $type == "datetime" ) echo "checked";?>><font face=verdana size=1>DATETIME (1000-01-01 00:00:00 ~ 9999-12-31 23:59:59, YYYY-MM-DD HH:MM:SS)</font></td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
</tr>
<tr>
<td><input type=radio name=type value="TIMESTAMP" <? if( $type == "timestamp" ) echo "checked";?>><font face=verdana size=1>TIMESTAMP (1970-01-01 00:00:00 ~ 2106..., YYYYMMDD[HH[MM[SS]]])</font></td>
<td align=center>O</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
</tr>
<tr>
<td><input type=radio name=type value="TIME" <? if( $type == "time" ) echo "checked";?>><font face=verdana size=1>TIME (-838:59:59 ~ 838:59:59, HH:MM:SS)</font></td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
</tr>
<tr>
<td><input type=radio name=type value="YEAR" <? if( $type == "year" ) echo "checked";?>><font face=verdana size=1>YEAR (1901 ~ 2155, 0000, YYYY)</font></td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
</tr>
<tr>
<td><input type=radio name=type value="CHAR" <? if( $type == "char" ) echo "checked";?>><font face=verdana size=1>CHAR</font></td>
<td align=center>O</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td align=center>O</td>
</tr>
<tr>
<td><input type=radio name=type value="VARCHAR" <? if( $type == "varchar" ) echo "checked";?>><font face=verdana size=1>VARCHAR</font></td>
<td align=center>O</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td align=center>O</td>
</tr>
<tr>
<td><input type=radio name=type value="TINYTEXT" <? if( $type == "tinytext" ) echo "checked";?>><font face=verdana size=1>TINYTEXT (0 ~ 255)</font></td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
</tr>
<tr>
<td><input type=radio name=type value="TEXT" <? if( $type == "text" ) echo "checked";?>><font face=verdana size=1>TEXT (0 ~ 65535)</font></td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
</tr>
<tr>
<td><input type=radio name=type value="MEDIUMTEXT" <? if( $type == "mediumtext" ) echo "checked";?>><font face=verdana size=1>MEDIUMTEXT (0 ~ 16777215)</font></td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
</tr>
<tr>
<td><input type=radio name=type value="LONGTEXT" <? if( $type == "longtext" ) echo "checked";?>><font face=verdana size=1>LONGTEXT (0 ~ 4294967295)</font></td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
</tr>
<tr>
<td><input type=radio name=type value="TINYBLOB" <? if( $type == "tinyblob" ) echo "checked";?>><font face=verdana size=1>TINYBLOB (0 ~ 255)</font></td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
</tr>
<tr>
<td><input type=radio name=type value="BLOB" <? if( $type == "blob" ) echo "checked";?>><font face=verdana size=1>BLOB (0 ~ 65535)</font></td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
</tr>
<tr>
<td><input type=radio name=type value="MEDIUMBLOB" <? if( $type == "mediumblob" ) echo "checked";?>><font face=verdana size=1>MEDIUMBLOB (0 ~ 16777215)</font></td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
</tr>
<tr>
<td><input type=radio name=type value="LONGBLOB" <? if( $type == "longblob" ) echo "checked";?>><font face=verdana size=1>LONGBLOB (0 ~ 4294967295)</font></td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
</tr> 
<tr>
<td><input type=radio name=type value="ENUM" <? if( $type == "enum" ) echo "checked";?>><font face=verdana size=1>ENUM</font></td>
<td colspan=5><center><font face=verdana size=1>Liste de valeurs</font></center></td>
</tr>
<tr>
<td><input type=radio name=type value="SET" <? if( $type == "set" ) echo "checked";?>><font face=verdana size=1>SET</font></td>
<td colspan=5><center><font face=verdana size=1>Liste de valeurs</font></center></td>
</tr>

</table>
<table>
<tr><th><font face=verdana size=1>M</font></th><th><font face=verdana size=1>D</font></th><th><font face=verdana size=1>non signé</font></th><th><font face=verdana size=1>zero possible</font></th><th><font face=verdana size=1>binaire</font></th><th><font face=verdana size=1>liste de valeur (ex: 'pomme', 'orange', 'banane') </font></th></tr>
<tr>
<td align=center><input type=text size=4 name=M <? if( $M != "" ) echo "value=$M";?>></td>
<td align=center><input type=text size=4 name=D <? if( $D != "" ) echo "value=$D";?>></td>
<td align=center><input type=checkbox name=unsigned value="UNSIGNED" <? if( strpos( $fieldtype, "unsigned" ) ) echo "checked";?>></td>
<td align=center><input type=checkbox name=zerofill value="ZEROFILL" <? if( strpos( $fieldtype, "zerofill" ) ) echo "checked";?>></td>
<td align=center><input type=checkbox name=binary value="BINARY" <? if( strpos( $fieldtype, "binary" )  ) echo "checked";?>></td>
<td align=center><input type=text size=60 name=valuelist <? if( $valuelist != "" ) echo "value=\"$valuelist\"";?>></td>
</tr>
</table>


<font face=verdana size=1><b>Flags</b> : précision sur les valeurs</font>
<table>
<tr><th><font face=verdana size=1>non nul</font></th><th><font face=verdana size=1>valeur par défaut</font></th><th><font face=verdana size=1>auto-incrementation</font></th><th><font face=verdana size=1>clef primaire</font></th></tr>
<tr>
<td align=center><input type=checkbox name=not_null value="NOT NULL" <? if( $fieldnull != "YES" ) echo "checked";?>></td>
<td align=center><input type=text name=default_value <? if( $fielddefault != "" ) echo "value=$fielddefault";?>></td>
<td align=center><input type=checkbox name=auto_increment value="AUTO_INCREMENT" <? if( $fieldextra == "auto_increment" ) echo "checked";?>></td>
<td align=center><input type=checkbox name=primary_key value="PRIMARY KEY" <? if( $fieldkey == "PRI" ) echo "checked";?>></td>
</tr>
</table>

<p>

<?
	if( $cmd == "add" )
		echo "<input type=submit value='Ajouter un champ'>\n";
	else if( $cmd == "edit" )
		echo "<input type=submit value='Editer le champ'>\n";
	echo "<input type=button value=Cancel onClick='history.back()'>\n";
	echo "</form>\n";
}

function manageField_submit( $cmd ) {
	global $mysqlHandle, $dbname, $tablename, $old_name, $name, $type, $PHP_SELF, $queryStr, $errMsg,
		$M, $D, $unsigned, $zerofill, $binary, $not_null, $default_value, $auto_increment, $primary_key, $valuelist;

	if( $cmd == "add" )
		$queryStr = "ALTER TABLE $tablename ADD $name ";
	else if( $cmd == "edit" )
		$queryStr = "ALTER TABLE $tablename CHANGE $old_name $name ";
	
	if( $M != "" )
		if( $D != "" )
			$queryStr .= "$type($M,$D) ";
		else
			$queryStr .= "$type($M) ";
	else if( $valuelist != "" ) {
		$valuelist = stripslashes( $valuelist );
		$queryStr .= "$type($valuelist) ";
	} else
		$queryStr .= "$type ";

	$queryStr .= "$unsigned $zerofill $binary ";

	if( $default_value != "" )
		$queryStr .= "DEFAULT '$default_value' ";
	
	$queryStr .= "$not_null $auto_increment";

	mysql_select_db( $dbname, $mysqlHandle );
	mysql_query( $queryStr, $mysqlHandle );
	$errMsg = mysql_error();

	// key change
	$keyChange = false;
	$result = mysql_query( "SHOW KEYS FROM $tablename" );
	$primary = "";
	while( $row = mysql_fetch_array($result) )
		if( $row["Key_name"] == "PRIMARY" ) {
			if( $row[Column_name] == $name )
				$keyChange = true;
			else
				$primary .= ", $row[Column_name]";
		}
	if( $primary_key == "PRIMARY KEY" ) {
		$primary .= ", $name";
		$keyChange = !$keyChange;
	}
	$primary = substr( $primary, 2 );
	if( $keyChange == true ) {
		$q = "ALTER TABLE $tablename DROP PRIMARY KEY";
		mysql_query( $q );
		$queryStr .= "<br>\n" . $q;
		$errMsg .= "<br>\n" . mysql_error();
		$q = "ALTER TABLE $tablename ADD PRIMARY KEY( $primary )";
		mysql_query( $q );
		$queryStr .= "<br>\n" . $q;
		$errMsg .= "<br>\n" . mysql_error();
	}

	viewSchema();
}

function dropField() {
	global $mysqlHandle, $dbname, $tablename, $fieldname, $PHP_SELF, $queryStr, $errMsg;

	$queryStr = "ALTER TABLE $tablename DROP COLUMN $fieldname";
	mysql_select_db( $dbname, $mysqlHandle );
	mysql_query( $queryStr , $mysqlHandle );
	$errMsg = mysql_error();

	viewSchema();
}

function viewData( $queryStr ) {
	global $mysqlHandle, $dbname, $tablename, $PHP_SELF, $errMsg, $page, $rowperpage, $orderby;

	echo "<font face=verdana size=3 color=#A4A260>Enregistrements dans la table $tablename</font>\n";
	if( $tablename != "" )
		echo "<br><font face=verdana size=1>Base/Table active : <b>$dbname &gt; $tablename</b></font><p></p>\n";
	else
		echo "<br><font face=verdana size=1>Base active : <b>$dbname</b></font><p></p>\n";

	$queryStr = stripslashes( $queryStr );
	if( $queryStr == "" ) {
		$queryStr = "SELECT * FROM $tablename";
		if( $orderby != "" )
			$queryStr .= " ORDER BY $orderby";
		echo "<font face=verdana size=1><a href='$PHP_SELF?action=addData&dbname=$dbname&tablename=$tablename'>Ajouter un enregistrement</a> | \n";
		echo "<a href='$PHP_SELF?action=viewSchema&dbname=$dbname&tablename=$tablename'>Structure de la table</a></font>\n";
	}

	$pResult = mysql_db_query( $dbname, $queryStr );
	$errMsg = mysql_error();

	$GLOBALS[queryStr] = $queryStr;

	if( $pResult == false ) {
		echoQueryResult();
		return;
	}
	if( $pResult == 1 ) {
		$errMsg = "Success";
		echoQueryResult();
		return;
	}

	echo "<hr>\n";

	$row = mysql_num_rows( $pResult );
	$col = mysql_num_fields( $pResult );

	if( $row == 0 ) {
		echo "<font face=verdana size=1 color=red>Aucune donnée !!</font>";
		return;
	}
	
	if( $rowperpage == "" ) $rowperpage = 20;
	if( $page == "" ) $page = 0;
	else $page--;
	mysql_data_seek( $pResult, $page * $rowperpage );

	echo "<table cellspacing=1 cellpadding=2>\n";
	echo "<tr>\n";
	for( $i = 0; $i < $col; $i++ ) {
		$field = mysql_fetch_field( $pResult, $i );
		echo "<th>";
		echo "<font face=verdana size=1><a href='$PHP_SELF?action=viewData&dbname=$dbname&tablename=$tablename&orderby=".$field->name."'>".$field->name."</a></font>\n";
		echo "</th>\n";
	}
	echo "<th colspan=2><font face=verdana size=1><b>Action</b></font></th>\n";
	echo "</tr>\n";

	for( $i = 0; $i < $rowperpage; $i++ ) {
		$rowArray = mysql_fetch_row( $pResult );
		if( $rowArray == false ) break;
		echo "<tr>\n";
		$key = "";
		for( $j = 0; $j < $col; $j++ ) {
			$data = $rowArray[$j];

			$field = mysql_fetch_field( $pResult, $j );
			if( $field->primary_key == 1 )
				$key .= "&" . $field->name . "=" . $data;

			if( strlen( $data ) > 20 )
				$data = substr( $data, 0, 20 ) . "...";
			$data = htmlspecialchars( $data );
			echo "<td>\n";
			echo "<font face=verdana size=1>$data</font>\n";
			echo "</td>\n";
		}

		if( $key == "" )
			echo "<td colspan=2><font face=verdana size=1>Pas de clef (NO KEY)</font></td>\n";
		else {
			echo "<td><font face=verdana size=1><a href='$PHP_SELF?action=editData&dbname=$dbname&tablename=$tablename$key'>Editer</a></font></td>\n";
			echo "<td><font face=verdana size=1><a href='$PHP_SELF?action=deleteData&dbname=$dbname&tablename=$tablename$key' onClick=\"return confirm('Supprimer la ligne ?')\">Effacer</a></font></td>\n";
		}
		echo "</tr>\n";
	}
	echo "</table>\n";

	echo "<font size=2>\n";
	echo "<form action='$PHP_SELF?action=viewData&dbname=$dbname&tablename=$tablename' method=post>\n";
	echo "<font color=green face=verdana size=1>\n";
	echo ($page+1)."/".(int)($row/$rowperpage+1)." page";
	echo "</font>\n";
	echo " | ";
	if( $page > 0 ) {
		echo "<font face=verdana size=1><a href='$PHP_SELF?action=viewData&dbname=$dbname&tablename=$tablename&page=".($page);
		if( $orderby != "" )
			echo "&orderby=$orderby";
		echo "'>Precedent</a></font>\n";
	} else
		echo "<font face=verdana size=1>Precedent";
	echo " | ";
	if( $page < ($row/$rowperpage)-1 ) {
		echo "<a href='$PHP_SELF?action=viewData&dbname=$dbname&tablename=$tablename&page=".($page+2);
		if( $orderby != "" )
			echo "&orderby=$orderby";
		echo "'>Suivant</a></font>\n";
	} else
		echo "<font face=verdana size=1>Suivant";
	echo " | ";
	if( $row > $rowperpage ) {
		echo "<input type=text size=4 name=page>\n";
		echo "<input type=submit value='Go'></font>\n";
	}
	echo "</form>\n";
	echo "</font>\n";
}

function manageData( $cmd ) {
	global $mysqlHandle, $dbname, $tablename, $PHP_SELF;

	if( $cmd == "add" )
		echo "<font face=verdana size=3 color=#A4A260>Ajouter un enregistrement</font>\n";
	else if( $cmd == "edit" ) {
		echo "<font face=verdana size=3 color=#A4A260>Editer un enregistrement</font>\n";
		$pResult = mysql_list_fields( $dbname, $tablename );
		$num = mysql_num_fields( $pResult );
	
		$key = "";
		for( $i = 0; $i < $num; $i++ ) {
			$field = mysql_fetch_field( $pResult, $i );
			if( $field->primary_key == 1 )
				if( $field->numeric == 1 )
					$key .= $field->name . "=" . $GLOBALS[$field->name] . " AND ";
				else
					$key .= $field->name . "='" . $GLOBALS[$field->name] . "' AND ";
		}
		$key = substr( $key, 0, strlen($key)-4 );

		mysql_select_db( $dbname, $mysqlHandle );
		$pResult = mysql_query( $queryStr =  "SELECT * FROM $tablename WHERE $key", $mysqlHandle );
		$data = mysql_fetch_array( $pResult );
	}

	echo "<br><font face=verdana size=1>Base/Table active : <b>$dbname &gt; $tablename</b></font><p></p>\n";

	echo "<form action='$PHP_SELF' method=post>\n";
	if( $cmd == "add" )
		echo "<input type=hidden name=action value=addData_submit>\n";
	else if( $cmd == "edit" )
		echo "<input type=hidden name=action value=editData_submit>\n";
	echo "<input type=hidden name=dbname value=$dbname>\n";
	echo "<input type=hidden name=tablename value=$tablename>\n";
	echo "<table cellspacing=1 cellpadding=2>\n";
	echo "<tr>\n";
	echo "<th><font face=verdana size=1>Nom</font></th>\n";
	echo "<th><font face=verdana size=1>Type</font></th>\n";
	echo "<th><font face=verdana size=1>Fonction</font></th>\n";
	echo "<th><font face=verdana size=1>Donnée</font></th>\n";
	echo "</tr>\n";

	$pResult = mysql_db_query( $dbname, "SHOW fields FROM $tablename" );
	$num = mysql_num_rows( $pResult );

	$pResultLen = mysql_list_fields( $dbname, $tablename );

	for( $i = 0; $i < $num; $i++ ) {
		$field = mysql_fetch_array( $pResult );
		$fieldname = $field["Field"];
		$fieldtype = $field["Type"];
		$len = mysql_field_len( $pResultLen, $i );

		echo "<tr>";
		echo "<td><font face=verdana size=1>$fieldname</font></td>";
		echo "<td><font face=verdana size=1>".$field["Type"]."</font></td>";
		echo "<td>\n";
		echo "<select name=${fieldname}_function>\n";
		echo "<option>\n";
		echo "<option>ASCII\n";
		echo "<option>CHAR\n";
		echo "<option>SOUNDEX\n";
		echo "<option>CURDATE\n";
		echo "<option>CURTIME\n";
		echo "<option>FROM_DAYS\n";
		echo "<option>FROM_UNIXTIME\n";
		echo "<option>NOW\n";
		echo "<option>PASSWORD\n";
		echo "<option>PERIOD_ADD\n";
		echo "<option>PERIOD_DIFF\n";
		echo "<option>TO_DAYS\n";
		echo "<option>USER\n";
		echo "<option>WEEKDAY\n";
		echo "<option>RAND\n";
		echo "</select>\n";
		echo "</td>\n";
		$value = htmlspecialchars($data[$i]);
		if( $cmd == "add" ) {
			$type = strtok( $fieldtype, " (,)\n" );
			if( $type == "enum" || $type == "set" ) {
				echo "<td>\n";
				if( $type == "enum" )
					echo "<select name=$fieldname>\n";
				else if( $type == "set" )
					echo "<select name=$fieldname size=4 multiple>\n";
				echo strtok( "'" );
				while( $str = strtok( "'" ) ) {
					echo "<option>$str\n";
					strtok( "'" );
				}
				echo "</select>\n";
				echo "</td>\n";
			} else {
				if( $len < 40 )
					echo "<td><input type=text size=40 maxlength=$len name=$fieldname></td>\n";
				else
					echo "<td><textarea cols=40 rows=3 maxlength=$len name=$fieldname></textarea>\n";
			}
		} else if( $cmd == "edit" ) {
			$type = strtok( $fieldtype, " (,)\n" );
			if( $type == "enum" || $type == "set" ) {
				echo "<td>\n";
				if( $type == "enum" )
					echo "<select name=$fieldname>\n";
				else if( $type == "set" )
					echo "<select name=$fieldname size=4 multiple>\n";
				echo strtok( "'" );
				while( $str = strtok( "'" ) ) {
					if( $value == $str )
						echo "<option selected>$str\n";
					else
						echo "<option>$str\n";
					strtok( "'" );
				}
				echo "</select>\n";
				echo "</td>\n";
			} else {
				if( $len < 40 )
					echo "<td><input type=text size=40 maxlength=$len name=$fieldname value=\"$value\"></td>\n";
				else
					echo "<td><textarea cols=40 rows=3 maxlength=$len name=$fieldname>$value</textarea>\n";
			}
		}
		echo "</tr>";
	}
	echo "</table><p>\n";
	if( $cmd == "add" )
		echo "<input type=submit value='Ajouter les données'>\n";
	else if( $cmd == "edit" )
		echo "<input type=submit value='Editer les données'>\n";
	echo "<input type=button value='Annuler' onClick='history.back()'>\n";
	echo "</form>\n";
}

function manageData_submit( $cmd ) {
	global $mysqlHandle, $dbname, $tablename, $fieldname, $PHP_SELF, $queryStr, $errMsg;

	$pResult = mysql_list_fields( $dbname, $tablename );
	$num = mysql_num_fields( $pResult );

	mysql_select_db( $dbname, $mysqlHandle );
	if( $cmd == "add" )
		$queryStr = "INSERT INTO $tablename VALUES (";
	else if( $cmd == "edit" )
		$queryStr = "REPLACE INTO $tablename VALUES (";
	for( $i = 0; $i < $num-1; $i++ ) {
		$field = mysql_fetch_field( $pResult );
		$func = $GLOBALS[$field->name."_function"];
		if( $func != "" )
			$queryStr .= " $func(";
		if( $field->numeric == 1 ) {
			$queryStr .= $GLOBALS[$field->name];
			if( $func != "" )
				$queryStr .= "),";
			else
				$queryStr .= ",";
		} else {
			$queryStr .= "'" . $GLOBALS[$field->name];
			if( $func != "" )
				$queryStr .= "'),";
			else
				$queryStr .= "',";
		}
	}
	$field = mysql_fetch_field( $pResult );
	if( $field->numeric == 1 )
		$queryStr .= $GLOBALS[$field->name] . ")";
	else 
		$queryStr .= "'" . $GLOBALS[$field->name] . "')";

	mysql_query( $queryStr , $mysqlHandle );
	$errMsg = mysql_error();

	viewData( "" );
}

function deleteData() {
	global $mysqlHandle, $dbname, $tablename, $fieldname, $PHP_SELF, $queryStr, $errMsg;

	$pResult = mysql_list_fields( $dbname, $tablename );
	$num = mysql_num_fields( $pResult );

	$key = "";
	for( $i = 0; $i < $num; $i++ ) {
		$field = mysql_fetch_field( $pResult, $i );
		if( $field->primary_key == 1 )
			if( $field->numeric == 1 )
				$key .= $field->name . "=" . $GLOBALS[$field->name] . " AND ";
			else
				$key .= $field->name . "='" . $GLOBALS[$field->name] . "' AND ";
	}
	$key = substr( $key, 0, strlen($key)-4 );

	mysql_select_db( $dbname, $mysqlHandle );
	$queryStr =  "DELETE FROM $tablename WHERE $key";
	mysql_query( $queryStr, $mysqlHandle );
	$errMsg = mysql_error();

	viewData( "" );
}

function dump() {
	global $PHP_SELF, $USERNAME, $PASSWORD, $action, $dbname, $tablename;

	if( $action == "dumpTable" )
		$filename = $tablename;
	else
		$filename = $dbname;

	header("Content-disposition: filename=$filename.sql");
	header("Content-type: application/octetstream");
	header("Pragma: no-cache");
	header("Expires: 0");

	$pResult = mysql_query( "show variables" );
	while( 1 ) {
		$rowArray = mysql_fetch_row( $pResult );
		if( $rowArray == false ) break;
		if( $rowArray[0] == "basedir" )
			$bindir = $rowArray[1]."bin/";
	}

	passthru( $bindir."mysqldump --user=$USERNAME --password=$PASSWORD $dbname $tablename" );
}

function utils() {
	global $PHP_SELF, $command;
	echo "<font face=verdana size=3 color=#A4A260>Utilitaires</font>\n";
	if( $command == "" || substr( $command, 0, 5 ) == "flush" ) {
		echo "<hr>\n";
		echo "<font face=verdana size=1>Voir les <b>informations MySQL</b> (fonction Show)</font>\n";
		echo "<ul>\n";
		echo "<li><font face=verdana size=1><a href='$PHP_SELF?action=utils&command=show_status'>Statut</a></font>\n";
		echo "<li><font face=verdana size=1><a href='$PHP_SELF?action=utils&command=show_variables'>Variables</a></font>\n";
		echo "<li><font face=verdana size=1><a href='$PHP_SELF?action=utils&command=show_processlist'>Liste des procédures</a></font>\n";
		echo "</ul>\n";
		echo "<font face=verdana size=1><b>Vide les caches</b> (fonction Flush)</font>\n";
		echo "<ul>\n";
		echo "<li><font face=verdana size=1><a href='$PHP_SELF?action=utils&command=flush_hosts'>Hote</a></font>\n";
		if( $command == "flush_hosts" ) {
			if( mysql_query( "Flush hosts" ) != false )
				echo "<font size=1 face=verdana color=red>- SUCCES</font>";
			else
				echo "<font size=1 face=verdana color=red>- ECHEC</font>";
		}
		echo "<li><font face=verdana size=1><a href='$PHP_SELF?action=utils&command=flush_logs'>Logs</a></font>\n";
		if( $command == "flush_logs" ) {
			if( mysql_query( "Flush logs" ) != false )
				echo "<font size=1 face=verdana color=red>- SUCCES</font>";
			else
				echo "<font size=1 face=verdana color=red>- ECHEC</font>";
		}
		echo "<li><font face=verdana size=1><a href='$PHP_SELF?action=utils&command=flush_privileges'>Privileges</a></font>\n";
		if( $command == "flush_privileges" ) {
			if( mysql_query( "Flush privileges" ) != false )
				echo "<font size=1 face=verdana color=red>- SUCCES</font>";
			else
				echo "<font size=1 face=verdana color=red>- ECHEC</font>";
		}
		echo "<li><font face=verdana size=1><a href='$PHP_SELF?action=utils&command=flush_tables'>Tables</a></font>\n";
		if( $command == "flush_tables" ) {
			if( mysql_query( "Flush tables" ) != false )
				echo "<font size=1 face=verdana color=red>- SUCCES</font>";
			else
				echo "<font size=1 face=verdana color=red>- ECHEC</font>";
		}
		echo "<li><font face=verdana size=1><a href='$PHP_SELF?action=utils&command=flush_status'>Status</a></font>\n";
		if( $command == "flush_status" ) {
			if( mysql_query( "Flush status" ) != false )
				echo "<font size=1 face=verdana color=red>- SUCCES</font>";
			else
				echo "<font size=1 face=verdana color=red>- ECHEC</font>";
		}
		echo "</ul>\n";
	} else {
		$queryStr = ereg_replace( "_", " ", $command );
		$pResult = mysql_query( $queryStr );
		if( $pResult == false ) {
			echo "Fail";
			return;
		}
		$col = mysql_num_fields( $pResult );

		echo "<p><font face=verdana size=1>Requete effectuée : <b>$queryStr</b></font></p>\n";
		echo "<hr>\n";

		echo "<table cellspacing=1 cellpadding=2 border=0>\n";
		echo "<tr>\n";
		for( $i = 0; $i < $col; $i++ ) {
			$field = mysql_fetch_field( $pResult, $i );
			echo "<th><font face=verdana size=1>".$field->name."</font></th>\n";
		}
		echo "</tr>\n";

		while( 1 ) {
			$rowArray = mysql_fetch_row( $pResult );
			if( $rowArray == false ) break;
			echo "<tr>\n";
			for( $j = 0; $j < $col; $j++ )
				echo "<td><font face=verdana size=1>".htmlspecialchars( $rowArray[$j] )."</font></td>\n";
			echo "</tr>\n";
		}
		echo "</table>\n";
	}
}

function header_html() {
	global $PHP_SELF;
	
?>
<html>
<head>
<title>Interface de gestion MySQL</title>
<style type="text/css">
<!--
p.location {
	color: #11bb33;
	font-size: small;
}
h1 {
	color: #A4A260;
}
th {
	background-color: #BDBE42;
	color: #FFFFFF;
	font-size: x-small;
}
td {
	background-color: #DEDFA5;
	font-size: x-small;
}
form {
	margin-top: 0;
	margin-bottom: 0;
}
a {
	text-decoration:none;
	color: #848200;
}
a:link {

	text-decoration:none    ;   
}
a:hover {
	background-color:#EEEFD5;
	color:#646200;
	text-decoration:none    ;           
}
//-->
</style>
</head>
<body>
<?
}

function footer_html() {
	global $mysqlHandle, $dbname, $tablename, $PHP_SELF, $USERNAME;

	echo "<hr>\n";
	echo "<font face=verdana size=1>\n";
	echo "<font color=blue>[<b>$USERNAME</b>]</font> - \n";

	echo "<a href='$PHP_SELF?action=listDBs'>Liste des bases</a> | \n";
	if( $tablename != "" )
		echo "<a href='$PHP_SELF?action=listTables&dbname=$dbname&tablename=$tablename'>Liste des tables de $dbname</a> | ";
	echo "<a href='$PHP_SELF?action=utils'>Utilitaires</a> |\n";
	echo "<a href='$PHP_SELF?action=logout'>Deconnexion</a>\n";
	echo "</font>\n";
	echo "</body>\n";
	echo "</html>\n";
}

//------------------------------------------------------ MAIN

if( $action == "logon" || $action == "" || $action == "logout" )
	logon();
else if( $action == "logon_submit" )
	logon_submit();
else if( $action == "dumpTable" || $action == "dumpDB" ) {
	while( list($var, $value) = each($HTTP_COOKIE_VARS) ) {
		if( $var == "mysql_web_admin_username" ) $USERNAME = $value;
		if( $var == "mysql_web_admin_password" ) $PASSWORD = $value;
	}
	$mysqlHandle = mysql_connect( $HOSTNAME, $USERNAME, $PASSWORD );
	dump();
} else {
	while( list($var, $value) = each($HTTP_COOKIE_VARS) ) {
		if( $var == "mysql_web_admin_username" ) $USERNAME = $value;
		if( $var == "mysql_web_admin_password" ) $PASSWORD = $value;
	}
	echo "<!--";
	$mysqlHandle = mysql_connect( $HOSTNAME, $USERNAME, $PASSWORD );
	echo "-->";

	if( $mysqlHandle == false ) {
		echo "<html>\n";
		echo "<head>\n";
		echo "<title>Interface de gestion MySQL</title>\n";
		echo "</head>\n";
		echo "<body>\n";
		echo "<table width=100% height=100%><tr><td><center>\n";
		echo "<font face=verdana size=3 color=#A4A260>** MAUVAIS MOT DE PASSE **</font>\n";
		echo "<a href='$PHP_SELF?action=logon'>Connexion</a>\n";
		echo "</center></td></tr></table>\n";
		echo "</body>\n";
		echo "</html>\n";
	} else {
		header_html();
		if( $action == "listDBs" )
			listDatabases();
		else if( $action == "createDB" )
			createDatabase();
		else if( $action == "dropDB" )
			dropDatabase();
		else if( $action == "listTables" )
			listTables();
		else if( $action == "createTable" )
			createTable();
		else if( $action == "dropTable" )
			dropTable();
		else if( $action == "viewSchema" )
			viewSchema();
		else if( $action == "query" )
			viewData( $queryStr );
		else if( $action == "addField" )
			manageField( "add" );
		else if( $action == "addField_submit" )
			manageField_submit( "add" );
		else if( $action == "editField" )
			manageField( "edit" );
		else if( $action == "editField_submit" )
			manageField_submit( "edit" );
		else if( $action == "dropField" )
			dropField();
		else if( $action == "viewData" )
			viewData( "" );
		else if( $action == "addData" )
			manageData( "add" );
		else if( $action == "addData_submit" )
			manageData_submit( "add" );
		else if( $action == "editData" )
			manageData( "edit" );
		else if( $action == "editData_submit" )
			manageData_submit( "edit" );
		else if( $action == "deleteData" )
			deleteData();
		else if( $action == "utils" )
			utils();

		mysql_close( $mysqlHandle);
		footer_html();
	}
}

?>
