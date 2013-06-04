					#{if $is_actu}#
					<div id="carousel_actu">
						#{$titreActu}#
						#{if $nbActu > 1}#
						<span id="prev_carousel_actu"><img src="images/common/btn_carActu_prev.gif" alt="#{smarty_trad value='lib_precedent'}#" /></span>
						<span id="next_carousel_actu"><img src="images/common/btn_carActu_next.gif" alt="#{smarty_trad value='lib_suivant'}#" /></span>
						#{/if}#
						<div class="inner_carousel">
							<ul>
								#{section name=act loop=$listeActu}#
								<li>
									<strong>#{$listeActu[act].titre}#</strong><br />#{$listeActu[act].description}#
									<a href="popin_actu.php?id=#{$listeActu[act].id}#" class="carouselink popinLink_ajax cboxElement">#{smarty_trad value='lib_lire_suite'}#</a>
								</li>
								#{/section}#
							</ul>
						</div>
					</div><!-- /#carousel_actu -->
					#{/if}#