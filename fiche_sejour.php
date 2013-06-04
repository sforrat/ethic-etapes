<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	AHE 							  
/*	Date : 		MAI 2010
/*	Version :	1.0							  
/*	Fichier :	sejour.php						  
/*										  
/*	Description :	Page sejour
/**********************************************************************************/

// Initialisation de la page
$path="./";
require($path."include/inc_header.inc.php");


// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");

	//$params['id_sejour'] = $_REQUEST['id']; // valeur manifestement ecrasee par un $_POST lors de l'utilisation d'un moteur "affinez votre recherche"
	$params['id_sejour'] = $_GET['id'];
	
	$listeInfoG = array();
	
	//*INFOS GENERALISTES (ne demandant pas de traitement special)
	getListeSejour($GLOBALS['Rub'], $listeRes, $params);
	
	if($listeRes[0]["nom_centre"] != ""){
		$template->assign('nom_centre',$listeRes[0]["nom_centre"]);
		$_SESSION['nom_centre'] = $listeRes[0]["nom_centre"];
	}else{
		$template->assign('nom_centre',$listeRes[0]["libelle"]);
		$_SESSION['nom_centre'] = $listeRes[0]["libelle"];
	}
	
	$template->assign('url_centre',get_url_nav_centre(_NAV_FICHE_CENTRE,$listeRes[0]["id_centre"]));
	
	$listeRes[0]["libelle"] = mb_strtoupper($listeRes[0]["libelle"],"utf-8");
	$template -> assign ('sejour', $listeRes[0]);
	
	if($_REQUEST['Rub'] == _NAV_ACCUEIL_GROUPES_SCOLAIRES){
		$template -> assign ('presentation_region', $listeRes[0]['presentation_region']);
	}	
	$template -> assign ('ville', mb_strtoupper($listeRes[0]['ville'],'utf-8'));
	$template -> assign ('region', stripAccents((strtolower(str_replace('-', '_',(str_replace(' ', '_',utf8_decode($listeRes[0]['region']))))))));	
	
	if ($listeRes[0]['id_centre_detention_label'] != '')
	{
		$params['id'] = split(",",$listeRes[0]['id_centre_detention_label']);
		
		$visuel_label = getCentreLabels($params);
	
		if ($visuel_label['ecolabel'])
			$template -> assign ('ecoLabel', true);
			
		$visuel_label = $visuel_label['label'];
	}
	$template -> assign ('title_label', get_libLocal('lib_'.$visuel_label));
	$template -> assign ('label', $visuel_label);
	$template -> assign ('urlContact', 'form_sejour_contact.php?Rub='.$_REQUEST['Rub'].'&id='.$params['id_sejour'].'&id_centre='.$listeRes[0]['id_centre']);
	
	if ($listeRes[0]['id_sejour_theme_seminaire'] != '')
	{
		$themes = explode(',', $listeRes[0]['id_sejour_theme_seminaire']);
		if(in_array(_CONST_SEJOUR_SEMINAIRE_THEME_VERT, $themes))
		{
			$template->assign('picto_seminaire_vert', true);
		}
	}
	
	//---------------------------------------------------
	//				COLONNE GAUCHE
	//---------------------------------------------------
	//trace($listeRes[0]);
	//*LES IMAGES
	$template -> assign ('nbImage', count($listeRes[0]['liste_image']));
	$template -> assign ('listeImage', $listeRes[0]['liste_image']);
	
	//*LES + SEJOURS
	$nbPlus = getSejourPlus($GLOBALS['Rub'], $params['id_sejour'], $listePlus);
	$template -> assign ('nbPlus', $nbPlus);
	$template -> assign ('listePlus', $listePlus);	
	
	if($_REQUEST["Rub"] == _NAV_ACCUEIL_SPORTIF){
		//*LES Sports adaptés
		$nbSport = getSport($GLOBALS['Rub'], $params['id_sejour'], $listeSport);
		$template -> assign ('nbSport', $nbSport);
		$template -> assign ('listeSport', $listeSport);	
	}
	
	//*AUTRES INFOS (demandant de traitement spécial)
	if (isset($listeRes[0]['nom_centre']))
		$template -> assign ('nomCentre', $listeRes[0]['nom_centre']. " - ");

	
    $arraySejourInfo = array ('niveau_scolaire', 'tranche_age', 'periode_disponibilite', 'accueil_handicap');
	foreach ($arraySejourInfo as $info)
	{
		if (isset($listeRes[0]['id_sejour_'.$info]))
		{
			$params['id'] = split(",",$listeRes[0]['id_sejour_'.$info]);
			$nbNvScolaire = getListeSejourInfos($info,$liste,$params);	
			
			$listeInfoG[] = array (	"nom" => mb_strtoupper(get_libLocal('lib_'.$info),"utf-8"),
									"array" => $liste);
		}
	}
	
	if ($_REQUEST['Rub'] != _NAV_CLASSE_DECOUVERTE && $_REQUEST['Rub'] != _NAV_ACCEUIL_REUNIONS)
	{
		$listeInfoCentre = array();
		$arrayCentreInfo = array ("nb_lit", "nb_couvert", "nb_chambre");
		foreach ($arrayCentreInfo as $info)
		{
			if (isset($listeRes[0][$info]))
			{
				$listeInfoCentre[] = array("libelle" => get_libLocal('lib_'.$info)." : ".$listeRes[0][$info]);
			}		
		}
			$listeInfoG[] = array (	"nom" => mb_strtoupper(get_libLocal('lib_capacite_accueil'),"utf-8"),
									"array" => $listeInfoCentre);		
	}	
	if (isset($listeRes[0]['nb_salle_reunion']) && $listeRes[0]['nb_salle_reunion']>0)
	{				
		$SallePersonne = str_replace("XXminXX", ($listeRes[0]['capacite_salle_min'] == "" ? 0 : $listeRes[0]['capacite_salle_min']), get_libLocal('lib_salle_de_a_personne'));
		$SallePersonne = str_replace("XXmaxXX", $listeRes[0]['capacite_salle_max'], $SallePersonne);
		
		$listeSalleReu[] = array("libelle" => get_libLocal('lib_nombre_salle')." : ".$listeRes[0]['nb_salle_reunion']);
		$listeSalleReu[] = array("libelle" => $SallePersonne);
		
		//**NB SALLE REUNION			
		$listeInfoG[] = array (	"nom" => mb_strtoupper(get_libLocal('lib_capacite_accueil'),"utf-8"),
								"array" => $listeSalleReu);		
	}	
		
	if (isset($listeRes[0]['adapte_IME_IMP_4']))
	{		
		if ($listeRes[0]['adapte_IME_IMP_4'] == 'Oui')		
		{
			$liste[] = array("libelle" => get_libLocal('lib_adapte_ime_imp_4'));
			
			//**NB SALLE REUNION			
			$listeInfoG[] = array (	"nom" => "",
									"array" => $liste);		
		}
	}		
		
	
	if ($GLOBALS['Rub'] == _NAV_ACCEUIL_REUNIONS)	
	{
		//*DATES DE VALIDITE
		$nbDateA = getSejourMateriel("accueil_reunions", $params['id_sejour'], $listeMateriel);	
		
		
		$listeInfoG[] = array (	"nom" => mb_strtoupper(get_libLocal('lib_service_reunion'),"utf-8"),
								"array" => $listeMateriel);			
	}
	
	
	
	
	if ($GLOBALS['Rub'] == _NAV_CVL)	
	{
		//*DATES DE VALIDITE
		$nbDateA = getSejourDateAccessible(_NAV_CVL, $params['id_sejour'], $listeDateA);	
		for ($i = 0 ; $i < $nbDateA ; $i++)
			$listeDate[]["libelle"] = $listeDateA[$i]['date_debut'] . ' - '.$listeDateA[$i]['date_fin'];
		
		$listeInfoG[] = array (	"nom" => mb_strtoupper(get_libLocal('lib_periode_disponibilite'),"utf-8"),
								"array" => $listeDate);			
	}
			
	$template -> assign ('nbInfoG', count($listeInfoG[0]["array"]));
	$template -> assign ('listeInfoG', $listeInfoG);

	if ($_REQUEST['Rub'] == _NAV_ACCUEIL_INDIVIDUEL)
	{
		// URL HostelWorld renseign�e ?
		if(isHostelWorld($listeRes[0]["id_centre"]))
			$template -> assign ('isHostelworld', true);
		else
			$template -> assign ('isHostelworld', false);
			
		$template -> assign ('urlReservation', 'form_reservation_accueil_individuel.php?Rub='.$_REQUEST['Rub'].'&id_centre='.$listeRes[0]['id_centre'].'&id_sejour='.$params['id_sejour']);
	}
	
	//---------------------------------------------------
	//				COLONNE DROITE
	//---------------------------------------------------	
	
	$listeInfoD = array(); 
	
	//**Onglet Les activités et équipements touristiques / Accueil de Groupe
	if ($_REQUEST['Rub'] == _NAV_ACCUEIL_GROUPE || $_REQUEST['Rub'] == _NAV_ACCUEIL_SPORTIF || $_REQUEST['Rub'] == _NAV_ACCUEIL_INDIVIDUEL)
	{
		if ($_REQUEST['Rub'] == _NAV_ACCUEIL_GROUPE || $_REQUEST['Rub'] == _NAV_ACCUEIL_INDIVIDUEL)
		{
			$params['id'] = split(",",$listeRes[0]['id_centre_activite']);
			$nbCActivite = getListeCentreInfos('activite',$listeCActivite,$params);
			if ($nbCActivite > 0)
			{
				$texte .= '<span class="titleSlider">'.get_libLocal('lib_activite')."</span> : <br />";
				foreach ($listeCActivite as $acctivite)
					$texte .= '<img alt="'.$acctivite["libelle"].'" title="'.$acctivite["libelle"].'" src="'.getPicto($acctivite["id"],"centre_activite").'" class="tooltipped" />';
				$texte .= '<br/><br/>';
			}		
		}
		$params['id_centre'] = array($listeRes[0]['id_centre']);
		$nbEquipement = getListeCentreEquipement($listeEquipement, $params);	
		if ($nbEquipement > 0)
		{
			$texte .= '<span class="titleSlider">'.get_libLocal('lib_equipement_sportif_loisir').' :</span><ul>';
			foreach ($listeEquipement as $equipement => $value)
			{
				if ($value['surplace'] == 1)
					$texte .= '<li>'.get_libLocal('lib_'.$equipement). " : ".get_libLocal('lib_sur_place')."</li>";
					
				if ($value['proche'] == 1)
					$texte .= '<li>'.get_libLocal('lib_'.$equipement). " : ".str_replace('xxDISTANCExx',$value['distance'], get_libLocal('lib_a_km') )."</li>";						
			}
			$texte .= '</ul>';
		}

		if ($_REQUEST['Rub'] == _NAV_ACCUEIL_SPORTIF)
		{
			$params['id'] = split(",",$listeRes[0]['id_sejour_services_sportifs']);
			$nbServices = getListeSejourInfos('services_sportifs', $listeServices, $params);
			if ($nbServices > 0)
			{
				$texte .= '<br/><strong>'.get_libLocal('lib_service_special_sportif').' :</strong><ul>';
				foreach ($listeServices as $service)
					$texte .= '<li>'.$service["libelle"].'<li>';
				$texte .= '</ul>';
			}
			
			if ($listeRes[0]['commentaire_accueil_sportifs'] != '')
			{
				$texte .= '<br/>'.$listeRes[0]['commentaire_accueil_sportifs'];
			}

			if ($listeRes[0]['sports_adaptes_FFH_4'] == 'Oui' && $_SESSION['ses_langue'] == 1)
			{
				// On affiche seulement en FR
				$texte .= '<br/><strong>'.get_libLocal('lib_centre_adapte').'</strong> : <br/>';
				$texte .= $listeRes[0]['sports_adaptes_FFH_libelle'];
			}		
		}

		$listeInfoD[] = array (	"nom" => get_libLocal('lib_activite_equipement_touristique'),
								"texte" => $texte);				
								
								
								
										
	}
	
	//**Onglet Exemples de séjour sportif / Accueil de Sportif
	if ($_REQUEST['Rub'] == _NAV_ACCUEIL_SPORTIF)
	{
		$texte = "";
		
		$arrayForfait = array ('sejour_preparation', 'sejour_rentree', 'sejour_oxygenation', 'forfait_autre');
		foreach ($arrayForfait as $forfait)
		{
			if ($listeRes[0][$forfait] == 1 && $listeRes[0][$forfait.'_commentaire'] != '')
				$texte .= '<strong>'.get_libLocal('lib_'.$forfait).' :</strong><br/>'.$listeRes[0][$forfait.'_commentaire'].'<br/>';
				
		}
		
			$listeInfoD[] = array (	"nom" => get_libLocal('lib_exemple_sejour_sportif'),
										"texte" => $texte);			
	}
	
	
	//**Onglet Le déroulement su séjour - Séjours touristique groupe
	if ($_REQUEST['Rub'] == _NAV_SEJOURS_TOURISTIQUES_GROUPE && $listeRes[0]['details'] != '')
	{
		$listeInfoD[] = array (	"nom" => get_libLocal('lib_deroulement_sejour'),
									"texte" => $listeRes[0]['details']);	
	}
	
	//**Onglet Interet pédagogique - Classe de découverte
	if (isset($listeRes[0]['interet_pedagogique']))
	{
		$listeInfoD[] = array (	"nom" => get_libLocal('lib_interet_pedagogique'),
									"texte" => $listeRes[0]['interet_pedagogique']);		
	}
			
	//**Onglet descriptif du séminaire / Séminaires
	if (isset($listeRes[0]['description_complete']) && $listeRes[0]['description_complete'] != '')
	{
		$listeInfoD[] = array (	"nom" => get_libLocal('lib_descriptif_seminaire'),
								"texte" => $listeRes[0]['description_complete']);		
	}
	
	//**Onglet Le déroulement du stage / Stage thématiques groupes
	if (($_REQUEST['Rub'] == _NAV_STAGES_THEMATIQUES_GROUPE || $_REQUEST['Rub'] == _NAV_STAGES_THEMATIQUES_INDIVIDUEL) && $listeRes[0]['description'] != '')
	{
$sql_S = "SELECT 
					trad_sejour_detail.jour,
					trad_sejour_detail.activite
				FROM
					trad_sejour_detail
				INNER JOIN 
					sejour_detail ON (	trad_sejour_detail.id__langue=".$_SESSION["ses_langue"]." AND 
								trad_sejour_detail.id__sejour_detail = sejour_detail.id_sejour_detail AND 
								sejour_detail.IdSejour=".$_GET["id"]." )
				order by 
					sejour_detail.id_sejour_detail ASC";
		$result_S = mysql_query($sql_S);
		$txt="";
		while($myrow_S = mysql_fetch_array($result_S)){
			$txt .= "<b>".$myrow_S["jour"]." :</b><br />".$myrow_S["activite"]."<br />";
		}
		
		$listeInfoD[] = array (	"nom" => get_libLocal('lib_deroulement_stage'),
								"texte" => $txt);	
	}
	
	
	//**Onglet Lieu du séjour - Classe de découverte / Seminaires / Stages thématique groupe
	if (isset($listeRes[0]['presentation']))
	{
		
		
		
		
			$texte = $listeRes[0]['presentation'];
		
		
		
		$texte .='<br/><br/>'.
											'<span class="bullet" style="font-weight: bold;">'.get_libLocal('lib_nb_chambre')." : </span>".$listeRes[0]['nb_chambre'].'<br/>'.
											'<span class="bullet" style="font-weight: bold;">'.get_libLocal('lib_nb_couvert')." : </span>".$listeRes[0]['nb_couvert'].'<br/>'.
											'<span class="bullet" style="font-weight: bold;">'.get_libLocal('lib_nb_lit')." : </span>".$listeRes[0]['nb_lit'].'<br/>';
		if($_REQUEST['Rub'] == _NAV_SEMINAIRES)
		{
			$texte.= '<span class="bullet" style="font-weight: bold;">'.get_libLocal('lib_nombre_salle')." : </span>".$listeRes[0]['nb_salle_reunion'].'<br/>';
		}

		$params['id'] = split(",",$listeRes[0]['id_centre_service']);
		$nbCService = getListeCentreInfos('service',$listeCService,$params);
		if ($nbCService > 0)
		{
			$texte .= '<br/><span class="titleSlider">'.get_libLocal('lib_service')."</span> : <br />";
			foreach ($listeCService as $service)
				$texte .= '<img alt="'.$service["libelle"].'" title="'.$service["libelle"].'" src="'.getPicto($service["id"],"centre_service").'" class="tooltipped" />';
			$texte .= '<br/>';
		}
		
		if (($_REQUEST['Rub'] == _NAV_CLASSE_DECOUVERTE || $_REQUEST['Rub'] == _NAV_SEMINAIRES || 
		$_REQUEST['Rub'] == _NAV_SEJOURS_TOURISTIQUES_GROUPE || $_REQUEST['Rub'] == _NAV_STAGES_THEMATIQUES_GROUPE ||
		$_REQUEST['Rub'] == _NAV_SHORT_BREAK || $_REQUEST['Rub'] == _NAV_STAGES_THEMATIQUES_INDIVIDUEL) && $listeRes[0]['id_centre_activite'] != '')
		{
			$params['id'] = split(",",$listeRes[0]['id_centre_activite']);
			$nbCActivite = getListeCentreInfos('activite',$listeCActivite,$params);
			if ($nbCActivite > 0)
			{
				//trace($listeCActivite);
				$texte .= '<br/><span class="titleSlider">'.get_libLocal('lib_activite')."</span> : <br />";
				foreach ($listeCActivite as $acctivite){
					$texte .= '<img alt="'.$acctivite["libelle"].'" title="'.$acctivite["libelle"].'" src="'.getPicto($acctivite["id"],"centre_activite").'" class="tooltipped" />';
				
				}
				$texte .= '<br/>';
			}		
		}
		
		/*
if ($listeRes[0]['nb_salle_reunion'] != '')
			$texte .= '<br/><span class="bullet" style="font-weight:bold;">'.get_libLocal('lib_nb_salle_reunion')." : </span>".$listeRes[0]['nb_salle_reunion'].'<br/>';

*/												
		$listeInfoD[] = array (	"nom" => get_libLocal('lib_lieu_sejour'),
								"texte" => $texte);		
	}	
	
	//**Onglet Tarifs - Classe de découverte / Accueil Réunion
	if (isset($listeRes[0]['a_partir_de_prix']))
	{
		$texte = '<span class="price_sejour">';
		if ($listeRes[0]['duree_sejour'] != '')
			$texte .= '<em>'.$listeRes[0]['duree_sejour'].'</em>';	
		elseif($listeRes[0]['nb_jours'] != '' && $listeRes[0]['nb_nuits'] != '')
			$texte .= '<em>'.$listeRes[0]['nb_jours'].' '.get_libLocal('lib_jours').' / '.$listeRes[0]['nb_nuits'].' '.get_libLocal('lib_nuits').'</em>';
		$texte .= get_libLocal('lib_a_partir_de').' <strong>'.$listeRes[0]['a_partir_de_prix']."<sup>&euro;</sup></strong> ";
		if($_REQUEST['Rub'] == _NAV_STAGES_THEMATIQUES_INDIVIDUEL || $_REQUEST['Rub'] == _NAV_STAGES_THEMATIQUES_GROUPE 
		|| $_REQUEST['Rub'] == _NAV_SEMINAIRES)
		{
			$texte .= get_libLocal('lib_par_participant');
		}
		elseif($_REQUEST['Rub'] == _NAV_SHORT_BREAK || $_REQUEST['Rub'] == _NAV_SEJOURS_TOURISTIQUES_GROUPE)
		{
			$texte .= get_libLocal('lib_par_personne');
		}
		elseif($_REQUEST['Rub'] == _NAV_CVL)
		{
			$texte .= get_libLocal('lib_par_enfant');
		}
		$texte .= (isset($listeRes[0]['prix_par_29']) ? ' <small>('.$listeRes[0]['prix_par_29'].')' : '').'</small><br/>';
		
		$texte .='</span>';	
		$texte .= '<span class="bullet" style="font-weight:bold;">'.get_libLocal('lib_prix_comprend').' : </span>'.$listeRes[0]['prix_comprend'].'<br/>'.
				  '<span class="bullet" style="font-weight:bold;">'.get_libLocal('lib_prix_ne_comprend_pas').' : </span>'.$listeRes[0]['prix_ne_comprend_pas'];
		
		$params['id'] = split(",",$listeRes[0]['id_sejour_nb_lit__par_chambre']);
		$nbSNbLit = getListeSejourInfos('nb_lit__par_chambre',$listeSNbLit,$params);	
		if ($nbSNbLit > 0)										
		{
			$texte .= '<br/><br/><ul><strong>'.get_libLocal('lib_nb_lit__par_chambre').' :</strong>';
			foreach ($listeSNbLit as $nblit)
			{
				$texte .= '<li>'.$nblit['libelle'].'</li>';
			}
			$texte .= '</ul>';
		}
		
		$listeInfoD[] = array (	"nom" => get_libLocal('lib_tarifs'),
								"texte" => $texte);		
	

	}	
		
	//**Onglet Les activités au centre - Accueil de scolaire
	if ($_REQUEST['Rub'] == _NAV_ACCUEIL_GROUPES_SCOLAIRES)
	{
		$texte = "";
		$nbLoisir = getSejourLoisirDispo(_NAV_ACCUEIL_GROUPES_SCOLAIRES, $params['id_sejour'], $listeLoisir);
		if ($nbLoisir > 0)
		{
			foreach ($listeLoisir as $loisir)
				$texte .= '<span class="bullet" style="font-weight:bold;">'.$loisir['libelle'].'</span> ('.$loisir['prix'].'&euro;) : '.$loisir['commentaire'].'<br/>';
		}	
		$listeInfoD[] = array (	"nom" => get_libLocal('lib_activite'),
									"texte" => $texte);			
	}		
	
	//**Onglet Agréments - Classe de découverte / Accueil de scolaire
	if (isset($listeRes[0]['agrement_edu_nationale_4']))
	{
		$texte = "";
		
		$arrayAgrement = array("agrement_edu_nationale", "agrement_jeunesse", "agrement_tourisme", 
								"agrement_ddass", "agrement_formation", "agrement_ancv", "agrement_autre");
		
		foreach ($arrayAgrement as $agrement)
		{
			if ($listeRes[0][$agrement.'_4'] == 'Oui' && $listeRes[0][$agrement.'_texte']!="")
			{
				$texte .= '<span class="bullet" style="font-weight:bold;">'.get_libLocal('lib_'.$agrement).'</span> : '.$listeRes[0][$agrement.'_texte']."<br/>";
			}
		}		
		$listeInfoD[] = array (	"nom" => get_libLocal('lib_agrement'),
								"texte" => $texte);	
	}	
		
	//** Tarifs - Accueil Scolaire
	if ($_REQUEST['Rub'] == _NAV_ACCUEIL_GROUPES_SCOLAIRES || $_REQUEST['Rub'] == _NAV_ACCUEIL_GROUPE || 
		$_REQUEST['Rub'] == _NAV_ACCUEIL_SPORTIF || $_REQUEST['Rub'] == _NAV_ACCUEIL_INDIVIDUEL)
	{
		getSejourTarifGroupe($_REQUEST['Rub'], $params['id_sejour'], $listeTarif);
		getSejourTarifGroupePlus1($_REQUEST['Rub'], $params['id_sejour'], $listeTarifPlus1);
		
		$arraySaison = array("HS" => get_libLocal('lib_haute_saison'), 
							 "MS" => get_libLocal('lib_moyenne_saison'), 
							 "BS" => get_libLocal('lib_basse_saison'));	
							 
		$arrayPension = array("bb" => get_libLocal('lib_bed_breakfast'), 
							  "dp" => get_libLocal('lib_demi_pension'), 
							  "pc" => get_libLocal('lib_pension_complete'), 
							  "rs" => get_libLocal('lib_repas_seul'));		
		
							  
		$texte = '<table class="priceList"><tr><td class="emptyCell"></td>';
		foreach ($arrayPension as $pension => $libelle)
			$texte .= "<th>".mb_strtoupper($libelle, 'utf-8')."</th>";
		$texte .= "</tr>";
				
			foreach ($arraySaison as $saison => $libelle)
			{
				$texte .= "<tr>";
				$texte .= "<th>".mb_strtoupper($libelle, 'utf-8')."</th>";
				foreach ($arrayPension as $pension => $libelle)
					if($listeTarif[$saison."_".$pension]>0){
						$texte .= "<td>".$listeTarif[$saison."_".$pension]."&euro;</td>";
					}else{
						$texte .= "<td>&nbsp;</td>";
					}
				$texte .= "</tr>";
			}		
			$texte .= "</table>";
			
			if($_REQUEST['Rub'] == _NAV_ACCUEIL_INDIVIDUEL || $_REQUEST['Rub'] == _NAV_ACCUEIL_SPORTIF 
			|| $_REQUEST['Rub'] == _NAV_ACCUEIL_GROUPE || $_REQUEST['Rub'] == _NAV_ACCUEIL_GROUPES_SCOLAIRES)
			{
				$texte .= get_libLocal('lib_prix_a_partir_de').'<br/>';
			}
			
			$texte.= "<br/>";
			
			if ($listeRes[0]['haute_saison'] != '')
				$texte .= get_libLocal('lib_haute_saison').' : '.$listeRes[0]['haute_saison'].'<br/>';
			if ($listeRes[0]['moyenne_saison'] != '')
				$texte .= get_libLocal('lib_moyenne_saison').' : '.$listeRes[0]['moyenne_saison'].'<br/>';
			if ($listeRes[0]['basse_saison'] != '')
				$texte .= get_libLocal('lib_basse_saison').' : '.$listeRes[0]['basse_saison'].'<br/>';
					
				if($listeTarifPlus1['HS_bb'] > 0 || $listeTarifPlus1['HS_dp'] > 0 || $listeTarifPlus1['HS_pc'] > 0 || $listeTarifPlus1['HS_rs'] > 0 || 
		$listeTarifPlus1['MS_bb'] > 0 || $listeTarifPlus1['MS_dp'] > 0 || $listeTarifPlus1['MS_pc'] > 0 || $listeTarifPlus1['MS_rs'] > 0 || 
		$listeTarifPlus1['BS_bb'] > 0 || $listeTarifPlus1['BS_dp'] > 0 || $listeTarifPlus1['BS_pc'] > 0 || $listeTarifPlus1['BS_rs'] > 0)
		{
			//$texte .= '<br/><a href="#" class="btn btn_green" onClick="javascript:window.open(\'fiche_centre_tarifs.php?n1=1&t='._NAV_ACCUEIL_GROUPES_SCOLAIRES.'&id_centre='.$listeRes[0]['id_centre'].'\',\'Tarifs ann�e prochaine\',\'menubar=no, status=no, scrollbars=no, menubar=no, location=no, width=600, height=350\');return false;"><span>'.get_libLocal('lib_tarifs_n1').'</span></a><br/><br/>';		
			$texte .= '<br/><a href="#" class="btn btn_green" onClick="javascript:window.open(\'fiche_centre_tarifs.php?n1=1&t='.$GLOBALS['Rub'].'&id_centre='.$listeRes[0]['id_centre'].'\',\'Tarifs annee prochaine\',\'menubar=no, status=no, scrollbars=no, menubar=no, location=no, width=600, height=350\');return false;"><span>'.get_libLocal('lib_tarifs_n1').'</span></a><br/><br/>';		
		}
		
			$params['id'] = split(",",$listeRes[0]['id_sejour_nb_lit__par_chambre']);
			$nbSNbLit = getListeSejourInfos('nb_lit__par_chambre',$listeSNbLit,$params);		
			if ($nbSNbLit > 0)										
			{
				$texte .= '<ul><strong>'.get_libLocal('lib_nb_lit__par_chambre').' :</strong>';
				foreach ($listeSNbLit as $nblit)
				{
					$texte .= '<li>'.$nblit['libelle'].'</li>';
				}
				$texte .= '</ul>';
			}			
			
			if ($_REQUEST['Rub'] == _NAV_ACCUEIL_GROUPES_SCOLAIRES)
			{			
				if($listeRes[0]['conditions_scolaires']!=""){
					$texte .= '<strong>'.get_libLocal('lib_condition_scolaire').'</strong> : '.$listeRes[0]['conditions_scolaires'].'<br/>';
				}
				if ($listeRes[0]['gratuite_chauffeur_4'] == 'Oui')
					$texte .= get_libLocal('lib_gratuite_chauffeur').'<br/>';
					
				if ($listeRes[0]['gratuite_accompagnateur_4'] == 'Oui')
					$texte .= get_libLocal('lib_gratuite_accompagnateur').'<br/>';		
			}
			
			
			if ($listeRes[0]['conditions_groupes'] != '')
			{
				$texte .= '<br/>'.$listeRes[0]['conditions_groupes'];
			}			
			
			$listeInfoD[] = array (	"nom" => get_libLocal('lib_tarifs'),
										"texte" => $texte);		
										

										

		if ($_REQUEST['Rub'] == _NAV_ACCUEIL_GROUPES_SCOLAIRES)
		{											
													
			//**Onglet Nos Classes de découverte - Accueil Scolaire
			$texte = "";
			
			$paramsSDecouverte['id_centre'] = $listeRes[0]['id_centre'];
			$nbSDecouverte = getListeSejour(_NAV_CLASSE_DECOUVERTE, $listeSDecouverte,$paramsSDecouverte);
			
			if ($nbSDecouverte > 0)	
			{
				$texte .= "<ul>";
				foreach ($listeSDecouverte as $sDecouverte)
					$texte .= '<li><a href="'.$sDecouverte['lien'].'">'.$sDecouverte['libelle']."</a></li>";
				$texte .= "</ul>";
				
				$listeInfoD[] = array (	"nom" => get_libLocal('lib_nos_classes_decouverte'),
											"texte" => $texte);						
			}			
			
		}		
		
	}
	
	//*onglet Spécial Famille / Accueil d'individuels
	if ($_REQUEST['Rub'] == _NAV_ACCUEIL_INDIVIDUEL)
	{
		$texte = "";
		/*
		if ($listeRes[0]['conditions_famille'] != '')
			$texte .= $listeRes[0]['conditions_famille'];
		*/	
		$arrayTypeService = array ('bebes', 'enfants')	;
			
		foreach ($arrayTypeService as $type)
		{
			$params['id'] = split(",",$listeRes[0]['id_sejour_services_familles_'.$type]);
			$nbServices = getListeSejourInfos('services_familles_'.$type, $listeServices, $params);
			
			
			$condition_particuliere = getConditionFamille($_REQUEST['id']);
			if($condition_particuliere != ""){
				$texte .=$condition_particuliere."<br />";
			}
			
			if ($nbServices > 0)
			{
				$texte .= '<br/><strong>'.get_libLocal('lib_services_familles_'.$type).' :</strong><ul>';
				foreach ($listeServices as $service)
					$texte .= '<li>'.$service["libelle"].'</li>';
				$texte .= '<ul>';
			}		
		}
		
		$listeInfoD[] = array (	"nom" => get_libLocal('lib_special_familles'),
								"texte" => $texte);		
	}	
	
	
	//**Onglet Sites touristiques aux alentour - Accueil Scolaire / Accueil de groupe
	if ($_REQUEST['Rub'] == _NAV_ACCUEIL_GROUPES_SCOLAIRES || $_REQUEST['Rub'] == _NAV_ACCUEIL_GROUPE || $_REQUEST['Rub'] == _NAV_ACCUEIL_INDIVIDUEL)
	{
		$texte = '';
		if ($listeRes [0]['presentation_region'] != '' && $_REQUEST['Rub'] == _NAV_ACCUEIL_GROUPE)
			$texte = $listeRes [0]['presentation_region'];	//Accueil de Groupe uniquement	
		
		$paramsSites['id_centre'] = $listeRes[0]['id_centre'];
		$nbSites = getListeCentreSiteTouristique($listeSites, $paramsSites);
		if ($nbSites > 0)	
		{
			$texte .= "<ul>";
			foreach ($listeSites as $site)
				$texte .= '<li><a href="'.$site['lien'].'">'.$site['libelle']."</a></li>";
			$texte .= "</ul>";
		}
		
		$listeInfoD[] = array (	"nom" => get_libLocal('lib_sites_touristique_alentour'),
									"texte" => $texte);			
	}
	
	//**Accueil de réunion
	if ($_REQUEST['Rub'] == _NAV_ACCEUIL_REUNIONS)
	{
		//**Onglet Les salles de r�union
		$nbSalle = getSejourSalleReunion (_NAV_ACCEUIL_REUNIONS, $params['id_sejour'], $listeSalle);
		
		if($nbSalle > 0)
		{
			
			if($listeSalle[0]["commentaires_salles"] != ""){
				$texte = $listeSalle[0]["commentaires_salles"]."<br />";
			}else{
				$texte="";
			}
			
			
			foreach ($listeSalle as $salle)
			{
				$texte .= '<span class="triggerPrice">'.$salle['libelle'].' ('.$salle['taille'].' m2)</span><div class="sliderPrice" style="display: none; ">';	

				$texte .= get_libLocal('lib_tarifs')." : ";
				$texte .= '<table class="priceList">';
				$texte .= '<tr>';
					$texte .= '<th>'.mb_strtoupper(get_libLocal('lib_tarif_demi_journee'), 'utf-8').'</th>';
					$texte .= '<th>'.mb_strtoupper(get_libLocal('lib_tarif_journee'), 'utf-8').'</th>';
					$texte .= '<th>'.mb_strtoupper(get_libLocal('lib_tarif_soiree'), 'utf-8').'</th>';
				$texte .= '</tr>';
				$texte .= '<tr>';
					$texte .= '<td>'.$salle['prix_demi_journee'].'</td>';
					$texte .= '<td>'.$salle['prix_journee'].'</td>';
					$texte .= '<td>'.$salle['prix_soiree'].'</td>';
				$texte .= '</tr>';				
				$texte .= '</table><br/>';
				
				//$texte .= get_libLocal('lib_taille')." : ".$salle['taille'].' m2<br/><br/>';
								
				$texte .= get_libLocal('lib_capacite')." : ";
				$texte .= '<table class="priceList">';
				$texte .= '<tr>';
					$texte .= '<th>'.mb_strtoupper(get_libLocal('lib_tour_table'), 'utf-8').'</th>';
					$texte .= '<th>'.mb_strtoupper(get_libLocal('lib_conference'), 'utf-8').'</th>';
					$texte .= '<th>'.mb_strtoupper(get_libLocal('lib_classe'), 'utf-8').'</th>';
				$texte .= '</tr>';
				$texte .= '<tr>';
					$texte .= '<td>'.$salle['tour_table'].'</td>';
					$texte .= '<td>'.$salle['conference'].'</td>';
					$texte .= '<td>'.$salle['classe'].'</td>';
				$texte .= '</tr>';				
				$texte .= '</table><br/>';				
				
				$texte .= get_libLocal('lib_equipement')." : ";
				$texte .= '<table class="priceList">';
				$texte .= '<tr>';
					$texte .= '<th>'.mb_strtoupper(get_libLocal('lib_tableau_blanc'), 'utf-8').'</th>';
					$texte .= '<th>'.mb_strtoupper(get_libLocal('lib_sonorisation'), 'utf-8').'</th>';
					$texte .= '<th>'.mb_strtoupper(get_libLocal('lib_paperboard'), 'utf-8').'</th>';
					$texte .= '<th>'.mb_strtoupper(get_libLocal('lib_ecran'), 'utf-8').'</th>';
					$texte .= '<th>'.mb_strtoupper(get_libLocal('lib_climatisation'), 'utf-8').'</th>';
					$texte .= '<th>'.mb_strtoupper(get_libLocal('lib_wifi_adsl'), 'utf-8').'</th>';
				$texte .= '</tr>';
				$texte .= '<tr>';
					$texte .= '<td>'.$salle['tableau_blanc'].'</td>';
					$texte .= '<td>'.$salle['sonorisation'].'</td>';
					$texte .= '<td>'.$salle['paperboard'].'</td>';
					$texte .= '<td>'.$salle['ecran'].'</td>';
					$texte .= '<td>'.$salle['climatisation'].'</td>';
					$texte .= '<td>'.$salle['wifi_adsl'].'</td>';
				$texte .= '</tr>';				
				$texte .= '</table></div>';						
										
			}
				$listeInfoD[] = array (	"nom" => get_libLocal('lib_salle_reunion'),
											"texte" => $texte);			
		}
		
		//**Onglet La restauration ... Les formules de réunion 
		$arrayTypeRestauration = array ('repas', 'pause', 'cocktail', 'formule_reunion');
		
		foreach ($arrayTypeRestauration as $typeResto)
		{
			$texte = '';
			$nbRepas = getSejourReunionInfos (_NAV_ACCEUIL_REUNIONS, $params['id_sejour'], $typeResto, $listeRepas);
			
			if ($nbRepas > 0)
			{
				foreach ($listeRepas as $repas)
				{
					$texte .= '<strong>'.$repas['libelle'];

					if($repas['prix']>0){
						$texte .= '('.$repas['prix'].'&euro;)';
					}
					
					$texte .= '</strong><br/>'.$repas['commentaire'].'<br/>';
				}
				
				$listeInfoD[] = array (	"nom" => get_libLocal('lib_'.$typeResto),
											"texte" => $texte);	
			}
			
			
			
		}
		
		
		//**Onglet Exemples de séminaire
			$paramsSeminaire['id_centre'] = $listeRes[0]['id_centre'];
			$nbSeminaire = getListeSejour(_NAV_SEMINAIRES, $listeSeminaire,$paramsSeminaire);		
			if ($nbSeminaire > 0)
			{
				$texte = '<ul>';
				foreach ($listeSeminaire as $seminaire)
				{
					$texte .= '<li><a href="'.get_url_nav_sejour(_NAV_INCENTIVE, $seminaire['id']).'">'.$seminaire['libelle'].'</a></li>';
				}
				$texte .= '</ul>';
				
				
				$listeInfoD[] = array (	"nom" => get_libLocal('lib_exemple_seminaire'),
											"texte" => $texte);	
			}
	}
	

	
	//**Onglet Accès - Classe Découverte / Accueil de scolaire / ...
	if (isset($listeRes[0]['acces_route_4']))
	{
		$texte = "";
		
		$arrayacces = array("acces_route", "acces_train", "acces_avion", "acces_bus_metro");
		
		foreach ($arrayacces as $acces)
		{
			if ($listeRes[0][$acces.'_4'] == 'Oui')
			{
				$texte .= '<span class="bullet" style="font-weight:bold;">'.get_libLocal('lib_'.$acces).' : </span>'.$listeRes[0][$acces.'_texte']."<br/>";
			}
		}		

		if ($listeRes[0]['latitude'] != '' && $listeRes[0]['longitude'] != '' )
			$texte .= '<br/><span class="titleSlider">'.get_libLocal('lib_coordonnees_gps').' : </span><br/><span class="bullet" style="font-weight:bold;">'.get_libLocal('latitude'). ' : </span>'.$listeRes[0]['latitude'].'<br/><span class="bullet" style="font-weight:bold;">'.get_libLocal('longitude'). ' : </span>'.$listeRes[0]['longitude'];
		
		$listeInfoD[] = array (	"nom" => get_libLocal('lib_acces'),
									"texte" => $texte);	
	}		
	
	//**Onglet L'organisateur - CVL
	
	if ($_REQUEST['Rub'] == _NAV_CVL)
	{
		getOrganisateurCVL ($listeRes[0]['id_centre'],$Organisateur);
		$texte = '<strong>'.$Organisateur['libelle'].'</strong><br/>'.$Organisateur['presentation'].
				'<a href="'.$Organisateur['lien'].'">'.get_libLocal('lib_en_savoir_plus').'</a>';
		
		
		$listeInfoD[] = array (	"nom" => get_libLocal('lib_organisateur'),
									"texte" => $texte);			
	}
	
	
	
	$template -> assign ('listeInfoD', $listeInfoD);
	
	
	
	$template->display('fiche_sejour.tpl');

?>