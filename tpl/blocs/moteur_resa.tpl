<div id="moteurResa">
	<h2>#{smarty_trad value='lib_titre_recherche'}#</h2>
	<form action="#">
		<p class="clear">
			#{if $is_infos}#
			<label>#{smarty_trad value='lib_filtre_recherche'}#</label>
			<select id="resa_filter1">
					#{section loop=$label name=sec}#
						<option value="#{$label[sec].id}#">#{$label[sec].libelle}#</option>
					#{/section}#
			</select>
			#{/if}#
			#{if $is_environ}#
			<select id="resa_filter2">
				#{section loop=$environmt name=env}#
					<option value="#{$environmt[env].id}#">#{$environmt[env].libelle}#</option>
				#{/section}#							
			</select>
			#{/if}#
		</p>
	</form>
	<div id="map">
		<a href="#"><img src="images/common/dot_map.gif" alt="Dijon" title="Dijon" class="dot" style="top:50px;left:150px;" /></a>
		<a href="#"><img src="images/common/dot_map.gif" alt="Marseille" title="Marseille" class="dot" style="top:78px;left:180px;"/></a>
		<a href="#"><img src="images/common/dot_map.gif" alt="Strasbourg" title="Strasbourg" class="dot" style="top:135px;left:115px;"/></a>
		<a href="#"><img src="images/common/dot_map.gif" alt="Lyon" title="Lyon" class="dot" style="top:64px;left:225px;"/></a>
		<a href="#"><img src="images/common/dot_active_map.gif" alt="Rennes" title="Rennes" class="dot" style="top:143px;left:215px;"/></a>					
	</div>
</div><!-- /#moteurResa-->	