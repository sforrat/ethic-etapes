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
						<h2>#{smarty_trad value='lib_titre_actualite'}#</h2>
						#{if $nbActu > 1}#
						<span id="prev_carousel_actu"><img src="images/common/btn_carActu_prev.gif" alt="#{smarty_trad value='lib_precedent'}#" /></span>
						<span id="next_carousel_actu"><img src="images/common/btn_carActu_next.gif" alt="#{smarty_trad value='lib_suivant'}#" /></span>
						#{/if}#
						<div class="inner_carousel">
							<ul>
								#{section name=act loop=$listeActu}#
								<li>
									<strong>#{$listeActu[act].titre}#</strong><br />#{$listeActu[act].description}#
									<a href="#{$listeActu[act].lien}#" class="carouselink">#{smarty_trad value='lib_lien_actualite'}#</a>
								</li>
								#{/section}#
							</ul>
						</div>
					</div><!-- /#carousel_actu -->
					#{/if}#
					
					#{if $is_promo}#
					<div id="carousel_promo">
						<h2>#{smarty_trad value='lib_bon_plan_promotion'}#</h2>
						#{if $nbPromo > 1}#
						<span id="prev_carousel_promo"><img src="images/common/btn_carPromo_prev.gif" alt="#{smarty_trad value='lib_precedent'}#" /></span>
						<span id="next_carousel_promo"><img src="images/common/btn_carPromo_next.gif" alt="#{smarty_trad value='lib_suivant'}#" /></span>
						#{/if}#
						<div class="inner_carousel">
							<ul>
								#{section name=bp loop=$listeBP}#							
								<li>
									<strong>#{$listeBP[bp].titre}#</strong><br /> du #{$listeBP[bp].date_debut}# au #{$listeBP[bp].date_fin}#
									<a href="#{$listeBP[bp].lien}#" class="carouselink">#{smarty_trad value='lib_nous_contacter_maj'|lower}#</a>
								</li>
								#{/section}#
							</ul>
						</div>
					</div><!-- /#carousel_promo -->	
					#{/if}#						
					
					#{include_php file="blocs/blocNewsletter_simple.php"}#
					#{if $is_ancv}#
					<img src="images/dyn/push_ancv.jpg" alt="#{smarty_trad value='lib_texte_ancv'}#" />
					#{/if}#
				</div><!-- /#sidebar -->