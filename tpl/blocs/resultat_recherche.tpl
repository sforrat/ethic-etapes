		#{if $affichFilter}#
			#{if $affichFilterSejour}#
				#{include_php file="blocs/moteur_recherche_sejour.php"}#
			#{/if}#
			#{if $affichFilterCentre}#
				#{include_php file="blocs/moteur_recherche_centre.php"}#
			#{/if}#
		#{/if}#
				
				<p><strong>#{smarty_trad value='lib_resultat_recherche'}# :</strong> #{$nbRes}# #{$txt_resultat}# </p>
					<ul id="results">
						#{section name=cen loop=$listeRes}#
						<li>							
							<a href="#{$listeRes[cen].lien}#"><img src="#{$listeRes[cen].image}#" alt="#{$listeRes[cen].ville}# : #{$listeRes[cen].libelle}#" title="#{$listeRes[cen].ville}# : #{$listeRes[cen].libelle}#" class="visuResult"/></a><h3>
								<a href="#{$listeRes[cen].lien}#">
									#{if $listeRes[cen].region != ''}#
										<img src="images/maps/carte_verte_france_#{$listeRes[cen].region}#.png" alt="region : #{$listeRes[cen].region}#" />
									#{/if}#
									<strong>#{$listeRes[cen].libelle}#</strong><br />
									#{$listeRes[cen].nom_centre}# #{$listeRes[cen].ville}#
								</a>
							</h3>
							<p>
								<a href="#{$listeRes[cen].lien}#">
								#{$listeRes[cen].description}#
								</a>
							</p>
							<p>
								<a href="#{$listeRes[cen].lien}#" class="btn btn_orange"><span>#{smarty_trad value='lib_plus_info_maj'}#</span></a>
								<!--<a href="#" class="btn btn_green"><span>TARIFS & DISPONIBILITES</span></a>-->
							</p>
						</li>
						#{/section}#

					</ul><!-- /#results -->
					#{if $nbPages > 1}#
					<ul class="pagination">
						<li class="controlPagin">
							<a href="#{$urlPagination}#" title="#{smarty_trad value='lib_aller_prem_page'}#"><img src="images/common/btn_pagin_first.gif" alt="#{smarty_trad value='lib_first_page'}#"  /></a>
							<a href="#{$urlPreviousPage}#" title="#{$lib_aller_precedente_page}#"><img src="images/common/btn_pagin_prev.gif" alt="#{smarty_trad value='lib_precedent'}#"  /></a>
						</li>
						#{section name=foo loop=$TabPagination}#
						 	<li><a href="#{$TabPagination[foo].url}#"  #{if $TabPagination[foo].currentPage == $currentPage}# class="current" #{/if}#>#{$TabPagination[foo].currentPage}#</a></li>
						#{/section}#
						<li class="controlPagin">
							<a href="#{$urlNextPage}#" title="#{smarty_trad value='lib_aller_page_suivante'}#"><img src="images/common/btn_pagin_next.gif" alt="#{smarty_trad value='lib_suivant'}#"  /></a>
							<a href="#{$url_last_page}#"title="#{smarty_trad value='lib_last_page'}#"><img src="images/common/btn_pagin_last.gif" alt="#{smarty_trad value='lib_last_page'}#"  />	</a>						
						</li>
					</ul>		
					#{/if}#	