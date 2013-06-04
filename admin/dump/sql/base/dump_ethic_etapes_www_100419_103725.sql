-- MySQL dump 10.11
--
-- Host: 10.63.1.135    Database: ethic_etapes_www
-- ------------------------------------------------------
-- Server version	5.0.32-Debian_7etch8-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `_dic_data`
--

DROP TABLE IF EXISTS `_dic_data`;
CREATE TABLE `_dic_data` (
  `id__dic_data` int(11) unsigned NOT NULL auto_increment,
  `id__table_def` int(11) unsigned default '0',
  `nom_table` varchar(255) default NULL,
  `libelle` varchar(255) default NULL,
  `template` mediumtext,
  `type` int(10) default '0',
  `id__workflow` int(11) unsigned default NULL,
  `position_in_dropdown` int(9) unsigned default NULL,
  `id__nav` varchar(254) default NULL,
  `id__profil` varchar(254) default NULL,
  PRIMARY KEY  (`id__dic_data`)
) ENGINE=MyISAM AUTO_INCREMENT=370 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_dic_data`
--

LOCK TABLES `_dic_data` WRITE;
/*!40000 ALTER TABLE `_dic_data` DISABLE KEYS */;
INSERT INTO `_dic_data` VALUES (4,7,'_dic_data','_dic_data',NULL,0,1,NULL,NULL,NULL),(6,2,'_nav','_nav',NULL,0,1,NULL,NULL,NULL),(7,91,'_newsletter','_newsletter',NULL,0,1,NULL,NULL,NULL),(8,4,'_param','_param',NULL,0,1,NULL,NULL,NULL),(9,68,'_profil','_profil',NULL,0,1,NULL,NULL,NULL),(10,0,'_stat','_stat',NULL,0,1,NULL,NULL,NULL),(11,6,'_style','_style',NULL,0,1,NULL,NULL,NULL),(12,1,'_table_def','_table_def',NULL,0,1,NULL,NULL,NULL),(13,49,'_user','_user',NULL,0,1,NULL,NULL,NULL),(97,231,'_xsl_tpl','_xsl_tpl',NULL,0,1,NULL,NULL,NULL),(98,233,'_object','_object','',0,1,NULL,NULL,NULL),(99,234,'_langue','_langue','',0,1,NULL,NULL,NULL),(100,235,'_workflow_state','_workflow_state','',0,1,NULL,NULL,NULL),(106,243,'_workflow_trans','_workflow_trans','',0,1,NULL,NULL,NULL),(107,246,'_workflow','_workflow','',0,1,NULL,NULL,NULL),(171,320,'_list_data','_list_data',NULL,0,NULL,NULL,NULL,NULL),(173,324,'navigation','navigation',NULL,2,NULL,NULL,NULL,NULL),(181,332,'portfolio_img','portfolio_img',NULL,2,NULL,NULL,NULL,NULL),(182,333,'portfolio_rub','portfolio_rub',NULL,1,NULL,NULL,NULL,NULL),(231,398,'_lib_champs','_lib_champs',NULL,0,NULL,NULL,NULL,NULL),(235,403,'_select_champ','_select_champ',NULL,0,NULL,NULL,NULL,NULL),(236,404,'format_mail','format_mail',NULL,2,NULL,NULL,NULL,NULL),(314,487,'_type_nav','_type_nav',NULL,0,NULL,NULL,NULL,NULL),(321,494,'_nav_site','_nav_site',NULL,0,NULL,NULL,NULL,NULL),(326,499,'param_home','param_home',NULL,2,NULL,NULL,NULL,NULL),(327,500,'tradotron','tradotron',NULL,2,NULL,NULL,NULL,NULL),(328,502,'centre_ambiance','centre_ambiance',NULL,2,NULL,NULL,NULL,NULL),(329,503,'centre_environnement','centre_environnement',NULL,2,NULL,NULL,NULL,NULL),(330,504,'centre_environnement_montagne','centre_environnement_montagne',NULL,2,NULL,NULL,NULL,NULL),(340,514,'centre_classement','centre_classement',NULL,2,NULL,NULL,NULL,NULL),(332,506,'centre_les_plus','centre_les_plus',NULL,2,NULL,NULL,NULL,NULL),(333,507,'centre_site_touristique','centre_site_touristique',NULL,2,NULL,NULL,NULL,NULL),(334,508,'centre_activite','centre_activite',NULL,2,NULL,NULL,NULL,NULL),(335,509,'centre_equipement','centre_equipement',NULL,2,NULL,NULL,NULL,NULL),(336,510,'centre_service','centre_service',NULL,2,NULL,NULL,NULL,NULL),(337,511,'centre_espace_detente','centre_espace_detente',NULL,2,NULL,NULL,NULL,NULL),(338,512,'centre','centre',NULL,2,NULL,NULL,NULL,NULL),(339,513,'centre_detention_label','centre_detention_label',NULL,2,NULL,NULL,NULL,NULL),(341,515,'centre_detail_hebergement','centre_detail_hebergement',NULL,2,NULL,NULL,NULL,NULL),(342,516,'centre_type_chambre','centre_type_chambre',NULL,2,NULL,NULL,NULL,NULL),(343,518,'actualite','actualite',NULL,2,NULL,NULL,NULL,NULL),(344,519,'actualite_thematique','actualite_thematique',NULL,2,NULL,NULL,NULL,NULL),(345,520,'bon_plan','bon_plan',NULL,2,NULL,NULL,NULL,NULL),(346,521,'sejour_thematique','sejour_thematique',NULL,2,NULL,NULL,NULL,NULL),(347,522,'participant_age','participant_age',NULL,2,NULL,NULL,NULL,NULL),(348,523,'organisateur_cvl','organisateur_cvl',NULL,2,NULL,NULL,NULL,NULL),(349,524,'centre_region','centre_region',NULL,2,NULL,NULL,NULL,NULL),(352,527,'sejour_categorie','sejour_categorie',NULL,2,NULL,NULL,NULL,NULL),(351,526,'sejour','sejour',NULL,2,NULL,NULL,NULL,NULL),(353,528,'sejour_theme','sejour_theme',NULL,2,NULL,NULL,NULL,NULL),(354,529,'sejour_niveau_scolaire','sejour_niveau_scolaire',NULL,2,NULL,NULL,NULL,NULL),(355,530,'sejour_priode_disponibilite','sejour_priode_disponibilite',NULL,2,NULL,NULL,NULL,NULL),(356,531,'sejour_nb_lit__par_chambre','sejour_nb_lit__par_chambre',NULL,2,NULL,NULL,NULL,NULL),(357,532,'sejour_tranche_age','sejour_tranche_age',NULL,2,NULL,NULL,NULL,NULL),(358,533,'sejour_accueil_handicap','sejour_accueil_handicap',NULL,2,NULL,NULL,NULL,NULL),(359,534,'sejour_materiel_service','sejour_materiel_service',NULL,2,NULL,NULL,NULL,NULL),(360,535,'sejour_theme_seminaire','sejour_theme_seminaire',NULL,2,NULL,NULL,NULL,NULL),(361,536,'gab_texte_riche','Texte riche','',3,2,1,'2,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,4,39,40,41,42,43,44,45,46,47,48,5,49,50,51,52,6,32,33,34,35,36,37,38,64,65,66,67,68,69,70,71,72,73,74,75,76,7,53,54,55,56,57,58,59,60,61,62,63,8,9,10,11,12,13,14,15,16','3,1,2'),(362,537,'classe_decouverte','classe_decouverte',NULL,2,NULL,NULL,NULL,NULL),(363,538,'accueil_groupes_scolaires','accueil_groupes_scolaires',NULL,2,NULL,NULL,NULL,NULL),(364,539,'cvl','cvl',NULL,2,NULL,NULL,NULL,NULL),(365,540,'acceuil_reunions','acceuil_reunions',NULL,2,NULL,NULL,NULL,NULL),(366,541,'seminaires','seminaires',NULL,2,NULL,NULL,NULL,NULL),(367,542,'accueil_groupes_jeunes_adultes','accueil_groupes_jeunes_adultes',NULL,2,NULL,NULL,NULL,NULL),(368,543,'sejour_services_sportifs','sejour_services_sportifs',NULL,2,NULL,NULL,NULL,NULL),(369,544,'sejour_centre_adapte','sejour_centre_adapte',NULL,2,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `_dic_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_error`
--

DROP TABLE IF EXISTS `_error`;
CREATE TABLE `_error` (
  `id__error` int(11) unsigned NOT NULL auto_increment,
  `_error` varchar(255) default NULL,
  `date_auto` date default NULL,
  `heure_auto` datetime default NULL,
  `session_id` varchar(255) default NULL,
  `error_num` varchar(255) default NULL,
  `error_desc` varchar(255) default NULL,
  `redirect_error_notes` varchar(255) default NULL,
  `redirect_url` varchar(255) default NULL,
  `request_uri` varchar(255) default NULL,
  `script_uri` varchar(255) default NULL,
  `http_referer` varchar(255) default NULL,
  `http_host` varchar(255) default NULL,
  `domain_addr` varchar(255) default NULL,
  `domain_ip` varchar(255) default NULL,
  PRIMARY KEY  (`id__error`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_error`
--

