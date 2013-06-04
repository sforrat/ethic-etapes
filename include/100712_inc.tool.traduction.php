<?

function getLibFromBase($string)
{

	$dicLib=getAllLibs();
		
	if($dicLib=="" || count($dicLib)==0 )
	{
		$dicLib=loadLib();
	}
	elseif (! isset($dicLib[$_SESSION['ses_langue']]))
	{
		
		$dicLib=loadLib($dicLib);
	}
	
	$libelle = "";
	if(isset($dicLib[$_SESSION['ses_langue']]) && isset($dicLib[$_SESSION['ses_langue']][$string]))
	{
		
		$libelle = $dicLib[$_SESSION['ses_langue']][$string];
	}
	
	if (strlen($libelle) == 0)
	{
		$strSQL = "SELECT id__langue, _langue_abrev FROM _langue WHERE _langue_by_default = 1 LIMIT 1";
		
		$rstLangue = mysql_query($strSQL);                
		if (mysql_num_rows($rstLangue))
		{
			$langue = mysql_result($rstLangue,0,"id__langue");
			
			if($dicLib=="" || count($dicLib)==0 )
			{
				$dicLib=loadLib();
			}
			elseif (! isset($dicLib[$langue]))
			{
				$dicLib=loadLib();
			}
			
			
			if(isset($dicLib[$langue]) && isset($dicLib[$langue][$string]))
			{

				return $dicLib[$langue][$string];
    			}
    			else
			{
				return "";
			}	
  		}
  		else
		{
			return "";
		}	
	}
	else
	{
		return $libelle;	
	}	
	
}

function loadLib($dicLib)
{	
		$db=$GLOBALS['db'];
	
		$strLibelles="SELECT code_libelle as id, t.libelle as lib FROM "._CONST_TRAD_TABLE_NAME." inner join "._CONST_BO_PREFIX_TABLE_TRAD._CONST_TRAD_TABLE_NAME." t ON id_"._CONST_TRAD_TABLE_NAME."=t.id__"._CONST_TRAD_TABLE_NAME." WHERE id__langue=".$_SESSION['ses_langue'];
	 	if (!($rsLibelles= $db->sql_query($strLibelles))) {
				message_die(GENERAL_ERROR, 'Impossible d\'exécuter la requête', '', __LINE__, __FILE__, $strLibelles);
		}
		while($row = $db->sql_fetchrow($rsLibelles))
		{   
			$dicLib[$_SESSION['ses_langue']][$row['id']]=$row['lib'];
		}	
				
		//setAllLibs($dicLib);
		
		return $dicLib;
}

function getAllLibs()
{
	
	return $GLOBALS['dicLib'];
}

function setAllLibs($value)
{
	if(_CONST_FLAG_MEMCACH)
		memcache_set($GLOBALS['memcache'],'dicLib',$value,0,300);
	else
		$_SESSION['dicLib']=$value;
	
		
	return true;
}

function deleteAllLib()
{
	if(_CONST_FLAG_MEMCACH)
		memcache_set($GLOBALS['memcache'],'dicLib',"",0,0);
	else
		$_SESSION['dicLib']="";
		
		return true;
	
}

function getTradTable ( $nomTable, $idLangue, $nomChamp, $idObjet ) {
	
	$sqlTrad = "SELECT ".$nomChamp." FROM trad_".$nomTable;
	$sqlTrad .= " WHERE id__langue = ".$idLangue;
	$sqlTrad .= " AND id__".$nomTable." = ".$idObjet;	
	$rstTrad = mysql_query($sqlTrad);
		
	if ( mysql_num_rows($rstTrad) > 0 ) 
		return ( mysql_result($rstTrad, 0, $nomChamp) );
	else
		return ( "" );
	
}

//=================================================
// Gestion des libellés
//=================================================
function loadLibelles()
{				
	//gestion via la table tradotron
	if(!_CONST_TRAD_GENERE_FIC)
	{
		$db=$GLOBALS['db'];
		$strLibelles="SELECT code_libelle as id, t.libelle as lib FROM "._CONST_TRAD_TABLE_NAME." inner join "._CONST_BO_PREFIX_TABLE_TRAD._CONST_TRAD_TABLE_NAME." t ON id_"._CONST_TRAD_TABLE_NAME."=t.id__"._CONST_TRAD_TABLE_NAME." WHERE id__langue=".$_SESSION['ses_langue'];
		if (!($rsLibelles= $db->sql_query($strLibelles))) {
			message_die(GENERAL_ERROR, 'Impossible d\'exécuter la requête', '', __LINE__, __FILE__, $strLibelles);
		}
		while($row = $db->sql_fetchrow($rsLibelles))
		{   		
			$GLOBALS['template']->assign($row['id'],$row['lib']);
		}	
	}
	//gestion par les fichiers
	else 
	{	
		//Librairie de trads
		require_once($GLOBALS['path']."include/inc_lib_language.inc.php");
	}
}

