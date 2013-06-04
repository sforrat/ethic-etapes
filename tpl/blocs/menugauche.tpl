#{section name=sec1 loop=$item_menu_n1}#
	<a href="#{$item_menu_n1[sec1].url_lien_item_n1}#" class="titrge12">#{$item_menu_n1[sec1].libelle_lien_item_n1}#</a>
	#{section name=sec2 loop=$item_menu_n1[sec1].item_menu_n2}#
		<a href="#{$item_menu_n1[sec1].item_menu_n2[sec2].url_lien_item_n2}#" class="lienplan1bis">#{$item_menu_n1[sec1].item_menu_n2[sec2].libelle_lien_item_n2}#</a>
			#{section name=sec3 loop=$item_menu_n1[sec1].item_menu_n2[sec2].item_menu_n3}#
				<a href="#{$item_menu_n1[sec1].item_menu_n2[sec2].item_menu_n3[sec3].url_lien_item_n3}#" class="lienplan2">#{$item_menu_n1[sec1].item_menu_n2[sec2].item_menu_n3[sec3].libelle_lien_item_n3}#</a>
				#{section name=sec4 loop=$item_menu_n1[sec1].item_menu_n2[sec2].item_menu_n3[sec3].item_menu_n4}#
				     <a href="#{$item_menu_n1[sec1].item_menu_n2[sec2].item_menu_n3[sec3].item_menu_n4[sec4].url_lien_item_n4}#" class="lienplan2bis">#{$item_menu_n1[sec1].item_menu_n2[sec2].item_menu_n3[sec3].item_menu_n4[sec4].libelle_lien_item_n4}#</a>
				#{/section}#
			#{/section}#
	#{/section}#
#{/section}#
