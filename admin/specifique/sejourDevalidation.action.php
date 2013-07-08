<?php

//$path="/data/services/web/www.ethic-etapes.fr/";
$path="../../";
require($path."include/inc_header.inc.php");

$filename_langue = $path."include/language/lib_language_fr.inc.php";

if (is_file($filename_langue))
{
    include($filename_langue);
}

// RPL - param Smarty pour execution bash hors apache
$template->template_dir = $path._CONST_TEMPLATE_DIR;
$template->compile_dir = $path._CONST_COMPILE_DIR;
$template->config_dir = $path._CONST_CONFIG_DIR;
$template->cache_dir = $path._CONST_CACHE_DIR;

$aujourdhui = date('m/d/Y');
$aujourdhui = strtotime($aujourdhui);

$content_1 		= get_libLocal('lib_texte_sejour_plus_valide');
$content 		  = get_libLocal('lib_texte_sejour_depublication');

$titre_1 		= get_libLocal('lib_sujet_mail_sejour_plus_valide');
$titre_2 		= get_libLocal('lib_sujet_mail_sejour_depublication');

//$template->assign('urlSite',_CONST_APPLI_URL);
$template->assign('urlSite', "http://www.ethic-etapes.fr/");

// --------------------------- Short Break --------------------------- \\
echo '<br>short_breaks<br><br>';
$table = "short_breaks";
$sql = "SELECT
    			$table.date_insertion,
    			$table.id_$table as id,
    			centre.libelle,
    			centre.email,
    			trad_$table.nom
    		FROM
    			$table
    		INNER JOIN
    			centre ON (centre.id_centre = $table.id_centre)
    		INNER JOIN
    			trad_$table ON (trad_$table.id__$table = $table.id_$table)
    		WHERE
    			$table.etat=1 and trad_$table.id__langue=1 and $table.date_insertion!='0000-00-00 00:00:00'";

$result = mysql_query($sql) or die(mysql_error());

while($myrow = mysql_fetch_array($result)){
    echo 'nom = '.$myrow["nom"].'<br>';
    $date = $myrow["date_insertion"];

    $date_fin 		= strtotime(date("m/d/Y", strtotime($date." + 365 days")));

    $date_1_mois 	= strtotime("- 1 month", $date_fin);
    $date_2_week 	= strtotime("- 2 weeks", $date_fin);
    $date_1_week 	= strtotime("- 1 weeks", $date_fin);

    if($aujourdhui>$date_fin){

        $sql_U = "update $table set etat=0 where id_$table=".$myrow["id"];
        $result_U = mysql_query($sql_U);

        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content_1);
        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_1);
        $template->assign('titre',$titre);
        $template->assign('message',$message);

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);

    }elseif($date_1_mois==$aujourdhui){

        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content);
        $message 	= str_replace("##DUREE##","1 mois",$message);

        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_2);
        $titre    = str_replace("##DUREE##","1 mois",$titre);
        $template->assign('titre',$titre);
        $template->assign('message',$message);
        $message_mail= $template->fetch('gab/mail/mail.tpl');

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);

    }elseif($date_2_week==$aujourdhui){
        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content);
        $message 	= str_replace("##DUREE##","2 semaines",$message);
        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_2);
        $titre    = str_replace("##DUREE##","15 jours",$titre);
        $template->assign('titre',$titre);
        $template->assign('message',$message);
        $message_mail= $template->fetch('gab/mail/mail.tpl');

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);

    }elseif($date_1_week==$aujourdhui){

        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content);
        $message 	= str_replace("##DUREE##","1 semaine",$message);
        $template->assign('message',$message);

        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_2);
        $titre    = str_replace("##DUREE##","7 jours",$titre);
        $template->assign('titre',$titre);

        $message_mail= $template->fetch('gab/mail/mail.tpl');

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);
    }

}

