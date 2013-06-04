					#{if $is_promo}#
					<div id="carousel_promo">
						#{$titreBP}#
						#{if $nbBP > 1}#
						<span id="prev_carousel_promo"><img src="images/common/btn_carPromo_prev.gif" alt="#{smarty_trad value='lib_precedent'}#" /></span>
						<span id="next_carousel_promo"><img src="images/common/btn_carPromo_next.gif" alt="#{smarty_trad value='lib_suivant'}#" /></span>
						#{/if}#
						<div class="inner_carousel">
							<ul>
								#{section name=bp loop=$listeBP}#							
								<li>
									<strong>#{$listeBP[bp].titre}#</strong><br /> #{smarty_trad value='lib_du'}# #{$listeBP[bp].date_debut}# #{smarty_trad value='lib_au'}# #{$listeBP[bp].date_fin}#
									<a href="popin_bp.php?id=#{$listeBP[bp].id}#" class="carouselink  popinLink_ajax cboxElement">#{smarty_trad value='lib_lire_suite'|lower}#</a>
								</li>
								#{/section}#
							</ul>
						</div>
					</div><!-- /#carousel_promo -->	
					#{/if}#						