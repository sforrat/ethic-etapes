				<div id="sidebar">
				#{if $is_bnt_back}#
					<a id="backToResults" href="javascript:history.back();" >#{smarty_trad value='lib_retour_resultat_recherche'}#</a>
				#{/if}#
				#{if $is_moteurResa}#	
					<div id="moteurResa">
					#{if $is_rechMulti}#					
						#{include_php file="blocs/recherche_multicritere.php"}#
					#{/if}#
					#{if $is_rechGeo}#
						#{include_php file="blocs/recherche_geographique.php"}#
					#{/if}#							
					</div><!-- /#moteurResa-->				
				#{/if}#						
					#{if $is_actu}#
					<div id="carousel_actu">
						<h2>LES ACTUALITES</h2>
						#{if $nbActu > 1}#
						<span id="prev_carousel_actu"><img src="images/common/btn_carActu_prev.gif" alt="précédent" /></span>
						<span id="next_carousel_actu"><img src="images/common/btn_carActu_next.gif" alt="suivant" /></span>
						#{/if}#
						<div class="inner_carousel">
							<ul>
								#{section name=act loop=$listeActu}#
								<li>
									<strong>#{$listeActu[act].titre}#</strong><br />#{$listeActu[act].description}#
									<a href="#{$listeActu[act].lien}#" class="carouselink">découvrir la destination</a>
								</li>
								#{/section}#
							</ul>
						</div>
					</div><!-- /#carousel_actu -->
					#{/if}#
					
					#{if $is_promo}#
					<div id="carousel_promo">
						<h2>BONS PLANS ET PROMOTIONS</h2>
						#{if $nbPromo > 1}#
						<span id="prev_carousel_promo"><img src="images/common/btn_carPromo_prev.gif" alt="précédent" /></span>
						<span id="next_carousel_promo"><img src="images/common/btn_carPromo_next.gif" alt="suivant" /></span>
						#{/if}#
						<div class="inner_carousel">
							<ul>
								#{section name=bp loop=$listeBP}#							
								<li>
									<strong>#{$listeBP[bp].titre}#</strong><br /> du #{$listeBP[bp].date_debut}# au #{$listeBP[bp].date_fin}#
									<a href="#{$listeBP[bp].lien}#" class="carouselink">nous contacter</a>
								</li>
								#{/section}#
							</ul>
						</div>
					</div><!-- /#carousel_promo -->	
					#{/if}#						
					
					<div id="push_newsletter">
						<h2><a href="#">NEWSLETTER</a></h2>
						<a href="#">Séjours, culture et engagements, partagez l'esprit Ethic Etapes. <img src="images/common/btn_carActu_next.gif" alt=">" /></a>
					</div>	
					#{if $is_ancv}#
					<img src="images/dyn/push_ancv.jpg" alt="ANCV : Tous les Ethic Etapes acceptent les chèques vacance" />
					#{/if}#
				</div><!-- /#sidebar -->