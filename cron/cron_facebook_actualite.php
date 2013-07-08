<?php
/*
 Cron permettant de regarder si il faut poster une actualité sur faceboook
 */

/*
ini_set('display_errors', 1);
error_reporting(E_ALL);
*/

$path = '../';

//require_once($path.'include/inc_header.inc.php');
require_once($path.'admin/library_local/lib_global.inc.php');
require_once($path.'admin/library_local/lib_local.inc.php');
require_once($path.'include/lib_front.inc.php');
require_once($path.'facebook-php-sdk/src/facebook.php');
require_once($path.'include/class.mysql.inc.php');

global $Host, $UserName, $UserPass, $BaseName;

// connexion base
$db = new sql_db($Host, $UserName, $UserPass, $BaseName, false);

if(!$db->db_connect_id)
{
    die("Connexion a la base de donnees impossible");
}

// Recuperation des actualites a poster dans la table cron_actualites_facebook
$str_select_cron_fb2 = 'select * from cron_actualites_facebook where a_ete_poste = 0 AND date_post_facebook = CURDATE() ';
$rst_select_cron_fb2 = mysql_query($str_select_cron_fb2);

// Pour chaque on poste et on desactive en base
while($row = mysql_fetch_array($rst_select_cron_fb2))
{
    $app_config = array(
        'appId' => _CONST_FB_API_APP_ID,
        'secret' => _CONST_FB_API_SECRET_ID
    );
    $page_config = array(
        'access_token' => _CONST_FB_API_TOKEN,
        'page_id' => _CONST_FB_API_PAGE_ID
    );

    $facebook = new Facebook($app_config);

    $params = array(
        'access_token' => $page_config['access_token'],
        'message' => $row['message'],
        'url' => $row['url_image'],
    );

    $post_id = $facebook->api('/'.$page_config['page_id'].'/photos','post',$params);

    // On passe 'a_ete_poste' a 1
    $str_update_cron_fb2 = ' UPDATE cron_actualites_facebook
                                    SET a_ete_poste = 1
                                    WHERE id_actualite = \''.$row['id_actualite'].'\' ';
    $rst_update_cron_fb2 = mysql_query($str_update_cron_fb2);
}