// --------------------------- Classe de découverte --------------------------- \\
echo '<br>classe_decouverte<br><br>';
$table = "classe_decouverte";
$sql = "SELECT
    			$table.date_insertion,
    			$table.id_$table as id,
    			centre.libelle,
    			centre.email,
    			$table.nom as nom
    		FROM
    			$table
    		INNER JOIN
    			centre ON (centre.id_centre = $table.id_centre)
    		INNER JOIN
    			trad_$table ON (trad_$table.id__$table = $table.id_$table)
    		WHERE
    			$table.etat=1 and trad_$table.id__langue=1 and $table.date_insertion!='0000-00-00 00:00:00'";

$result = mysql_query($sql) or die(mysql_error());

while($myrow = mysql_fetch_array($result)){
    echo 'nom = '.$myrow["nom"].'<br>';
    $date = $myrow["date_insertion"];

    $date_fin 		= strtotime(date("m/d/Y", strtotime($date." + 365 days")));
    $date_1_mois 	= strtotime("- 1 month", $date_fin);
    $date_2_week 	= strtotime("- 2 weeks", $date_fin);
    $date_1_week 	= strtotime("- 1 weeks", $date_fin);

    if($aujourdhui>$date_fin){

        $sql_U = "update $table set etat=0 where id_$table=".$myrow["id"];
        $result_U = mysql_query($sql_U);

        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content_1);
        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_1);
        $template->assign('titre',$titre);
        $template->assign('message',$message);
        $message_mail= $template->fetch('gab/mail/mail.tpl');

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);


    }elseif($date_1_mois==$aujourdhui){

        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content);
        $message 	= str_replace("##DUREE##","1 mois",$message);
        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_2);
        $titre    = str_replace("##DUREE##","1 mois",$titre);
        $template->assign('titre',$titre);
        $template->assign('message',$message);
        $message_mail= $template->fetch('gab/mail/mail.tpl');

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);

    }elseif($date_2_week==$aujourdhui){
        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content);
        $message 	= str_replace("##DUREE##","2 semaines",$message);
        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_2);
        $titre    = str_replace("##DUREE##","15 jours",$titre);
        $template->assign('titre',$titre);
        $template->assign('message',$message);
        $message_mail= $template->fetch('gab/mail/mail.tpl');

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);

    }elseif($date_1_week==$aujourdhui){
        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content);
        $message 	= str_replace("##DUREE##","1 semaine",$message);
        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_2);
        $titre    = str_replace("##DUREE##","7 jours",$titre);
        $template->assign('titre',$titre);
        $template->assign('message',$message);
        $message_mail= $template->fetch('gab/mail/mail.tpl');

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);
    }
}


// --------------------------- CVL --------------------------- \\
echo '<br>cvl<br><br>';
$table = "cvl";
$sql = "SELECT
    			$table.date_insertion,
    			$table.id_$table as id,
    			centre.libelle,
    			centre.email,
    			nom
    		FROM
    			$table
    		INNER JOIN
    			centre ON (centre.id_centre = $table.id_centre)
    		INNER JOIN
    			trad_$table ON (trad_$table.id__$table = $table.id_$table)
    		WHERE
    			$table.etat=1 and trad_$table.id__langue=1 and $table.date_insertion!='0000-00-00 00:00:00'";

$result = mysql_query($sql) or die(mysql_error());

while($myrow = mysql_fetch_array($result)){
    echo 'nom = '.$myrow["nom"].'<br>';
    $date = $myrow["date_insertion"];

    $date_fin 		= strtotime(date("m/d/Y", strtotime($date." + 365 days")));
    $date_1_mois 	= strtotime("- 1 month", $date_fin);
    $date_2_week 	= strtotime("- 2 weeks", $date_fin);
    $date_1_week 	= strtotime("- 1 weeks", $date_fin);


    if($aujourdhui>$date_fin){
        $sql_U = "update $table set etat=0 where id_$table=".$myrow["id"];
        $result_U = mysql_query($sql_U);

        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content_1);
        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_1);
        $template->assign('titre',$titre);
        $template->assign('message',$message);
        $message_mail= $template->fetch('gab/mail/mail.tpl');

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);


    }elseif($date_1_mois==$aujourdhui){

        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content);
        $message 	= str_replace("##DUREE##","1 mois",$message);
        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_2);
        $titre    = str_replace("##DUREE##","1 mois",$titre);
        $template->assign('titre',$titre);
        $template->assign('message',$message);
        $message_mail= $template->fetch('gab/mail/mail.tpl');

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);

    }elseif($date_2_week==$aujourdhui){
        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content);
        $message 	= str_replace("##DUREE##","2 semaines",$message);
        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_2);
        $titre    = str_replace("##DUREE##","15 jours",$titre);
        $template->assign('titre',$titre);
        $template->assign('message',$message);
        $message_mail= $template->fetch('gab/mail/mail.tpl');

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);

    }elseif($date_1_week==$aujourdhui){
        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content);
        $message 	= str_replace("##DUREE##","1 semaine",$message);
        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_2);
        $titre    = str_replace("##DUREE##","7 jours",$titre);
        $template->assign('titre',$titre);
        $template->assign('message',$message);
        $message_mail= $template->fetch('gab/mail/mail.tpl');

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);
    }
}

