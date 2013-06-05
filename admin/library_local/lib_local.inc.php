<?
//-----------------------------------------------------------------------------------------
// 					SPECIFIQUE  
//-----------------------------------------------------------------------------------------

//DEFINITIONS DES CONSTANTES SPECIFIQUES � l'APPLICATION LOCALE

// Email webmaster (from des emails)
define("_MAIL_WEBMASTER","info@ethic-etapes.fr");
define("_MAIL_WEBMASTER_COPY","site@ethic-etapes.fr");
//define("_MAIL_WEBMASTER","f.frezzato@c2is.fr");
define("_MAIL_WEBMASTER_C2IS","ethic-etapes@c2is.fr");
define("_MAIL_CONTACT_PRESSE","info@ethic-etapes.fr");
define("_MAIL_CONTACT_EMPLOI","site@ethic-etapes.fr");
define("_MAIL_CONTACT_SEJOUR","info@ethic-etapes.fr");
//define("_MAIL_CONTACT_SEJOUR","f.frezzato@c2is.fr");

define('_URL_HOSTELWORLD', 'http://www.hostelworld.com/');

define("_GOOGLE_MAP_KEY","ABQIAAAAf2vD1-Sq_SlMrRKIBBdwOxRV7A1CgNaeMKRESsJb7WOKo8prThQs19I9KYxAT2JGesjqJgvqVtvHBw");

// Valeur de Worflow state correspondant � l'�tat publi� des objets
// permet de savoir quand on affiche les objets en front
// WORKFLOW STATES
define("_WF_DISPLAYED_STATE_VALUE", "3",true); // id de l'�tape du workflow correspond � l'�tat Publi� et
					       // devant �tre affich� en front

// PAGINATION des R�sultats
define("_NB_ENR_PHOTOTHEQUE_RES",12); // nb max d'enregistrement par page dans la phototheque
define("_NB_ENR_PAGE_RES",10); // nb max d'enregistrement par page
define("_NB_PAGE_TOT_RES",5); // nb max de page affich�e en bas de page dans la navigation		     
define("_NB_ENR_PAGE_RES_OFFRE",5); // nb max d'enregistrement par page
define("_URL_PAGE_PAR_DEFAUT","editorial.php"); // uri de la page par d�faut du site courant

// Moteurs de filtres
define("_NB_MIN_RES_FOR_FILTER",10); //Nb de resultats de recherche � partir duquel on affiche les moteurs de filtres


//Liste de resultats
define("_NB_DESCRIPTION_MAX_CARACT",250); //Nb de caract�res maximum � afficher sur les listes de resultats

//Profil
define("_PROFIL_CENTRE", 4);

//TYPE NAV
define("_ID_SITE", 1);


//Environnement Montagne
define("_ID_ENVIRONNEMENT_MONTAGNE",5);

//ID LANGUE
define("_ID_FR",1);
define("_ID_EN",2);
define("_ID_ES",3);
define("_ID_DE",5);

//Type Contrat
define("_ID_CDI",1);

//Type Nav 
define("_NAV_SITE", 1);
define("_NAV_FOOTER", 2);

// NAV id des pages sp�cifiques
define("_NAV_ACCUEIL", 1);

//A CHACUN SON SEJOUR
define("_NAV_SEJOUR", 2);

define("_NAV_SEJOUR_MOINS_18_ANS", 3);
define("_NAV_CONTACT", 8);
define("_NAV_NEWSLETTER", 9);
define("_NAV_BROCHURE", 10);
define("_NAV_CLASSE_DECOUVERTE", 17);
define("_NAV_ACCUEIL_GROUPES_SCOLAIRES", 18);
define("_NAV_CVL", 19);
define("_NAV_INSCRIPTION_MEMBRE", 91);
define("_NAV_INSCRIPTION_PRESSE", 91);

define("_NAV_SEJOUR_REUNION", 20);
define("_NAV_ACCEUIL_REUNIONS", 21);
define("_NAV_INCENTIVE", 22);
define("_NAV_SEMINAIRES", 23);

