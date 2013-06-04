<?
//*********************************************
//MAJ Portfolio
//*********************************************

global $path;
// Initialisation de la page 
$path="../../";
require($path."include/inc_header.inc.php");

$form_fieldname = $_POST["id"];

$path_img = "../images/upload/portfolio_img/";
$StyleChamps =  "InputText";
$return = "";

//==============================
//requete portfolio
//==============================
if($_SESSION["ses_profil_user"]==_PROFIL_CENTRE)
{	
	$str_portfolio_rub = "SELECT * FROM portfolio_rub WHERE id__user ='".$_SESSION["ses_user_id"]."' ORDER BY portfolio_rub ";
}
else 
{		
	$str_portfolio_rub = "SELECT * FROM portfolio_rub ORDER BY portfolio_rub ";
}
$rst_portfolio_rub = mysql_query($str_portfolio_rub);
    
//==============================
//on construit le select
//==============================
$return .= "<option value=\"\">Choisir une image</option>\n";
//$return = "<select name=\"".$form_fieldname."_port\" onChange=\"JS_change_portfolio_preview('".$path_img."', this, 'img_portfolio_preview_".$form_fieldname."')\" class=\"".$StyleChamps." allSelectPortfolio\">";
for ($pfi=0; $pfi<@mysql_num_rows($rst_portfolio_rub) ; $pfi++) 
{
    $id_portfolio_rub = @mysql_result($rst_portfolio_rub,$pfi,0);
    $portfolio_rub    = @mysql_result($rst_portfolio_rub,$pfi,1);

    if ($pfi==0) 
    {
        $return .= "<option value=\"\">".$portfolio_rub."</option>\n";
    }
    else 
    {
        $return .= "<optgroup label=\"".$portfolio_rub."\">\n";
    }

    $str_portfolio_img = " SELECT * FROM portfolio_img WHERE id_portfolio_rub = ".$id_portfolio_rub." ORDER BY portfolio_img ";
	$rst_portfolio_img = mysql_query($str_portfolio_img);

    for ($pfj=0; $pfj<@mysql_num_rows($rst_portfolio_img) ; $pfj++) 
    {

        $id_portfolio_img       = @mysql_result($rst_portfolio_img,$pfj,0);
        $portfolio_img          = @mysql_result($rst_portfolio_img,$pfj,1);
		

        $selected = ($_POST["val"]==$id_portfolio_img) ? "selected=\"selected\"" : $selected="";
				
        $return .= "<option value=\"".$id_portfolio_img."\" $selected >".$portfolio_img."</option>\n";
    }
}
//$return .= "</select>";
echo $return;
?>