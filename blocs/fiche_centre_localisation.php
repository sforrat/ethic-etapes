<?

$iIdCentre = $_REQUEST['id_centre'];

$iNbCentre = getListeCentreGP($lstCentre,array('id_centre'=>array($iIdCentre)));
$lstCentre = $lstCentre[0];

if($iNbCentre)
{
	$this->assign("lstCentre",$lstCentre);
	if($lstCentre['acces_route_4'] == 'Oui') $this->assign("acces_route",true);
	if($lstCentre['acces_train_4'] == 'Oui') $this->assign("acces_train",true);
	if($lstCentre['acces_avion_4'] == 'Oui') $this->assign("acces_avion",true);
	if($lstCentre['acces_bus_metro_4'] == 'Oui') $this->assign("acces_bus_metro",true);
	
	/*if($iNbCentreTarifsScolaire) $template->assign("listeTarifsScolaire",$listeTarifsScolaire);	
	if($iNbCentreTarifsAdulte) $template->assign("listeTarifsAdulte",$listeTarifsAdulte);	
	if($iNbCentreTarifsFamille) $template->assign("listeTarifsFamille",$listeTarifsFamille);	*/
}

$this -> display ('blocs/fiche_centre_localisation.tpl');

?>