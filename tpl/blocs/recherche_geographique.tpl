<h2>#{smarty_trad value='lib_recherche_geographique_maj'}#</h2>

<form action="#{$url_recherche}##moteurResa" id="formRechercheGeo" name="formRechercheGeo" method="POST">
	<p class="clear">
		#{if $is_resa_filter1}#
		<label>#{smarty_trad value='lib_filtre_recherche_maj'}#</label>
		<select id="resa_filter1" name="detention_label" onChange="document.forms['formRechercheGeo'].submit();">
		    <option value="0" #{if $resa_filter1 == 0}#selected#{/if}#>#{smarty_trad value='lib_label'}#</option>		
			#{section name=sec1 loop=$TabLabel}#		
				<option value="#{$TabLabel[sec1].id}#"  #{if $resa_filter1 == $TabLabel[sec1].id}#selected#{/if}#>#{$TabLabel[sec1].libelle}#</option>						
			#{/section}#							
		</select>
		#{/if}#
		
		#{if $is_resa_filter2}#
		<select id="resa_filter2" name="environnement_filter" onChange="document.forms['formRechercheGeo'].submit();">
		  <option value="0" #{if $resa_filter2 == 0}#selected#{/if}#>#{smarty_trad value='lib_ambiance'}#</option>		
			#{section name=env loop=$TabEnv}#		
				<option value="#{$TabEnv[env].id}#" #{if $resa_filter2 == $TabEnv[env].id}#selected#{/if}#>#{$TabEnv[env].libelle}#</option>						
			#{/section}#					
		</select>
		#{/if}#
	</p>
</form>

<div id="map">
	<script type="text/javascript">
		//<![CDATA[
			var flashvars = {
	        	allCentre:
		        	"#{$allcentre}#"
					#{if $Rub != ""}#,Rub:"#{$Rub}#"#{/if}#
		        	#{if $isOnParis != ""}#,isOnParis:"#{$isOnParis}#"#{/if}#
			        #{if $centreID != ""}#,centreID:"#{$centreID}#"#{/if}#
				    #{if $idCentre != ""}#,idCentre:"#{$idCentre}#"#{/if}#
					#{if $resa_filter1 != ""}#,idLabel:"#{$resa_filter1}#"#{/if}#
					#{if $resa_filter2 != ""}#,idEnvironnement:"#{$resa_filter2}#"#{/if}#
	      	};
			var params = {
				wmode: "transparent"
			};							
			var attributes = {};
			swfobject.embedSWF("flash/localisationCentreFront.swf", "map", 265, 229, "10", false, flashvars, params, attributes);
		//]]>
	</script>	
	<!-- Contenu alternatif -->
	
</div>