define("_NAV_SEJOUR_DECOUVERTE", 24);
define("_NAV_ACCUEIL_GROUPE", 25);
define("_NAV_ACCUEIL_SPORTIF", 26);
define("_NAV_SEJOURS_TOURISTIQUES_GROUPE", 27);
define("_NAV_STAGES_THEMATIQUES_GROUPE", 28);
define("_NAV_ACCUEIL_INDIVIDUEL", 29);
define("_NAV_SHORT_BREAK", 30);
define("_NAV_ACTUALITE", 49);
define("_NAV_BON_PLAN", 50);


define("_NAV_STAGES_THEMATIQUES_INDIVIDUEL", 31);
define("_NAV_ESPACE_EMPLOI", 68);
define("_NAV_OFFRE_EMPLOI_LISTE", 69);
define("_NAV_CANDIDATURE_SPONTANEE", 70);
define("_NAV_DEVENIR_EE", 72);
define("_NAV_FICHE_CENTRE", 77);
define("_NAV_OFFRE_EMPLOI_FICHE", 78);
define("_NAV_OFFRE_EMPLOI_CANDIDATURE", 79);


define("_NAV_CONTACT_SEJOUR", 80);

define("_NAV_DEMANDE_PRESSE_OK", 92);
define("_NAV_DEMANDE_PRESSE_PAS_OK", 93);

define ('_NAV_CHARTE_GRAPHIQUE', 53);
define ('_NAV_CR_REUNION', 54);
define ('_NAV_DEV_DURABLE', 55);
define ('_NAV_ACTU', 56);
define ('_NAV_REGLEMENTAIRE', 58);
define ('_NAV_REF_FOURNISSEUR', 59);
define ('_NAV_EE_EEC', 61);
define ('_NAV_ETAPES_ECHOS', 62);
define ("_NAV_FORMULAIRE_NEW_PROJET", 83);
//define ("_NAV_FORMULAIRE_NEW_CENTRE", 83);
define ("_NAV_INFOS_FOURNISSEUR", 84);
define ("_NAV_LAISSEZ_AVIS", 85);


define ("_NAV_MDP_OUBLIE_PRESSE", 102);
define ("_NAV_ESPACE_PRESSE", 15);
define ("_NAV_DOSSIER_PRESSE", 86);
define ("_NAV_PHOTOTHEQUE", 87);

define ("_NAV_RECHERCHE", 88);
define('_NAV_FICHE_ORGANISATEUR_CVL', 89);

define("_Adresse_EE","27 rue de Turbigo<br />75002 Paris - France");
define("_Horaire_EE","Du lundi au vendredi <br />de 9h30 &agrave; 18h");
define("_TEL_EE","T&eacute;l. : +33 (0)1 40 26 57 64<br />Fax : +33 (0)1 40 26 58 20");



$GLOBALS["_NAV_SEJOUR"] = array(_NAV_CLASSE_DECOUVERTE,
								_NAV_ACCUEIL_GROUPES_SCOLAIRES,
								_NAV_CVL,
								_NAV_ACCEUIL_REUNIONS,
								_NAV_INCENTIVE,
								_NAV_SEMINAIRES,
								_NAV_ACCUEIL_GROUPE,
								_NAV_ACCUEIL_SPORTIF,
								_NAV_SEJOURS_TOURISTIQUES_GROUPE,
								_NAV_STAGES_THEMATIQUES_GROUPE,
								_NAV_ACCUEIL_INDIVIDUEL,
								_NAV_SHORT_BREAK,
								_NAV_STAGES_THEMATIQUES_INDIVIDUEL);
								
								
$GLOBALS["_NAV_SEJOUR_MOINS_18_ANS"] = array(_NAV_CLASSE_DECOUVERTE,
											 _NAV_ACCUEIL_GROUPES_SCOLAIRES,
											 _NAV_CVL);			
											
$GLOBALS["_NAV_SEJOUR_REUNION"] = array(_NAV_ACCEUIL_REUNIONS,
										_NAV_INCENTIVE,
										_NAV_SEMINAIRES);			
										
