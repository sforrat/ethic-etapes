<?
session_start();
// Fichiers généraux à tous les sites

if (isset($_SESSION['PATH_TO_INCLUDE']) && ($_SESSION['PATH_TO_INCLUDE']!=""))
{
   require $_SESSION['PATH_TO_INCLUDE']."local_param.inc.php"; // contient connexion mysql local
   require $_SESSION['PATH_TO_INCLUDE']."lib_local.inc.php"; 
}
else
{
	Redirect("../admin.php");
}

$path= _PATH_TO_APPLI;

include _PATH_TO_APPLI."/include/inc_header.inc.php";
include _PATH_TO_APPLI."/include/lib_titre_rub.inc.php";
?>

<script language="JavaScript">
window.resizeTo( 560, 800 );
</script>

<html>
<head>
<title>Preview</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript" src="../js/scripts.js"></script>
<BASE HREF="<?= _CONST_APPLI_URL ?>">
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="560">
<td><td>
<?		
	function get_retour_haut($field) 
	{
	    	$type = "gab_retour_haut";
	
	    	$template_top = new Template( _PATH_TO_APPLI."/include_tpl".$_SESSION['ses_langue_ext_sql'] );
	
	    	if( $field )
	    	{
	        	$template_top->set_filenames( array( $type => $type.".inc" ) );
	        	$template_top->assign_vars( array( "ID" => get_uid() ) );
	        	$template_top->pparse( $type );
	    	}
	}




	$StrSql = "SELECT item FROM _table_def WHERE id__table_def=".$TableDef;
	$Res = mysql_query( $StrSql );
	
	$template = new Template( _PATH_TO_APPLI."/include_tpl".$_SESSION['ses_langue_ext_sql'] );
	
	$type = mysql_result( $Res, 0, "item" );
	
	$template->set_filenames( array( $type => $type.".inc" ) );
	
	
	$StrSql1 = "SELECT * FROM ".$type." WHERE id_".$type." = 1";
	$Res1 = mysql_query( $StrSql1 );
	
	
	for( $i = 0; $i < mysql_num_fields( $Res1 ); $i++ )
	{
		$field1 = "";
		$field = mysql_field_name( $Res1, $i );
		$n = strrpos( $field, "_" );
		$tmp = substr( $field, $n + 1 );
		if( is_numeric( $tmp ) )
			$field1 = substr( $field, 0, $n );
		
		
		if( $field == "img" )
		{
		    	if( $_POST["choose_img_type_field_img"] == 1 )
		    		$nom_image = $_POST["field_img_port"];
		    	else
		    		$nom_image = $FILE["field_img"]["name"];
		    		
			if( is_numeric( $nom_image ) )
		    	{
		        	$img_dir        = "portfolio_img";
		        	$nom_image      = get_portfolio_img( $nom_image );
		        	$donnees[IMG]   = get_img( $nom_image, _CONST_APPLI_URL."images/upload/".$img_dir."/", "", 147, 117 );
		    	}
		    	else 
		    	{	        	
		        	$img_dir = _CONST_APPLI_URL."images/upload/tmp/";
		        	$nom_image = $_FILES["field_img"]["name"];
		        	
		        	move_uploaded_file( $_FILES["field_img"]["tmp_name"], _PATH_TO_APPLI."images/upload/tmp/".$nom_image );
		        	
		 	       	$donnees[IMG]   = get_img( $nom_image, $img_dir, "", 147, 117 );
		    	}
		}
		elseif( ( $field == "id_gab_contact" ) )
		{
		    	$list_contact_lie = $_POST["field_id_gab_contact"];
	
		    	reset( $list_contact_lie );
		
		    	foreach( $list_contact_lie as $value )
		    	{					
				$strSQL_contact = "
						SELECT 
							gab_contact.*
						FROM
							gab_contact
						WHERE
							id_gab_contact = \"".$value."\"
		                		AND 
		                        		id_gab_contact !=1
						LIMIT 1
						"; 
				
				$rstContacts = mysql_query( $strSQL_contact );
							
				if( mysql_numrows( $rstContacts) > 0 )
				{
					$compteur++;
		            $civilite = mysql_result( $rstContacts, 0, "civilite_6" );
		                                             
		            if( get_libLocal( $civilite ) != "" )
		            {
						$donnees[CIVILITE] = get_libLocal( $civilite );
					}
		            else
		            {
						$donnees[CIVILITE] = $civilite;
					}
		
		            $champ_nom = "nom".$_SESSION['ses_langue_ext_sql'];
		            $donnees[NOM] = mysql_result( $rstContacts, 0, $champ_nom );
		            if( $donnees[NOM] == "" )
		            { 
						$donnees[NOM] = mysql_result( $rstContacts,0, "nom" );
		            }                            
		          	  	
		          	$donnees[PRENOM] 	= mysql_result( $rstContacts, 0, "prenom" );
		          	$champ_poste = "poste".$_SESSION['ses_langue_ext_sql'];
		                $donnees[POSTE] 	= ( mysql_result( $rstContacts, 0, $champ_poste ) != ""?"<br>".mysql_result( $rstContacts, 0, $champ_poste )."<br>":"" );
		          	$donnees[TELEPHONE] 	= ( mysql_result( $rstContacts, 0, "telephone" ) != ""?"<br>T&eacute;l. : ".mysql_result( $rstContacts, 0, "telephone" ):"" );
		          	$donnees[FAX] 		= ( mysql_result( $rstContacts, 0, "fax" ) != ""?"<br>Fax : ".mysql_result( $rstContacts, 0, "fax" )."<br>":"" );
		          	$donnees[EMAIL] 	= ( mysql_result( $rstContacts, 0, "email" ) != ""?"<br>Mail : <a href=\"mailto:".mysql_result( $rstContacts, 0, "email" )."\">".mysql_result( $rstContacts, 0, "email" )."</a><br>":"" );
		                $donnees[ADRESSE] 	= "<br>".mysql_result( $rstContacts, 0, "adresse" );
		                  
		            		
		            if( $type == "gab_event" )
						$template->assign_block_vars("bloc_contact", $donnees );
					else
		            {
						// a gauche, ou a droite ?...
				    	if( $compteur % 2 )
			  	    	{
							$template->assign_block_vars( "ligne", $donnees );
							$template->assign_block_vars( "ligne.contact_gauche", $donnees );
						}
				    	else
				    	{
			           		$template->assign_block_vars( "ligne.contact_droit", $donnees );
			            }
					}
				}
		   	}
		}
		elseif( ( $type != "gab_title" ) && ( $field == "titre" ) && ( $_POST["field_".$field] ) )
	    {
			$template->assign_block_vars( "bloc_titre", array( "TITRE" => stripslashes( $_POST["field_titre"] )) );
		}
		else
		{
			if( is_array( $_POST["field_".$field] ) )
			{
				foreach( $_POST["field_".$field] as $Val )
				{
					if( $field1 )
					{	
						$donnees[strtoupper( $field1 )] = $Val;
						$field1 = "";
					}
					else
					{
						$donnees[strtoupper( $field )] = $Val;
					}
				}
			}
			else
			{
				if( $field1 )
				{
					$donnees[strtoupper( $field1 )] = stripslashes($_POST["field_".$field]);
					$field1 = "";
				}
				else
				{
					$donnees[strtoupper( $field )] = stripslashes($_POST["field_".$field]);
				}
			}
		}
	}
	
	if( $type == "gab_contact" )
	{
		$template->assign_block_vars( "ligne", $donnees );
		$template->assign_block_vars( "ligne.contact_gauche", $donnees );
	}
	else	 
		$template->assign_vars( $donnees );   	
	
	$template->pparse( $type );

	if( $_POST["field_retour_haut"] )
		get_retour_haut( true );

?>
</td></tr></table>
</body>
 </html>
