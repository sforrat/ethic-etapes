
<script type="text/javascript">

function changeTypeContact(id)
{
	if (id == 1)
	{
		document.getElementById('sejour_contact_enseignant').style.display = 'block';
		document.getElementById('sejour_contact_simple').style.display = 'none';
	}
	else
	{
		document.getElementById('sejour_contact_enseignant').style.display = 'none';
		document.getElementById('sejour_contact_simple').style.display = 'block';
	}
	
	if (id == 7)//Association ou organisme sportif
	{
		document.getElementById('p_nom_structure').style.display = 'none';
		document.getElementById('p_sportif').style.display = 'block';
	}
	else
	{
		document.getElementById('p_nom_structure').style.display = 'block';		
		document.getElementById('p_sportif').style.display = 'none';
	}
	
	if (id == 9) //Autres : précisez
	{
		document.getElementById('p_autre').style.display = 'block';
	}
	else
	{
		document.getElementById('p_autre').style.display = 'none';
	}
	
	$.fn.colorbox.resize();
}


function valid_form_sejour_contact()
{
	var data = ""
	var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,10}$/;
	
	data += "centre_contact_type=" + document.form_sejour_contact.ContactType.value;
	
	if (document.form_sejour_contact.ContactType.value == 9) //Autres : précisez
	{

		if (document.form_sejour_contact.e_autre.value == '')
		{
			alert(get_trad_champ('preciser_type_contact'));
			document.form_sejour_contact.e_autre.focus();
			return false;
		}
		else
		{
			data += '&precisez=' + document.form_sejour_contact.e_autre.value ;	
		}
	}	
	
	
	if (document.form_sejour_contact.ContactType.value == 1)
	{
		if (data != '')
			data += '&';
	
		data +=  'civilite=' + document.form_sejour_contact.e_civ.options[document.form_sejour_contact.e_civ.selectedIndex].value;

		if (document.form_sejour_contact.e_nom.value == '')
		{
			alert(get_trad_champ('nom'));
			document.form_sejour_contact.e_nom.focus();
			return false;
		}
		else
		{
			data += '&nom=' + document.form_sejour_contact.e_nom.value ;			
		}
			
		if (document.form_sejour_contact.e_nom_ecole.value == '')
		{
			alert(get_trad_champ('nom_ecole'));
			document.form_sejour_contact.e_nom_ecole.focus();
			return false;		
		}
		else
		{
			data += '&nom_ecole=' + document.form_sejour_contact.e_nom_ecole.value ;			
		}
		
		
		if(!document.getElementById('e_email').value.match(emailRegex))
		{
			alert(get_trad_champ('email'));
			document.form_sejour_contact.e_email.focus();
			return false;		
		}	
		else
		{
			data += '&email=' + document.form_sejour_contact.e_email.value;			
		}
		
		data += '&adresse=' + document.form_sejour_contact.e_adresse.value;				
		
		if (document.form_sejour_contact.e_code_postal.value == '')
		{
			alert(get_trad_champ('cp'));
			document.form_sejour_contact.e_code_postal.focus();
			return false;		
		}	
		else
		{
			data += '&code_postal=' + document.form_sejour_contact.e_code_postal.value;			
		}
		
	
		//Niveaux scolaire - Checkbox
		var i = 0;
		var checked = false;
		for (i ; i < document.getElementsByName('e_nvx_scolaire').length; i++)
		{
			if(document.getElementsByName('e_nvx_scolaire').item(i).checked)
			{
				checked = true;
			}
		}
		if (checked == false)
		{
			alert(get_trad_champ('niveau_scolaire'));
			return false;
		}
		
	//Newsletter - Checkbox
		var i = 0;
		var checked = false;
		for (i ; i < document.getElementsByName('newsletters').length; i++)
		{
			if(document.getElementsByName('newsletters').item(i).checked)
			{
				checked = true;
			}
		}
		if (checked == false)
		{
			alert(get_trad_champ('newsletter'));
			return false;
		}


		//Type d'établissement - Checkbox
		var i = 0;
		var checked = false;
		for (i ; i < document.getElementsByName('e_type_etablissement').length; i++)
		{
			if(document.getElementsByName('e_type_etablissement').item(i).checked)
			{
				checked = true;
			}
		}
		if (checked == false)
		{
			alert(get_trad_champ('type_etablissement'));
			return false;
		}
		
		
		
		if (document.form_sejour_contact.e_ville.value == '')
		{
			alert(get_trad_champ('ville'));
			document.form_sejour_contact.e_ville.focus();
			return false;		
		}
		else
		{
			data += '&ville=' + document.form_sejour_contact.e_ville.value;
		}
		
		
		data += '&pays=' + document.form_sejour_contact.e_pays.options[document.form_sejour_contact.e_pays.selectedIndex].value + 
					'&telephone=' + document.form_sejour_contact.e_num_tel.value + 
					'&fax=' + document.form_sejour_contact.e_num_fax.value + 
					'&commentaires_questions=' + document.form_sejour_contact.e_commentaire.value;
				
		if (document.form_sejour_contact.is_e_periode.value == 'true')	
		{
			data += 	'&periode_souhaite_debut=' + document.form_sejour_contact.e_periode_debut.value + 
						'&periode_souhaite_fin=' + document.form_sejour_contact.e_periode_fin.value ;
		}

		if (document.form_sejour_contact.is_e_duree.value == 'true')	
		{					 
			data += '&duree_souhaite=' + document.form_sejour_contact.e_duree.value;
		}
		
		if (document.form_sejour_contact.is_e_nb_personne.value == 'true')	
		{		
			data += '&nb_personne=' + document.form_sejour_contact.e_nb_personne.value;		
		}	


		var i = 0;
		data += '&niveau_scolaire=';
		var first = 1;
		for (i ; i < document.getElementsByName('e_nvx_scolaire').length; i++)
		{
			if(document.getElementsByName('e_nvx_scolaire').item(i).checked)
			{
				if (first)
				{	first = 0;		}
				else
				{	data +=  '- ';	}
			
				data += document.getElementsByName('e_nvx_scolaire').item(i).value;
			}
		}	
	
		var i = 0;
	data += '&newsletters=';
		var first = 1;
		for (i ; i < document.getElementsByName('newsletters').length; i++)
		{
			if(document.getElementsByName('newsletters').item(i).checked)
			{
				if (first)
				{	first = 0;		}
				else
				{	data +=  '- ';	}
			
				data += document.getElementsByName('newsletters').item(i).value;
			}
		}	
		
		
		var i = 0;
		data += '&type_etablissement=';
		var first = 1;
		for (i ; i < document.getElementsByName('e_type_etablissement').length; i++)
		{
			if(document.getElementsByName('e_type_etablissement').item(i).checked)
			{
				if (first)
				{	first = 0;		}
				else
				{	data +=  '- ';	}
			
				data += document.getElementsByName('e_type_etablissement').item(i).value;
			}
		}							
					
	}
	else
	{
		
		if (document.form_sejour_contact.is_nom_to.value == 'true')
		{
			data += '&nom_to=' + document.form_sejour_contact.nom_to.value;
		}
		
		data +=  '&civilite=' + document.form_sejour_contact.civ.options[document.form_sejour_contact.civ.selectedIndex].value;
		
		if (document.form_sejour_contact.nom.value == '')
		{
			alert(get_trad_champ('nom'));
			document.form_sejour_contact.nom.focus();
			return false;
		}
		else
		{
			data += '&nom=' + document.form_sejour_contact.nom.value;
		}
		
		if (!document.getElementById('email').value.match(emailRegex) )
		{
			alert(get_trad_champ('email'));
			document.form_sejour_contact.email.focus();
			return false;
		}	
		else
		{
			data += '&email=' + document.form_sejour_contact.email.value;
		}		
		
		
		
		if (document.form_sejour_contact.is_nom_assoc.value == 'true' && 
				(document.form_sejour_contact.ContactType.value == 7 || document.form_sejour_contact.ContactType.value == 0))	
		{
			if (document.form_sejour_contact.nom_assoc.value == '')
			{
				alert(get_trad_champ('nom_association'));
				document.form_sejour_contact.nom_assoc.focus();
				return false;		
			}	
			else
			{
				data += '&nom_association=' + document.form_sejour_contact.nom_assoc.value;
			}			
		}
		
		if (document.form_sejour_contact.is_discipline.value == 'true'&& 
				(document.form_sejour_contact.ContactType.value == 7 || document.form_sejour_contact.ContactType.value == 0))
		{
			var i = 0;
			var checked = false;
			for (i ; i < document.getElementsByName('discipline').length; i++)
			{
				if(document.getElementsByName('discipline').item(i).checked)
				{
					checked = true;
				}
			}
			if (checked == false)
			{
				alert(get_trad_champ('discipline'));
				return false;
			}		
		}
		
		
		if (document.form_sejour_contact.is_nom_structure.value == 'true' && 
				(document.form_sejour_contact.ContactType.value != 1 && document.form_sejour_contact.ContactType.value != 7))	
		{
			if (document.form_sejour_contact.nom_structure.value == '')
			{
				alert(get_trad_champ('nom_structure'));
				document.form_sejour_contact.nom_structure.focus();
				return false;		
			}	
			else
			{
				data += '&nom_structure=' + document.form_sejour_contact.nom_structure.value;
			}			
		}		
		
		data += '&adresse=' + document.form_sejour_contact.adresse.value;		
		
		if (document.form_sejour_contact.code_postal.value == '')
		{
			alert(get_trad_champ('cp'));
			document.form_sejour_contact.code_postal.focus();
			return false;		
		}
		else
		{
			data += '&code_postal=' + document.form_sejour_contact.code_postal.value;
		}			
		

		
		if (document.form_sejour_contact.ville.value == '')
		{
			alert(get_trad_champ('ville'));
			document.form_sejour_contact.ville.focus();
			return false;		
		}		
		else
		{
			data += '&ville=' + document.form_sejour_contact.ville.value;
		}	

		if (document.form_sejour_contact.is_discipline.value == 'true'&& 
				(document.form_sejour_contact.ContactType.value == 7 || document.form_sejour_contact.ContactType.value == 0))
		{		
			var i = 0;
			data += '&discipline_sportive=';
			var first = 1;
			for (i ; i < document.getElementsByName('discipline').length; i++)
			{
				if(document.getElementsByName('discipline').item(i).checked)
				{
					if (first)
					{	first = 0;		}
					else
					{	data +=  '- ';	}
				
					data += document.getElementsByName('discipline').item(i).value;
				}
			}	
		}		
		
		data += '&pays=' + document.form_sejour_contact.pays.options[document.form_sejour_contact.pays.selectedIndex].value + 
					'&telephone=' + document.form_sejour_contact.num_tel.value + 
					'&fax=' + document.form_sejour_contact.num_fax.value;

if(document.form_sejour_contact.commentaire != null){
      data += '&commentaires_questions=' + document.form_sejour_contact.commentaire.value;
    } 
		

		if (document.form_sejour_contact.is_nb_personne.value == 'true')	
		{		
			data += '&nb_personne=' + document.form_sejour_contact.nb_personne.value;		
		}						
						
		if (document.form_sejour_contact.is_periode.value == 'true')	
		{
			data += 	'&periode_souhaite_debut=' + document.form_sejour_contact.periode_debut.value + 
						'&periode_souhaite_fin=' + document.form_sejour_contact.periode_fin.value ;
		}			
					
	}
	
	//Captcha
	if (document.form_sejour_contact.userCode.value == '')
	{
		alert(get_trad_champ('bad_captcha'));
		document.form_sejour_contact.Capcha.focus();
		return false;			
	}
	else
	{
			data += '&userCode=' + document.form_sejour_contact.userCode.value;
	}

		
	if (document.form_sejour_contact.is_age_enfant.value == 'true')
	{
		if (document.form_sejour_contact.age_enfant.value == '')
		{
			alert(get_trad_champ('age_enfant'));
			document.form_sejour_contact.age_enfant.focus();
			return false;		
		}	
		else
		{
			data += '&age_enfant=' + document.form_sejour_contact.age_enfant.value;
		}
	}
	
		

	
	data += '&Rub=' + document.form_sejour_contact.rub.value;
	data += '&id=' + document.form_sejour_contact.id.value;
	
	$.ajax({
	   type: "POST",
	   url: "send_form_contact_sejour.php",
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
	
	
} // valid_form_sejour_contact()

</script>
<link type="text/css" rel="stylesheet" href="css/jquery-ui.css"  media="all"/>
<script type="text/javascript" src="js/jquery.ui.core.js"></script>
<script type="text/javascript" src="js/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="js/jquery.ui.datepicker-#{$prefixe}#.js"></script>


<div class="innerPopin" id="innerPopin">
	<h3>#{$titre}#</h3>	
	#{if $rappelSejour != ""}#
		<h4>#{$rappelSejour}#</h4>
	#{/if}#
	
	<form action="#" method="post" name="form_sejour_contact">
		<fieldset class="popinForm">
		<input type="hidden" name="rub" value="#{$Rub}#" />
		<input type="hidden" name="id" value="#{$idSejour}#" />
		
		#{if !$is_contact_type}#
		<input type="hidden" name="ContactType" value="0"/>
		#{/if}#
		
		
		#{if $is_contact_type}#
		<p>
		<label>#{smarty_trad value='lib_centre_contact_type'}#</label>
		<select name="ContactType" onchange="changeTypeContact(this.value); return false;">
			#{section loop=$listeContactType name=index}#
				<option value="#{$listeContactType[index].id}#">#{$listeContactType[index].libelle}#</option>
			#{/section}#
		</select>
		</p>

		<p id="p_autre" style="display:none;">
				<label for="e_autre">#{smarty_trad value='lib_precisez'}# * : </label>
				<input type="text" id="e_autre" name="e_autre" class="text" />
		</p>
		
		<div id="sejour_contact_enseignant">
			<p>
				<label>#{smarty_trad value='lib_civilite'}# :</label>
				<select name="e_civ" >
					#{section loop=$listeCivilite name=index}#
						<option value="#{$listeCivilite[index].libelle}#">#{$listeCivilite[index].libelle}#</option>
					#{/section}#
				</select>				
			</p>
			
			<p>
				<label for="e_nom">#{smarty_trad value='lib_nom'}# / #{smarty_trad value='lib_prenom'}# * : </label>
				<input type="text" id="e_nom" name="e_nom" class="text" />
			</p>		
			
			
			<p>
				<label for="e_nom_ecole">#{smarty_trad value='lib_nom_ecole'}# * : </label>
				<input type="text" id="e_nom_ecole" name="e_nom_ecole" class="text" />
			</p>			
			
			<p>
				<label for="e_email">#{smarty_trad value='lib_email'}# * :</label>
				<input type="text" id="e_email" name="e_email" class="text">
			</p>		
			
			<p>
				<label for="e_adresse">#{smarty_trad value='lib_adresse'}# :</label>
				<input type="text" id="e_adresse" name="e_adresse" class="text" />
				<label for="e_code_postal">#{smarty_trad value='lib_code_postal'}# * :</label>
				<input type="text" id="e_code_postal" name="e_code_postal" class="text" />
			</p>	
					
			<p>
				<label for="e_ville">#{smarty_trad value='lib_ville'}# * :</label>
				<input type="text" id="e_ville" name="e_ville" class="text" />
				<label for="e_pays">#{smarty_trad value='lib_pays'}# * :</label>
				<select name="e_pays" >
					#{section loop=$listePays name=index}#
						<option value="#{$listePays[index].libelle}#" #{if $listePays[index].selected}# selected="selected" #{/if}#>#{$listePays[index].libelle}#</option>
					#{/section}#
				</select>
			</p>	
		
			<p>
				<label for="e_num_tel">#{smarty_trad value='lib_telephone'}# :</label>
				<input type="text" id="e_num_tel" name="e_num_tel" class="text" />
				<label for="e_num_fax">#{smarty_trad value='lib_fax'}# :</label>
				<input type="text" id="e_num_fax" name="e_num_fax" class="text"/>
			</p>				
								
			<div class="formLine">
				<label for="e_nvx_scolaire">#{smarty_trad value='lib_niveau_scolaire'}# * :</label>
				<ul>
					#{section name=index loop=$listeNiveauScolaire}#
						<li><input type="checkbox" id='e_nvx_scolaire_#{$listeNiveauScolaire[index].id}#' name='e_nvx_scolaire' value="#{$listeNiveauScolaire[index].libelle}#"><label for="e_nvx_scolaire_#{$listeNiveauScolaire[index].id}#" class="labelCheckbox">#{$listeNiveauScolaire[index].libelle}#</label></li>
					#{/section}#
				</ul>
			</div>						
			
			<div class="formLine">
				<label for="e_type_etablissement">#{smarty_trad value='lib_type_etablissement'}# * :</label>
				<ul>
				#{section name=index loop=$listeEtablissementType}#
					<li><input type="checkbox" id='e_type_etablissement_#{$listeEtablissementType[index].id}#' name='e_type_etablissement' value="#{$listeEtablissementType[index].libelle}#"><label for="e_type_etablissement_#{$listeEtablissementType[index].id}#" class="labelCheckbox">#{$listeEtablissementType[index].libelle}#</label></li>
				#{/section}#
				</ul>
			</div>				
				
			#{if $isEPeriodeSouhaite}#
			<p>
				<label>#{smarty_trad value='lib_periode_souhaite'}# :</label>
				<label for="e_periode_debut" class="labelPeriod">#{smarty_trad value='lib_periode_souhaite_debut'}#</label> <input type="text"  name="e_periode_debut"  class="text smallText datepicker" id="datepicker1"/> <label for="e_periode_fin" class="labelPeriod">#{smarty_trad value='lib_periode_souhaite_fin'}#</label> <input type="text" name="e_periode_fin" class="text smallText datepicker" id="datepicker2"/>
				<input type="hidden" name="is_e_periode" value="true" />
				
			#{else}#			
				<input type="hidden" name="is_e_periode" value="false" />
			#{/if}#
			
			#{if $isDureeSouhaite}#
			
				<label for="e_duree">#{smarty_trad value='lib_duree_souhaite'}# :</label>
				<input type="text" id="e_duree" name="e_duree" class="text smallText" />
				<input type="hidden" name="is_e_duree" value="true" /> 
			</p>	
			#{else}#			
				<input type="hidden" name="is_e_duree" value="false" />
			#{/if}#		
			
			#{if $isENbPersonnes}#
			<p>
				<label for="e_nb_personne">#{smarty_trad value='lib_nb_personne'}# :</label>
				<input type="text" id="e_nb_personne" name="e_nb_personne" class="text smallText">
				<input type="hidden" name="is_e_nb_personne" value="true" />  
			</p>
			#{else}#				
				<input type="hidden" name="is_e_nb_personne" value="false" />  
			#{/if}#			

			#{if $isEPresentationProjet }#
			<p>
				<label for="e_projet">#{smarty_trad value='lib_presentation_projet'}# :</label>
				<textarea id="e_projet" name="e_projet"></textarea>
			</p>				
			#{/if}#							
			
			<p>
				<label for="e_commentaire">#{smarty_trad value='lib_commentaires_questions'}# :</label>
				<textarea id="e_commentaire" name="e_commentaire"></textarea>
			</p>				
		</div>
		#{/if}#

			
		<div id="sejour_contact_simple" #{if $is_contact_type}# style="display:none;" #{/if}#>
			<p>
				<label>#{smarty_trad value='lib_civilite'}# :</label>
				<select name="civ" >
					#{section loop=$listeCivilite name=index}#
						<option value="#{$listeCivilite[index].libelle}#">#{$listeCivilite[index].libelle}#</option>
					#{/section}#
				</select>		
			</p>
			
			#{if $isNomTo}#
			<p>
				<label for="nom_to">#{smarty_trad value='lib_nom_to'}# : </label>
				<input type="text" id="nom_to" name="nom_to" class="text" />
				<input type="hidden" name="is_nom_to" value="true" /> 
			</p>
			#{else}#
				<input type="hidden" name="is_nom_to" value="false" /> 
			#{/if}#
				
			<p>
				<label for="nom">#{smarty_trad value='lib_nom'}# / #{smarty_trad value='lib_prenom'}# * : </label>
				<input type="text" id="nom" name="nom" class="text" />
			</p>		
			
			<p>
				<label for="email">#{smarty_trad value='lib_email'}# * :</label>
				<input type="text" id="email" name="email" class="text" />
			</p>		
			
			<div id="p_nom_structure">
				#{if $isNomStructure}#
				<p>
					<label for="nom_structure">#{smarty_trad value='lib_nom_structure'}# :</label>
					<input type="text" id="nom_structure" name="nom_structure" class="text" /> 
					<input type="hidden" name="is_nom_structure" value="true" /> 
				</p>		
				#{else}#
					<input type="hidden" name="is_nom_structure" value="false" /> 		
				#{/if}#					
			</div>
			<div id="p_sportif">
				#{if $isNomAssoc}#
				<p>
					<label for="nom_assoc">#{smarty_trad value='lib_nom_association'}# * :</label>
					<input type="text" id="nom_assoc" name="nom_assoc" class="text" /> 
					<input type="hidden" name="is_nom_assoc" value='true' /> 
				</p>	
				#{else}#
					<input type="hidden" name="is_nom_assoc" value='false' /> 
				#{/if}#	
				
				#{if $isDiscipline}#
				<div class="formLine">
					<label>#{smarty_trad value='lib_discipline_sportive'}# * :</label>
					<ul>
					#{section name=index loop=$listeDiscipline}#
						<li><input type="checkbox" id='discipline_#{$listeDiscipline[index].id}#' name='discipline' value="#{$listeDiscipline[index].libelle}#"><label for="discipline_#{$listeDiscipline[index].id}#" class="labelCheckbox">#{$listeDiscipline[index].libelle}#</label></li>
					#{/section}#
					</ul>
					<input type="hidden" name="is_discipline" value='true' /> 
				</div>	
				#{else}#
					<input type="hidden" name="is_discipline" value='false' /> 
				#{/if}#					
			</div>						
			<p>
				<label for="adresse">#{smarty_trad value='lib_adresse'}# :</label>
				<input type="text" id="adresse" name="adresse" class="text" />
				<label for="code_postal">#{smarty_trad value='lib_code_postal'}# * :</label>
				<input type="text" id="code_postal" name="code_postal" class="text" />
			</p>	
		
			<p>
				<label for="ville">#{smarty_trad value='lib_ville'}# * :</label>
				<input type="text" id="ville" name="ville" class="text" />
				<label for="pays">#{smarty_trad value='lib_pays'}# * :</label>
				<select name="pays" >
					#{section loop=$listePays name=index}#
						<option value="#{$listePays[index].libelle}#" #{if $listePays[index].selected}# selected="selected" #{/if}#>#{$listePays[index].libelle}#</option>
					#{/section}#
				</select>
			</p>	
	
			<p>
				<label for="num_tel">#{smarty_trad value='lib_telephone'}# :</label>
				<input type="text" id="num_tel" name="num_tel" class="text" />
				<label for="num_fax">#{smarty_trad value='lib_fax'}# :</label>
				<input type="text" id="num_fax" name="num_fax" class="text" />
			</p>				
			
			#{if $isNbPersonnes}#
			<p>
				<label for="nb_personne">#{smarty_trad value='lib_nb_personne'}# :</label>
				<input type="text" id="nb_personne" name="nb_personne" class="text smallText" /> 
				<input type="hidden" name="is_nb_personne" value="true" /> 
			</p>
			#{else}#
				<input type="hidden" name="is_nb_personne" value="false" /> 				
			#{/if}#				
			
			#{if $isAgeEnfant}#
			<p>
				<label for="age_enfant">#{smarty_trad value='lib_age_enfant'}# * :</label>
				<input type="text" id="age_enfant" name="age_enfant" class="text" /> 
				<input type="hidden" name="is_age_enfant" value="true"> 
			</p>	
			#{else}#			
				<input type="hidden" name="is_age_enfant" value="false"> 
			#{/if}#						
			
			#{if $isPeriodeSouhaite}#
			<p>
				<label>#{smarty_trad value='lib_periode_souhaite'}# :</label>
				<label for="periode_debut" class="labelPeriod">#{smarty_trad value='lib_periode_souhaite_debut'}#</label> <input type="text" id="periode_debut" name="periode_debut" class="text smallText" /> <label for="periode_fin" class="labelPeriod">#{smarty_trad value='lib_periode_souhaite_fin'}#</label> <input type="text" id="periode_fin" name="periode_fin" class="text smallText" />
				<input type="hidden" name="is_periode" value="false"> 
			</p>	
			#{else}#	
				<input type="hidden" name="is_periode" value="false"> 		
			#{/if}#			
			
			#{if $isPresentationProjet }#
			<p>
				<label for="projet">#{smarty_trad value='lib_commentaires_questions'}# :</label>
				<textarea id="projet" name="projet"></textarea>
			</p>				
			#{/if}#	
							
			#{*
			<p>
				<label for="commentaire">#{smarty_trad value='lib_commentaires_questions'}# :</label>
				<textarea id="commentaire" name="commentaire"></textarea>
			</p>	
			*}#
		</div>	
			<p class="choiceNL spacedUp ">
		    <label for="projet">#{smarty_trad value='lib_newsletters'}# :</label><br />
		  	#{section loop=$listeNewsletter name=sec}#
				  <input type="checkbox" name="newsletters" id="newsletter_#{$listeNewsletter[sec].id}#" value="#{$listeNewsletter[sec].libelle}#" /><label for="newsletter_#{$listeNewsletter[sec].id}#" class="labelCheckbox">#{$listeNewsletter[sec].libelle}#</label><br />
		    #{/section}#
</p>			
		<p class="captchaLine">#{include file="blocs/captcha.tpl"}#</p>
		<p class="validLine">
			<input type="button" onclick="valid_form_sejour_contact();" value="#{smarty_trad value='lib_submit'}#">
		</p>
		<p class="mandatoryFields">* #{smarty_trad value='lib_champ_obligatoire'}#.</p>
		<p class="disclaimer">#{smarty_trad value='lib_mention_cnil'}#</p>		
		</fieldset>
	</form>
</div>
<script type="text/javascript">
$(function() {
	$("#datepicker1").datepicker({
		showOn: 'button',
		buttonImage: 'images/calendar.gif',
		buttonImageOnly: true
	});

	$("#datepicker2").datepicker({
		showOn: 'button',
		buttonImage: 'images/calendar.gif',
		buttonImageOnly: true
	});
	
});
</script>