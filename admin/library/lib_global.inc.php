<?
/**********************************************************************************/
/*	C2IS : 		xxprojetxx
/*	Auteur : 	auteur 							  																								
/*	Date : 		2005						  																					
/*	Version :	1.0							  
/*	Fichier :	lib_global.inc.php					  
/*										  
/*	Description :	Fichier de dfinition des constantes globales  	  
/*			l'application Front et Back office			  
/*			Ce fichier est gnralement inclus dans toutes les pages  
/*			par le inc_header.inc.php et permet de rcuprer	  
/*			les constantes globales  l'application.		  
/*										  
/**********************************************************************************/
	

	// PARAMETRES DE CONNEXION MYSQL

	// BASE 
  $Host		= "localhost";
  $BaseName	= "ethic_etapes";
  $UserName	= "ethic_etapes";
  $UserPass	= "zdlp6s7uxaxbnvcz";

  define("_CONST_RELATIVE_LOGICAL_PATH",	"/");
  define("_CONST_APPLICATION_NAME",				"Ethic Etapes");

  //$MailServer = ini_get("SMTP"); // relais smtp utilis par fonction envoi_mail_smtp
  $MailServer = "smtp.teaser.fr";
    	
  define("_DEFAULT_CHARSET","utf8");
  define("_DEFAULT_CHARSET_BDD","latin1");
  define("_DEFAULT_COLLATION","utf8_general_ci");
  define("_DEFAULT_COLLATION_BDD","latin1_swedish_ci");
  define("_DEFAUT_ENGINE","MyISAM");


	//set_magic_quotes_runtime(0); // permet de s'affranchir du remplacement de caractres spciaux automatiques dans
	// les requtes

	// NIVEAU REPORTING
	//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);	// en dveloppement
	error_reporting(0); // en production : retire l'affichage de toutes les erreurs
	//error_reporting(E_ALL ^ E_NOTICE);
	//error_reporting(E_ALL);
	
	define("DEBUG",false,true); // message d'erreur explicite ? a passer a false en production
	define("SHOW_DEBUG",false,true); // infos de debug affiches en pied de page ?
	define("DEBUG_SMARTY",false,true);
	
	//LIMITE D'EXECUTION DU SCRIPT
	set_time_limit(7200);

	// Constante qui dfinit le type de logs des actions dans le bo :    None : aucune, Full : tout logg, 
	//                                                                   Access : seulement les acces
	define("_CONST_STAT_BO", "None",true);
	
	//Constante definissant le nombre limite de fichiers d'archive  garder lors de l'utilisation du dump depuis le BO
	define("_CONST_ARCHIV_LIMIT", 20,true);	
	
	//Constantes LDAP : utilis seulement dans le cadre d'une authentification LDAP en back office
	define("_CONST_LDAP_ENABLED"          , "false"             , true); // Authentification LDAP active ? true/false
	define("_CONST_LDAP_HOST"             , "ldap.server.com"         , true); // LDAP Host server
	define("_CONST_LDAP_FILTER"           , "dc=,dc=" , true); // Filter
	define("_CONST_LDAP_DEFAULT_PROFIL_ID", 2                   , true);
	define("_CONST_LDAP_DEFAULT_USER_ID"  , 3                   , true);
	
	// Constantes CAS : utilis seulement dans le cadre d'une authentification SSO CAS 
	define( "_CONST_CAS_ENABLED"	, "false"		 , true ); // Authentification CAS active ? true/false
	define( "_CONST_CAS_HOST"	, "xxx.xxx.xxx", true ); // Serveur CAS
	define( "_CONST_CAS_PORT"	, 8443			 , true  ); // Port du serveur
	// Fin constantes CAS
	
	
	// Email administrateur : utilis pour affichage erreur
	define( "_CONST_ADM_EMAIL", "exploitation@c2is.fr", true );
	define("_DOMAINE_EMAIL","c2is.fr", true);
	
	
	// SMTP / ENVOI DE MAILS
	define( "_CONST_USE_SMTP"	, "false" , true ); // Doit on utiliser le relais SMTP pour l'envoi d'email, ou la fonction mail php ?
	
	
	// Paramtres de l'application locale	
	$s = empty($_SERVER["HTTPS"]) ? ''
		: ($_SERVER["HTTPS"] == "on") ? "s"
		: "";

	$protocol = substr(strtolower($_SERVER["SERVER_PROTOCOL"]), 0, strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), "/")).$s;
	
	$port = ($_SERVER["SERVER_PORT"] == "80") ? ""
		: (":".$_SERVER["SERVER_PORT"]);
		
	
  define( "_CONST_APPLI_NAME",_CONST_APPLICATION_NAME,true); // nom courant appli locale (utilis par smarty en particulier...)
  define( "_CONST_APPLI_PATH", _CONST_RELATIVE_LOGICAL_PATH, true ); // URL logique de l'appli a partir de la racine du serveur
	define( "_CONST_APPLI_URL", $protocol."://".$_SERVER['HTTP_HOST'].$port._CONST_RELATIVE_LOGICAL_PATH, true ); // URL absolue du site
	define( "_CONST_PATH_TO_APPLI",$_SERVER['DOCUMENT_ROOT']._CONST_APPLI_PATH,true); // chemin physique de l'appli sur le serveur	

	// REECRITURE
	define( "_CONST_ENABLE_REWRITING","true",true); // reecriture autorise ?
	
	// IMAGES DYNAMIQUES (ncessite GD sur le servueur + fichiers polices)
	define( "_CONST_ENABLE_IMG_DYN", "false", true ); // image dynamique autorise ? true / false
	define( "_CONST_PATH_TO_POLICE", _CONST_PATH_TO_APPLI."include/fonts/", true ); // chemin physique d'acces aux polices et aux images cres dynamiquement
	define( "_CONST_PATH_TO_IMG_DYN", _CONST_PATH_TO_APPLI."images/img_dyn/", true ); // chemin physique dans lequel les images dynamiques seront cres
	define( "_CONST_FORMAT_IMG_DYN_DEFAUT", "PNG", true ); // format des images dynamiques par dfaut sur ce serveur JPG, PNG

	// PORTFOLIO	
	define( "_CONST_FTP_PORTOFOLIO_ENABLE", "true", true ); // Transfert FTP des fichiers et images autoris ? true/false
	define( "_CONST_FTP_PORTOFOLIO_URL", "", true); // Adresse de tranfert FTP pour dposer les fichiers du portfolio 
	define( "_CONST_PORTFOLIO_PATH", _CONST_APPLI_URL."images/upload/portfolio_img/", true );
	define( "_CONST_PORTFOLIO_UPLOAD_PATH", _CONST_PATH_TO_APPLI."images/upload/portfolio_img/", true );
	
	// UPLOAD DE FICHIER
	define( "_CONST_UPLOAD_EXTENSIONS_AUTORISEES","jpg,gif,png,doc,xls,ppt,pdf,zip,swf,flv", true); // liste des extensions autorises en upload dans la back
	
	// MULTILINGUISME
	define( "_CONST_ENABLE_MULTILANGUE_FRONT","true",true); // est ce que le front est autoris a changer de langue ?
	define( "_CONST_ENABLE_MULTILANGUE","false",true); // gestion bo multilangue ?
	define( "_CONST_ENABLE_DETECT_LANGUE_NAVIGATOR","false",true); // positionne la langue en fct de la langue par dfaut du navigateur ?

	// RICHTEXT
	define( "_CONST_ENABLE_RICHTEXT","true",true); // activ le textriche pour la saisie ?
																								 // sinon, textarea simple
  define( "_CONST_RICHTEXT_URL",_CONST_APPLI_PATH."admin/fckeditor/",true); // URL relative du module richtext
  define( "_CONST_RICHTEXT_SKIN",_CONST_RICHTEXT_URL."editor/skins/silver/",true); // Richtext skin (default, office2003, silver)
  define( "_CONST_RICHTEXT_MODE","Fullkit",true); // mode par dfaut de l'diteur : Default (complet), ou Basic ?																								
  define( "_CONST_RICHTEXT_MODE_ROOT","Fullkit_complet",true); // mode par dfaut de l'diteur : Default (complet), ou Basic ?																								
  
  	// FCKEDITOR
  	define( "_CONST_FILEMANAGER_URL",_CONST_APPLI_URL."images/upload/fck/",true); // URL d'accs au ressources du filemanager
  	define( "_CONST_FILEMANAGER_PATH",_CONST_PATH_TO_APPLI."images/upload/fck/",true);

	// PARAMETRES SMARTY
	define( "_CONST_TEMPLATE_DIR",_CONST_PATH_TO_APPLI."tpl/",true); // rpertoire dans lequel se trouvent les tpl
	define( "_CONST_TEMPLATE_PRINT_DIR",_CONST_PATH_TO_APPLI."tpl_print/",true); // rpertoire dans lequel se trouvent les tpl en version imprimable
	define( "_CONST_PRINT_COMPILE_DIR",_CONST_PATH_TO_APPLI."include/smarty/templates_print_c/",true); // rpertoire de prcompilation des templates
	define( "_CONST_COMPILE_DIR",_CONST_PATH_TO_APPLI."include/smarty/templates_c/",true); // rpertoire de prcompilation des templates
	define( "_CONST_CONFIG_DIR",_CONST_PATH_TO_APPLI."include/smarty/configs/",true); // rpertoires dans lequel se trouvent les fichiers de cong de smarty
	define( "_CONST_CACHE_DIR",_CONST_PATH_TO_APPLI."include/smarty/cache/",true); // cache des pages gnres
	define( "_CONST_TPL_EXT",".tpl",true); // extension des templates par dfaut
	
	define("Template_left_delimiter", "#",true); 	// delimiter de tag pour les templates
	define("Template_right_delimiter", "#",true); 	// delimiter de tag pour les templates
	
	// CYBERCITE
	define( "_ID_SITE_CYBERCITE","",true); // identifiant du site si referencement CYBERCITE. Vide sinon.		
	define( "_ID_PROFIL_REFERENCEUR","-1",true); // id du profil referenceur : permet de shunter la verif 
	// du with_user_rights dans le get_arbo des lments de navigation
	
	// définit le ou les gabarits attribués par défaut à une nav
	// ex. : define("_DEFAULT_GAB_TABLES","gab_editorial");	
	// ou encore : define("_DEFAULT_GAB_TABLES","gab_editorial,gab_produits,gab_evenement");																		 
	define("_DEFAULT_GAB_TABLES","gab_texte_riche,gabarit_bouton,gab_bandeau_resultat");
	
	
