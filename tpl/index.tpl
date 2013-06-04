  #{include file="blocs/header.tpl"}#
	
	#{**************************************************************}#
	#{*		BLOC HEADER = LOGO + PAVE ACCES ACCES CLIENT		   *}#
	#{**************************************************************}#
	
		
	#{***************************}#
	#{*	BLOC MENUS HORIZONTAUX	*}#
	#{***************************}#	
	#{include_php file="blocs/menus.php"}#
	
		<div id="flashHome">
			<script type="text/javascript">
			if( DetectFlashVer(10, 0, 0) ){
				//<![CDATA[
					var flashvars = {
						theme: "#{$theme}#",
                        lib_suite: "#{$lib_suite}#"                        
					};
					var params = {
					 wmode: "transparent"
					};							
					var attributes = {};
					swfobject.embedSWF("flash/home.swf", "flashHome", 1280, 392, "10", false, flashvars, params, attributes);
				//]]>
			}
			else{
				// affichage alternatif
				document.write( "#{smarty_trad value='lib_noflash'}#" + " <a href='http://www.macromedia.com/go/getflash'>ici.</a>");
			}
			</script>	
		</div>	
	
	#{*************************}#
	#{*			CONTENT		  *}#
	#{*************************}#
	   	
			<div id="content" class="clear">

			<div id="sidebar">
				<div id="moteurResa">
					#{include_php file="blocs/recherche_multicritere.php"}#
					#{include_php file="blocs/recherche_geographique.php"}#
				</div>
				#{include_php file="blocs/blocNewsletter_simple.php"}#
				#{if $pub_visuel != ""}#
				 #{if $pub_url != "" && $pub_url !="http://www."}#
				 <a href="#{$pub_url}#" target="_blank">
				 #{/if}#
				<img src="#{$pub_visuel}#" alt="#{$pub_libelle}#"/>
				#{if $pub_url != "" && $pub_url !="http://www."}#
				</a>
				 #{/if}#
				#{/if}#
			</div>
			
				<div id="inner_content">	
					<h1>Ethic Etapes : Nous hébergeons vos passions</h1>
					#{if $nbActu > 0}#	
					<h2>#{smarty_trad value='lib_titre_actualite'}#</h2>				
					<div id="carousel_actu_home">	
						#{if $nbActu > 2}#					
						<span id="prev_carousel_actuHome"><img src="images/common/btn_carActu_prev.gif" alt="précédent" /></span>
						<span id="next_carousel_actuHome"><img src="images/common/btn_carActu_next.gif" alt="suivant" /></span>
						#{/if}#
						<div class="inner_carousel">
							<ul>
								#{section name=act loop=$listeActu}#
								<li>
									<strong>#{$listeActu[act].titre}#</strong><br />#{$listeActu[act].description}#
									<a href="#{$listeActu[act].lien}#" class="carouselink popinLink_ajax cboxElement">#{smarty_trad value='lib_lire_suite'}#</a>
								</li>
								#{/section}#
							</ul>
						</div>
					</div><!-- /#carousel_actu -->		
					#{/if}#					
					<ul id="push_offers" class="clear">
						<li class="offer_kids">
							<a href="#{$url_sejour_moins_18_ans}#"><img src="images/dyn/visuHome_offer_kids.jpg" alt="Offres découvertes jeunes" class="visu_push_offer" /></a>
							<p>
								<a href="#{$url_sejour_moins_18_ans}#"><strong>#{smarty_trad value='lib_decouvrez_les_sejours'}#</strong><br /> #{$libelle_sejour_moins_18_ans}# <img src="images/common/arrow_nextWhite.gif" alt=">" /></a>								
							</p>
						</li>
						<li class="offer_company">
							<a href="#{$url_sejour_reunion}#"><img src="images/dyn/visuHome_offer_company.jpg" alt="Offres découvertes entreprise" class="visu_push_offer" /></a>
							<p>
								<a href="#{$url_sejour_reunion}#"><strong>#{smarty_trad value='lib_decouvrez_les_sejours'}#</strong><br /> #{$libelle_sejour_reunion}# <img src="images/common/arrow_nextWhite.gif" alt=">" /></a>					
							</p>
						</li>
						<li class="offer_tourism">
							<a href="#{$url_sejour_decouverte}#"><img src="images/dyn/visuHome_offer_tourism.jpg" alt="Offres découvertes tourisme" class="visu_push_offer" /></a>
							<p>
								<a href="#{$url_sejour_decouverte}#"><strong>#{smarty_trad value='lib_nos_sejours'}#</strong><br /> #{$libelle_sejour_decouverte}# <img src="images/common/arrow_nextWhite.gif" alt=">" /></a>					
							</p>
						</li>
					</ul>
					<h2>#{smarty_trad value='lib_selection_destinations'}#</h2>
					<div id="carousel_dest_home">	
						<div class="inner_carousel">
							<ul>
								<li>
									<strong>#{$centre.libelle}#</strong><br />#{$centre.description}#
									<a href="#{$centre.lien}#" class="carouselink">#{smarty_trad value='lib_decouvrir_centre'}#</a>
								</li>	
								<li>
									<strong>#{$sejour.libelle}#</strong><br />#{$sejour.description}#
									<a href="#{$sejour.lien}#" class="carouselink">#{smarty_trad value='lib_decouvrir_sejour'}#</a>
								</li>	
							</ul>
						</div>
					</div><!-- /#carousel_actu -->	
									
				</div><!-- /#inner_content-->
			</div><!-- /#content -->
    
    
			#{*if $scrollto == "1"}#
			
			<script>
			$(document).ready(function(){
				$.scrollTo( { top:'400px', left:0}, 800 );
			});
			</script>
			#{/if*}#
			
    #{include_php file="blocs/bottom.php"}#<br /><br />
    
	#{*******************************}#
	#{*		BLOC FOOTER				*}#
	#{*******************************}#
	
#{include_php file="blocs/footer.php"}#
