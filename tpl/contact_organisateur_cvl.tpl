<script type="text/javascript" src="js/form.js"></script>
<script type="text/javascript">

function checkFormContactCVL()
{	
	if (checkFormAjax('formContactCVL'))
	{
		
		//Capcha
		if (document.getElementById('userCode').value == '')
		{
			alert(get_trad_champ('bad_captcha'));
			document.getElementById('userCode').focus();
			return false;			
		}
		else
		{
		
			var data = "";
			
			var els = document.forms['formContactCVL'].elements;
			for ( var i = 0 ; i < els.length ; i++ ) { // on boucle sur les éléments du formulaire		
				data += '&' + els[i].name + '=' + els[i].value; 
			}
					
			$.ajax({
			   type: "POST",
			   url: "processing/sendContactCVL.action.php",
			   data: data,
			   success: function(msg){
			     if (msg == 1)
			     {
			     	document.getElementById('innerPopin').innerHTML = get_trad_champ('reponse_ajax_ok');
			     	$.fn.colorbox.resize();
			     }
			     else
			     {
			     	var tabMsg = msg.split('|');
	
			     	msg = tabMsg[1];
			     	if ( msg == 'BAD_CAPTCHA')
			     	{
						alert(get_trad_champ('bad_captcha'));
			     	}
			     	else
			     	{
			     		alert(get_trad_champ('reponse_ajax_failed') +msg);
			     	}
			     	
			     }
			   }   
			 });	
		}
	}
}

</script>


<div class="innerPopin" id="innerPopin">
<h3>#{$titre}#</h3>	
<form  name="formContactCVL" id="formContactCVL"  >			
	#{if $messageOK == 1}#
	<p class="messageForm">#{$message}#</p>
	#{/if}#
	
	<fieldset class="skinThisForm">	
		<p>
			<label>#{smarty_trad value='lib_civilite'}#* :</label>
			#{section name=sec1 loop=$TabCivilite}#				
					<input name="test-Civilite" type="radio" id="#{$TabCivilite[sec1].libelle}#" value="#{$TabCivilite[sec1].libelle}#" /><label for="#{$TabCivilite[sec1].libelle}#" class="labelRadio">#{$TabCivilite[sec1].libelle}#</label>
			#{/section}#							
		</p>
		
		<p>
			<label for="test-contact_name">#{smarty_trad value='lib_nom_prenom'}#* :</label>
			<input type="text" class="text" id="#{smarty_trad value='lib_nom_prenom'}#" name="test-contact_name" />								
		</p>
		<p>
			<label for="test-email-contact_mail">#{smarty_trad value='lib_adresse_mail'}#* :</label>
			<input type="text" class="text" id="#{smarty_trad value='lib_adresse_mail'}#" name="test-email-contact_mail"/>								
		</p>
		<p id="Padresse">
			<label for="#{smarty_trad value='lib_adresse'}#">#{smarty_trad value='lib_adresse'}#* :</label>
			<input type="text" class="text" id="#{smarty_trad value='lib_adresse'}#" name="test-Padresse" />								
		</p>
		<p id="Pcp">
			<label for="#{smarty_trad value='lib_code_postal'}#">#{smarty_trad value='lib_code_postal'}#* :</label>
			<input type="text" class="text" id="#{smarty_trad value='lib_code_postal'}#" name="test-Pcp" />							
		</p>
		<p id="Pville">
			<label for="#{smarty_trad value='lib_ville'}#">#{smarty_trad value='lib_ville'}#* :</label>
			<input type="text" class="text" id="#{smarty_trad value='lib_ville'}#" name="test-Pville" />							
		</p>
		<p id="Ppays">
			<label for="#{smarty_trad value='lib_pays'}#">#{smarty_trad value='lib_pays'}#* :</label>
			<select id="#{smarty_trad value='lib_pays'}#"  name="test-Ppays">
				#{section name=sec3 loop=$TabPays}#
					<option value="#{$TabPays[sec3].id}#">#{$TabPays[sec3].libelle}#</option>
				#{/section}#
				
			</select>	
		</p>
		<p>
			<label for="#{smarty_trad value='lib_telephone'}#">#{smarty_trad value='lib_telephone'}#* :</label>
			<input type="text" class="text" id="#{smarty_trad value='lib_telephone'}#" name="test-contact_tel" />							
		</p>
		<p id="PFax">
			<label for="contact_fax">#{smarty_trad value='lib_fax'}# :</label>
			<input type="text" class="text" id="contact_fax" name="PFax" />							
		</p>
		<p>
			<label for="#{smarty_trad value='lib_commentaires_questions'}#">#{smarty_trad value='lib_commentaires_questions'}#* :</label>
			<span class="txtArea_container">
				<textarea id='#{smarty_trad value='lib_commentaires_questions'}#' name='test-contact_commentaire' cols="20" rows="5" ></textarea>
			</span>				
		</p>
		<p class="captchaLine">#{include file="blocs/captcha.tpl"}#</p>		
		<p class="validLine">
			<input type="button" onclick="checkFormContactCVL();" value="#{smarty_trad value='lib_submit'}#" /><!-- Lib a passer en majuscule -->
		</p>
		<p class="mandatoryFields">* #{smarty_trad value='lib_champ_obligatoire'}#.</p>
		<p class="disclaimer">#{smarty_trad value='lib_mention_cnil'}#</p>
	</fieldset>						
</form>
</div>