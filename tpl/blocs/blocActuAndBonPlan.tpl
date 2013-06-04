#{if $ville != ''}#
	<div id="carousels_fiche">
	<h2>#{smarty_trad value='lib_etape_a'}# [#{$ville}#]</h2>	
#{/if}#
#{include file="blocs/blocActu.tpl"}#
#{include file="blocs/blocBonPlan.tpl"}#

#{if $ville != ''}#
	</div>
#{/if}#