$GLOBALS["_NAV_SEJOUR_DECOUVERTE"] = array(	_NAV_ACCUEIL_GROUPE,
											_NAV_ACCUEIL_SPORTIF,
											_NAV_SEJOURS_TOURISTIQUES_GROUPE,
											_NAV_STAGES_THEMATIQUES_GROUPE,
											_NAV_ACCUEIL_INDIVIDUEL,
											_NAV_SHORT_BREAK,
											_NAV_STAGES_THEMATIQUES_INDIVIDUEL);		

//Sejours pouvants �tre affich�s en version etrang�re
$GLOBALS["_NAV_SEJOUR_V_ETRANGERE"] = array( _NAV_ACCUEIL_GROUPES_SCOLAIRES,
											 _NAV_CVL,
											 _NAV_ACCEUIL_REUNIONS,
											 _NAV_ACCUEIL_GROUPE,
											 _NAV_ACCUEIL_SPORTIF,
											 _NAV_SEJOURS_TOURISTIQUES_GROUPE,
											 _NAV_ACCUEIL_INDIVIDUEL,
											 _NAV_SHORT_BREAK,94,95,96);			
																																						

$GLOBALS["_NAV_SEJOUR_TABLE"] = array (	_NAV_CLASSE_DECOUVERTE 			   => "classe_decouverte",
										_NAV_ACCUEIL_GROUPES_SCOLAIRES 	   => "accueil_groupes_scolaires",
										_NAV_CVL 						   => "cvl",
										_NAV_ACCEUIL_REUNIONS 			   => "accueil_reunions",
										_NAV_INCENTIVE 					   => "seminaires",
										_NAV_SEMINAIRES 				   => "seminaires",
										_NAV_ACCUEIL_GROUPE 			   => "accueil_groupes_jeunes_adultes",
										_NAV_ACCUEIL_SPORTIF 			   => "accueil_groupes_jeunes_adultes",
										_NAV_SEJOURS_TOURISTIQUES_GROUPE   => "sejours_touristiques",
										_NAV_STAGES_THEMATIQUES_GROUPE 	   => "stages_thematiques_groupes",
										_NAV_ACCUEIL_INDIVIDUEL 		   => "accueil_individuels_familles",
										_NAV_SHORT_BREAK 				   => "short_breaks",
										_NAV_STAGES_THEMATIQUES_INDIVIDUEL => "stages_thematiques_individuels");	
										
										

$GLOBALS["_NAV_TRAD_SEJOUR_TABLE"] = array (	_NAV_CLASSE_DECOUVERTE 			   => "trad_classe_decouverte",
												_NAV_ACCUEIL_GROUPES_SCOLAIRES 	   => "trad_accueil_groupes_scolaires",
												_NAV_CVL 						   => "trad_cvl",
												_NAV_ACCEUIL_REUNIONS 			   => "trad_accueil_reunions",
												_NAV_INCENTIVE 					   => "trad_seminaires",
												_NAV_SEMINAIRES 				   => "trad_seminaires",
												_NAV_ACCUEIL_GROUPE 			   => "trad_accueil_groupes_jeunes_adultes",
												_NAV_ACCUEIL_SPORTIF 			   => "trad_accueil_groupes_jeunes_adultes",
												_NAV_SEJOURS_TOURISTIQUES_GROUPE   => "trad_sejours_touristiques",
												_NAV_STAGES_THEMATIQUES_GROUPE 	   => "trad_stages_thematiques_groupes",
												_NAV_ACCUEIL_INDIVIDUEL 		   => "trad_accueil_individuels_familles",
												_NAV_SHORT_BREAK 				   => "trad_short_breaks",
												_NAV_STAGES_THEMATIQUES_INDIVIDUEL => "trad_stages_thematiques_individuels");	
										

$GLOBALS["_NAV_SEJOUR_NOM"] = array (	_NAV_CLASSE_DECOUVERTE 			   => "nom",
										_NAV_ACCUEIL_GROUPES_SCOLAIRES 	   => "nom_centre",
										_NAV_CVL 						   => "nom",
										_NAV_ACCEUIL_REUNIONS 			   => "nom_centre",
										_NAV_INCENTIVE 					   => "nom",
										_NAV_SEMINAIRES 				   => "nom",
										_NAV_ACCUEIL_GROUPE 			   => "nom_centre",
										_NAV_ACCUEIL_SPORTIF 			   => "nom_centre",
										_NAV_SEJOURS_TOURISTIQUES_GROUPE   => "trad_nom_sejour",
										_NAV_STAGES_THEMATIQUES_GROUPE 	   => "trad_nom_stage",
										_NAV_ACCUEIL_INDIVIDUEL 		   => "nom_centre",
										_NAV_SHORT_BREAK 				   => "trad_nom",
										_NAV_STAGES_THEMATIQUES_INDIVIDUEL => "trad_nom");											

