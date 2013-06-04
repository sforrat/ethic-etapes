/* ======================================================================================*/
/*				 FONCTIONS GÉNÉRIQUES DE VALIDATION DE FORMULAIRE 						 */
/* ======================================================================================*/

//---------------------------------------------
// Empeche la saisie d'un caractere onKeypress
//----------------------------------------------
function empechechar()
{
	if( event.keyCode < 48 || event.keyCode > 57 )
	{
		alert(get_trad_champ("numeric") );
		event.returnValue = false;
	}
}

//-------------------------------------
// Permet la saisie d un chiffre
//-------------------------------------
function onlyNumber(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;

	return true;
}

//-------------------------------------
// Verifie la validite d'un email
//-------------------------------------
function isValidEmail ( _fieldId ) {

	var email = document.getElementById(_fieldId).value;
	var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

	if ( !filter.test(email) )
	{
		return false;
	}
	else
	{
		return true;
	}
}


//-------------------------------------
// Verifie la validite d'une date
//-------------------------------------
function isValidDate ( _fieldId )
{
	if ( _fieldId == "" )
	return true;

	// Récupération de la valeur
	var totalDate    = document.getElementById( _fieldId ).value;
	if ( totalDate == "" )
	return false;

	// Découpage de la date récupérée
	var aDate = totalDate.split( "/" );
	if ( aDate.length != 3 )
	return false;

	// Création d'un objet date
	var generatedDate = new Date ( aDate[ 2 ], aDate[ 1 ] - 1, aDate[ 0 ] );

	// Test
	if (     generatedDate.getFullYear() == aDate[ 2 ]
	&&    generatedDate.getMonth() + 1 == aDate[ 1 ]
	&&    generatedDate.getDate() == aDate[ 0 ] )
	return true;

	return false;
}


/* ======================================================================================*/
/*							 FONCTIONS GÉNÉRIQUES										 */
/* ======================================================================================*/

String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g,"");
}



/* ======================================================================================*/
/*				 FONCTIONS D APPELS LIES AU PROJET				 						 */
/* ======================================================================================*/

//-------------------------------------
// Affiche un div de contact dans un panel predefini en fonction d'une selection 'select'
// AUTHOR : GPE
// MODULE : Fiche Centre > Contact
//-------------------------------------
function chooseContactFormByStatus(frmElement)
{
	var sIndex;
	var aFormIndex = new Array();

	aFormIndex[1]='form_contact_enseignant';
	aFormIndex[2]='form_contact_autre';
	aFormIndex[3]='form_contact_autre';
	aFormIndex[4]='form_contact_autre';
	aFormIndex[5]='form_contact_autre';
	aFormIndex[6]='form_contact_association';
	aFormIndex[7]='form_contact_particulier';
	aFormIndex[8]='form_contact_presse';
	aFormIndex[9]='form_contact_collectivite';
	aFormIndex[10]='form_contact_partenaire';
	aFormIndex[11]='form_contact_futur';
	aFormIndex[12]='form_contact_autre';

	$("div[id^='form_contact']").each(function(){
		$(this).css('display','none');
	});

	//console.log(aFormIndex[frmElement.value]);
	$('#'+aFormIndex[frmElement.value]).css('display','block');

	$('#ajx_message_status').html('');
	$.fn.colorbox.resize();
}

