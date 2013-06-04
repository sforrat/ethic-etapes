<?
session_start();
require "library/fonction.inc.php";
require "library_local/lib_global.inc.php";

connection();

require "library_local/lib_local.inc.php";
require "library_local/lib_language.inc.php";
require "library/lib_tools.inc.php";
require "library/lib_bo.inc.php";
require "library/class_bo.inc.php";
require "library/class_SqlToTable.inc.php";
require "library/lib_design.inc.php";

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

get_arbo(1, "&nbsp;&nbsp;",0,$arr_user_nav_right,get_inter_color($MenuBgColor,0.8),3,0,1);
?>