<div class="innerPopin">
	<h3>#{smarty_trad value='lib_contact'}#</h3>
	<input type="hidden" id="id_centre" name="id_centre" value="#{$id_centre}#" />	
	<p class="spacedDown">
	<label for="slctFicheCentreContactType">#{smarty_trad value='lib_centre_contact_type'}#* :</label>
	<select id="slctFicheCentreContactType" name="slctFicheCentreContactType" onChange="chooseContactFormByStatus(this);">
		#{section loop=$listeContactType name=index}#
			<option value="#{$listeContactType[index].id}#" #{if $listeContactType[index].id=="7"}#selected #{/if}#>#{$listeContactType[index].libelle}#</option>
		#{/section}#
	</select>
	</p>
	<br /><br />
	<div id="form_contact_enseignant" style="display:none;">
		#{include file="blocs/form_centre_contact_enseignant.tpl"}#
	</div>
	<div id="form_contact_association" style="display:none;">
		#{include file="blocs/form_centre_contact_association.tpl"}#
	</div>
	<div id="form_contact_particulier" style="display:block;">
		#{include file="blocs/form_centre_contact_particulier.tpl"}#
	</div>
	<div id="form_contact_autre" style="display:none;">
		#{include file="blocs/form_centre_contact_autre.tpl"}#
	</div>
	<div id="form_contact_presse" style="display:none;">
		#{include file="blocs/form_centre_contact_presse.tpl"}#
	</div>
	<div id="form_contact_partenaire" style="display:none;">
		#{include file="blocs/form_centre_contact_partenaire.tpl"}#
	</div>
	<div id="form_contact_collectivite" style="display:none;">
		#{include file="blocs/form_centre_contact_collectivite.tpl"}#
	</div>
	<div id="form_contact_futur" style="display:none;">
		#{include file="blocs/form_centre_contact_futur.tpl"}#
	</div>
</div>