function majFormContact(id){

	switch (id){
		case '1':
		document.getElementById('PFax').style.display 			= "block";
		document.getElementById('Pecole').style.display 		= "none";
		document.getElementById('Pcollectivite').style.display 	= "none";
		document.getElementById('Pequipement').style.display 	= "none";
		document.getElementById('PFonction').style.display 		= "none";
		document.getElementById('Pstructure').style.display 	= "none";
		document.getElementById('Pmedia').style.display 		= "none";
		document.getElementById('Passociation').style.display 	= "none";
		document.getElementById('Pdiscipline').style.display 	= "none";
		document.getElementById('Padresse').style.display 		= "block";
		document.getElementById('Pcp').style.display 			= "block";
		document.getElementById('Pville').style.display 		= "block";
		document.getElementById('Ppays').style.display 			= "block";
		document.getElementById('Pniveau').style.display 		= "block";
		document.getElementById('Petablissement').style.display = "block";
		break;
		case '2':
		document.getElementById('PFax').style.display 			= "block";
		document.getElementById('Pecole').style.display 		= "none";
		document.getElementById('Pcollectivite').style.display 	= "none";
		document.getElementById('Pequipement').style.display 	= "none";
		document.getElementById('PFonction').style.display 		= "none";
		document.getElementById('Pstructure').style.display 	= "none";
		document.getElementById('Pmedia').style.display 		= "none";
		document.getElementById('Passociation').style.display 	= "block";
		document.getElementById('Pdiscipline').style.display 	= "none";
		document.getElementById('Padresse').style.display 		= "block";
		document.getElementById('Pcp').style.display 			= "block";
		document.getElementById('Pville').style.display 		= "block";
		document.getElementById('Ppays').style.display 			= "block";
		document.getElementById('Pniveau').style.display 		= "none";
		document.getElementById('Petablissement').style.display = "none";
		break;
		case '3':
		document.getElementById('PFax').style.display 			= "block";
		document.getElementById('Pecole').style.display 		= "none";
		document.getElementById('Pcollectivite').style.display 	= "none";
		document.getElementById('Pequipement').style.display 	= "none";
		document.getElementById('PFonction').style.display 		= "none";
		document.getElementById('Pstructure').style.display 	= "block";
		document.getElementById('Pmedia').style.display 		= "none";
		document.getElementById('Passociation').style.display 	= "none";
		document.getElementById('Pdiscipline').style.display 	= "none";
		document.getElementById('Padresse').style.display 		= "block";
		document.getElementById('Pcp').style.display 			= "block";
		document.getElementById('Pville').style.display 		= "block";
		document.getElementById('Ppays').style.display 			= "block";
		document.getElementById('Pniveau').style.display 		= "none";
		document.getElementById('Petablissement').style.display = "none";
		break;
		case '4':
		document.getElementById('PFax').style.display 			= "block";
		document.getElementById('Pecole').style.display 		= "none";
		document.getElementById('Pcollectivite').style.display 	= "none";
		document.getElementById('Pequipement').style.display 	= "none";
		document.getElementById('PFonction').style.display 		= "none";
		document.getElementById('Pstructure').style.display 	= "block";
		document.getElementById('Pmedia').style.display 		= "none";
		document.getElementById('Passociation').style.display 	= "none";
		document.getElementById('Pdiscipline').style.display 	= "none";
		document.getElementById('Padresse').style.display 		= "block";
		document.getElementById('Pcp').style.display 			= "block";
		document.getElementById('Pville').style.display 		= "block";
		document.getElementById('Ppays').style.display 			= "block";
		document.getElementById('Pniveau').style.display 		= "none";
		document.getElementById('Petablissement').style.display = "none";
		break;
		case '6':
		document.getElementById('PFax').style.display 			= "block";
		document.getElementById('Pecole').style.display 		= "none";
		document.getElementById('Pcollectivite').style.display 	= "none";
		document.getElementById('Pequipement').style.display 	= "none";
		document.getElementById('PFonction').style.display 		= "none";
		document.getElementById('Pstructure').style.display 	= "none";
		document.getElementById('Pmedia').style.display 		= "none";
		document.getElementById('Passociation').style.display 	= "block";
		document.getElementById('Pdiscipline').style.display 	= "block";
		document.getElementById('Padresse').style.display 		= "block";
		document.getElementById('Pcp').style.display 			= "block";
		document.getElementById('Pville').style.display 		= "block";
		document.getElementById('Ppays').style.display 			= "block";
		document.getElementById('Pniveau').style.display 		= "none";
		document.getElementById('Petablissement').style.display = "none";
		break;
		case '7':
		document.getElementById('PFax').style.display 			= "none";
		document.getElementById('Pecole').style.display 		= "none";
		document.getElementById('Pcollectivite').style.display 	= "none";
		document.getElementById('Pequipement').style.display 	= "none";
		document.getElementById('PFonction').style.display 		= "none";
		document.getElementById('Pstructure').style.display 	= "none";
		document.getElementById('Pmedia').style.display 		= "none";
		document.getElementById('Passociation').style.display 	= "none";
		document.getElementById('Pdiscipline').style.display 	= "none";
		document.getElementById('Padresse').style.display 		= "block";
		document.getElementById('Pcp').style.display 			= "block";
		document.getElementById('Pville').style.display 		= "block";
		document.getElementById('Ppays').style.display 			= "block";
		document.getElementById('Pniveau').style.display 		= "none";
		document.getElementById('Petablissement').style.display = "none";
		break;
		case '8':
		document.getElementById('PFax').style.display 			= "block";
		document.getElementById('Pecole').style.display 		= "none";
		document.getElementById('Pcollectivite').style.display 	= "none";
		document.getElementById('Pequipement').style.display 	= "none";
		document.getElementById('PFonction').style.display 		= "none";
		document.getElementById('Pstructure').style.display 	= "none";
		document.getElementById('Pmedia').style.display 		= "block";
		document.getElementById('Passociation').style.display 	= "none";
		document.getElementById('Pdiscipline').style.display 	= "none";
		document.getElementById('Padresse').style.display 		= "none";
		document.getElementById('Pcp').style.display 			= "none";
		document.getElementById('Pville').style.display 		= "none";
		document.getElementById('Ppays').style.display 			= "none";
		document.getElementById('Pniveau').style.display 		= "none";
		document.getElementById('Petablissement').style.display = "none";
		break;
		case '9':
		document.getElementById('PFax').style.display 			= "block";
		document.getElementById('Pecole').style.display 		= "none";
		document.getElementById('Pcollectivite').style.display 	= "block";
		document.getElementById('Pequipement').style.display 	= "none";
		document.getElementById('PFonction').style.display 		= "block";
		document.getElementById('Pstructure').style.display 	= "none";
		document.getElementById('Pmedia').style.display 		= "none";
		document.getElementById('Passociation').style.display 	= "none";
		document.getElementById('Pdiscipline').style.display 	= "none";
		document.getElementById('Padresse').style.display 		= "none";
		document.getElementById('Pcp').style.display 			= "none";
		document.getElementById('Pville').style.display 		= "none";
		document.getElementById('Ppays').style.display 			= "none";
		document.getElementById('Pniveau').style.display 		= "none";
		document.getElementById('Petablissement').style.display = "none";
		break;
		case '10':
		document.getElementById('PFax').style.display 			= "block";
		document.getElementById('Pecole').style.display 		= "none";
		document.getElementById('Pcollectivite').style.display 	= "none";
		document.getElementById('Pequipement').style.display 	= "none";
		document.getElementById('PFonction').style.display 		= "none";
		document.getElementById('Pstructure').style.display 	= "block";
		document.getElementById('Pmedia').style.display 		= "none";
		document.getElementById('Passociation').style.display 	= "none";
		document.getElementById('Pdiscipline').style.display 	= "none";
		document.getElementById('Padresse').style.display 		= "none";
		document.getElementById('Pcp').style.display 			= "none";
		document.getElementById('Pville').style.display 		= "none";
		document.getElementById('Ppays').style.display 			= "none";
		document.getElementById('Pniveau').style.display 		= "none";
		document.getElementById('Petablissement').style.display = "none";
		break;
		case '11':
		document.getElementById('PFax').style.display 			= "block";
		document.getElementById('Pecole').style.display 		= "none";
		document.getElementById('Pcollectivite').style.display 	= "none";
		document.getElementById('Pequipement').style.display 	= "block";
		document.getElementById('PFonction').style.display 		= "block";
		document.getElementById('Pstructure').style.display 	= "none";
		document.getElementById('Pmedia').style.display 		= "none";
		document.getElementById('Passociation').style.display 	= "none";
		document.getElementById('Pdiscipline').style.display 	= "none";
		document.getElementById('Padresse').style.display 		= "block";
		document.getElementById('Pcp').style.display 			= "block";
		document.getElementById('Pville').style.display 		= "block";
		document.getElementById('Ppays').style.display 			= "block";
		document.getElementById('Pniveau').style.display 		= "none";
		document.getElementById('Petablissement').style.display = "none";
		break;
		case '13':
		document.getElementById('PFax').style.display 			= "block";
		document.getElementById('Pecole').style.display 		= "block";
		document.getElementById('Pcollectivite').style.display 	= "block";
		document.getElementById('Pequipement').style.display 	= "block";
		document.getElementById('PFonction').style.display 		= "block";
		document.getElementById('Pstructure').style.display 	= "block";
		document.getElementById('Pmedia').style.display 		= "block";
		document.getElementById('Passociation').style.display 	= "block";
		document.getElementById('Pdiscipline').style.display 	= "block";
		document.getElementById('Padresse').style.display 		= "block";
		document.getElementById('Pcp').style.display 			= "block";
		document.getElementById('Pville').style.display 		= "block";
		document.getElementById('Ppays').style.display 			= "block";
		document.getElementById('Pniveau').style.display 		= "block";
		document.getElementById('Petablissement').style.display = "block";
		break;
		default:
		document.getElementById('PFax').style.display 			= "block";
		document.getElementById('Pecole').style.display 		= "none";
		document.getElementById('Pcollectivite').style.display 	= "none";
		document.getElementById('Pequipement').style.display 	= "none";
		document.getElementById('PFonction').style.display 		= "none";
		document.getElementById('Pstructure').style.display 	= "block";
		document.getElementById('Pmedia').style.display 		= "none";
		document.getElementById('Passociation').style.display 	= "none";
		document.getElementById('Pdiscipline').style.display 	= "none";
		document.getElementById('Padresse').style.display 		= "block";
		document.getElementById('Pcp').style.display 			= "block";
		document.getElementById('Pville').style.display 		= "block";
		document.getElementById('Ppays').style.display 			= "block";
		document.getElementById('Pniveau').style.display 		= "none";
		document.getElementById('Petablissement').style.display = "none";
		break;
	}
}
function majFormProjet(id){

	switch (id){
		case '1':
		document.getElementById('PFax').style.display 			= "block";
		document.getElementById('Pecole').style.display 		= "block";
		document.getElementById('Pcollectivite').style.display 	= "none";
		document.getElementById('Pequipement').style.display 	= "none";
		document.getElementById('PFonction').style.display 		= "none";
		document.getElementById('Pstructure').style.display 	= "none";
		document.getElementById('Pmedia').style.display 		= "none";
		document.getElementById('Passociation').style.display 	= "none";
		document.getElementById('Pdiscipline').style.display 	= "none";
		document.getElementById('Padresse').style.display 		= "block";
		document.getElementById('Pcp').style.display 			= "block";
		document.getElementById('Pville').style.display 		= "block";
		document.getElementById('Ppays').style.display 			= "block";
		document.getElementById('Pniveau').style.display 		= "block";
		document.getElementById('Petablissement').style.display = "block";
		break;
		
		case '6':
		document.getElementById('PFax').style.display 			= "block";
		document.getElementById('Pecole').style.display 		= "none";
		document.getElementById('Pcollectivite').style.display 	= "none";
		document.getElementById('Pequipement').style.display 	= "none";
		document.getElementById('PFonction').style.display 		= "none";
		document.getElementById('Pstructure').style.display 	= "none";
		document.getElementById('Pmedia').style.display 		= "none";
		document.getElementById('Passociation').style.display 	= "block";
		document.getElementById('Pdiscipline').style.display 	= "block";
		document.getElementById('Padresse').style.display 		= "block";
		document.getElementById('Pcp').style.display 			= "block";
		document.getElementById('Pville').style.display 		= "block";
		document.getElementById('Ppays').style.display 			= "block";
		document.getElementById('Pniveau').style.display 		= "none";
		document.getElementById('Petablissement').style.display = "none";
		break;
		case '7':
		document.getElementById('PFax').style.display 			= "none";
		document.getElementById('Pecole').style.display 		= "none";
		document.getElementById('Pcollectivite').style.display 	= "none";
		document.getElementById('Pequipement').style.display 	= "none";
		document.getElementById('PFonction').style.display 		= "none";
		document.getElementById('Pstructure').style.display 	= "none";
		document.getElementById('Pmedia').style.display 		= "none";
		document.getElementById('Passociation').style.display 	= "none";
		document.getElementById('Pdiscipline').style.display 	= "none";
		document.getElementById('Padresse').style.display 		= "block";
		document.getElementById('Pcp').style.display 			= "block";
		document.getElementById('Pville').style.display 		= "block";
		document.getElementById('Ppays').style.display 			= "block";
		document.getElementById('Pniveau').style.display 		= "none";
		document.getElementById('Petablissement').style.display = "none";
		break;
		
		default:
		document.getElementById('PFax').style.display 			= "block";
		document.getElementById('Pecole').style.display 		= "none";
		document.getElementById('Pcollectivite').style.display 	= "none";
		document.getElementById('Pequipement').style.display 	= "none";
		document.getElementById('PFonction').style.display 		= "none";
		document.getElementById('Pstructure').style.display 	= "none";
		document.getElementById('Pmedia').style.display 		= "none";
		document.getElementById('Passociation').style.display 	= "none";
		document.getElementById('Pdiscipline').style.display 	= "none";
		document.getElementById('Padresse').style.display 		= "block";
		document.getElementById('Pcp').style.display 			= "block";
		document.getElementById('Pville').style.display 		= "block";
		document.getElementById('Ppays').style.display 			= "block";
		document.getElementById('Pniveau').style.display 		= "none";
		document.getElementById('Petablissement').style.display = "none";
		break;
		
	}
}
function majFormNewsletter(id){

	switch (id){
		case '1':
		document.getElementById('PFax').style.display 			= "block";
		document.getElementById('Pecole').style.display 		= "block";
		document.getElementById('Pcollectivite').style.display 	= "none";
		document.getElementById('Pequipement').style.display 	= "none";
		document.getElementById('PFonction').style.display 		= "none";
		document.getElementById('Pstructure').style.display 	= "none";
		document.getElementById('Pmedia').style.display 		= "none";
		document.getElementById('Passociation').style.display 	= "none";
		document.getElementById('Pdiscipline').style.display 	= "none";
		document.getElementById('Padresse').style.display 		= "block";
		document.getElementById('Pcp').style.display 			= "block";
		document.getElementById('Pville').style.display 		= "block";
		document.getElementById('Ppays').style.display 			= "block";
		document.getElementById('Pniveau').style.display 		= "block";
		document.getElementById('Petablissement').style.display = "block";
		break;
		case '7':
		document.getElementById('PFax').style.display 			= "block";
		document.getElementById('Pecole').style.display 		= "none";
		document.getElementById('Pcollectivite').style.display 	= "none";
		document.getElementById('Pequipement').style.display 	= "none";
		document.getElementById('PFonction').style.display 		= "none";
		document.getElementById('Pstructure').style.display 	= "none";
		document.getElementById('Pmedia').style.display 		= "none";
		document.getElementById('Passociation').style.display 	= "block";
		document.getElementById('Pdiscipline').style.display 	= "block";
		document.getElementById('Padresse').style.display 		= "block";
		document.getElementById('Pcp').style.display 			= "block";
		document.getElementById('Pville').style.display 		= "block";
		document.getElementById('Ppays').style.display 			= "block";
		document.getElementById('Pniveau').style.display 		= "none";
		document.getElementById('Petablissement').style.display = "none";
		break;
		case '8':
		document.getElementById('PFax').style.display 			= "none";
		document.getElementById('Pecole').style.display 		= "none";
		document.getElementById('Pcollectivite').style.display 	= "none";
		document.getElementById('Pequipement').style.display 	= "none";
		document.getElementById('PFonction').style.display 		= "none";
		document.getElementById('Pstructure').style.display 	= "none";
		document.getElementById('Pmedia').style.display 		= "none";
		document.getElementById('Passociation').style.display 	= "none";
		document.getElementById('Pdiscipline').style.display 	= "none";
		document.getElementById('Padresse').style.display 		= "block";
		document.getElementById('Pcp').style.display 			= "block";
		document.getElementById('Pville').style.display 		= "block";
		document.getElementById('Ppays').style.display 			= "block";
		document.getElementById('Pniveau').style.display 		= "none";
		document.getElementById('Petablissement').style.display = "none";
		break;
		case '9':
		document.getElementById('PFax').style.display 			= "block";
		document.getElementById('Pecole').style.display 		= "block";
		document.getElementById('Pcollectivite').style.display 	= "block";
		document.getElementById('Pequipement').style.display 	= "block";
		document.getElementById('PFonction').style.display 		= "block";
		document.getElementById('Pstructure').style.display 	= "block";
		document.getElementById('Pmedia').style.display 		= "block";
		document.getElementById('Passociation').style.display 	= "block";
		document.getElementById('Pdiscipline').style.display 	= "block";
		document.getElementById('Padresse').style.display 		= "block";
		document.getElementById('Pcp').style.display 			= "block";
		document.getElementById('Pville').style.display 		= "block";
		document.getElementById('Ppays').style.display 			= "block";
		document.getElementById('Pniveau').style.display 		= "block";
		document.getElementById('Petablissement').style.display = "block";
		break;
		default:
		document.getElementById('PFax').style.display 			= "block";
		document.getElementById('Pecole').style.display 		= "none";
		document.getElementById('Pcollectivite').style.display 	= "none";
		document.getElementById('Pequipement').style.display 	= "none";
		document.getElementById('PFonction').style.display 		= "none";
		document.getElementById('Pstructure').style.display 	= "block";
		document.getElementById('Pmedia').style.display 		= "none";
		document.getElementById('Passociation').style.display 	= "none";
		document.getElementById('Pdiscipline').style.display 	= "none";
		document.getElementById('Padresse').style.display 		= "none";
		document.getElementById('Pcp').style.display 			= "none";
		document.getElementById('Pville').style.display 		= "none";
		document.getElementById('Ppays').style.display 			= "none";
		document.getElementById('Pniveau').style.display 		= "none";
		document.getElementById('Petablissement').style.display = "none";
		break;
		
	}
}