//Diff�rents types de s�minaires										
define('_CONST_SEJOUR_SEMINAIRE_THEME_VERT',1);
define('_CONST_SEJOUR_SEMINAIRE_THEME_ESPRIT_EQUIPE',2);
define('_CONST_SEJOUR_SEMINAIRE_THEME_PARTAGE_VALEUR',3);


//Diff�rents type d'accueil r�union
define('_CONST_CENTRE_CAPACITE_REU_10_20',	 1);
define('_CONST_CENTRE_CAPACITE_REU_21_40',	 2);
define('_CONST_CENTRE_CAPACITE_REU_41_80',	 3);
define('_CONST_CENTRE_CAPACITE_REU_81_100',	 4);
define('_CONST_CENTRE_CAPACITE_REU_101_140', 5);
define('_CONST_CENTRE_CAPACITE_REU_141_200', 6);
define('_CONST_CENTRE_CAPACITE_REU_MORE_200',7);

//Diff�rents type d'accueil r�union
define('_CONST_CENTRE_CAPACITE_LITS_100',		1);
define('_CONST_CENTRE_CAPACITE_LITS_100_150',	2);
define('_CONST_CENTRE_CAPACITE_LITS_150_200',	3);
define('_CONST_CENTRE_CAPACITE_LITS_MORE_200',	4);
define('_CONST_CENTRE_CAPACITE_LITS_MORE_100',	5);
define('_CONST_CENTRE_CAPACITE_LITS_MORE_150',	6);
define('_CONST_CENTRE_CAPACITE_LITS_100_200',	7);


//Diff�rentes actualit� th�matiques 
define('_CONST_ACTU_THEMATIQUE_GENERALE',			1);
define('_CONST_ACTU_THEMATIQUE_MOINS_18_ANS',		2);
define('_CONST_ACTU_THEMATIQUE_SEMINAIRE_REUNION',	3);
define('_CONST_ACTU_THEMATIQUE_SEJOUR_INDIVIDUEL',	4);
define('_CONST_ACTU_THEMATIQUE_SEJOUR_GROUPE',		5);
define('_CONST_ACTU_THEMATIQUE_INFO_RESEAU',		6);


//LES DESTINATIONS
define("_NAV_DESTINATIONS", 4);
define ("_NAV_CENTRES_MER", 39);
define ("_NAV_CENTRES_MONTAGNE", 40);
define ("_NAV_CENTRES_CAMPAGNE", 41);
define ("_NAV_CENTRES_VILLE", 42);
define ("_NAV_CENTRES_NEW", 43);
define ("_NAV_CENTRES_ACCUEIL_SPORTIFS", 44);
define ("_NAV_CENTRES_CULTUREL", 45);
define ("_NAV_CENTRES_AMBIANCE_FARNIENTE", 46);
define ("_NAV_CENTRES_100_NATURE", 47);
define ("_NAV_CENTRES_URBAN_TRIP", 48);


$GLOBALS["_NAV_DESTINATIONS"] = array(_NAV_CENTRES_MER,
								_NAV_CENTRES_MONTAGNE,
								_NAV_CENTRES_CAMPAGNE,
								_NAV_CENTRES_VILLE,
								_NAV_CENTRES_NEW);

//Diff�rents types d'environnements
define('_CONST_CENTRE_ENV_MER', 3);								
define('_CONST_CENTRE_ENV_MONTAGNE', 5);								
define('_CONST_CENTRE_ENV_VILLE', 1);								
define('_CONST_CENTRE_ENV_CAMPAGNE', 2);	
define('_CONST_CENTRE_ENV_MOYENNE_MONTAGNE', 4);	

