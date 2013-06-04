<?
//-----------------------------------------------------------------------------------------------------
function get_menu_gauche( $Rub, $navID, $db, $typeNav )
{

	$strFreres = "SELECT
   				n.id__nav, tr._nav, n.url_page
   		    FROM 
   		    	_nav n   		    	
   		    INNER JOIN
   		    	trad__nav tr on n.id__nav = tr.id___nav    		    	
   		    WHERE 
   		    	id__nav_pere = $Rub
   		    AND 
   		    	selected = 1 
   		    AND 
   		    	tr.id__langue = ".$_SESSION['ses_langue']."
   		    AND
   		    	id__type_nav = $typeNav ";			

	if($typeNav == _NAV_FOOTER){
		$strFreres .=" and id__nav_pere="._NAV_ACCUEIL;
	}

	$strFreres .=" ORDER BY ordre";

	if (!($rsFreres= $db->sql_query($strFreres))) {
		message_die(GENERAL_ERROR, 'Impossible d\'exécuter la requête', '', __LINE__, __FILE__, $strFreres);
	}

	$selected = 0;

	$nb_res = $db->sql_numrows($rsFreres);

	$i=0;
	$cpt=0;
	$attend = 1;
	$temp = 0;

	while($row = $db->sql_fetchrow($rsFreres))
	{
		$current = false;


		$cpt++;
		$i++;
		$id_itemN3 = $row[id__nav];
		$libelle_N3 =  $row[_nav];

		$url_n3 = $row[url_page];

		//Specif Ethic Etapes
		if ($_SESSION['ses_langue'] != _ID_FR)
		{
			if ($row[id__nav] == _NAV_ESPACE_MEMBRE)
			continue;

			if ($_SESSION['ses_langue'] != _ID_FR)
			{
				if ($row[id__nav] == _NAV_ESPACE_PRESSE)
				continue;
			}
		}


		if($typeNav != _NAV_FOOTER){
			$chaine =  "SELECT
   			n.id__nav, tr._nav, n.url_page
   		    FROM 
   		    	_nav n   		    	
   		    INNER JOIN
   		    	trad__nav tr on n.id__nav = tr.id___nav    		    	
   		    WHERE 
   		    	id__nav_pere = ".$row[id__nav]."
   		    AND 
   		    	selected = 1 
   		    AND 
   		    	tr.id__langue = ".$_SESSION['ses_langue']."
   		    ORDER BY ordre
   		    ";		

			if (!($RS2= $db->sql_query($chaine))) {
				message_die(GENERAL_ERROR, 'Impossible d\'exécuter la requête', '', __LINE__, __FILE__, $chaine);
			}


			while($row2 = $db->sql_fetchrow($RS2))
			{
				//Specif Ethic Etapes
				if ($_SESSION['ses_langue'] != _ID_FR)
				{
					if ($row2[id__nav] == _NAV_ESPACE_EMPLOI || $row2[id__nav] == _NAV_DEVENIR_EE)
					continue;
				}

				$chaine =  "SELECT
			   			n.id__nav, tr._nav, n.url_page
			   		    FROM 
			   		    	_nav n   		    	
			   		    INNER JOIN
			   		    	trad__nav tr on n.id__nav = tr.id___nav    		    	
			   		    WHERE 
			   		    	id__nav_pere = ".$row2[id__nav]."
			   		    AND 
			   		    	selected = 1 
			   		    AND 
			   		    	tr.id__langue = ".$_SESSION['ses_langue']."
			   		    ORDER BY ordre
			   		    ";		

				if (!($RS3= $db->sql_query($chaine))) {
					message_die(GENERAL_ERROR, 'Impossible d\'exécuter la requête', '', __LINE__, __FILE__, $chaine);
				}


				while($row3 = $db->sql_fetchrow($RS3)) {

					$chaine =  "SELECT
				   			n.id__nav, tr._nav, n.url_page
				   		    FROM 
				   		    	_nav n   		    	
				   		    INNER JOIN
				   		    	trad__nav tr on n.id__nav = tr.id___nav    		    	
				   		    WHERE 
				   		    	id__nav_pere = ".$row3[id__nav]."
				   		    AND 
				   		    	selected = 1 
				   		    AND 
				   		    	tr.id__langue = ".$_SESSION['ses_langue']."
				   		    ORDER BY ordre
				   		    ";			

					if (!($RS4= $db->sql_query($chaine))) {
						message_die(GENERAL_ERROR, 'Impossible d\'exécuter la requête', '', __LINE__, __FILE__, $chaine);
					}

					while($row4 = $db->sql_fetchrow($RS4)) {
						if ($row4[id__nav] == $_REQUEST['Rub']) $current = true;
						$item_menu_pro_n4 = array("url_lien_item_n4" => get_url_nav($row4[id__nav]), "libelle_lien_item_n4" => $row4[_nav]);
						$item_menu_n4[] = $item_menu_pro_n4;
					}

					// element N3 à dérouler ?
					if( !in_array( $row3[id__nav], $navID ) )
					{
						unset($item_menu_n4);
						//$item_menu_n4[] = array();
					}

					if ($row3[id__nav] == $_REQUEST['Rub']) $current = true;
					if ($row3[id__nav] == _NAV_OFFRE_EMPLOI_LISTE &&
					$_REQUEST['Rub'] == _NAV_OFFRE_EMPLOI_FICHE || $_REQUEST['Rub'] == _NAV_OFFRE_EMPLOI_CANDIDATURE) $current = true;

					//Specif Ethic Etapes
					if ($_SESSION['ses_langue'] != _ID_FR)
					{
						if (!in_array($row3[id__nav], $GLOBALS["_NAV_SEJOUR_V_ETRANGERE"]))
						continue;

						//En version étrangère on affiche obligatoirement les gammes de produits
						if (in_array($row3[id__nav], $GLOBALS["_NAV_SEJOUR_MOINS_18_ANS"]))
						$row3[id__nav] = _NAV_SEJOUR_MOINS_18_ANS;
						elseif (in_array($row3[id__nav], $GLOBALS["_NAV_SEJOUR_REUNION"]))
						$row3[id__nav] = _NAV_SEJOUR_REUNION;
						elseif (in_array($row3[id__nav], $GLOBALS["_NAV_SEJOUR_DECOUVERTE"]))
						$row3[id__nav] = _NAV_SEJOUR_DECOUVERTE;
					}



					$item_menu_pro_n3 = array("url_lien_item_n3" => get_url_nav($row3[id__nav]), "libelle_lien_item_n3" => $row3[_nav],"item_menu_n4" => $item_menu_n4);
					$item_menu_n3[] = $item_menu_pro_n3;

					// element N2 à dérouler ?
					//			if( !in_array( $row2[id__nav], $navID ) )
					//	        	{
					//	        	   unset($item_menu_n3);
					//	        	   //$item_menu_n3[] = array();
					//			}

					$item_menu_n4 = array();

				}
				$nb=0;
				if($row2[id__nav] == _NAV_CENTRES_NEW){
					$sql = "select count(*)as nb from centre where DATE_ADD(date_inscription, INTERVAL 6 MONTH) >= NOW() and etat=1";
					$result = mysql_query($sql);
					$nb = mysql_result($result,0,"nb");
				}else{
					$nb = 1;
				}
				
				if($nb>0){
					if ($row2[id__nav] == $_REQUEST['Rub']) $current = true;
					$item_menu_pro_n2 = array("url_lien_item_n2" => get_url_nav($row2[id__nav]), "libelle_lien_item_n2" => $row2[_nav],"item_menu_n3" => $item_menu_n3);
				
				//Specif Ethic Etapes
				if ($row[id__nav] == _NAV_ESPACE_MEMBRE && $_SESSION['user_connect_membre'] == '')
				continue;


				$item_menu_n2[] = $item_menu_pro_n2;

				$item_menu_n3 = array();
				}
			}

		}
		if ($id_itemN3 == $_REQUEST['Rub']) $current = true;
		$item_menu_pro_n1 = array("url_lien_item_n1" => get_url_nav($id_itemN3), "libelle_lien_item_n1" => mb_strtoupper($libelle_N3, "utf-8"), "num_item_n1" => $i,"item_menu_n2" => $item_menu_n2, "widesubMenu" => (($i == 1)? 1 : 0), "current" => $current, "nb_item_menu_n2" => count($item_menu_n2));

		$item_menu_n2 = array();
		$item_menu_n1[] = $item_menu_pro_n1;
	}	
	//trace($item_menu_n1);
	return $item_menu_n1;
}


?>