//-------------------------------------------------------------------------------------------------------------
// PARAMETRES INTERNES AU MOTEUR : NE PAS MODIFIER !!!
//-------------------------------------------------------------------------------------------------------------
// Toute modification dans les lments dfinis ci-aprs peut conduire
//  un dysfonctionnement complet de l'application.
//

	// PARAMETRES STRUCTURANT DE LA STRUCTURE DES TABLES EN BO
	// A Manipuler avec extreme prcaution !
	
	define("_CONST_BO_CODE_NAME"            ,   "_"      	                                        ,true); // prefixe de toutes les tables du BO
	define("_CONST_BO_TABLE_DATA_PREFIX"    ,   ""          	                                ,true); // prefixe de toutes les tables de donnes du BO
	define("_CONST_BO_TABLE_PREFIX"         ,   ""                                                  ,true); 
	define("_CONST_BO_BINARY_UPLOAD"        ,   "../images/upload/"                     ,true); // chemin de l'upload par dfaut
	define("_CONST_FO_BINARY_UPLOAD"        ,   "images/upload/"                     ,true); // chemin de l'upload par dfaut en FO
	
	define("_CONST_BO_AUTO_SUFFIX"          ,   "_auto"                                             ,true); // prfixe des champs si champ auto
	define("_CONST_BO_REQUIRE_SUFFIX"       ,   "_req"                                              ,true); // prfixe des champs si champ obligatoire
	
	//06/09/07-MVA
	define("_CONST_BO_PREFIX_TABLE_TRAD"       ,   "trad_" 																					,true); // prefix des tables de traductions
	
	//Gestion d'outil de traduction
	define("_CONST_TRAD_GENERE_FIC","true",true); // Boolen pour savoir si on genere les fichiers de trad ( pour gagner un peu de temps)
	define("_ID_TRADOTRON",500); // a updater
	define("_CONST_TRAD_TABLE_NAME","tradotron"); // nom de la table
	define("_CONST_TRAD_CODE_LIB","code_libelle"); // nom de la table

	// Flag d'utilisation du systeme memcach pour la mise en mmoire
	define("_CONST_FLAG_MEMCACH", false);

	define("_CONST_BO_TABLE_DATA_PREFIX2"   ,   str_replace("_","",_CONST_BO_TABLE_DATA_PREFIX)     ,true); 
	define("_CONST_BO_TABLE_PREFIX2"        ,   str_replace("_","",_CONST_BO_TABLE_PREFIX)          ,true);
	
	define("_CONST_BO_DEFAULT_CURRENCY"     ,   "&euro;"                                            ,true); // indicateur montaire par dfaut