//Diff�rents types d'ambiance
define('_CONST_CENTRE_AMB_SPORTIF', 1);		
define('_CONST_CENTRE_AMB_CULTUREL', 4);		
define('_CONST_CENTRE_AMB_FARNIENTE', 3);		
define('_CONST_CENTRE_AMB_100_NATURE', 2);		
define('_CONST_CENTRE_AMB_URBAN_TRIP', 5);		
								
					


define("_NAV_MOINS_18_ANS", 3);
define("_NAV_BLOG", 5);
define("_NAV_RESEAU", 6);
define("_NAV_ESPACE_MEMBRE", 7);
define("_NAV_POUR_VOS_REUNION", 20);
define("_NAV_DECOUVERTE_TOURISTIQUE", 24);
define ("_NAV_MDP_OUBLIE_MEMBRE", 63);


define("_CONST_TABLEDEF_NAVIGATION",324); // pour desactiver le with_user_rights sur le tabledef navigation

define("_CONST_TABLEDEF_PLUS_CENTRE",506);
define("_CONST_TABLEDEF_SITE_CENTRE",507);
define("_CONST_TABLEDEF_CENTRE",512);
define("_CONST_TABLEDEF_ACTUALITE",518);
define("_CONST_TABLEDEF_ACTUALITE_THEMATIQUE",519);
define("_CONST_TABLEDEF_BON_PLAN",520);
define("_CONST_TABLEDEF_ORGANISATEUR_CVL",523);
define("_CONST_TABLEDEF_CLASSE_DECOUVERTE",537);
define("_CONST_TABLEDEF_ACCUEIL_GROUPE",538);
define("_CONST_TABLEDEF_CVL",539);
define("_CONST_TABLEDEF_ACCUEIL_REUNION",540);
define("_CONST_TABLEDEF_SEMINAIRE",541);
define("_CONST_TABLEDEF_GROUPE_ADULTE",542);
define("_CONST_TABLEDEF_SEJOUR_TOURISTIQUE",545);
define("_CONST_TABLEDEF_SEJOUR_STAGE_THEM_GROUPE",547);
define("_CONST_TABLEDEF_SEJOUR_ACCUEIL_IND_FAMILLE",549);
define("_CONST_TABLEDEF_SEJOUR_SHORT_BREAK",553);
define("_CONST_TABLEDEF_SEJOUR_STAGE_THEM_INDIVIDUEL",555);
define("_CONST_TABLEDEF_PLUS_SEJOUR",556);
define("_CONST_TABLEDEF_LOISIRS_SEJOUR",558);
define("_CONST_TABLEDEF_SEJOUR_DATE_ACCESSIBLE",559);
define("_CONST_TABLEDEF_SEJOUR_SALLE_ACCUEIL_REUNION",560);
define("_CONST_TABLEDEF_SEJOUR_RESTAURATION_REPAS",561);
define("_CONST_TABLEDEF_SEJOUR_RESTAURATION_PAUSE",562);
define("_CONST_TABLEDEF_SEJOUR_RESTAURATION_COCKTAIL",563);
define("_CONST_TABLEDEF_SEJOUR_FORMULE_REUNION",564);
define("_CONST_TABLEDEF_SEJOUR_DETAIL",565);
define("_CONST_TABLEDEF_OFFRE_EMPLOI",574);
define("_CONST_TABLEDEF_MEMBRE",616);


// CONFIG FACEBOOK SDK - LOCAL TEST
define("_CONST_FB_API_APP_ID", '560177854025349');
define("_CONST_FB_API_SECRET_ID", '62ce563cd5026fb14a45eac8ff5a29bb');
define("_CONST_FB_API_TOKEN", 'CAAH9epIADoUBAAnZB8rhEpBOjYGuWVE9Piww1aIuQmwwlHZCzIfqpnbRu0KRXM2CJxw6e4YQzlbUFQZABeZCzItbBGIEdbc57KmR4GnaBNJ8x1QK7yOxfNn3t9HAW3ZCHlslcy8cFJwod0hkwXgeBmQheDE7NDvVRDZBqllFZBPJUgfBjvZBfCR6');
define("_CONST_FB_API_PAGE_ID", '355523337903149');

