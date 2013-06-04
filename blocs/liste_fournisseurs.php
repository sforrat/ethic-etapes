<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	AHE 							  
/*	Date : 		
/*	Version :	1.0							  
/*	Fichier :	liste_fournisseurs.php						  
/*										  
/*	Description :	Listes des fournisseurs pour l'espace memebre                    
/*										  
/**********************************************************************************/

// Initialisation de la page
$path="./";

if ($_REQUEST['Rub'] == _NAV_REF_FOURNISSEUR)
{
	//On récupère toutes les catégories
	$sql = "SELECT cat.id_em_ref_fournisseur_categorie, tcat.libelle FROM em_ref_fournisseur_categorie cat  
			inner join trad_em_ref_fournisseur_categorie tcat on (id__langue=".$_SESSION['ses_langue']." and cat.id_em_ref_fournisseur_categorie = tcat.id__em_ref_fournisseur_categorie)
			ORDER BY tcat.libelle ASC";
	
	$rstFC = mysql_query($sql);
	
	if (!$rstFC)
		echo mysql_error().' - '.$sql;
	else 
	{
		$nbFCat = mysql_num_rows($rstFC);
		for ($i = 0 ; $i < $nbFCat ; $i++)
		{
			$idFCat = mysql_result($rstFC, $i, 'id_em_ref_fournisseur_categorie');
			
			$sql = "SELECT id_em_ref_fournisseur, logo, societe, presentation FROM em_ref_fournisseur WHERE id_em_ref_fournisseur_categorie = ".$idFCat." ORDER BY societe ASC";
			$rstF = mysql_query($sql);
			if (!$rstF)
				echo mysql_error().' - '.$sql;
			else 
			{
				$nbF = mysql_num_rows($rstF);
				
				$listeF = array();
				for ($j = 0 ; $j < $nbF ; $j++)
				{
					$paramUrl[0] = array('id_name' => 'idF', 'id' =>mysql_result($rstF, $j , 'id_em_ref_fournisseur') );
					$listeF[] = array  ('id' => mysql_result($rstF, $j , 'id_em_ref_fournisseur'),
										'libelle' => mysql_result($rstF, $j, 'societe'),
										'logo' => getFileFromBDD(mysql_result($rstF, $j, 'logo'),"em_ref_fournisseur"),
										'description' => mysql_result($rstF, $j, 'presentation'),
										'lien' => get_url_nav(_NAV_INFOS_FOURNISSEUR, $paramUrl));
				}
			
				$listeFCat[] = array ('id' => $idFCat,
									'libelle' => mysql_result($rstFC, $i, 'libelle'),
									'lien' => get_url_nav($_REQUEST['Rub']).'#'.mysql_result($rstFC, $i, 'libelle'),
									'fournisseurs' => $listeF);					
					
			}			
			
		}

		
		
	}



	$this -> assign ('listeFCat', $listeFCat);	
	$this -> display('blocs/liste_fournisseurs.tpl');
}
?>