<ul id="brochures" class="clear">
#{section name=sec1 loop=$TabBrochure}#
<li>
	<a href="#{$TabBrochure[sec1].pdf}#" target="_blank"><img src="#{$TabBrochure[sec1].visuel}#" alt="#{$TabBrochure[sec1].libelle}#" /></a>
	<h2><a href="#{$TabBrochure[sec1].pdf}#" target="_blank">#{$TabBrochure[sec1].libelle}#</a></h2>
	<p><a href="#{$TabBrochure[sec1].pdf}#" target="_blank">#{$TabBrochure[sec1].description}#</a> </p>
	<p><a href="#{$TabBrochure[sec1].pdf}#" target="_blank" class="btn btn_teal"><span>#{smarty_trad value='lib_telecharger_brochure_maj'}#</span></a></p>
</li>
#{/section}#
</ul>