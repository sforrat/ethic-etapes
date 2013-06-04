<p><strong>#{smarty_trad value='lib_resultat_recherche'}# :</strong> #{$nbTotal}# #{smarty_trad value='lib_offres_trouvees'}# </p> 
<ul id="results" class="results_jobs"> 
	#{section name=sec1 loop=$TabOffre}#
	<li>							
		<h3><strong>#{$TabOffre[sec1].libelle}# - #{$TabOffre[sec1].contrat}#</strong><br />#{$TabOffre[sec1].ville}# (#{$TabOffre[sec1].dept}#)</h3> 
		<p>								
			#{$TabOffre[sec1].descriptif}#	
			#{if $TabOffre[sec1].periode_texte != ""}#
			<span class="bulletJob"><strong>#{$TabOffre[sec1].periode_texte}# :</strong> #{$TabOffre[sec1].periode}#</span> 
			#{else}#
			<span class="bulletJob"><strong>#{$TabOffre[sec1].date_debut_texte}# :</strong> #{$TabOffre[sec1].periode_debut}#</span> 
			#{/if}#
			<span class="bulletJob"><strong>#{smarty_trad value='lib_secteur'}# :</strong> #{$TabOffre[sec1].secteur}#</span>	
		</p> 
		<p> 
			<a href="#{$TabOffre[sec1].url}#" class="btn btn_orange"><span>#{smarty_trad value='lib_plus_info_maj'}#</span></a> 
			<!--<a href="#" class="btn btn_green"><span>TARIFS & DISPONIBILITES</span></a>--> 
		</p> 
	</li> 
	#{/section}#
</ul>


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