// --------------------------- seminaires --------------------------- \\
echo '<br>seminaires<br><br>';
$table = "seminaires";
$sql = "SELECT
			$table.date_insertion,
			$table.id_$table as id,
			centre.libelle,
			centre.email,
			nom
		FROM
			$table
		INNER JOIN
			centre ON (centre.id_centre = $table.id_centre)
		INNER JOIN
			trad_$table ON (trad_$table.id__$table = $table.id_$table)
		WHERE
			$table.etat=1 and trad_$table.id__langue=1 and $table.date_insertion!='0000-00-00 00:00:00'";

$result = mysql_query($sql) or die(mysql_error());

while($myrow = mysql_fetch_array($result)){
    echo 'nom = '.$myrow["nom"].'<br>';
    $date = $myrow["date_insertion"];

    $date_fin 		= strtotime(date("m/d/Y", strtotime($date." + 365 days")));
    $date_1_mois 	= strtotime("- 1 month", $date_fin);
    $date_2_week 	= strtotime("- 2 weeks", $date_fin);
    $date_1_week 	= strtotime("- 1 weeks", $date_fin);


    if($aujourdhui>$date_fin){
        $sql_U = "update $table set etat=0 where id_$table=".$myrow["id"];
        $result_U = mysql_query($sql_U);

        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content_1);
        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_1);
        $template->assign('titre',$titre);
        $template->assign('message',$message);
        $message_mail= $template->fetch('gab/mail/mail.tpl');

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);

    }elseif($date_1_mois==$aujourdhui){

        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content);
        $message 	= str_replace("##DUREE##","1 mois",$message);
        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_2);
        $titre    = str_replace("##DUREE##","1 mois",$titre);
        $template->assign('titre',$titre);
        $template->assign('message',$message);
        $message_mail= $template->fetch('gab/mail/mail.tpl');

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);

    }elseif($date_2_week==$aujourdhui){
        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content);
        $message 	= str_replace("##DUREE##","2 semaines",$message);
        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_2);
        $titre    = str_replace("##DUREE##","15 jours",$titre);
        $template->assign('titre',$titre);
        $template->assign('message',$message);
        $message_mail= $template->fetch('gab/mail/mail.tpl');

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);

    }elseif($date_1_week==$aujourdhui){
        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content);
        $message 	= str_replace("##DUREE##","1 semaine",$message);
        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_2);
        $titre    = str_replace("##DUREE##","7 jours",$titre);
        $template->assign('titre',$titre);
        $template->assign('message',$message);
        $message_mail= $template->fetch('gab/mail/mail.tpl');

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);
    }
}

// --------------------------- sejours_touristiques --------------------------- \\
echo '<br>sejours_touristiques<br><br>';
$table = "sejours_touristiques";
$sql = "SELECT
			$table.date_insertion,
			$table.id_$table as id,
			centre.libelle,
			centre.email,
			trad_$table.nom_sejour as nom
		FROM
			$table
		INNER JOIN
			centre ON (centre.id_centre = $table.id_centre)
		INNER JOIN
			trad_$table ON (trad_$table.id__$table = $table.id_$table)
		WHERE
			$table.etat=1 and trad_$table.id__langue=1 and $table.date_insertion!='0000-00-00 00:00:00'";

