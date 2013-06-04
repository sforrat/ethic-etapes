<?

session_start();

// fichiers gnraux  tous les sites
require "library_local/lib_global.inc.php";
require "library_local/lib_local.inc.php";
require "library/fonction.inc.php";
require "library/lib_tools.inc.php";
require "library/lib_ldap.inc.php";
require "library/lib_design.inc.php";
require "library/lib_bo.inc.php";

require "include/inc_init_bo.inc.php";

$DisplayMode = "PopUp";//On cache le menu deroulant

include "include/inc_header.inc.php";

$login = "";
if (isset($_REQUEST['login']))
	$login = $_REQUEST['login'];

$password = "" ;
if (isset($_REQUEST['password']))
	$password = $_REQUEST['password'];



if (isset($_POST['Log']) && $_POST['Log']) 
{
	$StrSQL = "Select * from "._CONST_BO_CODE_NAME."user where STRCMP(login,\"".$login."\")=0 and STRCMP(password,\"".$password."\")=0";
	$RstUser = mysql_query($StrSQL);

	//Authentification Proprietaire sur base
	if (@mysql_num_rows($RstUser)>0) 
	{
	    $_SESSION['ses_id_centre'] = mysql_result( $RstUser, 0, "id_centre" );
			$_SESSION['ses_user_id'] = mysql_result( $RstUser, 0, "id_"._CONST_BO_CODE_NAME."user" );
			$_SESSION['ses_user'] = mysql_result( $RstUser, 0, "prenom" )."&nbsp;".mysql_result( $RstUser, 0, "nom" );
			$_SESSION['ses_trig_user'] = strtoupper( substr( mysql_result( $RstUser, 0, "prenom" ), 0, 1 ) ).".".mb_strtoupper( unhtmlentities(mysql_result( $RstUser, 0, "nom" )) );
			$_SESSION['ses_profil_user'] = mysql_result($RstUser,0,"id_"._CONST_BO_CODE_NAME."profil");
			$_SESSION['ses_id_bo_user'] = mysql_result($RstUser,0,"id_"._CONST_BO_CODE_NAME."user");
			$_SESSION['ses_id_langue_user'] = mysql_result($RstUser,0,"id_"._CONST_BO_CODE_NAME."langue");
			
			
			if($_SESSION['ses_profil_user'] == _PROFIL_CENTRE){
      	$_SESSION['ses_punaise_value'] = 1; // spec : replie le menu gauche par dfaut
      }
		//Insertion du user dans la table de statistique
		StatsBo($_SESSION['ses_id_bo_user'],$_SERVER['HTTP_USER_AGENT'],$_GET['TableDef'],$_SERVER['QUERY_STRING'],$_SERVER['PHP_SELF']);
		
                //Suppresison des actualités et bons plans périmés :
		$sql_D = "DELETE FROM actualite WHERE date_fin < NOW()";
		$result_D = mysql_query($sql_D);
		
		$sql_D = "DELETE FROM bon_plan WHERE date_fin < NOW()";
		$result_D = mysql_query($sql_D);
		
		
		redirect("bo.php?Home=1&L=1");
	}
	//Authentification LDAP
	elseif ( (!strcmp(_CONST_LDAP_ENABLED,"true")) && (ldap_check_user($login,$password)))
	{
    $_SESSION['ses_id_centre'] = mysql_result( $RstUser, 0, "id_centre" );
		$_SESSION['ses_user_id'] = ldap_get_user_info($login,"uidnumber");
		$_SESSION['ses_user'] = ldap_get_user_info($login,"cn")." <i>(LDAP)</i>";
		$_SESSION['ses_profil_user'] = _CONST_LDAP_DEFAULT_PROFIL_ID;
		$_SESSION['ses_id_bo_user'] = _CONST_LDAP_DEFAULT_USER_ID;
		
			   //Insertion du user dans la table de statistique
			   StatsBo($_SESSION['ses_id_bo_user'],$_SERVER['HTTP_USER_AGENT'],$_GET['TableDef'],$_SERVER['QUERY_STRING'],$_SERVER['PHP_SELF']);

			   // on detruit le nb d'erreur si le log est correct		   
			   unset($_SESSION['nb_err_log']);
		
		redirect("bo.php?Home=1&L=1");

	}
	else 
	{				
			redirect( NomFichier( $_SERVER['PHP_SELF'], 0 )."?err=1" );
	}
}


//Affichage de la date
$Annee = split("/",CDate(date("Y-m-d"),1));
$Annee = $Annee[2];
?>
	<FORM METHOD=POST action="<?echo NomFichier($_SERVER['PHP_SELF'],0)?>" name="Log">
	<input type="hidden" name="Log" value="1">
<table>
<tr>
	<td colspan="2">Bonjour, <br>Bienvenue sur l'outil d'administration du site <?= _CONST_APPLI_NAME ?>.<br><br>Cet espace est strictement r&eacute;serv&eacute; au personnel autoris&eacute;.<br>Toute tentative d'intrusion entra&icirc;nera des poursuites judiciaires.<br><br>Veuillez vous identifier :<br><br></td>
</tr>
<? 
		if( isset($_GET['err']) && $_GET['err'] == 1 )
		{ 
	?>
<tr>
		<td colspan=2><font color=red><b>Utilisateur inconnu <i>(<?= ($_SESSION['nb_err_log'] + 1) ?> erreur(s))</i>
<?
		   if (!isset($_SESSION['nb_err_log'])) 
   		   {
			   $_SESSION['nb_err_log'] = 1;
   		   }
   		   else
   		   {
			   $_SESSION['nb_err_log'] = $_SESSION['nb_err_log'] + 1;
			   if( $_SESSION['nb_err_log'] >= 4 ) 
	   	           {	   
		   	      die("<br><br>Nombre maximum d'essai par session d&eacute;pass&eacute;.<br>Application interrompue.");
	   		   }
   		   }
?>
	</b></font></td>
</tr>
	<? 
	         } 
	?>
<tr>
	<td>Login :</td>
	<td><INPUT TYPE="text" NAME="login" class="InputText"></td>
</tr>
<tr>
	<td>Password :</td>
		<td><INPUT TYPE="password" NAME="password" class="InputText">&nbsp;&nbsp;<INPUT TYPE="submit" value="OK" class="InputText"></td>
</tr>
<tr>
		<td colspan=2 align=left><font size="-1"><br><br>Nous sommes le <?= Cdate(Date("Y-m-d"),3)?>, il est <?= Date("H\hi")?></font></td>
	</tr>
	<tr>
<tr>
		<td colspan=2 align=left><font size="-1"><br><?= "Environnement utilisateur : <br>".$_SERVER['HTTP_USER_AGENT']?></td>
	</tr>
	<tr>

		<td colspan="2" align="center"><font size="-1"><br>Copyright &copy; <?=$Annee?> -  <a href="http://www.c2is.fr" target="_blank">C2iS</a></font></td>
</tr>
</table>
	</FORM>
<script>
<!--
   document.Log.login.focus();
   //-->
</script>
<?
include "include/inc_footer.inc.php";
?>
