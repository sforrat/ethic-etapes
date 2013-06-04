
<p class="searchData"><strong>#{$nbitems}# #{smarty_trad value='lib_resultat'}# </strong> |&nbsp; #{smarty_trad value='lib_votre_critere'}# : <em>#{$critere}#</em></p>
#{*=======================*}#
#{* 	ITEMS TROUVES	  *}#
#{*=======================*}#
<ul id="searchTxt">
#{section name=sec loop=$items}#		
	
		#{if $items[sec].table != ""}#
		#{if !$smarty.section.sec.first}#
		</li>
		#{/if}#
		<li>
		
		
		<h2>#{$items[sec].table}#</h2>
		#{/if}#
		<dl>
			<dt><a href="#{$smarty.const._CONST_APPLI_URL}##{$items[sec].url}#">#{$items[sec].libelle}#</a></dt>	
			#{if $items[sec].content!=""}#<dd><a href="#{$smarty.const._CONST_APPLI_URL}##{$items[sec].url}#">#{$items[sec].content}#</a></dd>#{/if}#
			<dd class="link"><a href="#{$smarty.const._CONST_APPLI_URL}##{$items[sec].url}#">#{smarty_trad value='lib_lire_la_suite'}#</a></dd>
		</dl>
	
#{/section}#	
</li>
</ul>