$result = mysql_query($sql) or die(mysql_error());

while($myrow = mysql_fetch_array($result)){
    echo 'nom = '.$myrow["nom"].'<br>';
    $date = $myrow["date_insertion"];

    $date_fin 		= strtotime(date("m/d/Y", strtotime($date." + 365 days")));
    $date_1_mois 	= strtotime("- 1 month", $date_fin);
    $date_2_week 	= strtotime("- 2 weeks", $date_fin);
    $date_1_week 	= strtotime("- 1 weeks", $date_fin);


    if($aujourdhui>$date_fin){
        $sql_U = "update $table set etat=0 where id_$table=".$myrow["id"];
        $result_U = mysql_query($sql_U);

        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content_1);
        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_1);
        $template->assign('titre',$titre);
        $template->assign('message',$message);
        $message_mail= $template->fetch('gab/mail/mail.tpl');

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);

    }elseif($date_1_mois==$aujourdhui){

        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content);
        $message 	= str_replace("##DUREE##","1 mois",$message);
        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_2);
        $titre    = str_replace("##DUREE##","1 mois",$titre);
        $template->assign('titre',$titre);
        $template->assign('message',$message);
        $message_mail= $template->fetch('gab/mail/mail.tpl');

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);

    }elseif($date_2_week==$aujourdhui){
        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content);
        $message 	= str_replace("##DUREE##","2 semaines",$message);
        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_2);
        $titre    = str_replace("##DUREE##","15 jours",$titre);
        $template->assign('titre',$titre);
        $template->assign('message',$message);
        $message_mail= $template->fetch('gab/mail/mail.tpl');

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);

    }elseif($date_1_week==$aujourdhui){
        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content);
        $message 	= str_replace("##DUREE##","1 semaine",$message);
        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_2);
        $titre    = str_replace("##DUREE##","7 jours",$titre);
        $template->assign('titre',$titre);
        $template->assign('message',$message);
        $message_mail= $template->fetch('gab/mail/mail.tpl');

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);
    }
}
// --------------------------- stages_thematiques_groupes --------------------------- \\
echo '<br>stages_thematiques_groupes<br><br>';
$table = "stages_thematiques_groupes";
$sql = "SELECT
			$table.date_insertion,
			$table.id_$table as id,
			centre.libelle,
			centre.email,
			trad_$table.nom_stage as nom
		FROM
			$table
		INNER JOIN
			centre ON (centre.id_centre = $table.id_centre)
		INNER JOIN
			trad_$table ON (trad_$table.id__$table = $table.id_$table)
		WHERE
			$table.etat=1 and trad_$table.id__langue=1 and $table.date_insertion!='0000-00-00 00:00:00'";

$result = mysql_query($sql) or die(mysql_error());

while($myrow = mysql_fetch_array($result)){
    echo 'nom = '.$myrow["nom"].'<br>';
    $date = $myrow["date_insertion"];

    $date_fin 		= strtotime(date("m/d/Y", strtotime($date." + 365 days")));
    $date_1_mois 	= strtotime("- 1 month", $date_fin);
    $date_2_week 	= strtotime("- 2 weeks", $date_fin);
    $date_1_week 	= strtotime("- 1 weeks", $date_fin);


    if($aujourdhui>$date_fin){
        $sql_U = "update $table set etat=0 where id_$table=".$myrow["id"];
        $result_U = mysql_query($sql_U);

        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content_1);
        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_1);
        $template->assign('titre',$titre);
        $template->assign('message',$message);
        $message_mail= $template->fetch('gab/mail/mail.tpl');

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);

    }elseif($date_1_mois==$aujourdhui){

        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content);
        $message 	= str_replace("##DUREE##","1 mois",$message);
        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_2);
        $titre    = str_replace("##DUREE##","1 mois",$titre);
        $template->assign('titre',$titre);
        $template->assign('message',$message);
        $message_mail= $template->fetch('gab/mail/mail.tpl');

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);

    }elseif($date_2_week==$aujourdhui){
        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content);
        $message 	= str_replace("##DUREE##","2 semaines",$message);
        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_2);
        $titre    = str_replace("##DUREE##","15 jours",$titre);
        $template->assign('titre',$titre);
        $template->assign('message',$message);
        $message_mail= $template->fetch('gab/mail/mail.tpl');

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);

    }elseif($date_1_week==$aujourdhui){
        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content);
        $message 	= str_replace("##DUREE##","1 semaine",$message);
        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_2);
        $titre    = str_replace("##DUREE##","7 jours",$titre);
        $template->assign('titre',$titre);
        $template->assign('message',$message);
        $message_mail= $template->fetch('gab/mail/mail.tpl');

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);
    }
}

