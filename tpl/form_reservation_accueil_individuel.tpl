
<script type="text/javascript">

function valid_form_sejour_resa()
{

	if (document.form_sejour_resa.nb_personne.value == '')
	{
		alert(get_trad_champ('nb_personne'));
		return false;
	}
	
	if ($('input[type=radio][name=nb_personne]:checked').attr('value') > 9)
	{
		
	if (document.form_sejour_resa.idSejour.value != '')
	{
		var data = 'Rub=' + document.form_sejour_resa.rub.value;
		data += '&id=' + document.form_sejour_resa.idSejour.value;	
	}
	else
	{
		var data = 'id_centre=' + document.form_sejour_resa.idCentre.value;	
	}
				
		$.ajax({
		   type: "POST",
		   url: "#{$urlAjax}#",
		   data: data,
		   success: function(msg){
		   	
		     	document.getElementById('global').innerHTML = msg;
		     	$.fn.colorbox.resize();

		   }   
		 });	
	}
	else
	{
		window.open("#{$urlReservation}#");	
	}
	
	
} // valid_form_sejour_reservation()

</script>
<link type="text/css" rel="stylesheet" href="css/jquery-ui.css"  media="all"/>
<script type="text/javascript" src="js/jquery.ui.core.js"></script>
<script type="text/javascript" src="js/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="js/jquery.ui.datepicker-#{$prefixe}#.js"></script>


<div id="global">
	<div class="innerPopin">
		<h3>#{smarty_trad value='lib_reservation'}#</h3>		
		
		<form action="#" method="post" name="form_sejour_resa" >
			<fieldset class="popinForm">
			<input type="hidden" name="rub" value="#{$Rub}#" />
			<input type="hidden" name="idSejour" value="#{$idSejour}#" />	
			<input type="hidden" name="idCentre" value="#{$idCentre}#" />	
				#{*<p>
					<label>#{smarty_trad value='lib_periode_souhaite'}# :</label>
					<label for="periode_debut" class="labelPeriod">#{smarty_trad value='lib_periode_souhaite_debut'}#</label> <input type="text" name="periode_debut" class="text smallText datepicker" id="datepicker1"/> <label for="periode_fin" class="labelPeriod">#{smarty_trad value='lib_periode_souhaite_fin'}#</label> <input type="text" name="periode_fin" class="text smallText datepicker" id="datepicker2" />
				</p>
				*}#

				<p>
					<label for="moins">
					<input type="radio" value="9" id="moins" name="nb_personne">
						#{smarty_trad value='lib_moins_dix_personne'}#
					</label>
					
					<label for="plus">
					<input type="radio" value="10" id="plus" name="nb_personne">
						#{smarty_trad value='lib_plus_dix_personne'}#
					</label>
				</p>
				
				#{*
				<p>
					<label for="nb_personne">#{smarty_trad value='lib_nb_personne'}# * :</label>
					<input type="text" id="nb_personne" name="nb_personne" class="text"/>
				</p>*}#
				<p class="validLine">
					<input type="button" onclick="valid_form_sejour_resa();" value="#{smarty_trad value='lib_submit'}#">
				</p>
				<p class="mandatoryFields">* #{smarty_trad value='lib_champ_obligatoire'}#.</p>
				<p class="disclaimer">#{smarty_trad value='lib_mention_cnil'}#</p>				
			</fieldset>
		</form>
	</div>
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