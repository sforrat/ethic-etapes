<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
#{$META_LANGUAGE}#
<title>#{$TITLE}#</title>
<base href="#{$base_href}#" />

	<!-- CSS -->
	<link type="text/css" rel="stylesheet" href="css/styles_structure.css"  media="all"/>
	<!--[if lte IE 6]>
		<link rel="stylesheet" type="text/css" href="css/old_ie.css" />
	<![endif]-->
	<link type="text/css" rel="stylesheet" href="css/print.css"  media="print"/>
<meta name="Author" content="C2iS" />
#{$META_DESCRIPTION}#
#{$META_KEYWORD}#
<meta name="robots" content="INDEX, ALL" />
<meta name="generator" content="C2iS" />
<meta name="copyright" content="&copy; 2005 C2iS" />
<meta name="date" content="1999-03-18T00:00:00+00.00" />
<meta name="revisit-after" content="7 days" />
<meta name="comment" content="Pour plus d'informations, contactez C2iS http://www.c2is.fr" />
<script type="text/javascript">document.documentElement.id='js';</script>		
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>	
<script type="text/javascript" src="js/jquery.plugins.js"></script>
<script type="text/javascript" src="js/swfobject.js"></script>
<script type="text/javascript" src="js/scripts_language_#{$prefixe}#.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>	
<script type="text/javascript" src="js/all.js"></script>
<script type="text/javascript" src="js/form.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

#{if $afficheCalandar == 1}#
<link type="text/css" rel="stylesheet" href="css/jquery-ui.css"  media="all"/>
<script type="text/javascript" src="js/jquery.ui.core.js"></script>
<script type="text/javascript" src="js/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="js/jquery.ui.datepicker-#{$prefixe}#.js"></script>
#{/if}#

#{if $NOSCRIPT != "" }#
<div class="cychaut">
#{$NOSCRIPT}#
</div>
#{/if}#
</head>
<!-- #{$TITLE}# -->
<body style="overflow:auto;">
	<div id="wrapper">		
			<div id="header">						
				<a href="#" title="#{smarty_trad value='lib_retour_accueil'}#"><img src="images/common/logo_Ethic_Etapes.png" alt="Ethic Etapes" id="logo" /></a>
				<a href="#" title="#{smarty_trad value='lib_retour_accueil'}#"><img src="images/common/tagline.png" alt="#{smarty_trad value='lib_slogan'}#" id="tagline" /></a>
				<div id="searchBox">
					<span id="currentLang">#{$currentLang}#</span>
					<ul id="choiceLang">
						#{section name=lang loop=$listeLang}#
							<li><a href="#{$listeLang[lang].lien}#" title="#{$listeLang[lang].libelle}# version of the site">#{$listeLang[lang].libelle}#</a></li>
						#{/section}#
					</ul>
					<a href="#{$urlLoginEspaceMembre}#" id="memberArea">#{smarty_trad value='lib_votre_espace_membre'}#</a>
					<div class="searchField">
						<form action="#{$url_recherche}#" method="POST" enctype="text/html">						
							<p>
								<input type="text" class="text" id="search" name="search" onfocus="ViderInpurRecherche(this,'#{smarty_trad value='lib_rechercher'}#')" onblur="RemplirInpurRecherche(this,'#{smarty_trad value='lib_rechercher'}#')" value="#{smarty_trad value='lib_rechercher'}#"/>
								<input type="image" class="btnOK" src="images/common/btn_searchBox_OK.png" alt="OK" />			
							</p>	
						</form>
					</div>
				</div>				
			</div><!-- /#header -->	