// --------------------------- stages_thematiques_individuels --------------------------- \\
echo '<br>stages_thematiques_individuels<br><br>';
$table = "stages_thematiques_individuels";
$sql = "SELECT
			$table.date_insertion,
			$table.id_$table as id,
			centre.libelle,
			centre.email,
			trad_$table.nom as nom
		FROM
			$table
		INNER JOIN
			centre ON (centre.id_centre = $table.id_centre)
		INNER JOIN
			trad_$table ON (trad_$table.id__$table = $table.id_$table)
		WHERE
			$table.etat=1 and trad_$table.id__langue=1 and $table.date_insertion!='0000-00-00 00:00:00'";

$result = mysql_query($sql) or die(mysql_error());

while($myrow = mysql_fetch_array($result)){
    echo 'nom = '.$myrow["nom"].'<br>';
    $date = $myrow["date_insertion"];

    $date_fin 		= strtotime(date("m/d/Y", strtotime($date." + 365 days")));
    $date_1_mois 	= strtotime("- 1 month", $date_fin);
    $date_2_week 	= strtotime("- 2 weeks", $date_fin);
    $date_1_week 	= strtotime("- 1 weeks", $date_fin);


    if($aujourdhui>$date_fin){
        $sql_U = "update $table set etat=0 where id_$table=".$myrow["id"];
        $result_U = mysql_query($sql_U);

        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content_1);
        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_1);
        $template->assign('titre',$titre);
        $template->assign('message',$message);
        $message_mail= $template->fetch('gab/mail/mail.tpl');

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);

    }elseif($date_1_mois==$aujourdhui){

        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content);
        $message 	= str_replace("##DUREE##","1 mois",$message);
        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_2);
        $titre    = str_replace("##DUREE##","1 mois",$titre);
        $template->assign('titre',$titre);
        $template->assign('message',$message);
        $message_mail= $template->fetch('gab/mail/mail.tpl');

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);

    }elseif($date_2_week==$aujourdhui){
        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content);
        $message 	= str_replace("##DUREE##","2 semaines",$message);
        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_2);
        $titre    = str_replace("##DUREE##","15 jours",$titre);
        $template->assign('titre',$titre);
        $template->assign('message',$message);
        $message_mail= $template->fetch('gab/mail/mail.tpl');

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);

    }elseif($date_1_week==$aujourdhui){
        $message 	= str_replace("##SEJOUR##",$myrow["nom"],$content);
        $message 	= str_replace("##DUREE##","1 semaine",$message);
        $titre    = str_replace("##SEJOUR##",$myrow["nom"],$titre_2);
        $titre    = str_replace("##DUREE##","7 jours",$titre);
        $template->assign('titre',$titre);
        $template->assign('message',$message);
        $message_mail= $template->fetch('gab/mail/mail.tpl');

        envoie_mail_depublication($myrow["email"],$message_mail,_MAIL_WEBMASTER,$titre);
    }
}

// RPL - 11/06/2012
function envoie_mail_depublication($to, $message_mail, $from, $titre){
    // Centre concerne
    envoie_mail($to,$message_mail,$from,$titre);
    // Destinataires en copie
    envoie_mail(_MAIL_WEBMASTER,$message_mail,$from,$titre);
    envoie_mail(_MAIL_WEBMASTER_COPY,$message_mail,$from,$titre);
    envoie_mail('r.plancher@c2is.fr',$message_mail,$from,$titre);
    envoie_mail('f.frezzato@c2is.fr',$message_mail,$from,$titre);
}
