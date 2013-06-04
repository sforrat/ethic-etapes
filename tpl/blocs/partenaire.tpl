<ul class="partenaire">
	#{section name=sec1 loop=$TabPartenaire}#
	<li>
		<img src="#{$TabPartenaire[sec1].visuel}#" alt="#{$TabPartenaire[sec1].libelle}#" />
		<h2>#{$TabPartenaire[sec1].libelle}#</h2>
		<p>#{$TabPartenaire[sec1].description}#</p>
		<p><a href="#{$TabPartenaire[sec1].url}#" class="btn btn_blue"><span>#{smarty_trad value='lib_site_web_maj'}#</span></a></p>
	</li>
	#{/section}#
</ul>