<a href="#{$urlBackTop}#" id="backTop">#{smarty_trad value='lib_retour_haut'}#</a>
<ul id="footer">
#{section name=sec1 loop=$item_menu_n1}#
	<li><a href="#{$item_menu_n1[sec1].url_lien_item_n1}#">#{$item_menu_n1[sec1].libelle_lien_item_n1}#</a></li>	
	#{section name=sec2 loop=$item_menu_n1[sec1].item_menu_n2}#
		<a href="#{$item_menu_n1[sec1].item_menu_n2[sec2].url_lien_item_n2}#">#{$item_menu_n1[sec1].item_menu_n2[sec2].libelle_lien_item_n2}#</a>
			#{section name=sec3 loop=$item_menu_n1[sec1].item_menu_n2[sec2].item_menu_n3}#
				<li><a href="#{$item_menu_n1[sec1].item_menu_n2[sec2].item_menu_n3[sec3].url_lien_item_n3}#">#{$item_menu_n1[sec1].item_menu_n2[sec2].item_menu_n3[sec3].libelle_lien_item_n3}#</a></li>
				#{section name=sec4 loop=$item_menu_n1[sec1].item_menu_n2[sec2].item_menu_n3[sec3].item_menu_n4}#
				     <li><a href="#{$item_menu_n1[sec1].item_menu_n2[sec2].item_menu_n3[sec3].item_menu_n4[sec4].url_lien_item_n4}#">#{$item_menu_n1[sec1].item_menu_n2[sec2].item_menu_n3[sec3].item_menu_n4[sec4].libelle_lien_item_n4}#</a></li>
				#{/section}#
			#{/section}#
	#{/section}#	
#{/section}#
</ul>