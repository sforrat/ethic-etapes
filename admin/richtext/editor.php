<?php 

session_start();
require "../library/fonction.inc.php";
require "../library_local/lib_global.inc.php";
connection();
require "../library_local/lib_local.inc.php";
require "../library/lib_tools.inc.php";
require "../library/lib_bo.inc.php";
require "../library/class_bo.inc.php";
require "../library/class_SqlToTable.inc.php";
require "../library/lib_design.inc.php";
include "../include/inc_init_bo.inc.php";
include("../fckeditor/fckeditor.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
     <title>C2iS - EDITEUR TEXTE RICHE - FCK EDITOR -</title>
     <meta name="Description" content="Editeur de Texte Riche">
     <meta name="Keywords" content="editeur, texte, riche, C2iS">
     <meta name="Author" content="C2iS">
     <meta name="Identifier-URL" content="http://www.c2is.fr">
     <meta name="Reply-to" content="exploitation@c2is.fr">
     <meta name="Publisher" content="C2iS">
     <meta name="Copyright" content="C2iS">
     <meta http-equiv="expires" content="wed, 15 sept 1999 12:00:00 gmt">
     <meta http-equiv="pragma" content="no-cache">		
		 <meta name="robots" content="noindex, nofollow">
		 <script>
				var LeftPosition = (screen.width) ? (screen.width-700)/2 : 0;	
				var TopPosition = (screen.height) ? (screen.height-580)/4 : 0; 
				window.moveTo(LeftPosition,TopPosition);    
		 </script>
	</head>
	<body scroll="no" marginleft="0" marginheight="0"> 
<?php      



if ($_SESSION['ses_profil_user']!=1 && $_SESSION['ses_profil_user']!=2)
{
  $oFCKeditor = new FCKeditor($_GET['fieldname']) ;
	$oFCKeditor->BasePath = _CONST_RICHTEXT_URL;
	$oFCKeditor->Config['SkinPath'] = _CONST_RICHTEXT_SKIN;
	$oFCKeditor->Value = urldecode($_GET['fieldvalue']);
	$oFCKeditor->Width  = '700' ;
	$oFCKeditor->Height = '580' ;	
	$oFCKeditor->ToolbarSet = _CONST_RICHTEXT_MODE;
	$oFCKeditor->Config['AutoDetectLanguage']	= true ;
	$oFCKeditor->Config['DefaultLanguage']		= 'fr' ;							
	$oFCKeditor->Create() ;
		
}
else
{
  $oFCKeditor = new FCKeditor($_GET['fieldname']) ;
	$oFCKeditor->BasePath = _CONST_RICHTEXT_URL;
	$oFCKeditor->Config['SkinPath'] = _CONST_RICHTEXT_SKIN;
	$oFCKeditor->Value = urldecode($_GET['fieldvalue']);
	$oFCKeditor->Width  = '785' ;
	$oFCKeditor->Height = '580' ;	
	$oFCKeditor->ToolbarSet = _CONST_RICHTEXT_MODE_ROOT;
	$oFCKeditor->Config['AutoDetectLanguage']	= true ;
	$oFCKeditor->Config['DefaultLanguage']		= 'fr' ;							
	$oFCKeditor->Create() ;
		
}
?>
<script language="javascript">
document.getElementById("<?=$_GET['fieldname']?>").value = window.opener.document.formulaire.<?=$_GET['fieldname']?>.value;
</script>
</body>
</html>
