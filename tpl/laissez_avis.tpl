<div class="innerPopin">
	<h3>#{$titre}#</h3>
	<h4>#{smarty_trad value='lib_avis_centre'}#</h4>
	<p id='form_avis' class="error"></p>
	<form enctype="multipart/form-data" id="formAvis" name="formAvis" action="" method="post" onsubmit="verif_form_avis(); return false;">
		<input type="hidden" value="#{$id_centre}#" id="id_centre" name="id_centre">
		<fieldset class="popinForm">	
			<p>
				<label for="nom">#{smarty_trad value='lib_nom'}#* : </label>
				<input type="text" id="nom" name="nom" class="text" />
			</p>
			<p>
				<label for="prenom">#{smarty_trad value='lib_prenom'}# : </label>
				<input type="text" id="prenom" name="prenom" class="text" />
			</p>
			<p>
				<label for="email">#{smarty_trad value='lib_email'}#* : </label>
				<input type="text" id="email" name="email" class="text" />
			</p>
			<p>
				<label for="note">#{smarty_trad value='lib_votre_note'}#* : </label>
				<select id="note" name="note">
					#{section name=sec1 loop=$TabNote}#
					<option value="#{$TabNote[sec1].id}#">#{$TabNote[sec1].libelle}#</option>
					#{/section}#
				</select>
			</p>
			<p>
				<label for="commentaire">#{smarty_trad value='lib_commentaire'}#* : </label>
				<textarea rows="5" id="commentaire" name="commentaire"></textarea><br clear="all">
			</p>
			<p class="captchaLine">
				#{include file="blocs/captcha.tpl"}#
			</p>
			
			<p class="validLine">
				<input type="submit" value="#{$lib_valider}#" />
			</p>
		</fieldset>
	</form>
</div>