// CONFIG FACEBOOK SDK - PROD
/*
define("_CONST_FB_API_APP_ID", '508218265910649');
define("_CONST_FB_API_SECRET_ID", 'f32cbb96c6ea502926913dff801c6919');
define("_CONST_FB_API_TOKEN", 'CAAHOOMk1PXkBAPfHrygBzRllr647DNLnwpOIKUuBkKg3vbgSobv6EPpZBxFt80esootMonUmTmdRHZAJw2QCNrAS0iSKHOr84iaFvmms6BglnXKhXN51CybP30XfufdWLqSNvObEm1YiWRKVIci0F5VSgaIdZC9TX3s5jjcHgZDZD');
define("_CONST_FB_API_PAGE_ID", '227317984016143');
*/

$GLOBALS["_NAME_TABLE_SEJOUR"] = array( "classe_decouverte",
										"accueil_groupes_jeunes_adultes",
										"accueil_groupes_scolaires",
										"accueil_individuels_familles",
										"accueil_reunions",
										"cvl",
										"sejours_touristiques",
										"seminaires",
										"short_breaks",
										"stages_thematiques_groupes",
										"stages_thematiques_individuels");



$GLOBALS["_CONST_TABLEDEF_SEJOUR"] = array( _CONST_TABLEDEF_CLASSE_DECOUVERTE,
                                            _CONST_TABLEDEF_ACCUEIL_GROUPE,
                                            _CONST_TABLEDEF_CVL,
                                            _CONST_TABLEDEF_SEMINAIRE,
                                            _CONST_TABLEDEF_GROUPE_ADULTE,
                                            _CONST_TABLEDEF_SEJOUR_TOURISTIQUE,
                                            _CONST_TABLEDEF_ACCUEIL_REUNION,
                                            _CONST_TABLEDEF_SEJOUR_STAGE_THEM_GROUPE,
                                            _CONST_TABLEDEF_SEJOUR_ACCUEIL_IND_FAMILLE,
                                            _CONST_TABLEDEF_SEJOUR_SHORT_BREAK,
                                            _CONST_TABLEDEF_SEJOUR_STAGE_THEM_INDIVIDUEL);

$GLOBALS["_NAV_SEJOUR_TABLEDEF"] = array (	_NAV_CLASSE_DECOUVERTE 		   => _CONST_TABLEDEF_CLASSE_DECOUVERTE,
										_NAV_ACCUEIL_GROUPES_SCOLAIRES 	   => _CONST_TABLEDEF_ACCUEIL_GROUPE,
										_NAV_CVL 						   => _CONST_TABLEDEF_CVL,
										_NAV_ACCEUIL_REUNIONS 			   => _CONST_TABLEDEF_ACCUEIL_REUNION,
										_NAV_INCENTIVE 					   => _CONST_TABLEDEF_SEMINAIRE,
										_NAV_SEMINAIRES 				   => _CONST_TABLEDEF_SEMINAIRE,
										_NAV_ACCUEIL_GROUPE 			   => _CONST_TABLEDEF_GROUPE_ADULTE,
										_NAV_ACCUEIL_SPORTIF 			   => _CONST_TABLEDEF_GROUPE_ADULTE,
										_NAV_SEJOURS_TOURISTIQUES_GROUPE   => _CONST_TABLEDEF_SEJOUR_TOURISTIQUE,
										_NAV_STAGES_THEMATIQUES_GROUPE 	   => _CONST_TABLEDEF_SEJOUR_STAGE_THEM_GROUPE,
										_NAV_ACCUEIL_INDIVIDUEL 		   => _CONST_TABLEDEF_SEJOUR_ACCUEIL_IND_FAMILLE,
										_NAV_SHORT_BREAK 				   => _CONST_TABLEDEF_SEJOUR_SHORT_BREAK,
										_NAV_STAGES_THEMATIQUES_INDIVIDUEL => _CONST_TABLEDEF_SEJOUR_STAGE_THEM_INDIVIDUEL);                                            
                                            
//**************************************************************************************************/
// 					MOD REWRITE 
// constantes utilis�es pour r��crire les url par mod_rewrite : voir .htaccess � la racine du front
//**************************************************************************************************/       
?>