<? 
header('Content-type: text/css'); 
require "../library_local/lib_global.inc.php";
require "../library/fonction.inc.php";
require "../library/lib_tools.inc.php";

connection();//Connection a la base de données

$StrSQL = "Select * from "._CONST_BO_CODE_NAME."style where selected=1";
$Rstbo_style = mysql_query($StrSQL);

$MainFontColor				= @mysql_result($Rstbo_style,0,"main_font_color");            
$FontSize					= @mysql_result($Rstbo_style,0,"font_size_11");                 
$FontWeight					= @mysql_result($Rstbo_style,0,"font_weight_3");               
$FontType					= @mysql_result($Rstbo_style,0,"font_type_20");
$TextDecoration				= @mysql_result($Rstbo_style,0,"text_decoration_2");           
$ActiveItemTextDecoration	= @mysql_result($Rstbo_style,0,"active_item_text_decoration_2"); 
$ActiveItemColor			= @mysql_result($Rstbo_style,0,"active_item_color");          
$ActiveItemColorLight		= @mysql_result($Rstbo_style,0,"active_item_color_light");     
$ActiveItemFontWeight		= @mysql_result($Rstbo_style,0,"active_item_font_weight_3");     
$TitleFontSize				= @mysql_result($Rstbo_style,0,"title_font_size_11");            
$BorderColor				= @mysql_result($Rstbo_style,0,"border_color");              
$BackgroundColor			= @mysql_result($Rstbo_style,0,"background_color");          
$MenuFontColor				= @mysql_result($Rstbo_style,0,"menu_font_color");            
$Menutablebgcolor			= @mysql_result($Rstbo_style,0,"menu_table_bgcolor");         
$MenuBgColor				= @mysql_result($Rstbo_style,0,"menu_bgcolor");         


$StrSQLStyle = "
                SELECT
                        *
                FROM  
                        "._CONST_BO_CODE_NAME."style
                WHERE 
                        selected=1
                ";
$Rstbo_style = mysql_query($StrSQLStyle);	

$MenuBgColor				= @mysql_result($Rstbo_style,0,"menu_bgcolor");
$MenuTableBgColor			= @mysql_result($Rstbo_style,0,"menu_table_bgcolor");
?>


body, p, td, table, InputText {
	font-family: <?echo $FontType;?>;
	color : <?echo $MainFontColor;?>;
	font-size: <?echo $FontSize;?>;
	text-decoration: <?echo $TextDecoration;?>;
}

th {
	font-family: <?echo $FontType;?>;
	color : <?echo $ActiveItemColorLight;?>;
	font-size: <?echo $FontSize;?>;
	font-weight: <?echo $ActiveItemFontWeight;?>;
}

BODY {
	scrollbar-highlight-color: white;
	scrollbar-shadow-color: white;
	scrollbar-arrow-color: white;
	scrollbar-track-color: <?echo $BackgroundColor;?>;
	scrollbar-darkshadow-color: <?echo $Menutablebgcolor;?>;
	scrollbar-base-color: <?echo $MenuBgColor;?>;
	scrollbar-3d-light-color: white;
	background-color: <?echo $BackgroundColor;?>;

}

.chemin {
	color : <?echo $ActiveItemColor;?>;
	<? if ( intval($FontSize-2) !=0) 
	{ 
		?>
	font-size: <?echo intval($FontSize-2);?>px;
	<?
	}
	else
	{
	?>
	font-size: 10px;
	<?
	}
	?>
}

.InputText {
	font-family: <?echo $FontType;?>;
	font-size: <?echo $FontSize;?>;
}

.bg { background-color: <?echo $MenuBgColor;?>; }

.InputTextBo {
	font-family: Courier New;
	font-size: 10pt;
	width : 600 pt;
	/*height : 200 pt;*/
}

.navActiveState {
	font-family: Courier New;
	font-size: 8pt;
}

.active_state {
	color : #000D80;
    font-weight : bold;
	text-decoration: underline overline;
    text-transform: uppercase;
}

.wfActiveStateTitle {
	color : #606060;
    font-weight : bold;
}

.required {
	color : red;
}

