<ul class="partenaire">
	#{section name=sec1 loop=$TabFavoris}#
	<li>
		<img src="#{$TabFavoris[sec1].visuel}#" alt="#{$TabFavoris[sec1].libelle}#" />
		<h2>#{$TabFavoris[sec1].libelle}#</h2>
		<p>#{$TabFavoris[sec1].description}#</p>
		<p><a href="#{$TabFavoris[sec1].url}#" class="btn btn_blue"><span>#{smarty_trad value='lib_site_web_maj'}#</span></a></p>
	</li>
	#{/section}#
</ul>