function majFormDispo(id){
	switch (id){
			case '1':
			document.getElementById('PFax').style.display 			= "block";
			document.getElementById('Pecole').style.display 		= "block";
			document.getElementById('Passociation').style.display 	= "none";
			document.getElementById('Pdiscipline').style.display 	= "none";
			document.getElementById('Padresse').style.display 		= "block";
			document.getElementById('Pcp').style.display 			= "block";
			document.getElementById('Pville').style.display 		= "block";
			document.getElementById('Ppays').style.display 			= "block";
			document.getElementById('Pniveau').style.display 		= "block";
			document.getElementById('Petablissement').style.display = "block";
			document.getElementById('Pstructure').style.display 	= "none";
			break;
			case '7':
			document.getElementById('PFax').style.display 			= "block";
			document.getElementById('Pecole').style.display 		= "none";
			document.getElementById('Passociation').style.display 	= "block";
			document.getElementById('Pdiscipline').style.display 	= "block";
			document.getElementById('Padresse').style.display 		= "block";
			document.getElementById('Pcp').style.display 			= "block";
			document.getElementById('Pville').style.display 		= "block";
			document.getElementById('Ppays').style.display 			= "block";
			document.getElementById('Pniveau').style.display 		= "none";
			document.getElementById('Petablissement').style.display = "none";
			document.getElementById('Pstructure').style.display 	= "none";
			break;
			case '8':
			document.getElementById('PFax').style.display 			= "none";
			document.getElementById('Pecole').style.display 		= "none";
			document.getElementById('Passociation').style.display 	= "none";
			document.getElementById('Pdiscipline').style.display 	= "none";
			document.getElementById('Padresse').style.display 		= "block";
			document.getElementById('Pcp').style.display 			= "block";
			document.getElementById('Pville').style.display 		= "block";
			document.getElementById('Ppays').style.display 			= "block";
			document.getElementById('Pniveau').style.display 		= "none";
			document.getElementById('Petablissement').style.display = "none";
			document.getElementById('Pstructure').style.display 	= "none";
			break;
			default:
			document.getElementById('PFax').style.display 			= "block";
			document.getElementById('Pecole').style.display 		= "none";
			document.getElementById('Passociation').style.display 	= "none";
			document.getElementById('Pdiscipline').style.display 	= "none";
			document.getElementById('Padresse').style.display 		= "block";
			document.getElementById('Pcp').style.display 			= "block";
			document.getElementById('Pville').style.display 		= "block";
			document.getElementById('Ppays').style.display 			= "block";
			document.getElementById('Pniveau').style.display 		= "none";
			document.getElementById('Petablissement').style.display = "none";
			document.getElementById('Pstructure').style.display 	= "block";
			break;
	}
	$.fn.colorbox.resize();
}