.InputText, .InputTextBo {
	color : <?echo $MainFontColor;?>;
	font-style: <?echo $FontWeight;?>;
	line-height: <?echo $FontWeight;?>;
	font-weight: <?echo $FontWeight;?>;
	font-variant: <?echo $FontWeight;?>;
	text-transform: <?echo $TextDecoration;?>;
	text-decoration: <?echo $TextDecoration;?>;
	border-color: <?echo"$BorderColor $BorderColor $BorderColor $BorderColor";?>;
	list-style-type: <?echo $TextDecoration;?>;
	background-color: <?echo $BackgroundColor;?>;
	border-style: groove;
	border : thin groove;
}


.ActiveInputText {
	font-family: <?echo $FontType;?>;
	color : <?echo $ActiveItemColor;?>;
	font-style: <?echo $FontWeight;?>;
	font-size: <?echo $FontSize;?>;
	line-height: <?echo $FontWeight;?>;
	font-weight: <?echo $FontWeight;?>;
	font-variant: <?echo $FontWeight;?>;
	text-transform: <?echo $TextDecoration;?>;
	text-decoration: <?echo $TextDecoration;?>;
	border-color: <?echo"$BorderColor $BorderColor $BorderColor $BorderColor";?>;
	list-style-type: <?echo $TextDecoration;?>;
	background-color: <?echo $BackgroundColor;?>;
	border-style: groove;
}

.titre {
	font-family: <?echo $FontType;?>;
	font-size: <?echo $TitleFontSize;?>;
	font-weight: <?echo $ActiveItemFontWeight;?>;
	text-decoration: <?echo $TextDecoration;?>;
	color: <?echo $ActiveItemColor;?>;
}


/*Style pour tous les types de liens*/
a.LienBlanc:hover, a.LienBlanc, a.LienBlanc:link, a.LienBlanc:active,a.LienLight:hover, a.LienLight, a.LienLight:link, a.LienLight:active, a:hover, a.Menu:hover, a, a:link, a.Menu, a.Menu:link, a:active, a.Menu:active
{
	font-family: <?echo $FontType;?>;
	font-size: <?echo $FontSize;?>;
	font-style: <?echo $FontWeight;?>;
	line-height: <?echo $FontWeight;?>;
}


/* Lien par defaut*/

a:active {
	font-weight: <?echo $FontWeight;?>;
	font-variant: <?echo $FontWeight;?>;
	color: <?echo $ActiveItemColor;?>;
	text-decoration: <?echo $TextDecoration;?>;
}

a, a:link {
	font-weight: <?echo $FontWeight;?>;
	font-variant: <?echo $FontWeight;?>;
	color: <?echo $ActiveItemColor;?>;
	text-decoration: <?echo $ActiveItemTextDecoration;?>;
}

a:hover {
	font-weight: <?echo $FontWeight;?>;
	font-variant: <?echo $FontWeight;?>;
	color: <?echo $MainFontColor;?>;
	text-decoration: <?echo $TextDecoration;?>;
}

/* Lien Claire*/
a.LienLight:active {
	font-weight: <?echo $ActiveItemFontWeight;?>;
	font-variant: <?echo $FontWeight;?>;
	color: white;
	text-decoration: <?echo $TextDecoration;?>;
}

a.LienLight, a.LienLight:link {
	font-weight: <?echo $ActiveItemFontWeight;?>;
	font-variant: <?echo $FontWeight;?>;
	color: <?echo $ActiveItemColorLight;?>;
	text-decoration: <?echo $ActiveItemTextDecoration;?>;
}

a.LienLight:hover {
	font-weight: <?echo $ActiveItemFontWeight;?>;
	font-variant: <?echo $FontWeight;?>;
	color: <?echo $ActiveItemColorLight;?>;
	text-decoration: <?echo $TextDecoration;?>;
}

/* Lien blanc */
a.LienBlanc:active {
	font-weight: normal;
	font-variant: <?echo $FontWeight;?>;
	color: white;
	text-decoration: <?echo $TextDecoration;?>;
}

a.LienBlanc, a.LienBlanc:link {
	font-weight: normal;
	font-variant: <?echo $FontWeight;?>;
	color: white;
	text-decoration: none;
}

a.LienBlanc:hover {
	font-weight: normal;
	font-variant: <?echo $FontWeight;?>;
	color: white;
	text-decoration: underline;
}

