<div class="edito">
	<span class="titleEdito">#{smarty_trad value="lib_credits_photos"}# :</span>
	<ul>
		#{section name=idx loop=$arrCredits}#
			<li>#{$arrCredits[idx].img}# : #{$arrCredits[idx].auteur}#</li>
		#{/section}#
	</ul>
</div>