function verif_form_avis(){
	var selectValue = getSelectValue('note');
		
	if(document.getElementById('nom').value==""){
		alert(get_trad_champ('nom'));
		document.getElementById('nom').focus();
		return false;
	}
	if(document.getElementById('email').value==""){
		alert(get_trad_champ('email'));
		document.getElementById('email').focus();
		return false;
	}
	if(!isValidEmail('email')){
		alert(get_trad_champ('email'));
		document.getElementById('email').focus();
		return false;
	}
	if(document.getElementById('commentaire').value==""){
		alert(get_trad_champ('commentaire'));
		document.getElementById('commentaire').focus();
		return false;
	}
	
	$.ajax({
	   type: "POST",
	   url: "ajax/laissez_avis.action.php",
	   data: "nom="+document.getElementById('nom').value+"&prenom="+document.getElementById('prenom').value+"&email="+document.getElementById('email').value+"&note="+selectValue+"&commentaire="+document.getElementById('commentaire').value+"&userCode="+document.getElementById('userCode').value+"&id_centre="+document.getElementById('id_centre').value,
	   success: function(msg){
	   	tab = msg.split('|');
	     if(tab[1] != "BAD_CAPTCHA"){
	     	document.getElementById("form_avis").innerHTML=tab[1];
	     }else{
	     	alert(get_trad_champ('bad_captcha'));
	     }
	     
	   }
	 });
	
}