/* Lien noir */
a.LienNoir:active {
	font-weight: normal;
	font-variant: <?echo $FontWeight;?>;
	color: black;
	text-decoration: <?echo $TextDecoration;?>;
}

a.LienNoir, a.LienNoir:link {
	font-weight: normal;
	font-variant: <?echo $FontWeight;?>;
	color: black;
	text-decoration: none;
}

a.LienNoir:hover {
	font-weight: normal;
	font-variant: <?echo $FontWeight;?>;
	color: black;
	text-decoration: underline;
}



/* Lien dans les menus */
a.Menu:active {
	font-weight: <?echo $FontWeight;?>;
	font-variant: <?echo $FontWeight;?>;
	color: <?echo $ActiveItemColor;?>;
	text-decoration: <?echo $TextDecoration;?>;
}

a.Menu, a.Menu:link {
	font-weight: <?echo $FontWeight;?>;
	font-variant: <?echo $FontWeight;?>;
	color: <?echo $MenuFontColor;?>;
	text-decoration: <?echo $TextDecoration;?>;
}

a.Menu:hover {
	font-weight: <?echo $FontWeight;?>;
	font-variant: <?echo $FontWeight;?>;
	color: <?echo $MainFontColor;?>;
	text-decoration: <?echo $ActiveItemTextDecoration;?>;
}


A.ALink {
   color: #000000;
	font-family: arial, verdana, helvetica;
	text-decoration: none;
	display: block;
	padding-top: 6px;
	padding-left: 4px;
	padding-right: 4px;
	padding-bottom: 12px;
}

A.ALink:hover {
   color: #005A90;
	font-family: arial, verdana, helvetica;
	text-decoration: none;
	display: block;
	padding-top: 5px;
	padding-left: 3px;
	padding-right: 3px;
	padding-bottom: 11px;
	border: dashed #0000AA 1px;
}

/**********************************/
/***** Controls multilingues ******/
/**********************************/
.onglets_langues
{
	height:30px;
	border: 1px solid <?=$BorderColor?>/*#005295*/;
	border-width: 0px 0px 1px 0px;

}
* html .onglets_langues
{
	height:20px;
	padding: 0 0 0 0;
} 

.onglets_langues ul
{
	padding:0px;
	margin:0px;
}
.onglets_langues li
{
	top:1px;
	position:relative;
	float:left;
	list-style:none;
	margin:0px 8px 0px 0px;
	padding:5px;
	background-color:<?=$MenuBgColor?> /*#3374C7*/;
	border:1px solid <?=$BorderColor?>/*#005295*/;
}

.onglets_langues ul li.active 
{
	background-color:<?=$BackgroundColor?> /*#FFFFFF*/;
	border-bottom: 1px solid <?=$BackgroundColor?> /*#FFFFFF*/;
	border-left: 1px solid <?=$BorderColor?>/*#005295*/;
	color:blue;
}

.onglets_langues ul li a
{
	color:<?=$MenuFontColor?>/*#FFFFFF*/;
}
.onglets_langues ul li a:hover
{
	color:<?=$MenuFontColor?>/*#FFFFFF*/;
}

.onglets_langues ul li.active a
{
	color:<?=$MainFontColor?>/*#87919E*/;
}
.onglets_langues ul li.active a:hover
{
	color:<?=$MainFontColor?>/*#87919E*/;
}

.onglets_ctrls_multi
{
	clear:left;
	padding:20px;
	background:<?=$BackgroundColor?> /*#FFFFFF*/;
	border:1px solid <?=$BorderColor?>/*#005295*/;
	border-top:none
}

div.checkbox_select_multiple  {
  background:none repeat scroll 0 0;
  float:left;
  height:120px;
  margin:10px 0;
  overflow:auto;
  padding:0 0 5px;
  width:450px;
}
hr {
  border-bottom:0 none;
  border-top:1px solid #E5E5E5;
  clear:both;
  height:0;
  margin:1em 0;
}

/*MESSAGE CONTROL FORM*/
#msg {display:none; position:absolute; z-index:1200; background:url(../images/msg_arrow.gif) left center no-repeat; padding-left:7px}
#msgcontent {display:block; background:#f3e6e6; border:2px solid #924949; border-left:none; padding:5px; min-width:150px; max-width:250px}
