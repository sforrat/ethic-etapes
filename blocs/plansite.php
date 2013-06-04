<?
/**********************************************************************************/
/*	C2IS :
/*	Auteur : 	TLY
/*	Date :
/*	Version :	1.0
/*	Fichier :	plansite.php
/*
/*	Description :	Bloc de gestion du plan du site
/*
/**********************************************************************************/

// Initialisation de la page
$path="./";
$i=0;
$sql = "select 
			_nav.url_page,
			_nav.id__nav,
			trad__nav._nav
		FROM 
			_nav
		INNER JOIN
			trad__nav on (trad__nav.id__langue=".$_SESSION["ses_langue"]." and trad__nav.id___nav=_nav.id__nav)
		WHERE 
			_nav.selected=1 and
			_nav.id__type_nav="._ID_SITE." and 
			_nav.id__nav_pere="._NAV_ACCUEIL."
		ORDER BY 
			_nav.ordre";

$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
	$tab["libelle"] = mb_strtoupper($myrow["_nav"],"utf-8");
	$tab["url"] = get_url_nav($myrow["id__nav"]);
	$sql_S = "	select 
					_nav.url_page,
					_nav.id__nav,
					trad__nav._nav
				FROM 
					_nav
				INNER JOIN
					trad__nav on (trad__nav.id__langue=".$_SESSION["ses_langue"]." and trad__nav.id___nav=_nav.id__nav)
				WHERE 
					_nav.selected=1 and
					_nav.id__nav_pere=".$myrow["id__nav"]." and
                    FIND_IN_SET('".$_SESSION["ses_langue"]."',_nav.id__langue)>0
				ORDER BY 
					_nav.ordre";
	$result_S = mysql_query($sql_S);
	while($myrow_S = mysql_fetch_array($result_S)){
		$tab2["libelle"] = $myrow_S["_nav"];
		$tab2["url"] = get_url_nav($myrow_S["id__nav"]);
		
			
		$sql_SS = "	select 
						_nav.url_page,
						_nav.id__nav,
						trad__nav._nav
					FROM 
						_nav
					INNER JOIN
						trad__nav on (trad__nav.id__langue=".$_SESSION["ses_langue"]." and trad__nav.id___nav=_nav.id__nav)
					WHERE 
						_nav.selected=1 and
						_nav.id__nav_pere=".$myrow_S["id__nav"]." and
                        FIND_IN_SET('".$_SESSION["ses_langue"]."',_nav.id__langue)>0
					ORDER BY 
						_nav.ordre";
		
		$result_SS = mysql_query($sql_SS);
		while($myrow_SS = mysql_fetch_array($result_SS)){
			$tab3["libelle"] = $myrow_SS["_nav"];
			$tab3["url"] =get_url_nav($myrow_SS["id__nav"]);
			$tab2["ss_rub"][] = $tab3;
			unset($tab3);
		}
		
			
		$tab["ss_rub"][] = $tab2;
		unset($tab2);
	}
	
	if( ($i%3) == 0){
		$tab["retourLigne"] = 1;
	}else{
		$tab["retourLigne"] = 0;
	}
	$TabNav[] = $tab;
	unset($tab);
	$i++;
}

$this ->assign('TabNav',$TabNav);
$this ->display('blocs/plansite.tpl');
?>