/**Retourne la valeur du select selectId*/
function getSelectValue(selectId)
{
	/**On récupère l'élement html <select>*/
	var selectElmnt = document.getElementById(selectId);
	/**
	selectElmt.options correspond au tableau des balises <option> du select
	selectElmt.selectedIndex correspond à l'index du tableau options qui est actuellement sélectionné
	*/
	//alert(selectElmnt);
	//alert(selectElmnt.options[selectElmnt.selectedIndex].value);
	return selectElmnt.options[selectElmnt.selectedIndex].value;
}

function RemplirInpurRecherche(obj,text){
	if(obj.value==""){
		obj.value=text;
	}
}
function ViderInpurRecherche(obj,text){
	if(obj.value==text){
		obj.value="";
	}
}

function VerifCodePreprod(){
	$.ajax({
	   type: "POST",
	   url: "ajax/VerifCodePreprod.action.php",
	   data: "login="+document.getElementById('login').value+"&passe="+document.getElementById('passe').value,
	   success: function(msg){
	 
	   	tab = msg.split('|');
	     if(tab[1] == "KO"){
	     	alert("Identification échouée.");
	     }else{
	     	//alert("OK")
	     	var url = "index.php?Rub=1";    
			$(location).attr('href',url);

	     	document.getElementById('identification').submit();
	     }
	   }
	 });
}

function VerifFormInscriptionPresse(){
  if(document.getElementById('nom_media').value == ""){
    alert(get_trad_champ('media'));
    return;
  }
  
   if($("input[type=radio][name=type_media]").is(':checked') == false){
    alert(get_trad_champ('type_media'));
    return;
  }
  
  var ischecked = 0;
  $("input[type=checkbox][name=types_public[]][checked]").each( 
    function() { 
      ischecked++
    } 
  );
  
  if(ischecked<=0){
    alert(get_trad_champ('types_public'));
    return;
  }
  
  if($("input[type=radio][name=civilite]").is(':checked') == false){
    alert(get_trad_champ('civilite'));
    return;
  }
  
  if(document.getElementById('nom_contact').value == ""){
    alert(get_trad_champ('nom'));
    return;
  }
  
  if(document.getElementById('fonction').value == ""){
    alert(get_trad_champ('fonction'));
    return;
  }
  
  if(document.getElementById('email').value == "" || !isValidEmail('email')){
    alert(get_trad_champ('email'));
    return;
  }
   if(document.getElementById('telephone').value == ""){
    alert(get_trad_champ('tel'));
    return;
  }
  
  document.getElementById('formPresse').submit();
}