//----------------------------------------
//----------------DICTIONNAIRE INTERNE
//----------------------------------------
//
	//Dictionnaire de donnes interne
	$datatype_text			= "varchar(255)";
	$datatype_long_text		= "text";
	$datatype_rich_text		= "mediumtext";
	$datatype_url			= "varchar(250)";
	$datatype_file			= "varchar(100)";
	$datatype_integer		= "int(10)";
	$datatype_currency		= "float(10,2)";
	$datatype_float			= "float(9,2)";
	$datatype_booleen		= "int(1)";
	$datatype_key			= "int(11) unsigned";
	$datatype_multikey		= "varchar(254)";
	$datatype_list_data		= "varchar(253)";
	$datatype_color			= "varchar(15)";
	$datatype_arbo			= "id_"._CONST_BO_CODE_NAME."nav";

	$datatype_password		= "varchar(20)";
	$datatype_password_length 	= 8;

	$datatype_order			= "int(9)";
	$datatype_order_name		= "ordre";
	$datatype_real			= 12;

	$datatype_date			=	$datatype_date_auto		= "date";
	$datatype_datetime		=	$datatype_datetime_auto	= "datetime";

	//RETURN MySQL
	$mysql_datatype_text		= "string";
	$mysql_datatype_text_rich	= "blob";
	$mysql_datatype_integer		= "int";
	$mysql_datatype_real		= "real";

	$array_type			= array(
								"TEXT"			=>	$datatype_text,
								"TEXT LONG"		=>	$datatype_long_text,
								"MEDIUMTEXT"	=>	$datatype_rich_text,
								"DATE"			=>	$datatype_date,
								"DATE_AUTO"		=>	$datatype_date_auto,
								"DATETIME"		=>	$datatype_datetime,
								"DATETIME_AUTO"	=>	$datatype_datetime_auto,
								"LIEN"			=>	$datatype_url,
								"IMAGE"			=>	$datatype_file,
								"COLOR"			=>	$datatype_color,
								"INT"			=>	$datatype_integer,
								"FLOAT"			=>	$datatype_float,
								"ORDER"			=>	$datatype_order,
								"CURRENCY"		=>	$datatype_currency,
								"BOOLEEN"		=>	$datatype_booleen,
								"ARBO"			=>	$datatype_arbo,
								"LIST_DATA"		=>	$datatype_list_data,
								"KEY"			=>	$datatype_key,
								"MULTIKEY"		=>	$datatype_multikey,
								"PASSWORD"		=>	$datatype_password,
								"CREATE_DATETIME_AUTO"	=>	$datatype_datetime_auto,
								"UPDATE_DATETIME_AUTO"	=>	$datatype_datetime_auto
							);

	//$array_type = array_flip($array_type);

	$array_type_libelle = array(
								"TEXT"			=> "1.&nbsp;&nbsp;&nbsp;-> Texte",
								"TEXT LONG"		=> "2.&nbsp;&nbsp;&nbsp;-> Texte long",
								"MEDIUMTEXT"	=> "3.&nbsp;&nbsp;&nbsp;-> Texte riche",
								"DATE"			=> "4.&nbsp;&nbsp;&nbsp;-> Date",
								"DATE_AUTO"		=> "5.&nbsp;&nbsp;&nbsp;-> Date automatique",
								"DATETIME"		=> "6.&nbsp;&nbsp;&nbsp;-> Date & Heure",
								"DATETIME_AUTO"	=> "7.&nbsp;&nbsp;&nbsp;-> Date & Heure automatique",
								"LIEN"			=> "8.&nbsp;&nbsp;&nbsp;-> Lien-Url",
								"IMAGE"			=> "9.&nbsp;&nbsp;&nbsp;-> Fichier binaire",
								"INT"			=> "10. -> Entier",
								"FLOAT"			=> "11. -> Nombre &agrave; virgule",
								"CURRENCY"		=> "12. -> Mon&eacute;taire",
								"BOOLEEN"		=> "13. -> Bool&eacute;en",
								"PASSWORD"		=> "14. -> Mot de passe",
								"COLOR"			=> "15. -> Couleur",
								"ORDER"			=> "16. ^^ Ordre -> Ordonnancement",
								"ARBO"			=> "17. -^ Arborescence",
								"LIST_DATA"		=> "18. ^- Liste de donn&eacute;es",
								"KEY"			=> "19. o> Liste d&eacute;roulante",
								"MULTIKEY"		=> "20. >> Liste d&eacute;roulante &agrave; choix muliples",
								"CREATE_DATETIME_AUTO"	=> "22.&nbsp;&nbsp;&nbsp;-> Création Date & Heure automatique",
								"UPDATE_DATETIME_AUTO"	=> "23.&nbsp;&nbsp;&nbsp;-> Modification Date & Heure automatique"

							);
//-------------------------------------------------------------------------------------------------------------
// FIN PARAMETRES INTERNES AU MOTEUR
//-------------------------------------------------------------------------------------------------------------
?>
