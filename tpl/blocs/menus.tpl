<ul id="nav" class="clear">
	<li class="backHome">
		<a href="#{$url_home}#">#{smarty_trad value='lib_home'}#</a>
	</li>
#{section name=sec1 loop=$item_menu_n1}#
	<li #{if $item_menu_n1[sec1].current}# class="activeTab" #{/if}#>
		#{if $item_menu_n1[sec1].widesubMenu == 1}#
		<a href="#" onclick="return false;">#{$item_menu_n1[sec1].libelle_lien_item_n1}#</a>	
		<div class="widesubMenu">
	#{section name=sec2 loop=$item_menu_n1[sec1].item_menu_n2}#
		<dl>
		<dt>#{$item_menu_n1[sec1].item_menu_n2[sec2].libelle_lien_item_n2}#</dt>
			#{section name=sec3 loop=$item_menu_n1[sec1].item_menu_n2[sec2].item_menu_n3}#
				<dd><a href="#{$item_menu_n1[sec1].item_menu_n2[sec2].item_menu_n3[sec3].url_lien_item_n3}#">#{$item_menu_n1[sec1].item_menu_n2[sec2].item_menu_n3[sec3].libelle_lien_item_n3}#</a></dd>
				#{section name=sec4 loop=$item_menu_n1[sec1].item_menu_n2[sec2].item_menu_n3[sec3].item_menu_n4}#
				     <dd><a href="#{$item_menu_n1[sec1].item_menu_n2[sec2].item_menu_n3[sec3].item_menu_n4[sec4].url_lien_item_n4}#">#{$item_menu_n1[sec1].item_menu_n2[sec2].item_menu_n3[sec3].item_menu_n4[sec4].libelle_lien_item_n4}#</a></dd>
				#{/section}#
			#{/section}#
		</dl>
	#{/section}#	
		</div>
		#{elseif ($item_menu_n1[sec1].nb_item_menu_n2 !== 0)}#
		<a href="#" onclick="return false;">#{$item_menu_n1[sec1].libelle_lien_item_n1}#</a>	
			<ul>
			#{section name=sec2 loop=$item_menu_n1[sec1].item_menu_n2}#
				<li><a href="#{$item_menu_n1[sec1].item_menu_n2[sec2].url_lien_item_n2}#">#{$item_menu_n1[sec1].item_menu_n2[sec2].libelle_lien_item_n2}#</a></li>
			#{/section}#			
			</ul>	
		#{else}#
		<a href="#{$item_menu_n1[sec1].url_lien_item_n1}#" >#{$item_menu_n1[sec1].libelle_lien_item_n1}#</a>
		#{/if}#
	</li>	
#{/section}#
</ul><!-- /#nav -->		

