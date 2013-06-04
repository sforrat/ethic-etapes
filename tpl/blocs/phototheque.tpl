					<ul class="fototek">
					#{section name=index loop=$listePhoto}#
						<li>
							<img src="#{$listePhoto[index].fichier}#" alt="photo" />
							<h2>#{$listePhoto[index].titre}#</h2>
							#{smarty_trad value='lib_poids'}# : #{$listePhoto[index].size}# ko <br />
							#{smarty_trad value='lib_date'}# : #{$listePhoto[index].date}#
							<a href="#{$listePhoto[index].fichier}#" class="btn btn_green" target="_blank"><span>#{smarty_trad value='lib_telechargez'}#</span></a>
						</li>	
					#{/section}#
					</ul>	
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