#{include file="blocs/header.tpl"}#
	
	#{**************************************************************}#
	#{*		BLOC HEADER = LOGO + PAVE ACCES ACCES CLIENT		   *}#
	#{**************************************************************}#
	
		
	#{***************************}#
	#{*	BLOC MENUS HORIZONTAUX	*}#
	#{***************************}#	
	#{include_php file="blocs/menus.php"}#
	#{include_php file="blocs/chemin_fer.php"}#
	

	#{*************************}#
	#{*			CONTENT		  *}#
	#{*************************}#
	   	
			<div id="content" class="clear">
							
			<div id="sidebar">
				<a id="backToResults" href="javascript:history.back();" >#{smarty_trad value='lib_retour_resultat_recherche'}#</a>			
		
				#{include_php file="blocs/blocActuAndBonPlan.php"}#
		
				#{include_php file="blocs/blocNewsletter_simple.php"}#
			</div>	

				<div id="inner_content">	
					
					#{include_php file="blocs/blocAccessibilite.php"}#							
					<div id="ficheDest" class="clear fiche_sejour fiche_orange"><!-- class "fiche_sejour" a ajouter / 3 class de couleur prevues : "fiche_orange" , "fiche_vert" , "fiche_bleu" -->
						<h1>
							#{if $ecoLabel}#
								<img src="images/dyn/ecolabel.gif" alt="#{smarty_trad value='lib_ecolabel'}#" title="#{smarty_trad value='lib_ecolabel'}#" class="picto_dest tooltipped"/>
							#{/if}#						
							#{if $label != ""}#
								<img src="images/dyn/#{$label}#.gif" alt="#{$title_label}#" title="#{$title_label}#" class="picto_dest tooltipped"/>
							#{/if}#
							#{if $picto_seminaire_vert}#
								<img src="images/dyn/seminaire_vert.gif" alt="#{smarty_trad value='lib_seminaire_vert'}#" title="#{smarty_trad value='lib_seminaire_vert'}#" class="picto_dest tooltipped"/>
							#{/if}#
							<img src="images/maps/carte_orange_france_#{$region}#.png" alt="region : " class="map_region tooltipped" />
							<strong>#{$sejour.libelle}#</strong>
							#{$sejour.ville}#</em>
						</h1>
						<div id="ficheDest_side">
							<img src="#{$sejour.image}#" alt="#{$ville}#" id="placeholder" />
							#{if $nbImage > 4}#
							<span id="prev_carousel_dest"><img src="images/common/btn_carActu_prev.gif" alt="#{smarty_trad value='lib_precedent'}#" /></span>
							<span id="next_carousel_dest"><img src="images/common/btn_carActu_next.gif" alt="#{smarty_trad value='lib_suivant'}#" /></span>
							#{/if}#
							#{if $nbImage > 1}#
							<div class="inner_carousel">
								<ul>
									#{section name=img loop=$listeImage}#
									<li>
										<a href="#{$listeImage[img]}#"><img src="#{$listeImage[img]}#" alt="#{$ville}#" height="31" /></a>
									</li>		
									#{/section}#						
								</ul>
							</div>
							#{/if}#
							<ul id="detailsSejour">
								
								
								
								#{if $nbPlus > 0}#
								<li>
									<h3>#{smarty_trad value='lib_plus_sejour'}#</h3>
									<ul>
									 #{section name=plu loop=$listePlus}#
										<li>#{$listePlus[plu]}#</li>
									 #{/section}#
									</ul>
								</li>
								#{/if}#
								
								#{if $nbSport > 0}#
								<li>
									<h3>#{smarty_trad value='lib_sejour_approprie'}#</h3>
									<ul>
									 #{section name=spo loop=$listeSport}#
										<li>#{$listeSport[spo]}#</li>
									 #{/section}#
									</ul>
								</li>
								#{/if}#
								
								
								#{if $nbInfoG > 0}#
								<li>
									#{section name=inf loop=$listeInfoG}#
									#{if !$smarty.section.inf.first && $listeInfoG[inf].nom!=""}#
									</li><li>
									#{/if}#
									#{if $listeInfoG[inf].nom!=""}#
									<h3>#{$listeInfoG[inf].nom}#</h3>
									#{/if}#
									#{if $listeInfoG[inf].nom != ""}##{/if}#
									<ul>
										#{section name=arr loop=$listeInfoG[inf].array}#
										<li>#{$listeInfoG[inf].array[arr].libelle}#</li>				
										#{/section}#																				
									</ul>									
									#{/section}#
								</li>
								#{/if}#
			
								<li class="coord">
									<h3>#{smarty_trad value='lib_coordonnees'}#</h3>
									<a href="#{$url_centre}#" alt="#{$nom_centre}#" title="#{$nom_centre}#">#{$nom_centre}#</a> <br />
									#{$sejour.adresse}# - #{$sejour.code_postal}# #{$sejour.ville}# <br />
									#{if $sejour.telephone != ""}#
										#{smarty_trad value='lib_telephone'}# : #{$sejour.telephone}# <br />
									#{/if}#
									#{if $sejour.fax != ""}#
										#{smarty_trad value='lib_fax'}# : #{$sejour.fax}# <br />
									#{/if}#
									#{if $sejour.site_internet != ""}#
										#{smarty_trad value='lib_site_internet'}# : <a href="#{$sejour.site_internet}#" target="_blank">#{$sejour.site_internet}#</a><br />
									#{/if}#
									
									#{if $isHostelworld}#
										<a href="#{$urlContact}#" class="btn btn_white popinLink_ajax"><span>#{smarty_trad value='lib_contact'}#</span></a>									
										<a href="#{$urlReservation}#" class="btn btn_white popinLink_ajax"><span>#{smarty_trad value='lib_reservation'}#</span></a>									
									#{else}#
										<!--<a href="#{$urlContact}#" class="btn btn_white popinLink_ajax"><span>#{smarty_trad value='lib_contact_reservation'}#</span></a>-->
										<a href="#{$urlContact}#" class="btn btn_white popinLink_ajax cboxElement"><span>#{smarty_trad value='lib_contact_reservation'}#</span></a>
									#{/if}#
								</li>
							</ul>
							
						</div><!-- /#ficheDest_side -->
						<div id="ficheDest_main">
							#{if $presentation_region != ""}#
								#{$presentation_region}#
							#{else}#
								#{$sejour.description}#
							#{/if}#
							<ul id="blocSlider">		
								#{section name=inf loop=$listeInfoD}#
								#{if $listeInfoD[inf].texte != ""}#					
								<li>
									<h3>#{$listeInfoD[inf].nom}#</h3>
									<div class="blocSlider_content">
										#{$listeInfoD[inf].texte}#
									</div>
								</li>
								#{/if}#
								#{/section}#	
							</ul><!-- /#blocSlider -->
						</div><!-- /#ficheDest_main -->
					</div><!-- /#ficheDest -->						
					
				</div><!-- /#inner_content-->
			</div><!-- /#content -->
    
    
    #{include_php file="blocs/bottom.php"}#<br /><br />
    
	#{*******************************}#
	#{*		BLOC FOOTER				*}#
	#{*******************************}#
	
#{include_php file="blocs/footer.php"}#