LOCK TABLES `_error` WRITE;
/*!40000 ALTER TABLE `_error` DISABLE KEYS */;
/*!40000 ALTER TABLE `_error` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_langue`
--

DROP TABLE IF EXISTS `_langue`;
CREATE TABLE `_langue` (
  `id__langue` int(11) unsigned NOT NULL auto_increment,
  `_langue` varchar(255) default NULL,
  `_langue_by_default` int(1) default NULL,
  `_langue_abrev` varchar(255) default NULL,
  `_langue_ext_sql` varchar(255) default NULL,
  `picto` varchar(100) default NULL,
  `afficher` int(1) unsigned NOT NULL default '0',
  `ordre` int(9) default '0',
  PRIMARY KEY  (`id__langue`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_langue`
--

LOCK TABLES `_langue` WRITE;
/*!40000 ALTER TABLE `_langue` DISABLE KEYS */;
INSERT INTO `_langue` VALUES (1,'Fran&ccedil;ais',1,'fr','_fr','picto_fr_1.gif',1,1),(2,'English',0,'en','_en','picto_en_2.gif',1,2),(3,'Espa&ntilde;ol',0,'es','_es','picto_sp_3.gif',1,3),(5,'Allemand',0,'de','_de','picto_jp_5.gif',1,4);
/*!40000 ALTER TABLE `_langue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_lib_champs`
--

DROP TABLE IF EXISTS `_lib_champs`;
CREATE TABLE `_lib_champs` (
  `id__lib_champs` int(11) unsigned NOT NULL auto_increment,
  `field` varchar(255) default NULL,
  `list_libelle` varchar(255) default NULL,
  `libelle` varchar(255) default NULL,
  `up_title` varchar(255) default NULL,
  `description` mediumtext,
  `id__table_def` int(11) unsigned default NULL,
  `multilingue` int(1) default '0',
  PRIMARY KEY  (`id__lib_champs`)
) ENGINE=MyISAM AUTO_INCREMENT=545 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_lib_champs`
--

LOCK TABLES `_lib_champs` WRITE;
/*!40000 ALTER TABLE `_lib_champs` DISABLE KEYS */;
INSERT INTO `_lib_champs` VALUES (2,'_nav','','','','',2,1),(3,'libelle','','','','',500,1),(4,'libelle','','','','',502,1),(5,'libelle','','','','',503,1),(6,'libelle','','','','',504,1),(7,'libelle','','','','',505,1),(8,'libelle','','','','',506,1),(9,'libelle','','','','',507,1),(10,'libelle','','','','',508,1),(11,'libelle','','','','',509,1),(12,'libelle','','','','',510,1),(13,'libelle','','','','',511,1),(494,'presentation_region','','Texte de prÃ©sentation de la rÃ©gion','<hr /><strong>DÃ©couverte touristique</strong>','',512,0),(490,'agrement_tourisme_texte','','Si oui :','','',512,0),(491,'agrement_ddass','','DDASS :','','',512,0),(492,'agrement_ddass_texte','','Si oui :','','',512,0),(493,'id_centre_detention_label','',' ','<hr /><strong>DÃ©tention de labels</strong>','',512,0),(489,'agrement_tourisme','','Tourisme : ','','',512,0),(25,'libelle','','','','',513,1),(26,'libelle','','','','',514,1),(488,'agrement_jeunesse_texte','','Si oui :','','',512,0),(487,'agrement_jeunesse','','Jeunesse et sports :','','',512,0),(485,'agrement_edu_nationale','','Education nationale :','<hr /><strong>AgrÃ©ments</strong>','',512,0),(486,'agrement_edu_nationale_texte','','Si oui :','','',512,0),(482,'capacite_salle_min','','CapacitÃ© des salles min :','<hr />','',512,0),(483,'capacite_salle_max','','CapacitÃ© des salles max :','<hr />','',512,0),(484,'nb_chambre_handicap','','Nb. :','Nombre de chambres accessibles aux personnes Ã  mobilitÃ© rÃ©duite:','',512,0),(481,'nb_salle_reunion','','Nombre de salle de rÃ©union :','<hr />','',512,0),(480,'couvert_self','','self service ou plats sur table :','','',512,0),(479,'couvert_assiette','','Ã  lâ€™assiette :','','',512,0),(477,'nb_lit','','Nombres de lits :','<hr />','',512,0),(478,'nb_couvert','','Nombre de couverts :','<hr />','',512,0),(475,'id_centre_classement_1','','Classement 2 :','<hr />','',512,0),(476,'nb_chambre','','Nombre de chambres :','<hr />','',512,0),(474,'id_centre_classement','','Classement 1 :','<hr />','',512,0),(472,'acces_bus_metro_texte','','Si oui :','','',512,1),(473,'presentation','','PrÃ©sentation du centre :','<hr />','',512,1),(470,'acces_avion_texte','','Si oui :','','',512,1),(471,'acces_bus_metro','','AccÃ¨s par bus / mÃ©tro :','<hr />','',512,0),(469,'acces_avion','','AccÃ¨s par avion :','<hr />','',512,0),(464,'site_internet','','Site Internet :','<hr />','',512,0),(465,'acces_route','','AccÃ¨s par la route :','<hr />','',512,0),(468,'acces_train_texte','','Si oui :','','',512,1),(467,'acces_train','','AccÃ¨s par le train :','<hr />','',512,0),(466,'acces_route_texte','','Si oui :','','',512,1),(463,'email','','Email :','<hr />','',512,0),(462,'region_administrative','','RÃ©gion administrative :','<hr />','',512,0),(461,'fax','','Fax :','<hr />','',512,0),(460,'telephone','','TÃ©lÃ©phone :','<hr />','',512,0),(458,'latitude','','Latitude :','<hr />','',512,0),(459,'longitude','','Longitude :','<hr />','',512,0),(457,'ville','','Ville :','<hr />','',512,0),(456,'code_postal','','Code postal :','<hr />','',512,0),(455,'adresse','','Adresse :','<hr />','',512,0),(454,'id_centre_environnement_montagne','','Massif :','Si lâ€™environnement Â« montagne Â» a Ã©tÃ© cochÃ©, prÃ©ciser quel massif :','',512,0),(453,'id_centre_environnement','','Â ','<hr /><strong>Environnement du centre</strong>','',512,0),(452,'id_centre_ambiance','','Â ','<hr /><strong>Ambiance du centre</strong>','',512,0),(451,'libelle','','Nom du centre :','','',512,0),(495,'id_centre_activite','','Â ','<hr /><strong>ActivitÃ©s</strong>','',512,0),(496,'id_centre_equipement','','Â ','<hr /><strong>Equippements sportifs et de loisirs</strong>','',512,0),(497,'id_centre_espace_detente','','Â ','<hr /><strong>Espace dÃ©tente</strong>','',512,0),(498,'libelle','','','','',518,1),(499,'description_courte','','','','',518,1),(500,'description_longue','','','','',518,1),(501,'description','','','','',520,1),(502,'libelle','','','','',521,1),(503,'libelle','','','','',522,1),(504,'libelle','','','','',523,1),(505,'resentation_organisme','','','','',523,1),(506,'projet_educatif','','','','',523,1),(507,'agrement_jeunesse_texte','','','','',523,1),(508,'libelle','','','','',526,1),(509,'libelle','','','','',528,1),(510,'libelle','','','','',529,1),(511,'libelle','','','','',530,1),(512,'libelle','','','','',531,1),(513,'libelle','','','','',532,1),(514,'libelle','','','','',533,1),(515,'libelle','','','','',534,1),(516,'nom_sejour','','','','',537,1),(517,'duree_sejour','','','','',537,1),(518,'prix_comprend','','','','',537,1),(519,'prix_ne_comprend_pas','','','','',537,1),(520,'interet_pedagogique','','','','',537,1),(521,'details','','','','',537,1),(522,'theme_seminaire','','','','',535,1),(523,'haute_saison','','','','',538,1),(524,'moyenne_saison','','','','',538,1),(525,'base_saison','','','','',538,1),(526,'conditions_scolaires','','','','',538,1),(527,'nom_sejour','','','','',539,1),(528,'duree_sejour','','','','',539,1),(529,'prix_comprend','','','','',539,1),(530,'prix_ne_comprend_pas','','','','',539,1),(531,'presentation','','','','',539,1),(532,'commentaires_salles','','','','',540,1),(533,'nom_seminaire','','','','',541,1),(534,'presentation','','','','',541,1),(535,'prix_comprend','','','','',541,1),(536,'prix_ne_comprend_pas','','','','',541,1),(537,'descriptif','','','','',541,1),(538,'conditions_groupes','','','','',542,1),(539,'conditions_professionnels','','','','',542,1),(540,'installations_autres','','','','',542,1),(541,'sejour_services_sportifs','','','','',543,1),(542,'libelle','','','','',543,1),(543,'libelle','','','','',544,1),(544,'commentaire_accueil_sportifs','','','','',542,1);
/*!40000 ALTER TABLE `_lib_champs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_list_data`
--

DROP TABLE IF EXISTS `_list_data`;
CREATE TABLE `_list_data` (
  `id__list_data` int(11) unsigned NOT NULL auto_increment,
  `_list_data` varchar(255) default NULL,
  `data` text,
  `control_5` varchar(253) default NULL,
  `order_8` varchar(253) default NULL,
  `align_9` varchar(253) default NULL,
  PRIMARY KEY  (`id__list_data`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_list_data`
--

LOCK TABLES `_list_data` WRITE;
/*!40000 ALTER TABLE `_list_data` DISABLE KEYS */;
INSERT INTO `_list_data` VALUES (2,'Style : text-transform',' \r\nnone\r\nunderline\r\nblink\r\nline-through\r\noverline \r\noverline underline  ','radio','sort','horizontal'),(3,'Style : font-weight',' \r\nbold\r\nnormal ','radio','sort','horizontal'),(4,'Oui / Non','Non\r\nOui','radio','sort','left'),(5,'Types de controles','\nlistbox\r\nlistbox multiple\r\ncheckbox\r\nradio','radio','','horizontal'),(6,'Civilit&eacute;s','\r\nM.\r\nMme\r\nMlle\r\nDocteur\r\nProfesseur','radio','','horizontal'),(7,'Style : text-transform','none\r\ncapitalize\r\nuppercase\r\nlowercase','listbox','sort',NULL),(8,'PHP : array sort','\n\r\nsort\r\nrsort','listbox','','horizontal'),(9,'Affichage : Alignement','\n\r\nleft\r\nright\r\nvertical\r\nhorizontal\r\ntop\r\nbottom','listbox','',''),(10,'Valeures de 0 &agrave; 10','\n0\r\n1\r\n2\r\n3\r\n4\r\n5\r\n6\r\n7\r\n8\r\n9\r\n10','radio','','horizontal'),(11,'Fonts size','\r\n8px\r\n9px\r\n10px\r\n11px\r\n12px\r\n13px\r\n14px\r\n15px','radio','','horizontal'),(16,'Portfolio : Right','PortFolio\r\nUpload\r\nPortFolio & Upload','radio','','vertical'),(17,'Valeurs de 1 &agrave; 5','1\r\n2\r\n3\r\n4\r\n5','radio','','horizontal'),(18,'Insa : Type de liens sur home','acces directs\r\nzoom sur haut\r\nzoom sur bas\r\nlien outils transversaux','radio','','vertical'),(19,'Gauche, Centre ou droite','Gauche\r\nCentre\r\nDroite','radio','','left'),(20,'Font type','Arial\r\nVerdana','listbox','sort','left'),(22,'target_url','_self\r\n_parent\r\n_top\r\n_blank','listbox','',''),(23,'ThÃ¨mes','expressions\r\nle sport, un bel effort\r\npatrimoine et terroir\r\ncitoyennetÃ©, environnement et dÃ©veloppement durable','checkbox','sort','left'),(24,'Niveau(x) scolaire(s)','Maternelle (4-6 ans)\r\nCP-CE (7-9 ans)\r\nCM (10-11 ans)\r\n6e-5e (12-13 ans)\r\n4e-3e (14-15 ans)\r\nLycÃ©e (16-18 ans)\r\nEnseignement agricole','checkbox','','left'),(25,'Saisons','printemps\r\nÃ©tÃ©\r\nautomne\r\nhiver','checkbox','','left'),(26,'Nombre de lits','1 lit\r\n2 lits\r\n3-4 lits\r\n4-6 lits\r\nplus de 6 lits','checkbox','','left'),(27,'Prix du sÃ©jour par enfant','par enfant et par jour\r\npar enfant et par sÃ©jour','checkbox','','left');
/*!40000 ALTER TABLE `_list_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_menu`
--

DROP TABLE IF EXISTS `_menu`;
CREATE TABLE `_menu` (
  `id__menu` int(11) unsigned NOT NULL auto_increment,
  `_menu` varchar(255) default NULL,
  `ordre` int(9) default NULL,
  `menu_width` int(10) default NULL,
  `id__menu_1` varchar(254) default NULL,
  `afficher` int(1) default NULL,
  PRIMARY KEY  (`id__menu`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_menu`
--

LOCK TABLES `_menu` WRITE;
/*!40000 ALTER TABLE `_menu` DISABLE KEYS */;
INSERT INTO `_menu` VALUES (1,'_(Aucun)',4,200,'1',0),(2,'Administrateur',12,200,'3,4,5',1),(3,'Generateur',8,250,'1',0),(4,'Menus',7,200,'1',0),(5,'Utilisateurs',6,200,'1',0),(6,'Outils',10,200,'9,8',1),(7,'Gestion de contenu',5,200,'1',1),(8,'XML',9,250,'1',0),(9,'Workflow',11,200,'1',0),(10,'PortFolio',7,200,'1',1),(11,'Divers',2,200,'1',1),(15,'Global',6,200,'1',1),(16,'Formulaires principaux',1,250,'1',1),(17,'Admin. Centre',2,250,'1',1),(18,'Infos pÃ©riodiques',2,200,'1',1),(19,'Admin. diverse',3,280,'1',1),(20,'Admin. Sejours',4,200,'1',1),(21,'Sejours',7,200,'1',1);
/*!40000 ALTER TABLE `_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_nav`
--

DROP TABLE IF EXISTS `_nav`;
CREATE TABLE `_nav` (
  `id__nav` int(11) unsigned NOT NULL auto_increment,
  `_nav` varchar(255) default NULL,
  `id__nav_pere` int(11) unsigned default '0',
  `ordre` int(9) default NULL,
  `selected` int(1) unsigned default '0',
  `url_page` varchar(255) default NULL,
  `id__type_nav` int(11) unsigned default NULL,
  PRIMARY KEY  (`id__nav`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_nav`
--

LOCK TABLES `_nav` WRITE;
/*!40000 ALTER TABLE `_nav` DISABLE KEYS */;
INSERT INTO `_nav` VALUES (1,'Accueil',0,1,1,NULL,1),(2,'',1,1,1,'',1),(3,'',2,1,1,'',0),(4,'',1,2,1,'',1),(5,'',1,3,1,'',1),(6,'',1,4,1,'',1),(7,'',1,5,1,'',1),(8,'',1,1,1,'',2),(9,'',1,2,1,'',2),(10,'',1,3,1,'',2),(11,'',1,4,1,'',2),(12,'',1,5,1,'',2),(13,'',1,6,1,'',2),(14,'',1,7,1,'',2),(15,'',1,8,1,'',2),(16,'',1,9,1,'',2),(17,'',3,1,1,'',0),(18,'',3,2,1,'',0),(19,'',3,3,1,'',0),(20,'',2,2,1,'',0),(21,'',20,1,1,'',0),(22,'',20,2,1,'',0),(23,'',20,3,1,'',0),(24,'',2,3,1,'',0),(25,'',24,1,1,'',0),(26,'',24,2,1,'',0),(27,'',24,3,1,'',0),(28,'',24,4,1,'',0),(29,'',24,5,1,'',0),(30,'',24,6,1,'',0),(31,'',24,7,1,'',0),(32,'',6,1,1,'',0),(33,'',32,1,1,'',0),(34,'',32,2,1,'',0),(35,'',32,3,1,'',0),(36,'',6,2,1,'',0),(37,'',36,1,1,'',0),(38,'',36,2,1,'',0),(39,'',4,1,1,'',0),(40,'',4,2,1,'',0),(41,'',4,3,1,'',0),(42,'',4,4,1,'',0),(43,'',4,5,1,'',0),(44,'',4,6,1,'',0),(45,'',4,7,1,'',0),(46,'',4,8,1,'',0),(47,'',4,9,1,'',0),(48,'',4,10,1,'',0),(49,'',5,1,1,'',0),(50,'',5,2,1,'',0),(51,'',5,3,1,'',0),(52,'',5,4,1,'',0),(53,'',7,1,1,'',0),(54,'',7,2,1,'',0),(55,'',7,3,1,'',0),(56,'',7,4,1,'',0),(57,'',7,5,1,'',0),(58,'',7,6,1,'',0),(59,'',7,7,1,'',0),(60,'',7,8,1,'',0),(61,'',7,9,1,'',0),(62,'',7,10,1,'',0),(63,'',7,11,1,'',0),(64,'',6,3,1,'',0),(65,'',64,1,1,'',0),(66,'',64,2,1,'',0),(67,'',64,3,1,'',0),(68,'',6,4,1,'',0),(69,'',68,1,1,'',0),(70,'',68,2,1,'',0),(71,'',68,3,1,'',0),(72,'',6,5,1,'',0),(73,'',72,1,1,'',0),(74,'',72,2,1,'',0),(75,'',72,3,1,'',0),(76,'',72,4,1,'',0);
/*!40000 ALTER TABLE `_nav` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_nav_site`
--

DROP TABLE IF EXISTS `_nav_site`;
CREATE TABLE `_nav_site` (
  `id__nav_site` int(11) unsigned NOT NULL auto_increment,
  `id__site_user` int(11) unsigned default NULL,
  `id__type_nav` varchar(254) default NULL,
  PRIMARY KEY  (`id__nav_site`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_nav_site`
--

LOCK TABLES `_nav_site` WRITE;
/*!40000 ALTER TABLE `_nav_site` DISABLE KEYS */;
INSERT INTO `_nav_site` VALUES (1,1,'2');
/*!40000 ALTER TABLE `_nav_site` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_newsletter`
--

DROP TABLE IF EXISTS `_newsletter`;
CREATE TABLE `_newsletter` (
  `id__newsletter` int(11) unsigned NOT NULL auto_increment,
  `_newsletter` varchar(255) NOT NULL default '',
  `date` date NOT NULL default '0000-00-00',
  `descriptif` mediumtext NOT NULL,
  `numero` int(10) default NULL,
  PRIMARY KEY  (`id__newsletter`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_newsletter`
--

LOCK TABLES `_newsletter` WRITE;
/*!40000 ALTER TABLE `_newsletter` DISABLE KEYS */;
/*!40000 ALTER TABLE `_newsletter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_object`
--

DROP TABLE IF EXISTS `_object`;
CREATE TABLE `_object` (
  `id__object` int(11) unsigned NOT NULL auto_increment,
  `name_req` varchar(255) default NULL,
  `description` text,
  `date_create_auto` date default NULL,
  `date_update_auto` datetime default NULL,
  `table_ref_req` varchar(255) default NULL,
  `ordre` int(9) default NULL,
  `id__user` int(11) unsigned default NULL,
  `item_table_ref_req` int(10) default NULL,
  `id__workflow_state` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `id__nav` int(11) unsigned default NULL,
  `id__table_def` int(11) unsigned default NULL,
  `id__user_autor` int(11) unsigned default NULL,
  `id__object_source` varchar(255) default NULL,
  `_group_gab_id` varchar(255) default NULL,
  PRIMARY KEY  (`id__object`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_object`
--

LOCK TABLES `_object` WRITE;
/*!40000 ALTER TABLE `_object` DISABLE KEYS */;
/*!40000 ALTER TABLE `_object` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_param`
--

DROP TABLE IF EXISTS `_param`;
CREATE TABLE `_param` (
  `id__param` int(11) unsigned NOT NULL auto_increment,
  `model_name` varchar(255) default NULL,
  `selected` int(1) unsigned NOT NULL default '0',
  `default_date` varchar(255) default NULL,
  `date_format` int(10) unsigned default '1',
  `retour` varchar(255) default NULL,
  `field_width_size` varchar(255) default NULL,
  `field_height_size` varchar(255) default NULL,
  `nb_max_car` varchar(255) default NULL,
  `width_type` varchar(255) default NULL,
  `width_table` varchar(255) default NULL,
  `nb_enr_page` varchar(255) default NULL,
  `nb_page_tot` varchar(255) default NULL,
  `img_tri_asc` varchar(100) default NULL,
  `img_tri_desc` varchar(100) default NULL,
  `img_check_box_on` varchar(100) default NULL,
  `img_check_box_off` varchar(100) default NULL,
  `img_accep_text` varchar(255) default NULL,
  `no_picture_title` varchar(255) default NULL,
  `display_mode` varchar(255) default NULL,
  `display_menu` varchar(255) default NULL,
  `debug_mode` int(1) unsigned NOT NULL default '0',
  `silent_debug_mode` int(1) unsigned default NULL,
  PRIMARY KEY  (`id__param`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_param`
--

LOCK TABLES `_param` WRITE;
/*!40000 ALTER TABLE `_param` DISABLE KEYS */;
INSERT INTO `_param` VALUES (1,'standard',1,'',2,'Annuler','70','2','55','none','100','50','40','img_tri_asc_imgtriasc1_1.gif','img_tri_desc_ImgTriDesc3_1.gif','img_check_box_on_on_1_1.gif','img_check_box_off_off_1_1.gif','jpg;jpeg;gif','Supprimer','OptionOn','on',0,NULL),(3,'Strict',0,'__/__/____',1,'Annuler','40','5','50','none','720','20','10','ImgTriAsc3.gif','ImgTriDesc3.gif',NULL,NULL,'gif;jpg;jpeg','Supprimer','OptionOn','On',0,NULL),(5,'Cool',0,'',1,'Annuler','40','5','50','none','','10','10','','',NULL,NULL,'gif;jpg;jpeg','Supprimer','OptionOn','On',0,NULL);
/*!40000 ALTER TABLE `_param` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_profil`
--

DROP TABLE IF EXISTS `_profil`;
CREATE TABLE `_profil` (
  `id__profil` int(11) unsigned NOT NULL auto_increment,
  `_profil` varchar(255) default NULL,
  `id__workflow_state` varchar(254) default NULL,
  PRIMARY KEY  (`id__profil`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_profil`
--

LOCK TABLES `_profil` WRITE;
/*!40000 ALTER TABLE `_profil` DISABLE KEYS */;
INSERT INTO `_profil` VALUES (1,'Root','3,7,5,8,6,9'),(2,'Webmaster','8,6,9'),(3,'R&eacute;dacteur','6'),(4,'Centre','3,2,4');
/*!40000 ALTER TABLE `_profil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_select_champ`
--

DROP TABLE IF EXISTS `_select_champ`;
CREATE TABLE `_select_champ` (
  `id__select_champ` int(11) unsigned NOT NULL auto_increment,
  `champ_selection` varchar(255) default NULL,
  `libelle` varchar(255) default NULL,
  `down_description` text,
  `specific_sql` text,
  `flag_all_enable` int(1) NOT NULL default '0',
  `flag_actif` int(1) default NULL,
  `id__table_def` int(11) unsigned default NULL,
  PRIMARY KEY  (`id__select_champ`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_select_champ`
--

LOCK TABLES `_select_champ` WRITE;
/*!40000 ALTER TABLE `_select_champ` DISABLE KEYS */;
INSERT INTO `_select_champ` VALUES (1,'id__profil','Pofil :','','',0,1,406),(2,'id__menu','','','',0,0,16),(3,'id__table_def','','','',0,0,501),(4,'','','','',0,0,512),(5,'','','','',0,0,527),(6,'','','','',0,0,539);
/*!40000 ALTER TABLE `_select_champ` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_site_user`
--

DROP TABLE IF EXISTS `_site_user`;
CREATE TABLE `_site_user` (
  `id__site_user` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id__site_user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_site_user`
--

LOCK TABLES `_site_user` WRITE;
/*!40000 ALTER TABLE `_site_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `_site_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_stat`
--

DROP TABLE IF EXISTS `_stat`;
CREATE TABLE `_stat` (
  `id__stat` int(11) unsigned NOT NULL auto_increment,
  `id__user` int(11) unsigned default '0',
  `id__table_def` int(11) unsigned default '0',
  `session_id` varchar(255) default NULL,
  `interface` varchar(255) default 'Back-Office',
  `date` datetime default NULL,
  `user_agent` varchar(255) default NULL,
  `query_string` text,
  `file_name` varchar(255) default NULL,
  `agent` varchar(150) default NULL,
  `os` varchar(50) default NULL,
  `ip` varchar(16) default NULL,
  `country` varchar(100) default NULL,
  PRIMARY KEY  (`id__stat`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_stat`
--

LOCK TABLES `_stat` WRITE;
/*!40000 ALTER TABLE `_stat` DISABLE KEYS */;
/*!40000 ALTER TABLE `_stat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_style`
--

DROP TABLE IF EXISTS `_style`;
CREATE TABLE `_style` (
  `id__style` int(11) unsigned NOT NULL auto_increment,
  `style_name` varchar(255) default NULL,
  `selected` int(1) default NULL,
  `date_auto` date default NULL,
  `main_font_color` varchar(15) default NULL,
  `font_size_11` varchar(253) default NULL,
  `font_weight_3` varchar(253) default NULL,
  `font_type_20` varchar(253) default NULL,
  `text_decoration_2` varchar(253) default NULL,
  `active_item_text_decoration_2` varchar(253) default NULL,
  `active_item_color` varchar(15) default NULL,
  `active_item_font_weight_3` varchar(253) default NULL,
  `title_font_size_11` varchar(253) default NULL,
  `border_color` varchar(15) default NULL,
  `background_color` varchar(15) default NULL,
  `active_item_color_light` varchar(15) default NULL,
  `table_bgcolor` varchar(15) default NULL,
  `table_entete_bgcolor` varchar(15) default NULL,
  `table_border_10` varchar(253) default NULL,
  `table_cellspacing_10` varchar(253) default NULL,
  `table_cellpadding_10` varchar(253) default NULL,
  `td_bgcolor_1` varchar(15) default NULL,
  `td_bgcolor_2` varchar(15) default NULL,
  `menu_bgcolor` varchar(15) default NULL,
  `menu_table_bgcolor` varchar(15) default NULL,
  `menu_font_color` varchar(15) default NULL,
  `img_bandeau_haut_right` varchar(100) default NULL,
  `img_logo` varchar(100) default NULL,
  `img_fond` varchar(100) default NULL,
  `url_site` varchar(250) default NULL,
  PRIMARY KEY  (`id__style`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_style`
--

LOCK TABLES `_style` WRITE;
/*!40000 ALTER TABLE `_style` DISABLE KEYS */;
INSERT INTO `_style` VALUES (21,'FULLKIT BASIC',1,'2002-11-21','#000000','11px','normal','Verdana','none','underline','#669900','bold','11px','#999999','#ffffff','#000000','#DEE2B7','#C9CF87','0','1','2','#939f0f','#DEE2B7','#939f0f','#999999','#DEE2B7','','img_logo_logo_ethic_etapes_21.jpg','img_fond_fond_haut_21.jpg',''),(33,'Windows 2000',0,'2003-04-01','#000000','','normal','Arial','none','underline','#D4D0C8','','','','','#000000','#D4D0C8','#FFFFFF','0','1','2','#D4D0C8','#E7E5E1','#0A246A','#D4D0C8','#000000','','','','');
/*!40000 ALTER TABLE `_style` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_table_def`
--

DROP TABLE IF EXISTS `_table_def`;
CREATE TABLE `_table_def` (
  `id__table_def` int(11) unsigned NOT NULL auto_increment,
  `id__menu` int(11) unsigned default '1',
  `id__profil` varchar(254) default NULL,
  `select_liste` text,
  `alias` varchar(255) default NULL,
  `select_modif_ajout` text,
  `select_update_insert` text,
  `sql_body` text,
  `titre_rubrique_array` varchar(255) default NULL,
  `titre_bouton_array` varchar(255) default NULL,
  `item` varchar(255) default NULL,
  `titre_col` varchar(255) default NULL,
  `mode_col` varchar(255) default NULL,
  `upload_path` text,
  `cur_table_name` varchar(255) default NULL,
  `menu_title` varchar(255) NOT NULL default '',
  `ordre_menu` int(10) default '0',
  `popup_id` varchar(255) default NULL,
  `sql_before_insert` text,
  `sql_after_insert` text,
  `sql_before_update` text,
  `sql_after_update` text,
  `sql_after_delete` text,
  `sql_before_delete` text,
  `search_engine` int(1) default '0',
  `enable_filter` int(1) default '0',
  `enable_listing_order` int(1) unsigned default '1',
  `date_auto` date default '0000-00-00',
  `_item` int(1) default '0',
  `line_max` int(10) default NULL,
  `show_id` int(1) default '0',
  `display_on_menu` int(1) unsigned default '1',
  `id__xsl_tpl` varchar(254) default NULL,
  `deroulante_selection` varchar(255) default NULL,
  PRIMARY KEY  (`id__table_def`)
) ENGINE=MyISAM AUTO_INCREMENT=545 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_table_def`
--

LOCK TABLES `_table_def` WRITE;
/*!40000 ALTER TABLE `_table_def` DISABLE KEYS */;
INSERT INTO `_table_def` VALUES (1,3,'1','Select _table_def.id__table_def,_table_def.item,_table_def.cur_table_name,_table_def.menu_title,_table_def.search_engine,_table_def.enable_filter,_table_def.date_auto,_table_def._item,_table_def.show_id','id;item;cur_table_name;menu_title;search_engine;enabled_filter;date_auto;_item;show_id','Select _table_def.id__table_def, _table_def.select_liste,_table_def.alias,_table_def.select_modif_ajout,_table_def.select_update_insert,_table_def.sql_body,_table_def.titre_rubrique_array,_table_def.titre_bouton_array,_table_def.item As item,_table_def.titre_col,_table_def.mode_col,_table_def.upload_path,_table_def.cur_table_name As cur_table_name,_table_def.menu_title As menu_title,_table_def.ordre_menu,_table_def.popup_id,_table_def.search_engine As search_engine,_table_def.enable_filter As enabled_filter,_table_def.enable_listing_order,_table_def.date_auto As date_auto,_table_def._item As _item,_table_def.line_max,_table_def.show_id As show_id,_table_def.display_on_menu','Select _table_def.id__table_def, _table_def.select_liste,_table_def.alias,_table_def.select_modif_ajout,_table_def.select_update_insert,_table_def.sql_body,_table_def.titre_rubrique_array,_table_def.titre_bouton_array,_table_def.item,_table_def.titre_col,_table_def.mode_col,_table_def.upload_path,_table_def.cur_table_name,_table_def.menu_title,_table_def.ordre_menu,_table_def.popup_id,_table_def.search_engine,_table_def.enable_filter,_table_def.enable_listing_order,_table_def.date_auto,_table_def._item,_table_def.line_max,_table_def.show_id,_table_def.display_on_menu','From _table_def','liste des formulaires;création d\'un nouveau formulaire;modification du formuaire;suppression du formulaire','Créer;Modifier;Supprimer','formulaire','Modifier;Supprimer;sqleditor','modif;supr;sqleditor','','_table_def','Definition des tables',1,'',NULL,NULL,NULL,NULL,'',NULL,0,1,1,'0000-00-00',1,NULL,1,1,'1',NULL),(2,2,'2,1','Select _nav.*','','Select _nav.*','Select _nav.*','from _nav where id__nav != 1','liste des rubrique;cr&eacute;ation d\'une rubrique;modification de la rubrique;suppression de la rubrique','Cr&eacute;er;Modifier;Supprimer','rubrique','Nouveau;Modifier;Supprimer','nouveau;modif;supr','    ','_nav','Arborescence',0,'','/* global £INSERT;\r\nif (£_REQUEST[\'field_selected\']!=1) {\r\n  £_REQUEST[\'field_selected\'] = 0;\r\n}\r\n\r\n\r\n£INSERT = \"insert into _nav (id__nav_pere, _nav, ordre, selected, url_page,id__type_nav ) values (\".£_REQUEST[\'field_id__nav\'].\",\\\"\".£_REQUEST[\'field__nav\'].\"\\\",\\\"\".£_REQUEST[\'field_ordre\'].\"\\\",\".£_REQUEST[\'field_selected\'].\",\\\"\".£_REQUEST[\'field_url_page\'].\"\\\",\\\"\".£_REQUEST[\'field_id__type_nav\'].\"\\\")\";   \r\n\r\necho £INSERT.\"<br>\";\r\n*/','global £ses_id_bo_user;\r\n\r\nmysql_query(\"UPDATE _user SET id__nav= concat(id__nav, \\\",\".mysql_insert_id().\"\\\") WHERE id__user=£ses_id_bo_user\");        ','/*\r\nglobal £UPDATE ;\r\nif (£_REQUEST[\'field_selected\']!=1) {\r\n  £_REQUEST[\'field_selected\'] = 0;\r\n}\r\n\r\n\r\n£UPDATE = \"UPDATE _nav SET id__nav_pere=\".£_REQUEST[\'field_id__nav\'].\", _nav=\\\"\".£_REQUEST[\'field__nav\'].\"\\\",  ordre=\\\"\".£_REQUEST[\'field_ordre\'].\"\\\", selected = \".£_REQUEST[\'field_selected\'].\", url_page=\\\"\".£_REQUEST[\'field_url_page\'].\"\\\", id__type_nav=\\\"\".£_REQUEST[\'field_id__type_nav\'].\"\\\" WHERE id__nav=\".£id;  \r\necho £UPDATE .\"<br>\";\r\n\r\n*/','','global £target;\r\nif (£target) {\r\n//  $Req= \"Update _nav set id__nav_pere=\"._ARCHIVES_NAV_ID.\" where id__nav_pere=\".£id;\r\n}\r\nelse {\r\n  $Req= \"Update _nav set id__nav_pere=1 where id__nav_pere=\".£id;\r\n}\r\nmysql_query($Req);\r\n\r\n$Req= \"Update _object set id__nav=\"._ARCHIVES_NAV_ID.\" where id__nav=\".£id;\r\nmysql_query($Req);\r\n             ','',0,0,1,'2002-02-20',1,NULL,1,0,'1',';;;;;;'),(3,6,'1','Select _object.id__object,_object.name_req,_object.date_create_auto,_object.date_update_auto,_object.ordre,_object.id__workflow_state','id;Nom;Date creation;Date modification;Ordre;workflow;langue','Select _object.id__object, _object.name_req As ordre,_object.date_create_auto As Nom,_object.table_ref_req,_object.ordre As Date modification,_langue.id__langue As workflow,_object.id__nav','Select _object.id__object, _object.name_req,_object.date_create_auto,_object.table_ref_req,_object.ordre,_object.id__langue,_object.id__nav','From _object, _langue,_nav Where _langue.id__langue=_object.id__langue And _nav.id__nav=_object.id__nav','Liste des éléments liés;Création;Modification;Suppression','Créer;Modifier;Supprimer','objet de contenu','Nouveau;Supprimer;Dupliquer;Modifier','nouveau;supr;duplicate_object;get_object_values','            ','_object','Objets de contenus',1,'','','','','','','global £ID;\r\n\r\n$strSQL_obj = \"Select item_table_ref_req, table_ref_req from _object where id__object=£ID\";\r\n$str_object = mysql_query($strSQL_obj);\r\n$item_table_ref=@mysql_result($str_object,0,\"item_table_ref_req\");\r\n$table_ref=@mysql_result($str_object,0,\"table_ref_req\");\r\n$SQL_del_obj = \"DELETE FROM \".$table_ref.\" WHERE id_\".$table_ref.\" = \".$item_table_ref;\r\n@mysql_query($SQL_del_obj);',0,0,1,'2003-02-05',1,NULL,0,1,NULL,NULL),(4,2,'1','Select _param.id__param,_param.model_name,_param.selected,_param.date_format,_param.nb_max_car,_param.nb_enr_page','id;model_name;selected;date_format;nb_max_car;nb_enr_page','Select _param.id__param, _param.model_name,_param.selected,_param.default_date,_param.date_format,_param.retour,_param.field_width_size,_param.field_height_size,_param.nb_max_car,_param.width_type,_param.width_table,_param.nb_enr_page,_param.nb_page_tot,_param.img_tri_asc,_param.img_tri_desc,_param.img_check_box_on,_param.img_check_box_off,_param.img_accep_text,_param.no_picture_title,_param.display_mode,_param.display_menu,_param.debug_mode','Select _param.id__param, _param.model_name,_param.selected,_param.default_date,_param.date_format,_param.retour,_param.field_width_size,_param.field_height_size,_param.nb_max_car,_param.width_type,_param.width_table,_param.nb_enr_page,_param.nb_page_tot,_param.img_tri_asc,_param.img_tri_desc,_param.img_check_box_on,_param.img_check_box_off,_param.img_accep_text,_param.no_picture_title,_param.display_mode,_param.display_menu,_param.debug_mode','From _param','liste des s&eacute;ries d\'options; cr&eacute;ation d\'une s&eacute;rie d\'option; modification de la s&eacute;rie d\'options ; suppression de la s&eacute;rie d\' options','Cr&eacute;er;Modifier;Supprimer','s&eacute;rie d\'options','Nouveau;Modifier;Supprimer','nouveau;modif;supr','images/options/;images/options/;images/options/;images/options/','_param','Options',3,'','if (£_REQUEST[\'field_selected\']==1) {\r\nmysql_query(\"update _param set selected = 0\");\r\n}\r\n','','if (£_REQUEST[\'field_selected\']==1) {\r\nmysql_query(\"update _param set selected = 0\");\r\n}\r\n','','','',0,1,1,'0000-00-00',1,NULL,0,1,'1',NULL),(5,4,'1','select _menu.* ','','select _menu.* ','select _menu.* ','from _menu','liste des menus;cr&eacute;ation d\'un menu;modification du menu;suppression du menu','Cr&eacute;er;Modifier;Supprimer','menu','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','_menu','Menus',4,'',NULL,NULL,NULL,NULL,'update _table_def set id__menu=1 where id__menu=ID',NULL,0,1,1,'0000-00-00',1,0,1,1,'1',NULL),(6,2,'1',' \r\nSelect _style.id__style,_style.style_name,_style.selected,_style.date_auto,_style.main_font_color,_style.font_size_11,_style.url_site ','id;style_name;url_site;selected;date_auto;main_font_color;font_size_11',' \r\nselect _style.*  ',' \r\nselect _style.*  ',' \r\nfrom _style ','liste;cr&eacute;ation;modification;suppression','Cr&eacute;er;Modifier;Supprimer','formulaire','Nouveau;Modifier;Supprimer','nouveau;modif;supr',' \r\nimages/skins/;images/skins/;images/skins/','_style','Apparences',2,'','if (£_REQUEST[\'field_selected\']==1) {\r\nmysql_query(\"update _style set selected = 0\");\r\n}\r\n','','if (£_REQUEST[\'field_selected\']==1) {\r\nmysql_query(\"update _style set selected = 0\");\r\n}\r\n','','','',0,0,1,'0000-00-00',1,NULL,0,0,'1',NULL),(7,3,'1','select _dic_data.* ','','select _dic_data.* ','select _dic_data.* ','from _dic_data','Liste des tables;Création d\'une table;Modification de la table','Créer;Modifier;Supprimer','table','Nouveau;Modifier','nouveau;modif','','_dic_data','Biblioth&egrave;que de tables',2,'',NULL,NULL,NULL,NULL,NULL,NULL,0,1,1,'2002-11-18',1,NULL,0,1,'1',NULL),(8,5,'2,1',' select _user.* ','',' select _user.* ',' select _user.* ',' from _user\r\nwhere id__user!=1 ','liste des utilisateurs;cr&eacute;ation d\'un utilisateur;modification de l\'utilisateur;suppression de l\'utilisateur','Cr&eacute;er;Modifier;Supprimer','utilisateur','Nouveau;Dupliquer;Modifier;Supprimer','nouveau;duplicate;modif;supr','      ','_user','Utilisateurs',8,'',NULL,NULL,NULL,NULL,'',NULL,0,0,1,'0000-00-00',1,NULL,0,0,'1',NULL),(9,5,'2,1',' select _profil.*  ','',' select _profil.*  ',' select _profil.*  ',' from _profil ','liste des profils;cr&eacute;ation d\'un profil;modification du profil;suppression du profil','Cr&eacute;er;Modifier;Supprimer','formulaire','Nouveau;Modifier;Supprimer','nouveau;modif;supr','  ','_profil','Profils',6,'','','','','','','',0,0,1,'0000-00-00',1,0,0,1,'1',NULL),(10,5,'2,1','Select _table_def.id__table_def,_table_def.id__menu,_table_def.id__profil,_table_def.menu_title','','Select _table_def.id__table_def, _table_def.id__menu,_table_def.id__profil,_table_def.menu_title','Select _table_def.id__table_def, _table_def.id__menu,_table_def.id__profil,_table_def.menu_title','From _table_def, _menu,_profil Where _menu.id__menu=_table_def.id__menu And _profil.id__profil=_table_def.id__profil','liste des profils;création;modification;suppression','Créer;Modifier;Supprimer','profil','Modifier;Supprimer','modif;supr','','_table_def','Gestion des profils',7,'',NULL,NULL,NULL,NULL,'',NULL,0,1,1,'0000-00-00',1,NULL,0,1,'1',NULL),(11,2,'1',' Select _table_def.id__table_def,_table_def.item,_table_def.menu_title ','id;item;menu_title',' Select _table_def.id__table_def, _table_def.sql_before_insert,_table_def.sql_after_insert,_table_def.sql_before_update,_table_def.sql_after_update,_table_def.sql_after_delete,_table_def.sql_before_delete ',' Select _table_def.id__table_def, _table_def.sql_before_insert,_table_def.sql_after_insert,_table_def.sql_before_update,_table_def.sql_after_update,_table_def.sql_after_delete,_table_def.sql_before_delete ',' From _table_def ','liste des evenements;cr&eacute;ation d\'un evenement;modification de l\'evenement;suppression de l\'evenement','Cr&eacute;er;Modifier;Supprimer','&eacute;v&egrave;nement','Modifier','modif','  ','_table_def','Ev&egrave;nements',1,'',NULL,NULL,NULL,NULL,'',NULL,0,1,1,'0000-00-00',1,0,0,0,'1',NULL),(12,6,'1','Select _newsletter.id__newsletter,_newsletter._newsletter,_newsletter.date,_newsletter.descriptif,_newsletter.numero','id;_newsletter;date;descriptif;numero','Select _newsletter.id__newsletter, _newsletter._newsletter,_newsletter.date,_newsletter.descriptif,_newsletter.numero','Select _newsletter.id__newsletter, _newsletter._newsletter,_newsletter.date,_newsletter.descriptif,_newsletter.numero','From _newsletter','liste des newsletter;création d\'une newsletter;modification de la newsletter;suppression de la newsletter','Créer;Modifier;Supprimer','newsletter','Nouveau;Modifier;Supprimer;envoyer','nouveau;modif;supr;postnewsletter','','_newsletter','Newsletter',5,'',NULL,NULL,NULL,NULL,'',NULL,0,0,1,'0000-00-00',1,0,0,1,'1',NULL),(13,6,'1','select ','','select stats.php.id_stats.php,  ','select stats.php.id_stats.php, ','from stats.php','liste;création;modification;suppression','créer;modifier;supprimer','stats/stats.inc.php','nouveau;modifier;supprimer','nouveau;modif;supr','','none','Statistiques',12,'',NULL,NULL,NULL,NULL,'',NULL,0,1,1,'2002-04-19',1,0,0,1,'1',NULL),(14,3,'1','select ','','select _menu.id__menu, _menu.id__menu as _menu,_menu._menu,_menu.ordre,_menu.menu_width ','select _menu.id__menu, _menu.id__menu,_menu._menu,_menu.ordre,_menu.menu_width','from _menu','liste;cr&eacute;ation;modification;suppression','cr&eacute;er;modifier;supprimer','bo_mysql_manager.php','nouveau;modifier;supprimer','nouveau;modif;supr','','none','G&eacute;n&eacute;rateur de tables',1,'',NULL,NULL,NULL,NULL,NULL,NULL,0,1,1,'2002-09-27',1,NULL,0,1,'1',NULL),(15,8,'1','Select _xsl_tpl.id__xsl_tpl,_xsl_tpl.nom_req','','Select _xsl_tpl.*','Select _xsl_tpl.*','from _xsl_tpl \r\nwhere _xsl_tpl.id__xsl_tpl != 1','Liste des _xsl_tpl;Création;Modification;Suppression','Créer;Modifier;Supprimer','_xsl_tpl','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','_xsl_tpl','Templates xsl',1,'',NULL,NULL,NULL,NULL,'Update _table_def set id__xsl_tpl=1 where id__xsl_tpl=ID',NULL,0,1,1,'2003-01-29',1,NULL,0,1,'1',NULL),(16,4,'1','Select _table_def.id__table_def,_table_def.id__menu,_table_def.id__profil,_table_def.menu_title,_table_def.ordre_menu,_table_def.display_on_menu','id;;;;;','Select _table_def.id__table_def, _table_def.id__menu As id__menu,_table_def.id__profil As id__profil,_table_def.menu_title As menu_title,_table_def.ordre_menu As ordre_menu,_table_def.display_on_menu As display_on_menu','Select _table_def.id__table_def, _table_def.id__menu,_table_def.id__profil,_table_def.menu_title,_table_def.ordre_menu,_table_def.display_on_menu','From _table_def','liste des menus;crï¿½ation d\'un menu;modification du menu;suppression du menu','Cr&eacute;er;Modifier;Supprimer','menu','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','_table_def','Gestion des menus',5,'',NULL,NULL,NULL,NULL,'',NULL,0,1,1,'0000-00-00',1,NULL,0,1,'1',';;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;'),(232,8,'1','Select _table_def.id__table_def,_table_def.menu_title,_table_def.id__xsl_tpl','id;menu_title;id__xsl_tpl','Select _table_def.id__table_def,_table_def.menu_title,_table_def.id__xsl_tpl','Select _table_def.id__table_def,_table_def.menu_title,_table_def.id__xsl_tpl','From _table_def, _xsl_tpl Where _xsl_tpl.id__xsl_tpl=_table_def.id__xsl_tpl','Liste;Création;Modification;Suppression','Créer;Modifier;Supprimer','','Modifier','modif','','_table_def','Affectation des templates',2,'',NULL,NULL,NULL,NULL,NULL,NULL,0,1,1,'2003-01-29',1,NULL,0,1,'2',NULL),(234,6,'1','Select _langue.*','','Select _langue.*','Select _langue.*','from _langue','Liste des _langue;Cr&eacute;ation;Modification;Suppression','Cr&eacute;er;Modifier;Supprimer','_langue','Nouveau;Modifier;Supprimer','nouveau;modif;supr','images/upload/langue/','_langue','_langue',1,'',NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2003-02-05',1,NULL,0,1,NULL,NULL),(235,9,'1',' Select _workflow_state.* ','',' Select _workflow_state.* ',' Select _workflow_state.* ',' from _workflow_state \r\n where _workflow_state.id__workflow_state != 1','Liste des _workflow_state;Cr&eacute;ation;Modification;Suppression','Cr&eacute;er;Modifier;Supprimer','_workflow_state','Nouveau;Modifier;Supprimer','nouveau;modif;supr','  ','_workflow_state','Etats',2,'','if (£_REQUEST[\'field_defaut\']==1) {\r\nmysql_query(\"update _workflow_state set defaut = 0 where id__workflow_1 = \".£_REQUEST[\'field_id__workflow_1\']);\r\n}\r\n','','if (£_REQUEST[\'field_defaut\']==1) {\r\nmysql_query(\"update _workflow_state set defaut = 0 where id__workflow_1 = \".£_REQUEST[\'field_id__workflow_1\']);\r\n}','','','',0,1,1,'2003-02-05',1,NULL,0,1,NULL,NULL),(243,9,'1','Select _workflow_trans.id__workflow_trans,_workflow_trans._workflow_trans,_workflow_trans.id__workflow_state,_workflow_trans.id__workflow_state_1,_workflow_trans.id__profil','id;Transition;De;A;Profil','select _workflow_trans.* ','select _workflow_trans.* ','from _workflow_trans','Liste des _workflow_trans;Création;Modification;Suppression','Créer;Modifier;Supprimer','_workflow_trans','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','_workflow_trans','Transitions',3,'',NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2003-02-13',1,NULL,0,1,NULL,NULL),(246,9,'1',' Select _workflow.* ','',' Select _workflow.* ',' Select _workflow.* ',' from _workflow \r\n where _workflow.id__workflow != 1','Liste des _workflow;Cr&eacute;ation;Modification;Suppression','Cr&eacute;er;Modifier;Supprimer','_workflow','Nouveau;Modifier;Supprimer','nouveau;modif;supr','  ','_workflow','D&eacute;finition',1,'',NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2003-02-17',1,NULL,0,1,NULL,NULL),(320,2,'1','Select _list_data.*','','Select _list_data.*','Select _list_data.*','from _list_data','Liste des _list_data;Cr&eacute;ation;Modification;Suppression','Cr&eacute;er;Modifier;Supprimer','_list_data','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','_list_data','Liste de donn&eacute;es',0,'',NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2003-09-23',1,NULL,0,1,NULL,NULL),(324,15,'1,2','Select navigation.*','','Select navigation.*','Select navigation.*','from navigation','Liste des navigation;Cr&eacute;ation;Modification;Suppression','Cr&eacute;er;Modifier;Supprimer','navigation','Nouveau;Modifier;Supprimer','nouveau;modif;supr','../images/upload/navigation/;../images/upload/navigation/;../images/upload/navigation/;','navigation','Meta-donnÃ©es',3,'',NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2003-10-03',0,NULL,0,1,NULL,NULL),(332,10,'1','Select portfolio_img.*','','Select portfolio_img.*','Select portfolio_img.*','from portfolio_img','Liste des images;Cr&eacute;ation;Modification;Suppression','Cr&eacute;er;Modifier;Supprimer','Image','Nouveau;Modifier;Supprimer','nouveau;modif;supr','../images/upload/portfolio_img/;','portfolio_img','Images &amp; Fichiers',2,'333;',NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2003-10-08',0,NULL,0,0,NULL,NULL),(333,10,'1','  Select portfolio_rub.*  ','','  Select portfolio_rub.*  ','  Select portfolio_rub.*  ','  from portfolio_rub where id_portfolio_rub!=1  ','Liste des rubriques;Cr&eacute;ation;Modification;Suppression','Cr&eacute;er;Modifier;Supprimer','Rubrique','Nouveau;Modifier;Supprimer','nouveau;modif;supr','    ','portfolio_rub','Rubrique',1,'','  ','  ','  ','  ','  ','global £id;\r\n\r\nmysql_query(\"update portfolio_img set id_portfolio_rub = 1 where id_portfolio_rub = £id\");',0,0,1,'2003-10-08',0,NULL,0,0,NULL,NULL),(357,10,'1,2,3','select test.* ','','select test.* ','select test.* ','from test','Liste;Création;Modification;Suppression','Créer;Modifier;Supprimer','include/inc_portfolio_view.inc.php','','','','none','Gestion du Portfolio',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,1,'2004-08-15',0,NULL,0,1,NULL,';;id__langue;'),(398,1,'1','Select _lib_champs.*','','Select _lib_champs.*','Select _lib_champs.*','from _lib_champs','Liste des _lib_champs;Création;Modification;Suppression','Créer;Modifier;Supprimer','_lib_champs','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','_lib_champs','_lib_champs',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2005-01-04',0,NULL,0,0,NULL,NULL),(399,6,'1','select _dic_data.* ','','select _dic_data.* ','select _dic_data.* ','from _dic_data','Liste;Création;Modification;Suppression','Créer;Modifier;Supprimer','bo_generate_menu.php','Nouveau;Dupliquer;Modifier;Supprimer','nouveau;duplicate;modif;supr','','none','G&eacute;n&eacute;rer le menu',5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,1,'2005-02-15',0,NULL,0,1,NULL,';id__table_def;;;;;id__workflow;'),(403,1,'1','Select _select_champ.*','','Select _select_champ.*','Select _select_champ.*','from _select_champ','Liste des _select_champ;Création;Modification;Suppression','Créer;Modifier;Supprimer','_select_champ','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','_select_champ','_select_champ',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2005-03-01',0,NULL,0,0,NULL,NULL),(404,1,'1','select format_mail.* ','','select format_mail.* ','select format_mail.* ','from format_mail','Liste des format_mail;Création;Modification;Suppression','Créer;Modifier;Supprimer','format_mail','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','format_mail','Mails envoy&eacute;s',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2005-05-26',0,NULL,0,1,NULL,';;;;;;'),(405,1,'1','select _dic_data.* ','','select _dic_data.* ','select _dic_data.* ','from _dic_data','Liste;Création;Modification;Suppression','Créer;Modifier;Supprimer','include/inc_mailer.inc.php','Nouveau;Dupliquer;Modifier;Supprimer','nouveau;duplicate;modif;supr','','none','Mailer',0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,1,'2005-05-26',0,NULL,0,1,NULL,';;;;;;;;'),(406,15,'1,2','Select param.id_param,param.libelle,param.valeur','id;libelle;valeur','Select param.id_param, param.libelle,param.valeur','Select param.id_param, param.libelle,param.valeur','From param','Liste;Modification','Créer;Modifier;Supprimer','','Modifier','modif','','param','Parametres du site',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,1,'2004-08-15',0,NULL,0,0,NULL,';;;;'),(487,5,'1','Select _type_nav.*','','Select _type_nav.*','Select _type_nav.*','from _type_nav','Liste des _type_nav;Création;Modification;Suppression','Créer;Modifier;Supprimer','_type_nav','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','_type_nav','_type_nav',1,NULL,NULL,NULL,NULL,NULL,'',NULL,1,0,1,'2008-02-21',0,NULL,0,1,NULL,NULL),(493,5,'1','Select _site_user.*','','Select _site_user.*','Select _site_user.*','from _site_user','Liste des _site_user;Création;Modification;Suppression','Créer;Modifier;Supprimer','_site_user','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','_site_user','_site_user',1,NULL,NULL,NULL,NULL,NULL,'',NULL,1,0,1,'2008-03-04',0,NULL,0,1,NULL,NULL),(494,5,'1','Select _nav_site.*','','Select _nav_site.*','Select _nav_site.*','from _nav_site','Liste des _nav_site;Création;Modification;Suppression','Créer;Modifier;Supprimer','_nav_site','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','_nav_site','_nav_site',1,NULL,NULL,NULL,NULL,NULL,'',NULL,1,0,1,'2008-03-04',0,NULL,0,1,NULL,NULL),(499,1,'1','Select param_home.*','','Select param_home.*','Select param_home.*','from param_home','Liste des param_home;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','param_home','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','param_home','param_home',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2008-06-24',0,NULL,0,0,NULL,NULL),(500,15,'3,1,2','Select tradotron.*','','Select tradotron.*','Select tradotron.*','from tradotron','Liste des tradotron;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','tradotron','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','tradotron','LibellÃ©s du site',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2009-08-31',0,NULL,0,1,NULL,NULL),(501,15,'1','Select _dic_data.id__dic_data,','id;','Select _dic_data.id__dic_data, ','Select _dic_data.id__dic_data, ','From _dic_data','Liste;CrÃ©ation;Modification;Suppression','Cr&eacute;er;Modifier;Supprimer','bo_insert_trads_global.php','Nouveau;Dupliquer;Modifier;','nouveau;duplicate;modif;','','none','Insertion de masse',2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,1,'0000-00-00',0,NULL,0,1,NULL,';;;;;;;;'),(502,17,'1,2','Select centre_ambiance.*','','Select centre_ambiance.*','Select centre_ambiance.*','from centre_ambiance','Liste des centre_ambiance;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','centre_ambiance','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','centre_ambiance','centre_ambiance',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-03-30',0,NULL,0,1,NULL,NULL),(503,17,'1,2','Select centre_environnement.*','','Select centre_environnement.*','Select centre_environnement.*','from centre_environnement','Liste des centre_environnement;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','centre_environnement','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','centre_environnement','centre_environnement',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-03-30',0,NULL,0,1,NULL,NULL),(504,17,'1,2','Select centre_environnement_montagne.*','','Select centre_environnement_montagne.*','Select centre_environnement_montagne.*','from centre_environnement_montagne','Liste des centre_environnement_montagne;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','centre_environnement_montagne','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','centre_environnement_montagne','centre_environnement_montagne',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-03-30',0,NULL,0,1,NULL,NULL),(514,17,'1,2','Select centre_classement.*','','Select centre_classement.*','Select centre_classement.*','from centre_classement','Liste des centre_classement;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','centre_classement','Nouveau;Modifier;Supprimer','nouveau;modif;supr','../images/upload/centre_classement/','centre_classement','centre_classement',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-03-31',0,NULL,0,1,NULL,NULL),(506,17,'1,2','Select centre_les_plus.*','','Select centre_les_plus.*','Select centre_les_plus.*','from centre_les_plus','Liste des centre_les_plus;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','centre_les_plus','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','centre_les_plus','centre_les_plus',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-03-30',0,NULL,0,1,NULL,NULL),(507,17,'1,2','Select centre_site_touristique.*','','Select centre_site_touristique.*','Select centre_site_touristique.*','from centre_site_touristique','Liste des centre_site_touristique;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','centre_site_touristique','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','centre_site_touristique','centre_site_touristique',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-03-30',0,NULL,0,1,NULL,NULL),(508,17,'1,2','Select centre_activite.*','','Select centre_activite.*','Select centre_activite.*','from centre_activite','Liste des centre_activite;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','centre_activite','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','centre_activite','centre_activite',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-03-30',0,NULL,0,1,NULL,NULL),(509,17,'1,2','Select centre_equipement.*','','Select centre_equipement.*','Select centre_equipement.*','from centre_equipement','Liste des centre_equipement;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','centre_equipement','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','centre_equipement','centre_equipement',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-03-30',0,NULL,0,1,NULL,NULL),(510,17,'1,2','Select centre_service.*','','Select centre_service.*','Select centre_service.*','from centre_service','Liste des centre_service;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','centre_service','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','centre_service','centre_service',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-03-30',0,NULL,0,1,NULL,NULL),(511,17,'1,2','Select centre_espace_detente.*','','Select centre_espace_detente.*','Select centre_espace_detente.*','from centre_espace_detente','Liste des centre_espace_detente;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','centre_espace_detente','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','centre_espace_detente','centre_espace_detente',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-03-30',0,NULL,0,1,NULL,NULL),(512,16,'1,2','Select centre.id_centre,centre.libelle,centre.id_centre_ambiance,centre.id_centre_environnement,centre.id_centre_environnement_montagne,centre.ville,centre.fax,centre.id_centre_region','id;libelle;id_centre_ambiance;id_centre_environnement;id_centre_environnement_montagne;ville;fax;id_centre_region','Select centre.id_centre, centre.libelle,centre.id_centre_ambiance,centre.id_centre_environnement,centre.id_centre_environnement_montagne,centre.adresse,centre.code_postal,centre.ville,centre.latitude,centre.longitude,centre.telephone,centre.fax,centre.id_centre_region,centre.email,centre.site_internet,centre.acces_route,centre.acces_route_texte,centre.acces_train,centre.acces_train_texte,centre.acces_avion,centre.acces_avion_texte,centre.acces_bus_metro,centre.acces_bus_metro_texte,centre.presentation,centre.id_centre_classement,centre.id_centre_classement_1,centre.nb_chambre,centre.nb_lit,centre.nb_couvert,centre.couvert_assiette,centre.couvert_self,centre.nb_salle_reunion,centre.capacite_salle_min,centre.capacite_salle_max,centre.nb_chambre_handicap,centre.agrement_edu_nationale,centre.agrement_edu_nationale_texte,centre.agrement_jeunesse,centre.agrement_jeunesse_texte,centre.agrement_tourisme,centre.agrement_tourisme_texte,centre.agrement_ddass,centre.agrement_ddass_texte,centre.id_centre_detention_label,centre.presentation_region,centre.id_centre_activite,centre.id_centre_equipement,centre.id_centre_espace_detente','Select centre.id_centre, centre.libelle,centre.id_centre_ambiance,centre.id_centre_environnement,centre.id_centre_environnement_montagne,centre.adresse,centre.code_postal,centre.ville,centre.latitude,centre.longitude,centre.telephone,centre.fax,centre.id_centre_region,centre.email,centre.site_internet,centre.acces_route,centre.acces_route_texte,centre.acces_train,centre.acces_train_texte,centre.acces_avion,centre.acces_avion_texte,centre.acces_bus_metro,centre.acces_bus_metro_texte,centre.presentation,centre.id_centre_classement,centre.id_centre_classement_1,centre.nb_chambre,centre.nb_lit,centre.nb_couvert,centre.couvert_assiette,centre.couvert_self,centre.nb_salle_reunion,centre.capacite_salle_min,centre.capacite_salle_max,centre.nb_chambre_handicap,centre.agrement_edu_nationale,centre.agrement_edu_nationale_texte,centre.agrement_jeunesse,centre.agrement_jeunesse_texte,centre.agrement_tourisme,centre.agrement_tourisme_texte,centre.agrement_ddass,centre.agrement_ddass_texte,centre.id_centre_detention_label,centre.presentation_region,centre.id_centre_activite,centre.id_centre_equipement,centre.id_centre_espace_detente','From centre','Liste des centre;CrÃ©ation;Modification;Suppression','Cr&eacute;er;Modifier;Supprimer','centre','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','centre','Fiche centre',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-03-30',0,NULL,0,1,NULL,';;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;'),(513,17,'1,2','Select centre_detention_label.*','','Select centre_detention_label.*','Select centre_detention_label.*','from centre_detention_label','Liste des centre_detention_label;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','centre_detention_label','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','centre_detention_label','centre_detention_label',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-03-30',0,NULL,0,1,NULL,NULL),(515,17,'1,2','Select centre_detail_hebergement.*','','Select centre_detail_hebergement.*','Select centre_detail_hebergement.*','from centre_detail_hebergement','Liste des centre_detail_hebergement;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','centre_detail_hebergement','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','centre_detail_hebergement','centre_detail_hebergement',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-03-31',0,NULL,0,1,NULL,NULL),(516,17,'1,2','Select centre_type_chambre.*','','Select centre_type_chambre.*','Select centre_type_chambre.*','from centre_type_chambre','Liste des centre_type_chambre;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','centre_type_chambre','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','centre_type_chambre','centre_type_chambre',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-03-31',0,NULL,0,1,NULL,NULL),(518,18,'1,2','Select actualite.*','','Select actualite.*','Select actualite.*','from actualite','Liste des actualite;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','actualite','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','actualite','ActualitÃ©s',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-04-02',0,NULL,0,1,NULL,NULL),(519,19,'1,2','Select actualite_thematique.*','','Select actualite_thematique.*','Select actualite_thematique.*','from actualite_thematique','Liste des actualite_thematique;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','actualite_thematique','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','actualite_thematique','actualite_thematique',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-04-02',0,NULL,0,1,NULL,NULL),(520,18,'1,2','Select bon_plan.*','','Select bon_plan.*','Select bon_plan.*','from bon_plan','Liste des bon_plan;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','bon_plan','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','bon_plan','Bons PLans - Promotions',2,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-04-02',0,NULL,0,1,NULL,NULL),(521,19,'1,2','Select sejour_thematique.*','','Select sejour_thematique.*','Select sejour_thematique.*','from sejour_thematique','Liste des sejour_thematique;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','sejour_thematique','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','sejour_thematique','ThÃ©matiques des sÃ©jours organisÃ©s',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-04-02',0,NULL,0,1,NULL,NULL),(522,19,'1,2','Select participant_age.*','','Select participant_age.*','Select participant_age.*','from participant_age','Liste des participant_age;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','participant_age','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','participant_age','Age des participants',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-04-02',0,NULL,0,1,NULL,NULL),(523,16,'1,2','Select organisateur_cvl.*','','Select organisateur_cvl.*','Select organisateur_cvl.*','from organisateur_cvl','Liste des organisateur_cvl;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','organisateur_cvl','Nouveau;Modifier;Supprimer','nouveau;modif;supr','../images/upload/organisateur_cvl/','organisateur_cvl','Organisateurs CVL',2,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-04-02',0,NULL,0,1,NULL,NULL),(524,17,'1','Select centre_region.*','','Select centre_region.*','Select centre_region.*','from centre_region','Liste des centre_region;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','centre_region','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','centre_region','centre_region',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-04-02',0,NULL,0,1,NULL,NULL),(527,20,'1,2','Select sejour_categorie.id_sejour_categorie,sejour_categorie.sejour_categorie,sejour_categorie.id__table_def','id;sejour_categorie;id__table_def','Select sejour_categorie.id_sejour_categorie, sejour_categorie.sejour_categorie,sejour_categorie.id__table_def','Select sejour_categorie.id_sejour_categorie, sejour_categorie.sejour_categorie,sejour_categorie.id__table_def','From sejour_categorie','Liste des sejour_categorie;CrÃ©ation;Modification;Suppression','Cr&eacute;er;Modifier;Supprimer','sejour_categorie','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','sejour_categorie','sejour_categorie',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-04-02',0,NULL,0,1,NULL,';;menu_title;'),(526,1,'1','Select sejour.*','','Select sejour.*','Select sejour.*','from sejour','Liste des sejour;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','sejour','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','sejour','sejour',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-04-02',0,NULL,0,1,NULL,NULL),(528,20,'1','Select sejour_theme.*','','Select sejour_theme.*','Select sejour_theme.*','from sejour_theme','Liste des sejour_theme;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','sejour_theme','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','sejour_theme','ThÃ¨mes',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-04-02',0,NULL,0,1,NULL,NULL),(529,20,'1','Select sejour_niveau_scolaire.*','','Select sejour_niveau_scolaire.*','Select sejour_niveau_scolaire.*','from sejour_niveau_scolaire','Liste des sejour_niveau_scolaire;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','sejour_niveau_scolaire','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','sejour_niveau_scolaire','Niveaux Scolaires',2,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-04-02',0,NULL,0,1,NULL,NULL),(530,20,'1','Select sejour_priode_disponibilite.*','','Select sejour_priode_disponibilite.*','Select sejour_priode_disponibilite.*','from sejour_priode_disponibilite','Liste des sejour_priode_disponibilite;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','sejour_priode_disponibilite','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','sejour_priode_disponibilite','PÃ©riodes de disponibilitÃ©s',3,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-04-02',0,NULL,0,1,NULL,NULL),(531,20,'1','Select sejour_nb_lit__par_chambre.*','','Select sejour_nb_lit__par_chambre.*','Select sejour_nb_lit__par_chambre.*','from sejour_nb_lit__par_chambre','Liste des sejour_nb_lit__par_chambre;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','sejour_nb_lit__par_chambre','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','sejour_nb_lit__par_chambre','Nb lits par chambre',5,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-04-02',0,NULL,0,1,NULL,NULL),(532,20,'1','Select sejour_tranche_age.*','','Select sejour_tranche_age.*','Select sejour_tranche_age.*','from sejour_tranche_age','Liste des sejour_tranche_age;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','sejour_tranche_age','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','sejour_tranche_age','Tranches d\'Ã¢ge',6,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-04-02',0,NULL,0,1,NULL,NULL),(533,20,'1','Select sejour_accueil_handicap.*','','Select sejour_accueil_handicap.*','Select sejour_accueil_handicap.*','from sejour_accueil_handicap','Liste des sejour_accueil_handicap;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','sejour_accueil_handicap','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','sejour_accueil_handicap','Accueil handicap',7,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-04-02',0,NULL,0,1,NULL,NULL),(534,20,'1','Select sejour_materiel_service.*','','Select sejour_materiel_service.*','Select sejour_materiel_service.*','from sejour_materiel_service','Liste des sejour_materiel_service;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','sejour_materiel_service','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','sejour_materiel_service','Materiel service',8,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-04-02',0,NULL,0,1,NULL,NULL),(535,20,'1','Select sejour_theme_seminaire.*','','Select sejour_theme_seminaire.*','Select sejour_theme_seminaire.*','from sejour_theme_seminaire','Liste des sejour_theme_seminaire;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','sejour_theme_seminaire','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','sejour_theme_seminaire','Theme seminaire',9,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-04-02',0,NULL,0,1,NULL,NULL),(536,1,'4,3,1,2','Select gab_texte_riche.*','','Select gab_texte_riche.*','Select gab_texte_riche.*','from gab_texte_riche','Liste des gab_texte_riche;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','gab_texte_riche','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','gab_texte_riche','Texte riche',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-04-14',0,NULL,0,1,NULL,NULL),(537,21,'1','Select classe_decouverte.*','','Select classe_decouverte.*','Select classe_decouverte.*','from classe_decouverte','Liste des classe_decouverte;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','classe_decouverte','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','classe_decouverte','Classe de dÃ©couverte',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-04-19',0,NULL,0,1,NULL,NULL),(538,21,'1','Select accueil_groupes_scolaires.*','','Select accueil_groupes_scolaires.*','Select accueil_groupes_scolaires.*','from accueil_groupes_scolaires','Liste des accueil_groupes_scolaires;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','accueil_groupes_scolaires','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','accueil_groupes_scolaires','Accueil de groupes scolaires et enfants',2,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-04-19',0,NULL,0,1,NULL,NULL),(539,21,'1','Select *','id;;;;;;;;;;;','Select *','Select *','From cvl','Liste des cvl;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','cvl','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','cvl','Cvl',3,'',NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-04-19',0,NULL,0,1,NULL,';;;;;;;;;;;;'),(540,21,'1','Select acceuil_reunions.*','','Select acceuil_reunions.*','Select acceuil_reunions.*','from acceuil_reunions','Liste des acceuil_reunions;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','acceuil_reunions','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','acceuil_reunions','Acceuil de reunions',4,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-04-19',0,NULL,0,1,NULL,NULL),(541,21,'1','Select seminaires.*','','Select seminaires.*','Select seminaires.*','from seminaires','Liste des seminaires;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','seminaires','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','seminaires','SÃ©minaires',5,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-04-19',0,NULL,0,1,NULL,NULL),(542,1,'1','Select accueil_groupes_jeunes_adultes.*','','Select accueil_groupes_jeunes_adultes.*','Select accueil_groupes_jeunes_adultes.*','from accueil_groupes_jeunes_adultes','Liste des accueil_groupes_jeunes_adultes;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','accueil_groupes_jeunes_adultes','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','accueil_groupes_jeunes_adultes','accueil_groupes_jeunes_adultes',1,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-04-19',0,NULL,0,1,NULL,NULL),(543,20,'1','Select sejour_services_sportifs.*','','Select sejour_services_sportifs.*','Select sejour_services_sportifs.*','from sejour_services_sportifs','Liste des sejour_services_sportifs;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','sejour_services_sportifs','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','sejour_services_sportifs','Services spÃ©cial sportifs',10,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-04-19',0,NULL,0,1,NULL,NULL),(544,20,'1','Select sejour_centre_adapte.*','','Select sejour_centre_adapte.*','Select sejour_centre_adapte.*','from sejour_centre_adapte','Liste des sejour_centre_adapte;CrÃ©ation;Modification;Suppression','CrÃ©er;Modifier;Supprimer','sejour_centre_adapte','Nouveau;Modifier;Supprimer','nouveau;modif;supr','','sejour_centre_adapte','Centre adaptÃ©',11,NULL,NULL,NULL,NULL,NULL,'',NULL,0,0,1,'2010-04-19',0,NULL,0,1,NULL,NULL);
/*!40000 ALTER TABLE `_table_def` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_type_nav`
--

DROP TABLE IF EXISTS `_type_nav`;
CREATE TABLE `_type_nav` (
  `id__type_nav` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  `ordre` int(9) default NULL,
  PRIMARY KEY  (`id__type_nav`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_type_nav`
--

LOCK TABLES `_type_nav` WRITE;
/*!40000 ALTER TABLE `_type_nav` DISABLE KEYS */;
INSERT INTO `_type_nav` VALUES (1,'Site',1),(2,'footer',2);
/*!40000 ALTER TABLE `_type_nav` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_user`
--

DROP TABLE IF EXISTS `_user`;
CREATE TABLE `_user` (
  `id__user` int(11) unsigned NOT NULL auto_increment,
  `nom` varchar(255) default NULL,
  `prenom` varchar(255) default NULL,
  `login` varchar(255) default NULL,
  `password` varchar(20) default NULL,
  `email` varchar(255) default NULL,
  `id__profil` int(11) unsigned default NULL,
  `id__nav` longtext,
  `portfolio_access_16` varchar(253) default NULL,
  `id__langue` varchar(254) default NULL,
  `id__site_user` int(11) unsigned default NULL,
  PRIMARY KEY  (`id__user`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_user`
--

LOCK TABLES `_user` WRITE;
/*!40000 ALTER TABLE `_user` DISABLE KEYS */;
INSERT INTO `_user` VALUES (1,'C2IS','ROOT','root','rootc2is','f.frezzato@c2is.fr',1,NULL,'PortFolio & Upload','1',NULL),(2,'Webmaster','webmaster','webmaster','webmaster',NULL,2,NULL,'PortFolio & Upload','1',NULL),(3,'RÃ©dacteur','redacteur','redacteur','redacteur','',3,NULL,'PortFolio & Upload','1',0),(4,'Amboise','','Amboise','ethic29',NULL,4,NULL,'PortFolio & Upload','1',NULL),(5,'ethic','','ethic','ucrif07','',2,'','PortFolio & Upload','1,2,3,5',0),(6,'angers','','angers','ethic27',NULL,4,NULL,'PortFolio & Upload','1',NULL),(7,'anduze','','anduze','ethic53',NULL,4,NULL,'PortFolio & Upload','1',NULL),(8,'aubervilliers','','aubervilliers','ethic130',NULL,4,NULL,'PortFolio & Upload','1',NULL),(9,'autun','','autun','ethic128',NULL,4,NULL,'PortFolio & Upload','1',NULL),(10,'besancon','','besancon','ethic31',NULL,4,NULL,'PortFolio & Upload','1',NULL),(11,'blois','','blois','ethic94',NULL,4,NULL,'PortFolio & Upload','1',NULL),(12,'bramans','','bramans','ethic121',NULL,4,NULL,'PortFolio & Upload','1',NULL),(13,'brest','','brest','ethic23',NULL,4,NULL,'PortFolio & Upload','1',NULL),(14,'cannes','','cannes','ethic107',NULL,4,NULL,'PortFolio & Upload','1',NULL),(15,'clermont','','clermont','ethic122',NULL,4,NULL,'PortFolio & Upload','1',NULL),(16,'concarneau','','concarneau','ethic93',NULL,4,NULL,'PortFolio & Upload','1',NULL),(17,'dammarie','','dammarie','ethic11',NULL,4,NULL,'PortFolio & Upload','1',NULL),(18,'dijon','','dijon','ethic33',NULL,4,NULL,'PortFolio & Upload','1',NULL),(19,'evian','','evian','ethic37',NULL,4,NULL,'PortFolio & Upload','1',NULL),(20,'florac','','florac','ethic100',NULL,4,NULL,'PortFolio & Upload','1',NULL),(21,'goersdorf','','goersdorf','ethic109',NULL,4,NULL,'PortFolio & Upload','1',NULL),(22,'lanslebourg','','lanslebourg','ethic111',NULL,4,NULL,'PortFolio & Upload','1',NULL),(23,'lathus','','lathus','ethic43',NULL,4,NULL,'PortFolio & Upload','1',NULL),(24,'lyon','','lyon','ethic35',NULL,4,NULL,'PortFolio & Upload','1',NULL),(25,'mittelwihr','','mittelwihr','ethic114',NULL,4,NULL,'PortFolio & Upload','1',NULL),(26,'martinique','','martinique','ethic129',NULL,4,NULL,'PortFolio & Upload','1',NULL),(27,'morlaix','','morlaix','ethic127',NULL,4,NULL,'PortFolio & Upload','1',NULL),(28,'narbonne','','narbonne','ethic75',NULL,4,NULL,'PortFolio & Upload','1',NULL),(29,'neuwiller','','neuwiller','ethic102',NULL,4,NULL,'PortFolio & Upload','1',NULL),(30,'olhain','','olhain','ethic117',NULL,4,NULL,'PortFolio & Upload','1',NULL),(31,'latin','','latin','ethic02',NULL,4,NULL,'PortFolio & Upload','1',NULL),(32,'fiap','','fiap','ethic03',NULL,4,NULL,'PortFolio & Upload','1',NULL),(33,'rip','','rip','ethic120',NULL,4,NULL,'PortFolio & Upload','1',NULL),(34,'pierrefontaine','','pierrefontaine','ethic108',NULL,4,NULL,'PortFolio & Upload','1',NULL),(35,'poissy','','poissy','ethic08',NULL,4,NULL,'PortFolio & Upload','1',NULL),(36,'reims','','reims','ethic13',NULL,4,NULL,'PortFolio & Upload','1',NULL),(37,'romorantin','','romorantin','ethic26',NULL,4,NULL,'PortFolio & Upload','1',NULL),(38,'stcyr','','stcyr','ethic106',NULL,4,NULL,'PortFolio & Upload','1',NULL),(39,'cyrmer','','cyrmer','ethic126',NULL,4,NULL,'PortFolio & Upload','1',NULL),(40,'malo','','malo','ethic21',NULL,4,NULL,'PortFolio & Upload','1',NULL),(41,'salignac','','salignac','ethic119',NULL,4,NULL,'PortFolio & Upload','1',NULL),(42,'seix','','seix','ethic110',NULL,4,NULL,'PortFolio & Upload','1',NULL),(43,'sommieres','','sommieres','ethic54',NULL,4,NULL,'PortFolio & Upload','1',NULL),(44,'ciarus','','ciarus','ethic16',NULL,4,NULL,'PortFolio & Upload','1',NULL),(45,'merville','','merville','ethic125',NULL,4,NULL,'PortFolio & Upload','1',NULL),(46,'yvon','','yvon','ethic01',NULL,4,NULL,'PortFolio & Upload','1',NULL),(47,'lecart','','lecart','ethic00',NULL,4,NULL,'PortFolio & Upload','1',NULL),(48,'angerville','','angerville','ethic131',NULL,4,NULL,'PortFolio & Upload','1',NULL),(49,'stmarc','','stmarc','ethic132',NULL,4,NULL,'PortFolio & Upload','1',NULL),(50,'quiberon','','quiberon','ethic135',NULL,4,NULL,'PortFolio & Upload','1',NULL),(51,'metz','','metz','ethic134',NULL,4,NULL,'PortFolio & Upload','1',NULL),(52,'calais','','calais','ethic92',NULL,4,NULL,'PortFolio & Upload','1',NULL),(53,'libarrenx','','libarrenx','ethic133',NULL,4,NULL,'PortFolio & Upload','1',NULL);
/*!40000 ALTER TABLE `_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_workflow`
--

DROP TABLE IF EXISTS `_workflow`;
CREATE TABLE `_workflow` (
  `id__workflow` int(11) unsigned NOT NULL auto_increment,
  `Nom` varchar(255) default NULL,
  PRIMARY KEY  (`id__workflow`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_workflow`
--

LOCK TABLES `_workflow` WRITE;
/*!40000 ALTER TABLE `_workflow` DISABLE KEYS */;
INSERT INTO `_workflow` VALUES (1,'(Aucun)'),(2,'Workflow gÃ©nÃ©ral');
/*!40000 ALTER TABLE `_workflow` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_workflow_state`
--

DROP TABLE IF EXISTS `_workflow_state`;
CREATE TABLE `_workflow_state` (
  `id__workflow_state` int(11) unsigned NOT NULL auto_increment,
  `_workflow_state` varchar(255) default NULL,
  `id__workflow_1` int(11) unsigned default NULL,
  `defaut` int(1) default NULL,
  PRIMARY KEY  (`id__workflow_state`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_workflow_state`
--

LOCK TABLES `_workflow_state` WRITE;
/*!40000 ALTER TABLE `_workflow_state` DISABLE KEYS */;
INSERT INTO `_workflow_state` VALUES (1,'(Aucun)',1,0),(2,'RÃ©digÃ©',2,1),(3,'PubliÃ©',2,0),(4,'SupprimÃ©',2,0);
/*!40000 ALTER TABLE `_workflow_state` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_workflow_trans`
--

DROP TABLE IF EXISTS `_workflow_trans`;
CREATE TABLE `_workflow_trans` (
  `id__workflow_trans` int(11) unsigned NOT NULL auto_increment,
  `_workflow_trans` varchar(255) default NULL,
  `id__workflow_state` int(11) unsigned default NULL,
  `id__workflow_state_1` int(11) unsigned default NULL,
  `id__profil` varchar(254) default NULL,
  PRIMARY KEY  (`id__workflow_trans`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_workflow_trans`
--

LOCK TABLES `_workflow_trans` WRITE;
/*!40000 ALTER TABLE `_workflow_trans` DISABLE KEYS */;
INSERT INTO `_workflow_trans` VALUES (1,'Publier',2,3,'3,1,2'),(9,'Supprimer',3,4,'1,2'),(10,'Supprimer',2,4,'3,1,2'),(11,'DÃ©sactiver',3,2,'1,2'),(12,'RÃ©-activer',4,2,'1,2');
/*!40000 ALTER TABLE `_workflow_trans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_xsl_tpl`
--

DROP TABLE IF EXISTS `_xsl_tpl`;
CREATE TABLE `_xsl_tpl` (
  `id__xsl_tpl` int(11) unsigned NOT NULL auto_increment,
  `nom_req` varchar(255) default NULL,
  `xsl_tpl` text,
  PRIMARY KEY  (`id__xsl_tpl`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_xsl_tpl`
--

LOCK TABLES `_xsl_tpl` WRITE;
/*!40000 ALTER TABLE `_xsl_tpl` DISABLE KEYS */;
INSERT INTO `_xsl_tpl` VALUES (1,'(Aucun)',NULL),(7,'News tpl 1','<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\r\n<xsl:stylesheet version=\"1.0\" xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\">\r\n<xsl:template match=\"root/result/row\">\r\n<TABLE cellSpacing=\"1\" cellPadding=\"2\" border=\"0\">\r\n<TBODY>\r\n<TR>\r\n<TD bgcolor=\"#555555\"><font color=\"#ffffff\"><B><xsl:value-of select=\"titre\"/></B></font></TD></TR>\r\n<TR>\r\n<TD><xsl:value-of select=\"contenu\" disable-output-escaping=\"yes\"/></TD></TR>\r\n</TBODY>\r\n</TABLE>\r\n</xsl:template>\r\n</xsl:stylesheet>'),(9,'News tpl 2','<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\r\n<xsl:stylesheet version=\"1.0\" xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\">\r\n<xsl:template match=\"root/result/row\">\r\n<TABLE cellSpacing=\"1\" cellPadding=\"2\" border=\"0\" width=\"200\">\r\n<TBODY>\r\n<TR>\r\n<TD bgcolor=\"#111111\" align=\"center\"><font color=\"#ffffff\"><B><xsl:value-of select=\"titre\"/></B></font></TD></TR>\r\n<TR>\r\n<TD><xsl:value-of select=\"contenu\" disable-output-escaping=\"yes\"/></TD></TR>\r\n</TBODY>\r\n</TABLE>\r\n</xsl:template>\r\n</xsl:stylesheet>');
/*!40000 ALTER TABLE `_xsl_tpl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acceuil_reunions`
--

DROP TABLE IF EXISTS `acceuil_reunions`;
CREATE TABLE `acceuil_reunions` (
  `id_acceuil_reunions` int(11) unsigned NOT NULL auto_increment,
  `commentaires_salles` mediumtext,
  `id_sejour_materiel_service` varchar(254) default NULL,
  PRIMARY KEY  (`id_acceuil_reunions`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acceuil_reunions`
--

LOCK TABLES `acceuil_reunions` WRITE;
/*!40000 ALTER TABLE `acceuil_reunions` DISABLE KEYS */;
/*!40000 ALTER TABLE `acceuil_reunions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accueil_groupes_jeunes_adultes`
--

DROP TABLE IF EXISTS `accueil_groupes_jeunes_adultes`;
CREATE TABLE `accueil_groupes_jeunes_adultes` (
  `id_accueil_groupes_jeunes_adultes` int(11) unsigned NOT NULL auto_increment,
  `conditions_groupes` mediumtext,
  `gratuite_chauffeur` int(1) default NULL,
  `conditions_professionnels` mediumtext,
  `piste_athetisme` int(1) default NULL,
  `piste_athetisme_sur_place` int(1) default NULL,
  `piscine` int(1) default NULL,
  `piscine_sur_place` int(1) default NULL,
  `terrains_exterieurs` int(1) default NULL,
  `terrains_exterieurs_sur_place` int(1) default NULL,
  `terrains_couverts` int(1) default NULL,
  `terrains_couverts_sur_place` int(1) default NULL,
  `dojos` int(1) default NULL,
  `dojos_sur_place` int(1) default NULL,
  `courts_tennis` int(1) default NULL,
  `courts_tennis_sur_place` int(1) default NULL,
  `installations_autres` text,
  `id_sejour_services_sportifs` varchar(254) default NULL,
  `id_sejour_centre_adapte` varchar(254) default NULL,
  `commentaire_accueil_sportifs` mediumtext,
  `sports_adaptes_FFH` int(1) default NULL,
  PRIMARY KEY  (`id_accueil_groupes_jeunes_adultes`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accueil_groupes_jeunes_adultes`
--

LOCK TABLES `accueil_groupes_jeunes_adultes` WRITE;
/*!40000 ALTER TABLE `accueil_groupes_jeunes_adultes` DISABLE KEYS */;
/*!40000 ALTER TABLE `accueil_groupes_jeunes_adultes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accueil_groupes_scolaires`
--

DROP TABLE IF EXISTS `accueil_groupes_scolaires`;
CREATE TABLE `accueil_groupes_scolaires` (
  `id_accueil_groupes_scolaires` int(11) unsigned NOT NULL auto_increment,
  `id_sejour_nb_lit__par_chambre` varchar(254) default NULL,
  `haute_saison` varchar(255) default NULL,
  `moyenne_saison` varchar(255) default NULL,
  `base_saison` varchar(255) default NULL,
  `conditions_scolaires` mediumtext,
  `gratuite_chauffeur` int(1) default NULL,
  `gratuite_accompagnateur` int(1) default NULL,
  PRIMARY KEY  (`id_accueil_groupes_scolaires`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accueil_groupes_scolaires`
--

LOCK TABLES `accueil_groupes_scolaires` WRITE;
/*!40000 ALTER TABLE `accueil_groupes_scolaires` DISABLE KEYS */;
/*!40000 ALTER TABLE `accueil_groupes_scolaires` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `actualite`
--

DROP TABLE IF EXISTS `actualite`;
CREATE TABLE `actualite` (
  `id_actualite` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  `description_courte` text,
  `description_longue` mediumtext,
  `date_debut` date default NULL,
  `date_fin` date default NULL,
  `id_actualite_thematique` varchar(254) default NULL,
  PRIMARY KEY  (`id_actualite`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `actualite`
--

LOCK TABLES `actualite` WRITE;
/*!40000 ALTER TABLE `actualite` DISABLE KEYS */;
/*!40000 ALTER TABLE `actualite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `actualite_thematique`
--

DROP TABLE IF EXISTS `actualite_thematique`;
CREATE TABLE `actualite_thematique` (
  `id_actualite_thematique` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_actualite_thematique`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `actualite_thematique`
--

LOCK TABLES `actualite_thematique` WRITE;
/*!40000 ALTER TABLE `actualite_thematique` DISABLE KEYS */;
INSERT INTO `actualite_thematique` VALUES (1,'info gÃ©nÃ©rale'),(2,'info spÃ©cial sÃ©jours â€“ de 18 ans'),(3,'info spÃ©cial sÃ©minaires / rÃ©unions'),(4,'info spÃ©cial sÃ©jours individuels'),(5,'info spÃ©cial sÃ©jours groupes');
/*!40000 ALTER TABLE `actualite_thematique` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bon_plan`
--

DROP TABLE IF EXISTS `bon_plan`;
CREATE TABLE `bon_plan` (
  `id_bon_plan` int(11) unsigned NOT NULL auto_increment,
  `description` mediumtext,
  `date_debut` date default NULL,
  `date_fin` date default NULL,
  `id_actualite_thematique` varchar(254) default NULL,
  PRIMARY KEY  (`id_bon_plan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bon_plan`
--

LOCK TABLES `bon_plan` WRITE;
/*!40000 ALTER TABLE `bon_plan` DISABLE KEYS */;
/*!40000 ALTER TABLE `bon_plan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `centre`
--

DROP TABLE IF EXISTS `centre`;
CREATE TABLE `centre` (
  `id_centre` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  `id_centre_ambiance` varchar(254) default NULL,
  `id_centre_environnement` varchar(254) default NULL,
  `id_centre_environnement_montagne` varchar(254) default NULL,
  `adresse` varchar(255) default NULL,
  `code_postal` varchar(255) default NULL,
  `ville` varchar(255) default NULL,
  `latitude` float(9,2) default NULL,
  `longitude` float(9,2) default NULL,
  `telephone` varchar(255) default NULL,
  `fax` varchar(255) default NULL,
  `id_centre_region` int(11) unsigned default NULL,
  `email` varchar(255) default NULL,
  `site_internet` varchar(250) default NULL,
  `acces_route` int(1) default NULL,
  `acces_route_texte` varchar(255) default NULL,
  `acces_train` int(1) default NULL,
  `acces_train_texte` varchar(255) default NULL,
  `acces_avion` int(1) default NULL,
  `acces_avion_texte` varchar(255) default NULL,
  `acces_bus_metro` int(1) default NULL,
  `acces_bus_metro_texte` varchar(255) default NULL,
  `presentation` mediumtext,
  `id_centre_classement` int(11) unsigned default NULL,
  `id_centre_classement_1` int(11) unsigned default NULL,
  `nb_chambre` int(10) default NULL,
  `nb_lit` int(10) default NULL,
  `nb_couvert` int(10) default NULL,
  `couvert_assiette` int(1) default NULL,
  `couvert_self` int(1) default NULL,
  `nb_salle_reunion` int(10) default NULL,
  `capacite_salle_min` int(10) default NULL,
  `capacite_salle_max` int(10) default NULL,
  `nb_chambre_handicap` int(10) default NULL,
  `agrement_edu_nationale` int(1) default NULL,
  `agrement_edu_nationale_texte` varchar(255) default NULL,
  `agrement_jeunesse` int(1) default NULL,
  `agrement_jeunesse_texte` varchar(255) default NULL,
  `agrement_tourisme` int(1) default NULL,
  `agrement_tourisme_texte` varchar(255) default NULL,
  `agrement_ddass` int(1) default NULL,
  `agrement_ddass_texte` varchar(255) default NULL,
  `id_centre_detention_label` varchar(254) default NULL,
  `presentation_region` mediumtext,
  `id_centre_activite` varchar(254) default NULL,
  `id_centre_equipement` varchar(254) default NULL,
  `id_centre_espace_detente` varchar(254) default NULL,
  `idCentre` int(10) default NULL,
  PRIMARY KEY  (`id_centre`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `centre`
--

LOCK TABLES `centre` WRITE;
/*!40000 ALTER TABLE `centre` DISABLE KEYS */;
INSERT INTO `centre` VALUES (2,'123','','','','','','',NULL,NULL,'','',NULL,'','http://www.',0,'',0,'',0,'',0,'','',0,0,NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,0,'',0,'',0,'',0,'','','','','','',NULL);
/*!40000 ALTER TABLE `centre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `centre_activite`
--

DROP TABLE IF EXISTS `centre_activite`;
CREATE TABLE `centre_activite` (
  `id_centre_activite` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_centre_activite`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `centre_activite`
--

LOCK TABLES `centre_activite` WRITE;
/*!40000 ALTER TABLE `centre_activite` DISABLE KEYS */;
INSERT INTO `centre_activite` VALUES (1,''),(2,''),(3,''),(4,''),(5,''),(6,''),(7,''),(8,''),(9,''),(10,''),(11,''),(12,''),(13,''),(14,''),(15,''),(16,''),(17,''),(18,''),(19,''),(20,''),(21,''),(22,''),(23,''),(24,''),(25,''),(26,''),(27,''),(28,''),(29,''),(30,''),(31,''),(32,''),(33,''),(34,''),(35,''),(36,''),(37,''),(38,''),(39,''),(40,''),(41,''),(42,''),(43,''),(44,''),(45,''),(46,''),(47,'');
/*!40000 ALTER TABLE `centre_activite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `centre_ambiance`
--

DROP TABLE IF EXISTS `centre_ambiance`;
CREATE TABLE `centre_ambiance` (
  `id_centre_ambiance` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_centre_ambiance`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `centre_ambiance`
--

LOCK TABLES `centre_ambiance` WRITE;
/*!40000 ALTER TABLE `centre_ambiance` DISABLE KEYS */;
INSERT INTO `centre_ambiance` VALUES (1,''),(2,''),(3,''),(4,''),(5,'');
/*!40000 ALTER TABLE `centre_ambiance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `centre_classement`
--

DROP TABLE IF EXISTS `centre_classement`;
CREATE TABLE `centre_classement` (
  `id_centre_classement` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  `visuel` varchar(100) default NULL,
  PRIMARY KEY  (`id_centre_classement`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `centre_classement`
--

LOCK TABLES `centre_classement` WRITE;
/*!40000 ALTER TABLE `centre_classement` DISABLE KEYS */;
INSERT INTO `centre_classement` VALUES (2,'',''),(4,'',''),(6,'',''),(8,'','');
/*!40000 ALTER TABLE `centre_classement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `centre_detail_hebergement`
--

DROP TABLE IF EXISTS `centre_detail_hebergement`;
CREATE TABLE `centre_detail_hebergement` (
  `id_centre_detail_hebergement` int(11) unsigned NOT NULL auto_increment,
  `id_centre_2` int(11) unsigned default NULL,
  `id_centre_type_chambre` int(11) unsigned default NULL,
  `nb_chambre` int(10) default NULL,
  `nb_lit` int(10) default NULL,
  `nb_lavDouWC_chambre` int(10) default NULL,
  `nb_lavDouWC_lit` int(10) default NULL,
  `nb_lavDou_chambre` int(10) default NULL,
  `nb_lavDou_lit` int(10) default NULL,
  `nb_lavOuWC_chambre` int(10) default NULL,
  `nb_lavOuWC_lit` int(10) default NULL,
  `nb_noWC_chambre` int(10) default NULL,
  `nb_noWC_lit` int(10) default NULL,
  PRIMARY KEY  (`id_centre_detail_hebergement`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `centre_detail_hebergement`
--

LOCK TABLES `centre_detail_hebergement` WRITE;
/*!40000 ALTER TABLE `centre_detail_hebergement` DISABLE KEYS */;
INSERT INTO `centre_detail_hebergement` VALUES (1,2,1,3,2,4,5,6,7,8,9,10,11),(2,2,2,0,0,0,0,0,0,0,0,0,0),(3,2,3,0,0,0,0,0,0,0,0,0,0),(4,2,4,0,0,0,0,0,0,0,0,0,0),(5,2,5,0,0,0,0,0,0,0,0,0,0),(6,2,6,0,0,0,0,0,0,0,0,0,0),(7,2,7,0,0,0,0,0,0,0,0,0,0),(8,2,8,0,0,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `centre_detail_hebergement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `centre_detention_label`
--

DROP TABLE IF EXISTS `centre_detention_label`;
CREATE TABLE `centre_detention_label` (
  `id_centre_detention_label` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_centre_detention_label`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `centre_detention_label`
--

LOCK TABLES `centre_detention_label` WRITE;
/*!40000 ALTER TABLE `centre_detention_label` DISABLE KEYS */;
INSERT INTO `centre_detention_label` VALUES (1,''),(2,''),(3,''),(4,''),(5,'');
/*!40000 ALTER TABLE `centre_detention_label` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `centre_environnement`
--

DROP TABLE IF EXISTS `centre_environnement`;
CREATE TABLE `centre_environnement` (
  `id_centre_environnement` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_centre_environnement`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `centre_environnement`
--

LOCK TABLES `centre_environnement` WRITE;
/*!40000 ALTER TABLE `centre_environnement` DISABLE KEYS */;
INSERT INTO `centre_environnement` VALUES (1,''),(2,''),(3,''),(4,'');
/*!40000 ALTER TABLE `centre_environnement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `centre_environnement_montagne`
--

DROP TABLE IF EXISTS `centre_environnement_montagne`;
CREATE TABLE `centre_environnement_montagne` (
  `id_centre_environnement_montagne` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_centre_environnement_montagne`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `centre_environnement_montagne`
--

LOCK TABLES `centre_environnement_montagne` WRITE;
/*!40000 ALTER TABLE `centre_environnement_montagne` DISABLE KEYS */;
INSERT INTO `centre_environnement_montagne` VALUES (1,''),(2,''),(3,''),(4,''),(5,'');
/*!40000 ALTER TABLE `centre_environnement_montagne` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `centre_equipement`
--

DROP TABLE IF EXISTS `centre_equipement`;
CREATE TABLE `centre_equipement` (
  `id_centre_equipement` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_centre_equipement`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `centre_equipement`
--

LOCK TABLES `centre_equipement` WRITE;
/*!40000 ALTER TABLE `centre_equipement` DISABLE KEYS */;
INSERT INTO `centre_equipement` VALUES (1,''),(2,''),(3,''),(4,''),(5,''),(6,''),(7,''),(8,''),(9,''),(10,''),(11,''),(12,''),(13,''),(14,''),(15,''),(16,''),(17,''),(18,''),(19,''),(20,''),(21,''),(22,''),(23,''),(24,''),(25,'');
/*!40000 ALTER TABLE `centre_equipement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `centre_espace_detente`
--

DROP TABLE IF EXISTS `centre_espace_detente`;
CREATE TABLE `centre_espace_detente` (
  `id_centre_espace_detente` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_centre_espace_detente`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `centre_espace_detente`
--

LOCK TABLES `centre_espace_detente` WRITE;
/*!40000 ALTER TABLE `centre_espace_detente` DISABLE KEYS */;
INSERT INTO `centre_espace_detente` VALUES (1,''),(2,''),(3,''),(4,''),(5,''),(6,''),(7,''),(8,''),(9,''),(10,''),(11,''),(12,'');
/*!40000 ALTER TABLE `centre_espace_detente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `centre_les_plus`
--

DROP TABLE IF EXISTS `centre_les_plus`;
CREATE TABLE `centre_les_plus` (
  `id_centre_les_plus` int(11) unsigned NOT NULL auto_increment,
  `id_centre_1` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_centre_les_plus`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `centre_les_plus`
--

LOCK TABLES `centre_les_plus` WRITE;
/*!40000 ALTER TABLE `centre_les_plus` DISABLE KEYS */;
INSERT INTO `centre_les_plus` VALUES (5,1,''),(6,1,'');
/*!40000 ALTER TABLE `centre_les_plus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `centre_region`
--

DROP TABLE IF EXISTS `centre_region`;
CREATE TABLE `centre_region` (
  `id_centre_region` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_centre_region`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `centre_region`
--

LOCK TABLES `centre_region` WRITE;
/*!40000 ALTER TABLE `centre_region` DISABLE KEYS */;
INSERT INTO `centre_region` VALUES (1,'Auvergne');
/*!40000 ALTER TABLE `centre_region` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `centre_service`
--

DROP TABLE IF EXISTS `centre_service`;
CREATE TABLE `centre_service` (
  `id_centre_service` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_centre_service`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `centre_service`
--

LOCK TABLES `centre_service` WRITE;
/*!40000 ALTER TABLE `centre_service` DISABLE KEYS */;
INSERT INTO `centre_service` VALUES (1,''),(2,''),(3,''),(4,''),(5,''),(6,''),(7,''),(8,''),(9,''),(10,''),(11,''),(12,''),(13,''),(14,''),(15,''),(16,''),(17,''),(18,''),(19,'');
/*!40000 ALTER TABLE `centre_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `centre_site_touristique`
--

DROP TABLE IF EXISTS `centre_site_touristique`;
CREATE TABLE `centre_site_touristique` (
  `id_centre_site_touristique` int(11) unsigned NOT NULL auto_increment,
  `id_centre_1` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  `adresse` varchar(255) default NULL,
  PRIMARY KEY  (`id_centre_site_touristique`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `centre_site_touristique`
--

LOCK TABLES `centre_site_touristique` WRITE;
/*!40000 ALTER TABLE `centre_site_touristique` DISABLE KEYS */;
INSERT INTO `centre_site_touristique` VALUES (2,1,'','wwww');
/*!40000 ALTER TABLE `centre_site_touristique` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `centre_type_chambre`
--

DROP TABLE IF EXISTS `centre_type_chambre`;
CREATE TABLE `centre_type_chambre` (
  `id_centre_type_chambre` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_centre_type_chambre`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `centre_type_chambre`
--

LOCK TABLES `centre_type_chambre` WRITE;
/*!40000 ALTER TABLE `centre_type_chambre` DISABLE KEYS */;
INSERT INTO `centre_type_chambre` VALUES (1,'Ch. individuelle'),(2,'Ch. Ã  1 lit double'),(3,'Ch. Ã  2 lits'),(4,'Ch. Ã  3 lits'),(5,'Ch. Ã  4 lits'),(6,'Ch. Ã  5 lits'),(7,'Ch. Ã  6 lits'),(8,'Ch. Ã  + 6 lits');
/*!40000 ALTER TABLE `centre_type_chambre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classe_decouverte`
--

DROP TABLE IF EXISTS `classe_decouverte`;
CREATE TABLE `classe_decouverte` (
  `id_classe_decouverte` int(11) unsigned NOT NULL auto_increment,
  `nom_sejour` varchar(255) default NULL,
  `id_sejour_theme` varchar(254) default NULL,
  `id_sejour_niveau_scolaire` varchar(254) default NULL,
  `duree_sejour` varchar(255) default NULL,
  `id_sejour_priode_disponibilite` varchar(254) default NULL,
  `id_sejour_nb_lit__par_chambre` varchar(254) default NULL,
  `a_partir_de` int(1) default NULL,
  `a_partir_de_prix` varchar(255) default NULL,
  `prix_comprend` text,
  `prix_ne_comprend_pas` text,
  `interet_pedagogique` mediumtext,
  `details` mediumtext,
  PRIMARY KEY  (`id_classe_decouverte`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classe_decouverte`
--

LOCK TABLES `classe_decouverte` WRITE;
/*!40000 ALTER TABLE `classe_decouverte` DISABLE KEYS */;
/*!40000 ALTER TABLE `classe_decouverte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cvl`
--

DROP TABLE IF EXISTS `cvl`;
CREATE TABLE `cvl` (
  `id_cvl` int(11) unsigned NOT NULL auto_increment,
  `nom_sejour` varchar(255) default NULL,
  `id_sejour_theme` varchar(254) default NULL,
  `id_sejour_tranche_age` varchar(254) default NULL,
  `duree_sejour` varchar(255) default NULL,
  `id_sejour_nb_lit__par_chambre` varchar(254) default NULL,
  `a_partir_de` int(1) default NULL,
  `a_partir_de_prix` varchar(255) default NULL,
  `prix_comprend` text,
  `prix_ne_comprend_pas` text,
  `presentation` mediumtext,
  `id_sejour_accueil_handicap` varchar(254) default NULL,
  PRIMARY KEY  (`id_cvl`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cvl`
--

LOCK TABLES `cvl` WRITE;
/*!40000 ALTER TABLE `cvl` DISABLE KEYS */;
/*!40000 ALTER TABLE `cvl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `format_mail`
--

DROP TABLE IF EXISTS `format_mail`;
CREATE TABLE `format_mail` (
  `id_format_mail` int(11) unsigned NOT NULL auto_increment,
  `objet` varchar(255) default NULL,
  `cible` varchar(255) default NULL,
  `part` varchar(255) default NULL,
  `message` mediumtext,
  `date_ins` datetime default NULL,
  PRIMARY KEY  (`id_format_mail`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `format_mail`
--

LOCK TABLES `format_mail` WRITE;
/*!40000 ALTER TABLE `format_mail` DISABLE KEYS */;
/*!40000 ALTER TABLE `format_mail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gab_texte_riche`
--

DROP TABLE IF EXISTS `gab_texte_riche`;
CREATE TABLE `gab_texte_riche` (
  `id_gab_texte_riche` int(11) unsigned NOT NULL auto_increment,
  `gab_texte_riche` varchar(255) default NULL,
  PRIMARY KEY  (`id_gab_texte_riche`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gab_texte_riche`
--

LOCK TABLES `gab_texte_riche` WRITE;
/*!40000 ALTER TABLE `gab_texte_riche` DISABLE KEYS */;
/*!40000 ALTER TABLE `gab_texte_riche` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `libelle_site`
--

DROP TABLE IF EXISTS `libelle_site`;
CREATE TABLE `libelle_site` (
  `id_libelle_site` int(11) unsigned NOT NULL auto_increment,
  `libelle_site` varchar(255) default NULL,
  `libelle` varchar(255) default NULL,
  `valeur` mediumtext,
  `id__langue` int(11) unsigned default NULL,
  PRIMARY KEY  (`id_libelle_site`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `libelle_site`
--

LOCK TABLES `libelle_site` WRITE;
/*!40000 ALTER TABLE `libelle_site` DISABLE KEYS */;
/*!40000 ALTER TABLE `libelle_site` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `moteur`
--

DROP TABLE IF EXISTS `moteur`;
CREATE TABLE `moteur` (
  `id_moteur` int(11) unsigned NOT NULL auto_increment,
  `table_concernee` varchar(255) default NULL,
  `champ_concerne` text,
  PRIMARY KEY  (`id_moteur`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `moteur`
--

LOCK TABLES `moteur` WRITE;
/*!40000 ALTER TABLE `moteur` DISABLE KEYS */;
/*!40000 ALTER TABLE `moteur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `navigation`
--

DROP TABLE IF EXISTS `navigation`;
CREATE TABLE `navigation` (
  `id_navigation` int(11) unsigned NOT NULL auto_increment,
  `id__nav` int(11) unsigned default NULL,
  `id__langue` int(11) default NULL,
  `title` varchar(255) default NULL,
  `meta_keyword` text,
  `meta_description` text,
  `balise_xiti` varchar(255) default NULL,
  PRIMARY KEY  (`id_navigation`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `navigation`
--

LOCK TABLES `navigation` WRITE;
/*!40000 ALTER TABLE `navigation` DISABLE KEYS */;
INSERT INTO `navigation` VALUES (1,1,NULL,'FULLKIT BASIC','',NULL,'');
/*!40000 ALTER TABLE `navigation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organisateur_cvl`
--

DROP TABLE IF EXISTS `organisateur_cvl`;
CREATE TABLE `organisateur_cvl` (
  `id_organisateur_cvl` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  `adresse` varchar(255) default NULL,
  `code_postal` varchar(255) default NULL,
  `ville` varchar(255) default NULL,
  `telephone` varchar(255) default NULL,
  `fax` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `site_internet` varchar(250) default NULL,
  `resentation_organisme` mediumtext,
  `projet_educatif` mediumtext,
  `id_sejour_thematique` varchar(254) default NULL,
  `id_participant_age` varchar(254) default NULL,
  `agrement_jeunesse` int(1) default NULL,
  `agrement_jeunesse_texte` varchar(255) default NULL,
  `visuel` varchar(100) default NULL,
  PRIMARY KEY  (`id_organisateur_cvl`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organisateur_cvl`
--

LOCK TABLES `organisateur_cvl` WRITE;
/*!40000 ALTER TABLE `organisateur_cvl` DISABLE KEYS */;
/*!40000 ALTER TABLE `organisateur_cvl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `param`
--

DROP TABLE IF EXISTS `param`;
CREATE TABLE `param` (
  `id_param` int(11) unsigned NOT NULL auto_increment,
  `param` varchar(255) default NULL,
  `libelle` varchar(255) default NULL,
  `valeur` mediumtext,
  PRIMARY KEY  (`id_param`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `param`
--

LOCK TABLES `param` WRITE;
/*!40000 ALTER TABLE `param` DISABLE KEYS */;
/*!40000 ALTER TABLE `param` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `param_home`
--

DROP TABLE IF EXISTS `param_home`;
CREATE TABLE `param_home` (
  `id_param_home` int(11) unsigned NOT NULL auto_increment,
  `param_home` varchar(255) default NULL,
  `id__nav` int(11) unsigned default NULL,
  PRIMARY KEY  (`id_param_home`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `param_home`
--

LOCK TABLES `param_home` WRITE;
/*!40000 ALTER TABLE `param_home` DISABLE KEYS */;
INSERT INTO `param_home` VALUES (1,'',2);
/*!40000 ALTER TABLE `param_home` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participant_age`
--

DROP TABLE IF EXISTS `participant_age`;
CREATE TABLE `participant_age` (
  `id_participant_age` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_participant_age`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `participant_age`
--

LOCK TABLES `participant_age` WRITE;
/*!40000 ALTER TABLE `participant_age` DISABLE KEYS */;
INSERT INTO `participant_age` VALUES (1,''),(2,''),(3,''),(4,''),(5,''),(6,'');
/*!40000 ALTER TABLE `participant_age` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `portfolio_img`
--

DROP TABLE IF EXISTS `portfolio_img`;
CREATE TABLE `portfolio_img` (
  `id_portfolio_img` int(11) unsigned NOT NULL auto_increment,
  `portfolio_img` varchar(255) default NULL,
  `img` varchar(100) default NULL,
  `id_portfolio_rub` int(11) unsigned default NULL,
  PRIMARY KEY  (`id_portfolio_img`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `portfolio_img`
--

LOCK TABLES `portfolio_img` WRITE;
/*!40000 ALTER TABLE `portfolio_img` DISABLE KEYS */;
INSERT INTO `portfolio_img` VALUES (1,'Colline','Collines.jpg',1),(2,'book','Book.pdf',1);
/*!40000 ALTER TABLE `portfolio_img` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `portfolio_rub`
--

DROP TABLE IF EXISTS `portfolio_rub`;
CREATE TABLE `portfolio_rub` (
  `id_portfolio_rub` int(11) unsigned NOT NULL auto_increment,
  `portfolio_rub` varchar(255) default NULL,
  PRIMARY KEY  (`id_portfolio_rub`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `portfolio_rub`
--

LOCK TABLES `portfolio_rub` WRITE;
/*!40000 ALTER TABLE `portfolio_rub` DISABLE KEYS */;
INSERT INTO `portfolio_rub` VALUES (1,'(Aucune)');
/*!40000 ALTER TABLE `portfolio_rub` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sejour`
--

DROP TABLE IF EXISTS `sejour`;
CREATE TABLE `sejour` (
  `id_sejour` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  `itemTableDefGabarit` int(10) default NULL,
  `id_sejour_categorie` int(11) unsigned default NULL,
  PRIMARY KEY  (`id_sejour`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sejour`
--

LOCK TABLES `sejour` WRITE;
/*!40000 ALTER TABLE `sejour` DISABLE KEYS */;
/*!40000 ALTER TABLE `sejour` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sejour_accueil_handicap`
--

DROP TABLE IF EXISTS `sejour_accueil_handicap`;
CREATE TABLE `sejour_accueil_handicap` (
  `id_sejour_accueil_handicap` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_sejour_accueil_handicap`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sejour_accueil_handicap`
--

LOCK TABLES `sejour_accueil_handicap` WRITE;
/*!40000 ALTER TABLE `sejour_accueil_handicap` DISABLE KEYS */;
INSERT INTO `sejour_accueil_handicap` VALUES (1,''),(2,''),(3,''),(4,'');
/*!40000 ALTER TABLE `sejour_accueil_handicap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sejour_categorie`
--

DROP TABLE IF EXISTS `sejour_categorie`;
CREATE TABLE `sejour_categorie` (
  `id_sejour_categorie` int(11) unsigned NOT NULL auto_increment,
  `sejour_categorie` varchar(255) default NULL,
  `id__table_def` int(11) unsigned default NULL,
  PRIMARY KEY  (`id_sejour_categorie`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sejour_categorie`
--

LOCK TABLES `sejour_categorie` WRITE;
/*!40000 ALTER TABLE `sejour_categorie` DISABLE KEYS */;
/*!40000 ALTER TABLE `sejour_categorie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sejour_centre_adapte`
--

DROP TABLE IF EXISTS `sejour_centre_adapte`;
CREATE TABLE `sejour_centre_adapte` (
  `id_sejour_centre_adapte` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_sejour_centre_adapte`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sejour_centre_adapte`
--

LOCK TABLES `sejour_centre_adapte` WRITE;
/*!40000 ALTER TABLE `sejour_centre_adapte` DISABLE KEYS */;
INSERT INTO `sejour_centre_adapte` VALUES (1,''),(2,''),(3,''),(4,''),(5,''),(6,''),(7,''),(8,''),(9,''),(10,''),(11,''),(12,''),(13,'');
/*!40000 ALTER TABLE `sejour_centre_adapte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sejour_materiel_service`
--

DROP TABLE IF EXISTS `sejour_materiel_service`;
CREATE TABLE `sejour_materiel_service` (
  `id_sejour_materiel_service` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_sejour_materiel_service`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sejour_materiel_service`
--

LOCK TABLES `sejour_materiel_service` WRITE;
/*!40000 ALTER TABLE `sejour_materiel_service` DISABLE KEYS */;
INSERT INTO `sejour_materiel_service` VALUES (2,''),(3,''),(4,''),(5,''),(6,''),(7,''),(8,''),(9,''),(10,''),(11,'');
/*!40000 ALTER TABLE `sejour_materiel_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sejour_nb_lit__par_chambre`
--

DROP TABLE IF EXISTS `sejour_nb_lit__par_chambre`;
CREATE TABLE `sejour_nb_lit__par_chambre` (
  `id_sejour_nb_lit__par_chambre` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_sejour_nb_lit__par_chambre`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sejour_nb_lit__par_chambre`
--

LOCK TABLES `sejour_nb_lit__par_chambre` WRITE;
/*!40000 ALTER TABLE `sejour_nb_lit__par_chambre` DISABLE KEYS */;
INSERT INTO `sejour_nb_lit__par_chambre` VALUES (1,''),(2,''),(3,''),(4,''),(5,'');
/*!40000 ALTER TABLE `sejour_nb_lit__par_chambre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sejour_niveau_scolaire`
--

DROP TABLE IF EXISTS `sejour_niveau_scolaire`;
CREATE TABLE `sejour_niveau_scolaire` (
  `id_sejour_niveau_scolaire` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_sejour_niveau_scolaire`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sejour_niveau_scolaire`
--

LOCK TABLES `sejour_niveau_scolaire` WRITE;
/*!40000 ALTER TABLE `sejour_niveau_scolaire` DISABLE KEYS */;
INSERT INTO `sejour_niveau_scolaire` VALUES (1,''),(2,''),(3,''),(4,''),(5,''),(6,''),(7,'');
/*!40000 ALTER TABLE `sejour_niveau_scolaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sejour_priode_disponibilite`
--

DROP TABLE IF EXISTS `sejour_priode_disponibilite`;
CREATE TABLE `sejour_priode_disponibilite` (
  `id_sejour_priode_disponibilite` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_sejour_priode_disponibilite`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sejour_priode_disponibilite`
--

LOCK TABLES `sejour_priode_disponibilite` WRITE;
/*!40000 ALTER TABLE `sejour_priode_disponibilite` DISABLE KEYS */;
INSERT INTO `sejour_priode_disponibilite` VALUES (1,''),(2,''),(3,''),(4,'');
/*!40000 ALTER TABLE `sejour_priode_disponibilite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sejour_services_sportifs`
--

DROP TABLE IF EXISTS `sejour_services_sportifs`;
CREATE TABLE `sejour_services_sportifs` (
  `id_sejour_services_sportifs` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_sejour_services_sportifs`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sejour_services_sportifs`
--

LOCK TABLES `sejour_services_sportifs` WRITE;
/*!40000 ALTER TABLE `sejour_services_sportifs` DISABLE KEYS */;
INSERT INTO `sejour_services_sportifs` VALUES (1,''),(2,''),(3,''),(4,''),(5,''),(6,'');
/*!40000 ALTER TABLE `sejour_services_sportifs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sejour_thematique`
--

DROP TABLE IF EXISTS `sejour_thematique`;
CREATE TABLE `sejour_thematique` (
  `id_sejour_thematique` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_sejour_thematique`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sejour_thematique`
--

LOCK TABLES `sejour_thematique` WRITE;
/*!40000 ALTER TABLE `sejour_thematique` DISABLE KEYS */;
INSERT INTO `sejour_thematique` VALUES (1,''),(2,''),(3,''),(4,'');
/*!40000 ALTER TABLE `sejour_thematique` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sejour_theme`
--

DROP TABLE IF EXISTS `sejour_theme`;
CREATE TABLE `sejour_theme` (
  `id_sejour_theme` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_sejour_theme`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sejour_theme`
--

LOCK TABLES `sejour_theme` WRITE;
/*!40000 ALTER TABLE `sejour_theme` DISABLE KEYS */;
INSERT INTO `sejour_theme` VALUES (1,''),(2,''),(3,''),(4,'');
/*!40000 ALTER TABLE `sejour_theme` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sejour_theme_seminaire`
--

DROP TABLE IF EXISTS `sejour_theme_seminaire`;
CREATE TABLE `sejour_theme_seminaire` (
  `id_sejour_theme_seminaire` int(11) unsigned NOT NULL auto_increment,
  `theme_seminaire` varchar(255) default NULL,
  PRIMARY KEY  (`id_sejour_theme_seminaire`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sejour_theme_seminaire`
--

LOCK TABLES `sejour_theme_seminaire` WRITE;
/*!40000 ALTER TABLE `sejour_theme_seminaire` DISABLE KEYS */;
INSERT INTO `sejour_theme_seminaire` VALUES (1,''),(2,''),(3,'');
/*!40000 ALTER TABLE `sejour_theme_seminaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sejour_tranche_age`
--

DROP TABLE IF EXISTS `sejour_tranche_age`;
CREATE TABLE `sejour_tranche_age` (
  `id_sejour_tranche_age` int(11) unsigned NOT NULL auto_increment,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_sejour_tranche_age`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sejour_tranche_age`
--

LOCK TABLES `sejour_tranche_age` WRITE;
/*!40000 ALTER TABLE `sejour_tranche_age` DISABLE KEYS */;
INSERT INTO `sejour_tranche_age` VALUES (1,''),(2,''),(3,''),(4,''),(5,''),(6,'');
/*!40000 ALTER TABLE `sejour_tranche_age` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seminaires`
--

DROP TABLE IF EXISTS `seminaires`;
CREATE TABLE `seminaires` (
  `id_seminaires` int(11) unsigned NOT NULL auto_increment,
  `nom_seminaire` varchar(255) default NULL,
  `id_sejour_thematique` varchar(254) default NULL,
  `presentation` mediumtext,
  `a_partir_de` int(1) default NULL,
  `a_partir_de_prix` varchar(255) default NULL,
  `prix_comprend` text,
  `prix_ne_comprend_pas` text,
  `descriptif` mediumtext,
  `id_sejour_accueil_handicap` varchar(254) default NULL,
  PRIMARY KEY  (`id_seminaires`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `seminaires`
--

LOCK TABLES `seminaires` WRITE;
/*!40000 ALTER TABLE `seminaires` DISABLE KEYS */;
/*!40000 ALTER TABLE `seminaires` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad__nav`
--

DROP TABLE IF EXISTS `trad__nav`;
CREATE TABLE `trad__nav` (
  `id_trad__nav` int(11) unsigned NOT NULL auto_increment,
  `id___nav` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `_nav` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad__nav`)
) ENGINE=MyISAM AUTO_INCREMENT=302 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad__nav`
--

LOCK TABLES `trad__nav` WRITE;
/*!40000 ALTER TABLE `trad__nav` DISABLE KEYS */;
INSERT INTO `trad__nav` VALUES (1,1,1,'accueil -fr'),(2,2,1,'A chacun son sÃ©jour'),(3,2,2,''),(4,2,3,''),(5,2,5,''),(6,3,1,'POUR LES -18 ANS'),(7,3,2,''),(8,3,3,''),(9,3,5,''),(10,4,1,'Les destinations'),(11,4,2,''),(12,4,3,''),(13,4,5,''),(14,5,1,'Le blog'),(15,5,2,''),(16,5,3,''),(17,5,5,''),(18,6,1,'Le rÃ©seau Ethic Etapes'),(19,6,2,''),(20,6,3,''),(21,6,5,''),(22,7,1,'Le mÃ©dia Center'),(23,7,2,''),(24,7,3,''),(25,7,5,''),(26,8,1,'Contact'),(27,8,2,''),(28,8,3,''),(29,8,5,''),(30,9,1,'Newsletter'),(31,9,2,''),(32,9,3,''),(33,9,5,''),(34,10,1,'Brochures'),(35,10,2,''),(36,10,3,''),(37,10,5,''),(38,11,1,'Mentions lÃ©gales'),(39,11,2,''),(40,11,3,''),(41,11,5,''),(42,12,1,'Plan du site'),(43,12,2,''),(44,12,3,''),(45,12,5,''),(46,13,1,'Liens favoris'),(47,13,2,''),(48,13,3,''),(49,13,5,''),(50,14,1,'Partenaires'),(51,14,2,''),(52,14,3,''),(53,14,5,''),(54,15,1,'Presse'),(55,15,2,''),(56,15,3,''),(57,15,5,''),(58,16,1,'FAQ'),(59,16,2,''),(60,16,3,''),(61,16,5,''),(62,17,1,'Classe de dÃ©couverte'),(63,17,2,''),(64,17,3,''),(65,17,5,''),(66,18,1,'Accueil de scolaires'),(67,18,2,''),(68,18,3,''),(69,18,5,''),(70,19,1,'CVL'),(71,19,2,''),(72,19,3,''),(73,19,5,''),(74,20,1,'POUR VOS RÃ‰UNIONS'),(75,20,2,''),(76,20,3,''),(77,20,5,''),(78,21,1,'Une salle de rÃ©union'),(79,21,2,''),(80,21,3,''),(81,21,5,''),(82,22,1,'Incentives'),(83,22,2,''),(84,22,3,''),(85,22,5,''),(86,23,1,'SÃ©minaires verts'),(87,23,2,''),(88,23,3,''),(89,23,5,''),(90,24,1,'DÃ‰COUVERTES TOURISTIQUES'),(91,24,2,''),(92,24,3,''),(93,24,5,''),(94,25,1,'Accueil de groupes'),(95,25,2,''),(96,25,3,''),(97,25,5,''),(98,26,1,'Accueil de sportifs'),(99,26,2,''),(100,26,3,''),(101,26,5,''),(102,27,1,'SÃ©jours touristiques groupes'),(103,27,2,''),(104,27,3,''),(105,27,5,''),(106,28,1,'Stages thÃ©matiques groupes'),(107,28,2,''),(108,28,3,''),(109,28,5,''),(110,29,1,'Accueil d\'individuels'),(111,29,2,''),(112,29,3,''),(113,29,5,''),(114,30,1,'Short break individuels'),(115,30,2,''),(116,30,3,''),(117,30,5,''),(118,31,1,'Stages thÃ©matiques individuels'),(119,31,2,''),(120,31,3,''),(121,31,5,''),(122,32,1,'Tout un Ã©tat d\'esprit'),(123,32,2,''),(124,32,3,''),(125,32,5,''),(126,33,1,'Missions et Objectifs'),(127,33,2,''),(128,33,3,''),(129,33,5,''),(130,34,1,'Historique et Chiffres clÃ©s'),(131,34,2,''),(132,34,3,''),(133,34,5,''),(134,35,1,'Des hÃ©bergements accessibles'),(135,35,2,''),(136,35,3,''),(137,35,5,''),(138,36,1,'Notre dÃ©marche qualitÃ©'),(139,36,2,''),(140,36,3,''),(141,36,5,''),(142,37,1,'La chartre qualitÃ©'),(143,37,2,''),(144,37,3,''),(145,37,5,''),(146,38,1,'Les classements'),(147,38,2,''),(148,38,3,''),(149,38,5,''),(150,39,1,'Centres Mer'),(151,39,2,''),(152,39,3,''),(153,39,5,''),(154,40,1,'Centres Montagne'),(155,40,2,''),(156,40,3,''),(157,40,5,''),(158,41,1,'Centres Campagne'),(159,41,2,''),(160,41,3,''),(161,41,5,''),(162,42,1,'Centres Ville'),(163,42,2,''),(164,42,3,''),(165,42,5,''),(166,43,1,'Nouvelles destinations'),(167,43,2,''),(168,43,3,''),(169,43,5,''),(170,44,1,'Accueil de sportifs'),(171,44,2,''),(172,44,3,''),(173,44,5,''),(174,45,1,'Etape culturelle'),(175,45,2,''),(176,45,3,''),(177,45,5,''),(178,46,1,'Ambiance Farniente'),(179,46,2,''),(180,46,3,''),(181,46,5,''),(182,47,1,'100% nature'),(183,47,2,''),(184,47,3,''),(185,47,5,''),(186,48,1,'Urban trip'),(187,48,2,''),(188,48,3,''),(189,48,5,''),(190,49,1,'ActualitÃ©s'),(191,49,2,''),(192,49,3,''),(193,49,5,''),(194,50,1,'Agenda des centres'),(195,50,2,''),(196,50,3,''),(197,50,5,''),(198,51,1,'Astuces pour votre sÃ©jour'),(199,51,2,''),(200,51,3,''),(201,51,5,''),(202,52,1,'Forum de discussion'),(203,52,2,''),(204,52,3,''),(205,52,5,''),(206,53,1,'Espace Chartre graphique'),(207,53,2,''),(208,53,3,''),(209,53,5,''),(210,54,1,'Espace compte rendu de rÃ©union'),(211,54,2,''),(212,54,3,''),(213,54,5,''),(214,55,1,'Espace dÃ©veloppement durable'),(215,55,2,''),(216,55,3,''),(217,55,5,''),(218,56,1,'Espace actualitÃ©s'),(219,56,2,''),(220,56,3,''),(221,56,5,''),(222,57,1,'Espace agenda'),(223,57,2,''),(224,57,3,''),(225,57,5,''),(226,58,1,'Espace rÃ©glementaire'),(227,58,2,''),(228,58,3,''),(229,58,5,''),(230,59,1,'Espace rÃ©fÃ©rence fournisseur'),(231,59,2,''),(232,59,3,''),(233,59,5,''),(234,60,1,'Espace dÃ©pÃ´t offres d\'emplois'),(235,60,2,''),(236,60,3,''),(237,60,5,''),(238,61,1,'IngÃ©nierie pour les Ethic Etapes'),(239,61,2,''),(240,61,3,''),(241,61,5,''),(242,62,1,'Espace Ã©tapes Ã©chos'),(243,62,2,''),(244,62,3,''),(245,62,5,''),(246,63,1,'AccÃ¨s oubliÃ©s'),(247,63,2,''),(248,63,3,''),(249,63,5,''),(250,64,1,'Une dÃ©marche durable'),(251,64,2,''),(252,64,3,''),(253,64,5,''),(254,65,1,'Dans le rÃ©seau'),(255,65,2,''),(256,65,3,''),(257,65,5,''),(258,66,1,'Dans les centres'),(259,66,2,''),(260,66,3,''),(261,66,5,''),(262,67,1,'Avec nos partenaires'),(263,67,2,''),(264,67,3,''),(265,67,5,''),(266,68,1,'Notre espace emploi'),(267,68,2,''),(268,68,3,''),(269,68,5,''),(270,69,1,'Nos offres d\'emplois et de stages'),(271,69,2,''),(272,69,3,''),(273,69,5,''),(274,70,1,'Faites votre candidature spontannÃ©e'),(275,70,2,''),(276,70,3,''),(277,70,5,''),(278,71,1,'Formation professionnelle et BAFA des centres'),(279,71,2,''),(280,71,3,''),(281,71,5,''),(282,72,1,'Devenir Ethic Etapes'),(283,72,2,''),(284,72,3,''),(285,72,5,''),(286,73,1,'Pourquoi rejoindre le rÃ©seau ?'),(287,73,2,''),(288,73,3,''),(289,73,5,''),(290,74,1,'Le concept Ethic Etapes'),(291,74,2,''),(292,74,3,''),(293,74,5,''),(294,75,1,'Les critÃ¨res pour devenir Ethic Etapes'),(295,75,2,''),(296,75,3,''),(297,75,5,''),(298,76,1,'La procÃ©dure Ã  suivre'),(299,76,2,''),(300,76,3,''),(301,76,5,'');
/*!40000 ALTER TABLE `trad__nav` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_acceuil_reunions`
--

DROP TABLE IF EXISTS `trad_acceuil_reunions`;
CREATE TABLE `trad_acceuil_reunions` (
  `id_trad_acceuil_reunions` int(11) unsigned NOT NULL auto_increment,
  `id__acceuil_reunions` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `commentaires_salles` text,
  PRIMARY KEY  (`id_trad_acceuil_reunions`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_acceuil_reunions`
--

LOCK TABLES `trad_acceuil_reunions` WRITE;
/*!40000 ALTER TABLE `trad_acceuil_reunions` DISABLE KEYS */;
/*!40000 ALTER TABLE `trad_acceuil_reunions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_accueil_groupes_jeunes_adultes`
--

DROP TABLE IF EXISTS `trad_accueil_groupes_jeunes_adultes`;
CREATE TABLE `trad_accueil_groupes_jeunes_adultes` (
  `id_trad_accueil_groupes_jeunes_adultes` int(11) unsigned NOT NULL auto_increment,
  `id__accueil_groupes_jeunes_adultes` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `conditions_groupes` mediumtext,
  `conditions_professionnels` mediumtext,
  `installations_autres` text,
  `commentaire_accueil_sportifs` mediumtext,
  PRIMARY KEY  (`id_trad_accueil_groupes_jeunes_adultes`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_accueil_groupes_jeunes_adultes`
--

LOCK TABLES `trad_accueil_groupes_jeunes_adultes` WRITE;
/*!40000 ALTER TABLE `trad_accueil_groupes_jeunes_adultes` DISABLE KEYS */;
/*!40000 ALTER TABLE `trad_accueil_groupes_jeunes_adultes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_accueil_groupes_scolaires`
--

DROP TABLE IF EXISTS `trad_accueil_groupes_scolaires`;
CREATE TABLE `trad_accueil_groupes_scolaires` (
  `id_trad_accueil_groupes_scolaires` int(11) unsigned NOT NULL auto_increment,
  `id__accueil_groupes_scolaires` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `haute_saison` varchar(255) default NULL,
  `moyenne_saison` varchar(255) default NULL,
  `base_saison` varchar(255) default NULL,
  `conditions_scolaires` mediumtext,
  PRIMARY KEY  (`id_trad_accueil_groupes_scolaires`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_accueil_groupes_scolaires`
--

LOCK TABLES `trad_accueil_groupes_scolaires` WRITE;
/*!40000 ALTER TABLE `trad_accueil_groupes_scolaires` DISABLE KEYS */;
/*!40000 ALTER TABLE `trad_accueil_groupes_scolaires` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_actualite`
--

DROP TABLE IF EXISTS `trad_actualite`;
CREATE TABLE `trad_actualite` (
  `id_trad_actualite` int(11) unsigned NOT NULL auto_increment,
  `id__actualite` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  `description_courte` text,
  `description_longue` mediumtext,
  PRIMARY KEY  (`id_trad_actualite`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_actualite`
--

LOCK TABLES `trad_actualite` WRITE;
/*!40000 ALTER TABLE `trad_actualite` DISABLE KEYS */;
/*!40000 ALTER TABLE `trad_actualite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_bon_plan`
--

DROP TABLE IF EXISTS `trad_bon_plan`;
CREATE TABLE `trad_bon_plan` (
  `id_trad_bon_plan` int(11) unsigned NOT NULL auto_increment,
  `id__bon_plan` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `description` mediumtext,
  PRIMARY KEY  (`id_trad_bon_plan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_bon_plan`
--

LOCK TABLES `trad_bon_plan` WRITE;
/*!40000 ALTER TABLE `trad_bon_plan` DISABLE KEYS */;
/*!40000 ALTER TABLE `trad_bon_plan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_centre`
--

DROP TABLE IF EXISTS `trad_centre`;
CREATE TABLE `trad_centre` (
  `id_trad_centre` int(11) unsigned NOT NULL auto_increment,
  `id__centre` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `acces_route_texte` varchar(255) default NULL,
  `acces_train_texte` varchar(255) default NULL,
  `acces_avion_texte` varchar(255) default NULL,
  `acces_bus_metro_texte` varchar(255) default NULL,
  `presentation` mediumtext,
  `classement1` varchar(255) default NULL,
  `classement2` varchar(255) default NULL,
  `agrement_edu_nationale_texte` varchar(255) default NULL,
  `agrement_jeunesse_texte` varchar(255) default NULL,
  `agrement_tourisme_texte` varchar(255) default NULL,
  `agrement_ddass_texte` varchar(255) default NULL,
  `presentation_region` mediumtext,
  PRIMARY KEY  (`id_trad_centre`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_centre`
--

LOCK TABLES `trad_centre` WRITE;
/*!40000 ALTER TABLE `trad_centre` DISABLE KEYS */;
INSERT INTO `trad_centre` VALUES (8,2,5,'','','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,2,3,'','','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,2,2,'','','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,2,1,'','','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `trad_centre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_centre_activite`
--

DROP TABLE IF EXISTS `trad_centre_activite`;
CREATE TABLE `trad_centre_activite` (
  `id_trad_centre_activite` int(11) unsigned NOT NULL auto_increment,
  `id__centre_activite` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad_centre_activite`)
) ENGINE=MyISAM AUTO_INCREMENT=189 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_centre_activite`
--

LOCK TABLES `trad_centre_activite` WRITE;
/*!40000 ALTER TABLE `trad_centre_activite` DISABLE KEYS */;
INSERT INTO `trad_centre_activite` VALUES (1,1,1,'accrobranche'),(2,1,2,''),(3,1,3,''),(4,1,5,''),(5,2,1,'alpinisme / escalade'),(6,2,2,''),(7,2,3,''),(8,2,5,''),(9,3,1,'arts martiaux'),(10,3,2,''),(11,3,3,''),(12,3,5,''),(13,4,1,'athlÃ©tisme'),(14,4,2,''),(15,4,3,''),(16,4,5,''),(17,5,1,'vol Ã  voile'),(18,5,2,''),(19,5,3,''),(20,5,5,''),(21,6,1,'badminton'),(22,6,2,''),(23,6,3,''),(24,6,5,''),(25,7,1,'basket ball'),(26,7,2,''),(27,7,3,''),(28,7,5,''),(29,8,1,'canoÃ©/ kayak'),(30,8,2,''),(31,8,3,''),(32,8,5,''),(33,9,1,'cannyoning'),(34,9,2,''),(35,9,3,''),(36,9,5,''),(37,10,1,'volle yâ€ball'),(38,10,2,''),(39,10,3,''),(40,10,5,''),(41,11,1,'cerf volant'),(42,11,2,''),(43,11,3,''),(44,11,5,''),(45,12,1,'char Ã  voile'),(46,12,2,''),(47,12,3,''),(48,12,5,''),(49,13,1,'course dâ€™orientation'),(50,13,2,''),(51,13,3,''),(52,13,5,''),(53,14,1,'cyclotourisme'),(54,14,2,''),(55,14,3,''),(56,14,5,''),(57,15,1,'yoga'),(58,15,2,''),(59,15,3,''),(60,15,5,''),(61,16,1,'cyclotourisme'),(62,16,2,''),(63,16,3,''),(64,16,5,''),(65,17,1,'Ã©quitation'),(66,17,2,''),(67,17,3,''),(68,17,5,''),(69,18,1,'football'),(70,18,2,''),(71,18,3,''),(72,18,5,''),(73,19,1,'golf / swin golf'),(74,19,2,''),(75,19,3,''),(76,19,5,''),(77,20,1,'voile'),(78,20,2,''),(79,20,3,''),(80,20,5,''),(81,21,1,'gymnastique'),(82,21,2,''),(83,21,3,''),(84,21,5,''),(85,22,1,'hand ball'),(86,22,2,''),(87,22,3,''),(88,22,5,''),(89,23,1,'karting'),(90,23,2,''),(91,23,3,''),(92,23,5,''),(93,24,1,'kayak de mer'),(94,24,2,''),(95,24,3,''),(96,24,5,''),(97,25,1,'vÃ©lo sur piste'),(98,25,2,''),(99,25,3,''),(100,25,5,''),(101,26,1,'musculation'),(102,26,2,''),(103,26,3,''),(104,26,5,''),(105,27,1,'natation'),(106,27,2,''),(107,27,3,''),(108,27,5,''),(109,28,1,'sports de glace'),(110,28,2,''),(111,28,3,''),(112,28,5,''),(113,29,1,'parachutisme'),(114,29,2,''),(115,29,3,''),(116,29,5,''),(117,30,1,'tir Ã  lâ€™arc'),(118,30,2,''),(119,30,3,''),(120,30,5,''),(121,31,1,'pÃªche'),(122,31,2,''),(123,31,3,''),(124,31,5,''),(125,32,1,'planche Ã  voile'),(126,32,2,''),(127,32,3,''),(128,32,5,''),(129,33,1,'plongÃ©e'),(130,33,2,''),(131,33,3,''),(132,33,5,''),(133,34,1,'rafting / hydrospeed'),(134,34,2,''),(135,34,3,''),(136,34,5,''),(137,35,1,'tennis'),(138,35,2,''),(139,35,3,''),(140,35,5,''),(141,36,1,'randonnÃ©e pÃ©destre'),(142,36,2,''),(143,36,3,''),(144,36,5,''),(145,37,1,'randonnÃ©e Ã©questre'),(146,37,2,''),(147,37,3,''),(148,37,5,''),(149,38,1,'randonnÃ©e VTT / vÃ©lo'),(150,38,2,''),(151,38,3,''),(152,38,5,''),(153,39,1,'raquettes'),(154,39,2,''),(155,39,3,''),(156,39,5,''),(157,40,1,'rugby'),(158,40,2,''),(159,40,3,''),(160,40,5,''),(161,41,1,'roller'),(162,41,2,''),(163,41,3,''),(164,41,5,''),(165,42,1,'skate board'),(166,42,2,''),(167,42,3,''),(168,42,5,''),(169,43,1,'ski alpin / snowboard'),(170,43,2,''),(171,43,3,''),(172,43,5,''),(173,44,1,'ski de fond'),(174,44,2,''),(175,44,3,''),(176,44,5,''),(177,45,1,'ski nautique'),(178,45,2,''),(179,45,3,''),(180,45,5,''),(181,46,1,'spÃ©lÃ©ologie'),(182,46,2,''),(183,46,3,''),(184,46,5,''),(185,47,1,'surf / bodyboard'),(186,47,2,''),(187,47,3,''),(188,47,5,'');
/*!40000 ALTER TABLE `trad_centre_activite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_centre_ambiance`
--

DROP TABLE IF EXISTS `trad_centre_ambiance`;
CREATE TABLE `trad_centre_ambiance` (
  `id_trad_centre_ambiance` int(11) unsigned NOT NULL auto_increment,
  `id__centre_ambiance` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad_centre_ambiance`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_centre_ambiance`
--

LOCK TABLES `trad_centre_ambiance` WRITE;
/*!40000 ALTER TABLE `trad_centre_ambiance` DISABLE KEYS */;
INSERT INTO `trad_centre_ambiance` VALUES (1,1,1,'Centre sportif'),(2,1,2,''),(3,1,3,''),(4,1,5,''),(5,2,1,'Centre farniente'),(6,2,2,''),(7,2,3,''),(8,2,5,''),(9,3,1,'Centre 100% nature'),(10,3,2,''),(11,3,3,''),(12,3,5,''),(13,4,1,'Centre culturel'),(14,4,2,''),(15,4,3,''),(16,4,5,''),(17,5,1,'Centre spÃ©cial urban trip'),(18,5,2,''),(19,5,3,''),(20,5,5,'');
/*!40000 ALTER TABLE `trad_centre_ambiance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_centre_classement`
--

DROP TABLE IF EXISTS `trad_centre_classement`;
CREATE TABLE `trad_centre_classement` (
  `id_trad_centre_classement` int(11) unsigned NOT NULL auto_increment,
  `id__centre_classement` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad_centre_classement`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_centre_classement`
--

LOCK TABLES `trad_centre_classement` WRITE;
/*!40000 ALTER TABLE `trad_centre_classement` DISABLE KEYS */;
INSERT INTO `trad_centre_classement` VALUES (1,2,1,'Atouts simples'),(2,2,2,''),(3,2,3,''),(4,2,5,''),(5,4,1,'Atouts simples et variÃ©s'),(6,4,2,''),(7,4,3,''),(8,4,5,''),(9,6,1,'Atouts nombreux et variÃ©s'),(10,6,2,''),(11,6,3,''),(12,6,5,''),(13,8,1,'Atouts trÃ¨s nombreux et trÃ¨s variÃ©s'),(14,8,2,''),(15,8,3,''),(16,8,5,'');
/*!40000 ALTER TABLE `trad_centre_classement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_centre_detention_label`
--

DROP TABLE IF EXISTS `trad_centre_detention_label`;
CREATE TABLE `trad_centre_detention_label` (
  `id_trad_centre_detention_label` int(11) unsigned NOT NULL auto_increment,
  `id__centre_detention_label` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad_centre_detention_label`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_centre_detention_label`
--

LOCK TABLES `trad_centre_detention_label` WRITE;
/*!40000 ALTER TABLE `trad_centre_detention_label` DISABLE KEYS */;
INSERT INTO `trad_centre_detention_label` VALUES (1,1,1,'Ecolabel europÃ©en'),(2,1,2,''),(3,1,3,''),(4,1,5,''),(5,2,1,'Tourisme et handicap moteur'),(6,2,2,''),(7,2,3,''),(8,2,5,''),(9,3,1,'Tourisme et handicap mental'),(10,3,2,''),(11,3,3,''),(12,3,5,''),(13,4,1,'Tourisme et handicap auditif'),(14,4,2,''),(15,4,3,''),(16,4,5,''),(17,5,1,'Tourisme et handicap visuel'),(18,5,2,''),(19,5,3,''),(20,5,5,'');
/*!40000 ALTER TABLE `trad_centre_detention_label` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_centre_environnement`
--

DROP TABLE IF EXISTS `trad_centre_environnement`;
CREATE TABLE `trad_centre_environnement` (
  `id_trad_centre_environnement` int(11) unsigned NOT NULL auto_increment,
  `id__centre_environnement` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad_centre_environnement`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_centre_environnement`
--

LOCK TABLES `trad_centre_environnement` WRITE;
/*!40000 ALTER TABLE `trad_centre_environnement` DISABLE KEYS */;
INSERT INTO `trad_centre_environnement` VALUES (1,1,1,'Mer'),(2,1,2,''),(3,1,3,''),(4,1,5,''),(5,2,1,'Montagne'),(6,2,2,''),(7,2,3,''),(8,2,5,''),(9,3,1,'Campagne'),(10,3,2,''),(11,3,3,''),(12,3,5,''),(13,4,1,'Ville'),(14,4,2,''),(15,4,3,''),(16,4,5,'');
/*!40000 ALTER TABLE `trad_centre_environnement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_centre_environnement_montagne`
--

DROP TABLE IF EXISTS `trad_centre_environnement_montagne`;
CREATE TABLE `trad_centre_environnement_montagne` (
  `id_trad_centre_environnement_montagne` int(11) unsigned NOT NULL auto_increment,
  `id__centre_environnement_montagne` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad_centre_environnement_montagne`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_centre_environnement_montagne`
--

LOCK TABLES `trad_centre_environnement_montagne` WRITE;
/*!40000 ALTER TABLE `trad_centre_environnement_montagne` DISABLE KEYS */;
INSERT INTO `trad_centre_environnement_montagne` VALUES (1,1,1,'Jura'),(2,1,2,''),(3,1,3,''),(4,1,5,''),(5,2,1,'Alpes'),(6,2,2,''),(7,2,3,''),(8,2,5,''),(9,3,1,'Vosges'),(10,3,2,''),(11,3,3,''),(12,3,5,''),(13,4,1,'PyrÃ©nÃ©es'),(14,4,2,''),(15,4,3,''),(16,4,5,''),(17,5,1,'Massif Central'),(18,5,2,''),(19,5,3,''),(20,5,5,'');
/*!40000 ALTER TABLE `trad_centre_environnement_montagne` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_centre_equipement`
--

DROP TABLE IF EXISTS `trad_centre_equipement`;
CREATE TABLE `trad_centre_equipement` (
  `id_trad_centre_equipement` int(11) unsigned NOT NULL auto_increment,
  `id__centre_equipement` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad_centre_equipement`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_centre_equipement`
--

LOCK TABLES `trad_centre_equipement` WRITE;
/*!40000 ALTER TABLE `trad_centre_equipement` DISABLE KEYS */;
INSERT INTO `trad_centre_equipement` VALUES (1,1,1,'aÃ©rodrome'),(2,1,2,''),(3,1,3,''),(4,1,5,''),(5,2,1,'terrain de boules'),(6,2,2,''),(7,2,3,''),(8,2,5,''),(9,3,1,'mur dâ€™escalade'),(10,3,2,''),(11,3,3,''),(12,3,5,''),(13,4,1,'salle de musculation'),(14,4,2,''),(15,4,3,''),(16,4,5,''),(17,5,1,'swin golf'),(18,5,2,''),(19,5,3,''),(20,5,5,''),(21,6,1,'centre Ã©questre'),(22,6,2,''),(23,6,3,''),(24,6,5,''),(25,7,1,'terrain grands jeux'),(26,7,2,''),(27,7,3,''),(28,7,5,''),(29,8,1,'patinoire'),(30,8,2,''),(31,8,3,''),(32,8,5,''),(33,9,1,'stade'),(34,9,2,''),(35,9,3,''),(36,9,5,''),(37,10,1,'vÃ©lodrome'),(38,10,2,''),(39,10,3,''),(40,10,5,''),(41,11,1,'centre nautique'),(42,11,2,''),(43,11,3,''),(44,11,5,''),(45,12,1,'gymnase'),(46,12,2,''),(47,12,3,''),(48,12,5,''),(49,13,1,'stade de glisse'),(50,13,2,''),(51,13,3,''),(52,13,5,''),(53,14,1,'courts de tennis'),(54,14,2,''),(55,14,3,''),(56,14,5,''),(57,15,1,'practice'),(58,15,2,''),(59,15,3,''),(60,15,5,''),(61,16,1,'salle de sport spÃ©cialisÃ©e'),(62,16,2,''),(63,16,3,''),(64,16,5,''),(65,17,1,'Ã©quipement sports de raquettes'),(66,17,2,''),(67,17,3,''),(68,17,5,''),(69,18,1,'centre Ã©questre'),(70,18,2,''),(71,18,3,''),(72,18,5,''),(73,19,1,'golf'),(74,19,2,''),(75,19,3,''),(76,19,5,''),(77,20,1,'parcours de santÃ©'),(78,20,2,''),(79,20,3,''),(80,20,5,''),(81,21,1,'pas de tir Ã  lâ€™arc'),(82,21,2,''),(83,21,3,''),(84,21,5,''),(85,22,1,'tables de tennis de table'),(86,22,2,''),(87,22,3,''),(88,22,5,''),(89,23,1,'sentier balisÃ©'),(90,23,2,''),(91,23,3,''),(92,23,5,''),(93,24,1,'dojo'),(94,24,2,''),(95,24,3,''),(96,24,5,''),(97,25,1,'Sauna Hammam'),(98,25,2,''),(99,25,3,''),(100,25,5,'');
/*!40000 ALTER TABLE `trad_centre_equipement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_centre_espace_detente`
--

DROP TABLE IF EXISTS `trad_centre_espace_detente`;
CREATE TABLE `trad_centre_espace_detente` (
  `id_trad_centre_espace_detente` int(11) unsigned NOT NULL auto_increment,
  `id__centre_espace_detente` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad_centre_espace_detente`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_centre_espace_detente`
--

LOCK TABLES `trad_centre_espace_detente` WRITE;
/*!40000 ALTER TABLE `trad_centre_espace_detente` DISABLE KEYS */;
INSERT INTO `trad_centre_espace_detente` VALUES (1,1,1,'bar'),(2,1,2,''),(3,1,3,''),(4,1,5,''),(5,2,1,'cheminÃ©e'),(6,2,2,''),(7,2,3,''),(8,2,5,''),(9,3,1,'ping pong'),(10,3,2,''),(11,3,3,''),(12,3,5,''),(13,4,1,'discothÃ¨que'),(14,4,2,''),(15,4,3,''),(16,4,5,''),(17,5,1,'terrasse'),(18,5,2,''),(19,5,3,''),(20,5,5,''),(21,6,1,'salle de jeux'),(22,6,2,''),(23,6,3,''),(24,6,5,''),(25,7,1,'piano'),(26,7,2,''),(27,7,3,''),(28,7,5,''),(29,8,1,'bibliothÃ¨que'),(30,8,2,''),(31,8,3,''),(32,8,5,''),(33,9,1,'salon'),(34,9,2,''),(35,9,3,''),(36,9,5,''),(37,10,1,'billard'),(38,10,2,''),(39,10,3,''),(40,10,5,''),(41,11,1,'salle TV'),(42,11,2,''),(43,11,3,''),(44,11,5,''),(45,12,1,'jeux de sociÃ©tÃ©'),(46,12,2,''),(47,12,3,''),(48,12,5,'');
/*!40000 ALTER TABLE `trad_centre_espace_detente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_centre_les_plus`
--

DROP TABLE IF EXISTS `trad_centre_les_plus`;
CREATE TABLE `trad_centre_les_plus` (
  `id_trad_centre_les_plus` int(11) unsigned NOT NULL auto_increment,
  `id__centre_les_plus` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad_centre_les_plus`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_centre_les_plus`
--

LOCK TABLES `trad_centre_les_plus` WRITE;
/*!40000 ALTER TABLE `trad_centre_les_plus` DISABLE KEYS */;
INSERT INTO `trad_centre_les_plus` VALUES (20,5,5,''),(19,5,3,''),(18,5,2,''),(17,5,1,'111'),(22,6,2,'111'),(21,6,1,'222'),(23,6,3,'333'),(24,6,5,'444');
/*!40000 ALTER TABLE `trad_centre_les_plus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_centre_service`
--

DROP TABLE IF EXISTS `trad_centre_service`;
CREATE TABLE `trad_centre_service` (
  `id_trad_centre_service` int(11) unsigned NOT NULL auto_increment,
  `id__centre_service` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad_centre_service`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_centre_service`
--

LOCK TABLES `trad_centre_service` WRITE;
/*!40000 ALTER TABLE `trad_centre_service` DISABLE KEYS */;
INSERT INTO `trad_centre_service` VALUES (1,1,1,'accÃ¨s public internet'),(2,1,2,''),(3,1,3,''),(4,1,5,''),(5,2,1,'am classes maternelles'),(6,2,2,''),(7,2,3,''),(8,2,5,''),(9,3,1,'amÃ©nagement handicapÃ©s'),(10,3,2,''),(11,3,3,''),(12,3,5,''),(13,4,1,'ascenseur'),(14,4,2,''),(15,4,3,''),(16,4,5,''),(17,5,1,'bagagerie'),(18,5,2,''),(19,5,3,''),(20,5,5,''),(21,6,1,'bar / cafÃ©teria'),(22,6,2,''),(23,6,3,''),(24,6,5,''),(25,7,1,'boutique'),(26,7,2,''),(27,7,3,''),(28,7,5,''),(29,8,1,'service tourisme'),(30,8,2,''),(31,8,3,''),(32,8,5,''),(33,9,1,'consignes automatiques'),(34,9,2,''),(35,9,3,''),(36,9,5,''),(37,10,1,'garage Ã  vÃ©los'),(38,10,2,''),(39,10,3,''),(40,10,5,''),(41,11,1,'laverie'),(42,11,2,''),(43,11,3,''),(44,11,5,''),(45,12,1,'location vÃ©lo / VTT'),(46,12,2,''),(47,12,3,''),(48,12,5,''),(49,13,1,'parking bus'),(50,13,2,''),(51,13,3,''),(52,13,5,''),(53,14,1,'parking voitures'),(54,14,2,''),(55,14,3,''),(56,14,5,''),(57,15,1,'tÃ©lÃ©phone dans les chambres'),(58,15,2,''),(59,15,3,''),(60,15,5,''),(61,16,1,'carte bancaire'),(62,16,2,''),(63,16,3,''),(64,16,5,''),(65,17,1,'devises acceptÃ©es'),(66,17,2,''),(67,17,3,''),(68,17,5,''),(69,18,1,'aire de camping'),(70,18,2,''),(71,18,3,''),(72,18,5,''),(73,19,1,'ChÃ¨que de voyages (ex : Travellers)'),(74,19,2,''),(75,19,3,''),(76,19,5,'');
/*!40000 ALTER TABLE `trad_centre_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_centre_site_touristique`
--

DROP TABLE IF EXISTS `trad_centre_site_touristique`;
CREATE TABLE `trad_centre_site_touristique` (
  `id_trad_centre_site_touristique` int(11) unsigned NOT NULL auto_increment,
  `id__centre_site_touristique` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad_centre_site_touristique`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_centre_site_touristique`
--

LOCK TABLES `trad_centre_site_touristique` WRITE;
/*!40000 ALTER TABLE `trad_centre_site_touristique` DISABLE KEYS */;
INSERT INTO `trad_centre_site_touristique` VALUES (7,2,3,''),(6,2,2,''),(5,2,1,'www'),(8,2,5,'');
/*!40000 ALTER TABLE `trad_centre_site_touristique` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_classe_decouverte`
--

DROP TABLE IF EXISTS `trad_classe_decouverte`;
CREATE TABLE `trad_classe_decouverte` (
  `id_trad_classe_decouverte` int(11) unsigned NOT NULL auto_increment,
  `id__classe_decouverte` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `nom_sejour` varchar(255) default NULL,
  `duree_sejour` varchar(255) default NULL,
  `prix_comprend` text,
  `prix_ne_comprend_pas` text,
  `interet_pedagogique` mediumtext,
  `details` mediumtext,
  PRIMARY KEY  (`id_trad_classe_decouverte`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_classe_decouverte`
--

LOCK TABLES `trad_classe_decouverte` WRITE;
/*!40000 ALTER TABLE `trad_classe_decouverte` DISABLE KEYS */;
/*!40000 ALTER TABLE `trad_classe_decouverte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_cvl`
--

DROP TABLE IF EXISTS `trad_cvl`;
CREATE TABLE `trad_cvl` (
  `id_trad_cvl` int(11) unsigned NOT NULL auto_increment,
  `id__cvl` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `nom_sejour` varchar(255) default NULL,
  `duree_sejour` varchar(255) default NULL,
  `prix_comprend` text,
  `prix_ne_comprend_pas` text,
  `presentation` mediumtext,
  PRIMARY KEY  (`id_trad_cvl`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_cvl`
--

LOCK TABLES `trad_cvl` WRITE;
/*!40000 ALTER TABLE `trad_cvl` DISABLE KEYS */;
/*!40000 ALTER TABLE `trad_cvl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_detention_label`
--

DROP TABLE IF EXISTS `trad_detention_label`;
CREATE TABLE `trad_detention_label` (
  `id_trad_detention_label` int(11) unsigned NOT NULL auto_increment,
  `id__detention_label` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad_detention_label`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_detention_label`
--

LOCK TABLES `trad_detention_label` WRITE;
/*!40000 ALTER TABLE `trad_detention_label` DISABLE KEYS */;
/*!40000 ALTER TABLE `trad_detention_label` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_organisateur_cvl`
--

DROP TABLE IF EXISTS `trad_organisateur_cvl`;
CREATE TABLE `trad_organisateur_cvl` (
  `id_trad_organisateur_cvl` int(11) unsigned NOT NULL auto_increment,
  `id__organisateur_cvl` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  `resentation_organisme` mediumtext,
  `projet_educatif` mediumtext,
  `agrement_jeunesse_texte` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad_organisateur_cvl`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_organisateur_cvl`
--

LOCK TABLES `trad_organisateur_cvl` WRITE;
/*!40000 ALTER TABLE `trad_organisateur_cvl` DISABLE KEYS */;
/*!40000 ALTER TABLE `trad_organisateur_cvl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_participant_age`
--

DROP TABLE IF EXISTS `trad_participant_age`;
CREATE TABLE `trad_participant_age` (
  `id_trad_participant_age` int(11) unsigned NOT NULL auto_increment,
  `id__participant_age` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad_participant_age`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_participant_age`
--

LOCK TABLES `trad_participant_age` WRITE;
/*!40000 ALTER TABLE `trad_participant_age` DISABLE KEYS */;
INSERT INTO `trad_participant_age` VALUES (1,1,1,'4â€6 ans'),(2,1,2,''),(3,1,3,''),(4,1,5,''),(5,2,1,'7â€9 ans'),(6,2,2,''),(7,2,3,''),(8,2,5,''),(9,3,1,'10â€11 ans'),(10,3,2,''),(11,3,3,''),(12,3,5,''),(13,4,1,'12â€13 ans'),(14,4,2,''),(15,4,3,''),(16,4,5,''),(17,5,1,'14â€15 ans'),(18,5,2,''),(19,5,3,''),(20,5,5,''),(21,6,1,'16â€18 ans'),(22,6,2,''),(23,6,3,''),(24,6,5,'');
/*!40000 ALTER TABLE `trad_participant_age` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_sejour`
--

DROP TABLE IF EXISTS `trad_sejour`;
CREATE TABLE `trad_sejour` (
  `id_trad_sejour` int(11) unsigned NOT NULL auto_increment,
  `id__sejour` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad_sejour`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_sejour`
--

LOCK TABLES `trad_sejour` WRITE;
/*!40000 ALTER TABLE `trad_sejour` DISABLE KEYS */;
/*!40000 ALTER TABLE `trad_sejour` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_sejour_accueil_handicap`
--

DROP TABLE IF EXISTS `trad_sejour_accueil_handicap`;
CREATE TABLE `trad_sejour_accueil_handicap` (
  `id_trad_sejour_accueil_handicap` int(11) unsigned NOT NULL auto_increment,
  `id__sejour_accueil_handicap` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad_sejour_accueil_handicap`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_sejour_accueil_handicap`
--

LOCK TABLES `trad_sejour_accueil_handicap` WRITE;
/*!40000 ALTER TABLE `trad_sejour_accueil_handicap` DISABLE KEYS */;
INSERT INTO `trad_sejour_accueil_handicap` VALUES (1,1,1,'Ã  l\'handicap moteur'),(2,1,2,''),(3,1,3,''),(4,1,5,''),(5,2,1,'Ã  l\'handicap mental'),(6,2,2,''),(7,2,3,''),(8,2,5,''),(9,3,1,'Ã  l\'handicap auditif'),(10,3,2,''),(11,3,3,''),(12,3,5,''),(13,4,1,'Ã  l\'handicap visuel'),(14,4,2,''),(15,4,3,''),(16,4,5,'');
/*!40000 ALTER TABLE `trad_sejour_accueil_handicap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_sejour_centre_adapte`
--

DROP TABLE IF EXISTS `trad_sejour_centre_adapte`;
CREATE TABLE `trad_sejour_centre_adapte` (
  `id_trad_sejour_centre_adapte` int(11) unsigned NOT NULL auto_increment,
  `id__sejour_centre_adapte` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad_sejour_centre_adapte`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_sejour_centre_adapte`
--

LOCK TABLES `trad_sejour_centre_adapte` WRITE;
/*!40000 ALTER TABLE `trad_sejour_centre_adapte` DISABLE KEYS */;
INSERT INTO `trad_sejour_centre_adapte` VALUES (1,1,1,'activitÃ©s nautiques'),(2,1,2,''),(3,1,3,''),(4,1,5,''),(5,2,1,'arts martiaux'),(6,2,2,''),(7,2,3,''),(8,2,5,''),(9,3,1,'athlÃ©tisme'),(10,3,2,''),(11,3,3,''),(12,3,5,''),(13,4,1,'basket'),(14,4,2,''),(15,4,3,''),(16,4,5,''),(17,5,1,'cyclotourisme / cyclisme'),(18,5,2,''),(19,5,3,''),(20,5,5,''),(21,6,1,'natation'),(22,6,2,''),(23,6,3,''),(24,6,5,''),(25,7,1,'Outdoor (spÃ©lÃ©o, escalade...)'),(26,7,2,''),(27,7,3,''),(28,7,5,''),(29,8,1,'randonnÃ©es pÃ©destres'),(30,8,2,''),(31,8,3,''),(32,8,5,''),(33,9,1,'sports collectifs indoor'),(34,9,2,''),(35,9,3,''),(36,9,5,''),(37,10,1,'sports collectifs outdoor'),(38,10,2,''),(39,10,3,''),(40,10,5,''),(41,11,1,'sports d\'eaux vives'),(42,11,2,''),(43,11,3,''),(44,11,5,''),(45,12,1,'tennis'),(46,12,2,''),(47,12,3,''),(48,12,5,''),(49,13,1,'Yoga, fitness, danse'),(50,13,2,''),(51,13,3,''),(52,13,5,'');
/*!40000 ALTER TABLE `trad_sejour_centre_adapte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_sejour_materiel_service`
--

DROP TABLE IF EXISTS `trad_sejour_materiel_service`;
CREATE TABLE `trad_sejour_materiel_service` (
  `id_trad_sejour_materiel_service` int(11) unsigned NOT NULL auto_increment,
  `id__sejour_materiel_service` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad_sejour_materiel_service`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_sejour_materiel_service`
--

LOCK TABLES `trad_sejour_materiel_service` WRITE;
/*!40000 ALTER TABLE `trad_sejour_materiel_service` DISABLE KEYS */;
INSERT INTO `trad_sejour_materiel_service` VALUES (5,2,1,'accÃ¨s public internet'),(6,2,2,''),(7,2,3,''),(8,2,5,''),(9,3,1,'enregistrement des rÃ©unions'),(10,3,2,''),(11,3,3,''),(12,3,5,''),(13,4,1,'hÃ´te / hÃ´tesse d\'accueil'),(14,4,2,''),(15,4,3,''),(16,4,5,''),(17,5,1,'location d\'un bureau'),(18,5,2,''),(19,5,3,''),(20,5,5,''),(21,6,1,'micro HF'),(22,6,2,''),(23,6,3,''),(24,6,5,''),(25,7,1,'photocopie'),(26,7,2,''),(27,7,3,''),(28,7,5,''),(29,8,1,'service vestiaire'),(30,8,2,''),(31,8,3,''),(32,8,5,''),(33,9,1,'tÃ©lÃ©copie'),(34,9,2,''),(35,9,3,''),(36,9,5,''),(37,10,1,'TV + lecteur DVD'),(38,10,2,''),(39,10,3,''),(40,10,5,''),(41,11,1,'vidÃ©o-projecteur'),(42,11,2,''),(43,11,3,''),(44,11,5,'');
/*!40000 ALTER TABLE `trad_sejour_materiel_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_sejour_nb_lit__par_chambre`
--

DROP TABLE IF EXISTS `trad_sejour_nb_lit__par_chambre`;
CREATE TABLE `trad_sejour_nb_lit__par_chambre` (
  `id_trad_sejour_nb_lit__par_chambre` int(11) unsigned NOT NULL auto_increment,
  `id__sejour_nb_lit__par_chambre` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad_sejour_nb_lit__par_chambre`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_sejour_nb_lit__par_chambre`
--

LOCK TABLES `trad_sejour_nb_lit__par_chambre` WRITE;
/*!40000 ALTER TABLE `trad_sejour_nb_lit__par_chambre` DISABLE KEYS */;
INSERT INTO `trad_sejour_nb_lit__par_chambre` VALUES (1,1,1,'1 lit'),(2,1,2,''),(3,1,3,''),(4,1,5,''),(5,2,1,'2 lits'),(6,2,2,''),(7,2,3,''),(8,2,5,''),(9,3,1,'3-4 lits'),(10,3,2,''),(11,3,3,''),(12,3,5,''),(13,4,1,'4-6 lits'),(14,4,2,''),(15,4,3,''),(16,4,5,''),(17,5,1,'plus de 6 lits'),(18,5,2,''),(19,5,3,''),(20,5,5,'');
/*!40000 ALTER TABLE `trad_sejour_nb_lit__par_chambre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_sejour_niveau_scolaire`
--

DROP TABLE IF EXISTS `trad_sejour_niveau_scolaire`;
CREATE TABLE `trad_sejour_niveau_scolaire` (
  `id_trad_sejour_niveau_scolaire` int(11) unsigned NOT NULL auto_increment,
  `id__sejour_niveau_scolaire` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad_sejour_niveau_scolaire`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_sejour_niveau_scolaire`
--

LOCK TABLES `trad_sejour_niveau_scolaire` WRITE;
/*!40000 ALTER TABLE `trad_sejour_niveau_scolaire` DISABLE KEYS */;
INSERT INTO `trad_sejour_niveau_scolaire` VALUES (1,1,1,'Maternelle (4-6 ans)'),(2,1,2,''),(3,1,3,''),(4,1,5,''),(5,2,1,'CP-CE (7-9 ans)'),(6,2,2,''),(7,2,3,''),(8,2,5,''),(9,3,1,'CM (10-11 ans)'),(10,3,2,''),(11,3,3,''),(12,3,5,''),(13,4,1,'6e-5e (12-13 ans)'),(14,4,2,''),(15,4,3,''),(16,4,5,''),(17,5,1,'4e-3e (14-15 ans)'),(18,5,2,''),(19,5,3,''),(20,5,5,''),(21,6,1,'LycÃ©e (16-18 ans)'),(22,6,2,''),(23,6,3,''),(24,6,5,''),(25,7,1,'Enseignement agricole'),(26,7,2,''),(27,7,3,''),(28,7,5,'');
/*!40000 ALTER TABLE `trad_sejour_niveau_scolaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_sejour_priode_disponibilite`
--

DROP TABLE IF EXISTS `trad_sejour_priode_disponibilite`;
CREATE TABLE `trad_sejour_priode_disponibilite` (
  `id_trad_sejour_priode_disponibilite` int(11) unsigned NOT NULL auto_increment,
  `id__sejour_priode_disponibilite` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad_sejour_priode_disponibilite`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_sejour_priode_disponibilite`
--

LOCK TABLES `trad_sejour_priode_disponibilite` WRITE;
/*!40000 ALTER TABLE `trad_sejour_priode_disponibilite` DISABLE KEYS */;
INSERT INTO `trad_sejour_priode_disponibilite` VALUES (1,1,1,'printemps'),(2,1,2,''),(3,1,3,''),(4,1,5,''),(5,2,1,'Ã©tÃ©'),(6,2,2,''),(7,2,3,''),(8,2,5,''),(9,3,1,'automne'),(10,3,2,''),(11,3,3,''),(12,3,5,''),(13,4,1,'hiver'),(14,4,2,''),(15,4,3,''),(16,4,5,'');
/*!40000 ALTER TABLE `trad_sejour_priode_disponibilite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_sejour_services_sportifs`
--

DROP TABLE IF EXISTS `trad_sejour_services_sportifs`;
CREATE TABLE `trad_sejour_services_sportifs` (
  `id_trad_sejour_services_sportifs` int(11) unsigned NOT NULL auto_increment,
  `id__sejour_services_sportifs` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `sejour_services_sportifs` varchar(255) default NULL,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad_sejour_services_sportifs`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_sejour_services_sportifs`
--

LOCK TABLES `trad_sejour_services_sportifs` WRITE;
/*!40000 ALTER TABLE `trad_sejour_services_sportifs` DISABLE KEYS */;
INSERT INTO `trad_sejour_services_sportifs` VALUES (1,1,1,NULL,'Equipements bien Ãªtre (sauna, hammam)'),(2,1,2,NULL,''),(3,1,3,NULL,''),(4,1,5,NULL,''),(5,2,1,NULL,'Lits de +2m'),(6,2,2,NULL,''),(7,2,3,NULL,''),(8,2,5,NULL,''),(9,3,1,NULL,'Local de stockage matÃ©riel'),(10,3,2,NULL,''),(11,3,3,NULL,''),(12,3,5,NULL,''),(13,4,1,NULL,'Restauration adaptÃ©e'),(14,4,2,NULL,''),(15,4,3,NULL,''),(16,4,5,NULL,''),(17,5,1,NULL,'Salle de musculation'),(18,5,2,NULL,''),(19,5,3,NULL,''),(20,5,5,NULL,''),(21,6,1,NULL,'Salle de rÃ©union Ã©quipÃ©e de TV/lecteur DVD'),(22,6,2,NULL,''),(23,6,3,NULL,''),(24,6,5,NULL,'');
/*!40000 ALTER TABLE `trad_sejour_services_sportifs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_sejour_thematique`
--

DROP TABLE IF EXISTS `trad_sejour_thematique`;
CREATE TABLE `trad_sejour_thematique` (
  `id_trad_sejour_thematique` int(11) unsigned NOT NULL auto_increment,
  `id__sejour_thematique` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad_sejour_thematique`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_sejour_thematique`
--

LOCK TABLES `trad_sejour_thematique` WRITE;
/*!40000 ALTER TABLE `trad_sejour_thematique` DISABLE KEYS */;
INSERT INTO `trad_sejour_thematique` VALUES (1,1,1,'expressions'),(2,1,2,''),(3,1,3,''),(4,1,5,''),(5,2,1,'patrimoine et terroir'),(6,2,2,''),(7,2,3,''),(8,2,5,''),(9,3,1,'le sport, un bel effort'),(10,3,2,''),(11,3,3,''),(12,3,5,''),(13,4,1,'citoyennetÃ©, environnement et dÃ©veloppement durable'),(14,4,2,''),(15,4,3,''),(16,4,5,'');
/*!40000 ALTER TABLE `trad_sejour_thematique` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_sejour_theme`
--

DROP TABLE IF EXISTS `trad_sejour_theme`;
CREATE TABLE `trad_sejour_theme` (
  `id_trad_sejour_theme` int(11) unsigned NOT NULL auto_increment,
  `id__sejour_theme` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad_sejour_theme`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_sejour_theme`
--

LOCK TABLES `trad_sejour_theme` WRITE;
/*!40000 ALTER TABLE `trad_sejour_theme` DISABLE KEYS */;
INSERT INTO `trad_sejour_theme` VALUES (1,1,1,'expressions'),(2,1,2,''),(3,1,3,''),(4,1,5,''),(5,2,1,'patrimoine et terroir'),(6,2,2,''),(7,2,3,''),(8,2,5,''),(9,3,1,'le sport, un bel effort'),(10,3,2,''),(11,3,3,''),(12,3,5,''),(13,4,1,'citoyennetÃ©, environnement et dÃ©veloppement durable'),(14,4,2,''),(15,4,3,''),(16,4,5,'');
/*!40000 ALTER TABLE `trad_sejour_theme` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_sejour_theme_seminaire`
--

DROP TABLE IF EXISTS `trad_sejour_theme_seminaire`;
CREATE TABLE `trad_sejour_theme_seminaire` (
  `id_trad_sejour_theme_seminaire` int(11) unsigned NOT NULL auto_increment,
  `id__sejour_theme_seminaire` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `theme_seminaire` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad_sejour_theme_seminaire`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_sejour_theme_seminaire`
--

LOCK TABLES `trad_sejour_theme_seminaire` WRITE;
/*!40000 ALTER TABLE `trad_sejour_theme_seminaire` DISABLE KEYS */;
INSERT INTO `trad_sejour_theme_seminaire` VALUES (1,1,1,'SÃ©minaire vert'),(2,1,2,''),(3,1,3,''),(4,1,5,''),(5,2,1,'esprit d\'Ã©quipe'),(6,2,2,''),(7,2,3,''),(8,2,5,''),(9,3,1,'partageons nos valeurs'),(10,3,2,''),(11,3,3,''),(12,3,5,'');
/*!40000 ALTER TABLE `trad_sejour_theme_seminaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_sejour_tranche_age`
--

DROP TABLE IF EXISTS `trad_sejour_tranche_age`;
CREATE TABLE `trad_sejour_tranche_age` (
  `id_trad_sejour_tranche_age` int(11) unsigned NOT NULL auto_increment,
  `id__sejour_tranche_age` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad_sejour_tranche_age`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_sejour_tranche_age`
--

LOCK TABLES `trad_sejour_tranche_age` WRITE;
/*!40000 ALTER TABLE `trad_sejour_tranche_age` DISABLE KEYS */;
INSERT INTO `trad_sejour_tranche_age` VALUES (1,1,1,'4-6 ans'),(2,1,2,''),(3,1,3,''),(4,1,5,''),(5,2,1,'7-9 ans'),(6,2,2,''),(7,2,3,''),(8,2,5,''),(9,3,1,'10-11 ans'),(10,3,2,''),(11,3,3,''),(12,3,5,''),(13,4,1,'12-13 ans'),(14,4,2,''),(15,4,3,''),(16,4,5,''),(17,5,1,'14-15 ans'),(18,5,2,''),(19,5,3,''),(20,5,5,''),(21,6,1,'16-18 ans'),(22,6,2,''),(23,6,3,''),(24,6,5,'');
/*!40000 ALTER TABLE `trad_sejour_tranche_age` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_seminaires`
--

DROP TABLE IF EXISTS `trad_seminaires`;
CREATE TABLE `trad_seminaires` (
  `id_trad_seminaires` int(11) unsigned NOT NULL auto_increment,
  `id__seminaires` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `nom_seminaire` varchar(255) default NULL,
  `presentation` mediumtext,
  `prix_comprend` text,
  `prix_ne_comprend_pas` text,
  `descriptif` mediumtext,
  PRIMARY KEY  (`id_trad_seminaires`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_seminaires`
--

LOCK TABLES `trad_seminaires` WRITE;
/*!40000 ALTER TABLE `trad_seminaires` DISABLE KEYS */;
/*!40000 ALTER TABLE `trad_seminaires` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trad_tradotron`
--

DROP TABLE IF EXISTS `trad_tradotron`;
CREATE TABLE `trad_tradotron` (
  `id_trad_tradotron` int(11) unsigned NOT NULL auto_increment,
  `id__tradotron` int(11) unsigned default NULL,
  `id__langue` int(11) unsigned default NULL,
  `libelle` varchar(255) default NULL,
  PRIMARY KEY  (`id_trad_tradotron`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trad_tradotron`
--

LOCK TABLES `trad_tradotron` WRITE;
/*!40000 ALTER TABLE `trad_tradotron` DISABLE KEYS */;
/*!40000 ALTER TABLE `trad_tradotron` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tradotron`
--

DROP TABLE IF EXISTS `tradotron`;
CREATE TABLE `tradotron` (
  `id_tradotron` int(11) unsigned NOT NULL auto_increment,
  `code_libelle` varchar(255) default NULL,
  `libelle` varchar(255) default NULL,
  `commentaires` text,
  PRIMARY KEY  (`id_tradotron`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tradotron`
--

LOCK TABLES `tradotron` WRITE;
/*!40000 ALTER TABLE `tradotron` DISABLE KEYS */;
/*!40000 ALTER TABLE `tradotron` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-04-19  8:37:27