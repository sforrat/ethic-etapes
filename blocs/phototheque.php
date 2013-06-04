<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	AHE							  
/*	Date : 		
/*	Version :	1.0							  
/*	Fichier :	phototheque.php						  
/*										  
/*	Description :	Page Photothèque de l'espace presse                
/*										  
/**********************************************************************************/

// Initialisation de la page
$path="./";

function getStartLimitPhototheque($nbTotal)
{
	$pageCourante = 1;
	if (isset($_REQUEST['P']) && is_numeric($_REQUEST['P']))
	$pageCourante = $_REQUEST['P'];

	$nbPages = ceil($nbTotal / _NB_ENR_PHOTOTHEQUE_RES)+1;

	if ($nbTotal <= _NB_ENR_PHOTOTHEQUE_RES)
	$startPagination = 0;
	else
	$startPagination = (($pageCourante - 1) * _NB_ENR_PHOTOTHEQUE_RES) ;

	if ($pageCourante > $nbPages)
	{
		$pageCourante = 1;
		$startPagination = 0;
	}
	return $startPagination;
} // getStartLimit($nbTotal)

if ($_REQUEST['Rub'] == _NAV_PHOTOTHEQUE)
{		
	$sql = "SELECT id_ep_phototheque, fichier, date FROM ep_phototheque";
	
	$rst = mysql_query($sql);
	if (!$rst)
		echo mysql_error() . ' - '.$sql;
	else 
	{
		$nbRes = mysql_num_rows($rst);
		
		$sql = "SELECT id_ep_phototheque, fichier, date FROM ep_phototheque";
		$sql .= " LIMIT " . getStartLimitPhototheque($nbRes) . "," . _NB_ENR_PHOTOTHEQUE_RES;
		
		$rst = mysql_query($sql);
		if (!$rst)
			echo mysql_error() . ' - '.$sql;		
	
		$nb = mysql_num_rows($rst);
			
		for ($i = 0 ; $i < $nb ; $i++)
		{
			$fichier = getFileFromBDD(mysql_result($rst,$i,'fichier'), 'ep_phototheque');
			
			if (file_exists($fichier))
			{
				$listePhoto[] = array('titre' => getTradTable('ep_phototheque', $_SESSION['ses_langue'], 'titre', mysql_result($rst, $i, 'id_ep_phototheque')),
									  'fichier' => $fichier,
									  'size' => ceil(filesize($fichier)/1000),
									  'date' => mysql_result($rst, $i, 'date'));
			}
		}
	}
	
//Pagination
$nbPages = ceil($nbRes / _NB_ENR_PHOTOTHEQUE_RES);
$currentPage = (isset($_REQUEST['P']) ? $_REQUEST['P'] : 1);

$startPage = $currentPage - ceil(_NB_PAGE_TOT_RES/2) + 1;
$endPage = $currentPage + ceil(_NB_PAGE_TOT_RES/2) ;

if ($startPage <= 0)
	$startPage = 1;	

if ($endPage > $nbPages)
	$endPage = $nbPages +1;


// --------------------------------------------------------------
// --- URL PREVIOUS
if(isset($_REQUEST['P'])){
	if(($_REQUEST['P'] > 1)){
		$previousPage = $_REQUEST['P']-1;
	}else{
		$previousPage = 1;
	}
}

if($previousPage == 1 || !$previousPage){
	$url_previous = get_url_nav($_REQUEST['Rub']);
}else{
	$params = array();
	$params[0]["id"] = $previousPage;
	$url_previous = get_url_nav($_REQUEST['Rub'],$params);
}
$this -> assign ('urlPreviousPage', $url_previous);
// --------------------------------------------------------------
// --- URL NEXT
if(isset($_REQUEST['P'])){
	$val  = $_REQUEST['P']+1;
	if($val >= $nbPages){
		
		$next = $nbPages;
	}else{
		
		$next = $_REQUEST['P']+1;
	}
}else{
	
	$next  = $nbPages;
}

if($next ==1  || !$next){
	$url_next = get_url_nav($_REQUEST['Rub']);
}else{
	$params = array();
	$params[0]["id"] = $next;
	$url_next = get_url_nav($_REQUEST['Rub'],$params);
}
$this -> assign ('urlNextPage', $url_next);
// --------------------------------------------------------------
// --- Derniere page
if($nbPages>1){
	$params = array();
	$params[0]["id"] = $nbPages;
	$this -> assign ('url_last_page', get_url_nav($_REQUEST['Rub'],$params));
}else{
	$this -> assign ('url_last_page', get_url_nav($_REQUEST['Rub']));
}

// --------------------------------------------------------------

$this -> assign ('currentPage', $currentPage);
$this -> assign ('nextPage', $url_next);

$this -> assign ('urlPagination', get_url_nav($_REQUEST['Rub']));
$this -> assign ('nbPages', $nbPages);
$this->assign("nbTotal",$nb);


// ------ FFR
unset($tab);
for($i = $startPage; $i<$endPage;$i++){
	$params = array();
	$params[0]["id_name"]="P";
	$params[0]["id"]=$i;
	
	if($i == 1){
		$tab["url"] = get_url_nav($_REQUEST['Rub']);
	}else{
		$tab["url"] = get_url_nav($_REQUEST['Rub'],$params);
	}
	
	$tab["currentPage"] = $i;
	
	$TabPagination[] = $tab;
	unset($tab);
}


$this -> assign ('TabPagination', $TabPagination);
$this -> assign ('$page', $_GET["P"]);	
	
	
	$this -> assign('listePhoto', $listePhoto);
	$this -> display('blocs/phototheque.tpl');
}
?>
