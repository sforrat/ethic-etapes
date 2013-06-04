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
				<div id="carousels_fiche">
				<h2>#{smarty_trad value='lib_etape_a'}# [#{$ville}#]</h2>				
				#{include_php file="blocs/blocActu.php"}#
				#{include_php file="blocs/blocBonPlan.php"}#
				</div>				
				#{include_php file="blocs/blocNewsletter_simple.php"}#
			</div>	

				<div id="inner_content">	
					
					<ul class="controlBox clear">
						<li>
							<button type="button" id="biggerText">T+</button><button type="button" id="smallerText">T-</button>
						</li>
						<li class="print">
							<a href="javascript:window.print()">Imprimer</a>
						</li>
						<!--<li class="comment">
							<a href="#">Laisser votre avis</a>
						</li>	-->
					</ul>					
					<div id="ficheDest" class="clear fiche_sejour fiche_orange"><!-- class "fiche_sejour" a ajouter / 3 class de couleur prevues : "fiche_orange" , "fiche_vert" , "fiche_bleu" -->
						<h1>
							<strong>#{$organisateurCVL.nom}#</strong>
						</h1>
						<div id="ficheDest_side">
							<img src="#{$organisateurCVL.image}#" alt="#{$ville}#" id="placeholder" />
							<ul id="detailsSejour">
								#{if $nbThematique > 0}#
								<li>
									<h3>#{smarty_trad value='lib_thematique_sejour'}#</h3>
									<ul>
									 #{section name=the loop=$listeThematique}#
										<li>#{$listeThematique[the].libelle}#</li>
									 #{/section}#
									</ul>
								</li>
								#{/if}#
								
								#{if $nbAge > 0}#
								<li>
									<h3>#{smarty_trad value='lib_tranche_age'}#</h3>
									<ul>
										#{section name=age loop=$listeAge}#
											<li>#{$listeAge[age].libelle}#</li>				
										#{/section}#																				
									</ul>									
								</li>
								#{/if}#
			
								<li class="coord">
									<h3>#{smarty_trad value='lib_coordonnees'}#</h3>
									#{$organisateurCVL.adresse}# - #{$organisateurCVL.code_postal}# #{$organisateurCVL.ville}# <br />
									#{if $organisateurCVL.telephone != ""}#
										#{smarty_trad value='lib_telephone'}# : #{$organisateurCVL.telephone}# <br />
									#{/if}#
									#{if $organisateurCVL.fax != ""}#
										#{smarty_trad value='lib_fax'}# : #{$organisateurCVL.fax}# <br />
									#{/if}#
									#{if $organisateurCVL.site_internet != ""}#
										#{smarty_trad value='lib_site_internet'}# : <a target="_blank" href="#{$organisateurCVL.site_internet}#">#{$organisateurCVL.site_internet}#</a><br />
									#{/if}#
										<a href="#{$urlContact}#" class="btn btn_white popinLink_ajax"><span>#{smarty_trad value='lib_contact'}#</span></a>
								</li>
							</ul>
							
						</div><!-- /#ficheDest_side -->
						<div id="ficheDest_main">
							<h3>#{smarty_trad value='lib_presentation_organisme_maj'}#</h3>
							#{$organisateurCVL.description}#
							<br/>
							<h3>#{smarty_trad value='lib_projet_educatif_maj'}#</h3>
							#{$organisateurCVL.projet_educatif}#
							
							#{if $organisateurCVL.agrement_jeunesse != ''}#
								<br/><strong>#{smarty_trad value='lib_numero_agrement_jeunesse'}# : </strong>#{$organisateurCVL.agrement_jeunesse}#
							#{/if}#
							<ul id="blocSlider">		
								#{section name=inf loop=$listeInfoD}#					
								<li>
									<h3>#{$listeInfoD[inf].nom}#</h3>
									<div class="blocSlider_content">
										#{$listeInfoD[inf].texte}#
									</div>
								</li>
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

