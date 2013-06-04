function make_point(isParis,coord_x,coord_y){


	var form = document.getElementById('formulaire');


	form.field_flash_y.value=coord_y;
	form.field_flash_x.value=coord_x;
	form.field_flash_paris.value=isParis;

}



function Verif_checkbox(ObjName,maxchecked,obj,texte){

	checked = false;
	name = '';
	nb = 0;

	jQuery(":checkbox[@name='" + ObjName + "']").each(

	function(intIndex)
	{
		checkbox = jQuery(this);

		if(checkbox.attr('name') == ObjName && this.checked == true){
			nb ++;

		}
		if(nb>maxchecked){
			obj.checked = false;
			alert("Vous ne pouvez pas selectionner plus de "+maxchecked+" "+texte);
			return false;
		}
	});


}


function valid_form_plus_retour(ancre,tableId){

	/*
	if(tableId == 512){
	if( ! validFormCentre(1) ){
	return false;
	}
	}
	if(tableId == 537){
	if( ! validFormClasseDecouverte(1) ){
	return false;
	}
	}
	if(tableId == 538){
	if( ! validFormAccueilScolaire(1) ){
	return false;
	}
	}

	if(tableId == 539){
	if( ! validFormCVL(1) ){
	return false;
	}
	}
	if(tableId == 540){
	if( ! validFormAccueilReunion(1) ){
	return false;
	}
	}

	if(tableId == 541){
	if( ! validFormSeminaires(1) ){
	return false;
	}
	}

	if(tableId == 542){
	if( ! validFormAccueilGroupes(1) ){
	return false;
	}
	}

	if(tableId == 545){
	if( ! validFormSejourTouristique(1) ){
	return false;
	}
	}

	if(tableId == 547){
	if( ! validFormSejourStageThemGroupe(1) ){
	return false;
	}
	}
	if(tableId == 549){
	if( ! validFormSejourAccueilIndFamille(1) ){
	return false;
	}
	}
	if(tableId == 553){
	if( ! validFormShortBreaksInd(1) ){
	return false;
	}
	}
	if(tableId == 555){
	if( ! validFormStageThemIndividuel(1) ){
	return false;
	}
	}
	*/
	document.getElementById('ancreId').value=ancre;
	document.formulaire.submit();


}

function  valid_form() {
	if (verif_fields()==true)	{
		if(document.getElementById('url_retour')!= null){
			document.getElementById('url_retour').value="";
		}

		var form = document.getElementById('formulaire');
		if(form.field_etat!=null){
			form.field_etat.checked = true;
		}


		document.formulaire.submit();
	}
}


function Annuler_form(url,mode){
	if(mode != "supr"){

		if(confirm('Voulez vous annuler ?\nAttention, vos données non sauvegardée seront perdues.')){
			document.location.href =url;
		}
	}else{
		document.location.href =url;
	}
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
	window.open(theURL,winName,features);
}

function JustSoPicWindow(imageName,imageWidth,imageHeight,alt,bgcolor,hugger,hugMargin) {
	// by E Michael Brandt of ValleyWebDesigns.com - Please leave these comments intact.
	// version 2.2.3

	alt=alt+"  ** Cliquez pour fermer **"
	if (bgcolor=="") {
		bgcolor="#FFFFFF";
	}
	var adj=10
	var w = screen.width;
	var h = screen.height;
	var byFactor=1;

	if(w<740){
		var lift=0.90;
	}
	if(w>=740 & w<835){
		var lift=0.91;
	}
	if(w>=835){
		var lift=0.93;
	}
	if (imageWidth>w){
		byFactor = w / imageWidth;
		imageWidth = w;
		imageHeight = imageHeight * byFactor;
	}
	if (imageHeight>h-adj){
		byFactor = h / imageHeight;
		imageWidth = (imageWidth * byFactor);
		imageHeight = h;
	}

	var scrWidth = w-adj;
	var scrHeight = (h*lift)-adj;

	if (imageHeight>scrHeight){
		imageHeight=imageHeight*lift;
		imageWidth=imageWidth*lift;
	}

	var posLeft=0;
	var posTop=0;

	if (hugger == "hug image"){
		if (hugMargin == ""){
			hugMargin = 0;
		}
		var scrHeightTemp = imageHeight - 0 + 2*hugMargin;
		if (scrHeightTemp < scrHeight) {
			scrHeight = scrHeightTemp;
		}
		var scrWidthTemp = imageWidth - 0 + 2*hugMargin;
		if (scrWidthTemp < scrWidth) {
			scrWidth = scrWidthTemp;
		}

		if (scrHeight<100){scrHeight=100;}
		if (scrWidth<100){scrWidth=100;}

		posTop =  ((h-(scrHeight/lift)-adj)/2);
		posLeft = ((w-(scrWidth)-adj)/2);
	}

	if (imageHeight > (h*lift)-adj || imageWidth > w-adj){
		imageHeight=imageHeight-adj;
		imageWidth=imageWidth-adj;
	}

	var agt=navigator.userAgent.toLowerCase();
	if (agt.indexOf("opera") != -1){
		var args= new Array();
		args[0]='parent';
		args[1]=imageName;
		var i ; //document.MM_returnValue = false;
		for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
	} else {
		newWindow = window.open("view.html","newWindow","width="+scrWidth+",height="+scrHeight+",left="+posLeft+",top="+posTop);
		newWindow.focus();
		if(navigator.appVersion.charAt(0) >=4) {

			//			if (Scroll == 1)
			//			{
			//				for(width1 = 1 ; width1 < posLeft ; width1 = width1 + 3) {
			//					newWindow.moveTo(width1,posTop);
			//				}
			//			}
			//			else {
			newWindow.moveTo(posLeft,posTop);
			//			}

		}

		newWindow.document.open();
		newWindow.document.write('<html><title>'+alt+'</title><body leftmargin="0" topmargin="0" marginheight="0" marginwidth="0" bgcolor='+bgcolor+' onBlur="self.close()" onClick="self.close()">');
		newWindow.document.write('<table width='+imageWidth+' border="0" cellspacing="0" cellpadding="0" align="center" height='+scrHeight+' ><tr><td>');
		newWindow.document.write('<img src="'+imageName+'" width='+imageWidth+' height='+imageHeight+' alt="Cliquez pour fermer" >');
		newWindow.document.write('</td></tr></table></body></html>');
		newWindow.document.close();
		newWindow.focus();

	}
}

function ConfirmDelete(url) {
	if (confirm('Supprimer tout le contenu de la base.')) {
		document.location.href = url + '?DeleteDatabase=1';
	}
}


function ConfirmEmptyTable(url) {
	if (confirm('Supprimer tout le contenu de la table.')) {
		document.location.href = url;
	}
}


function ItemOn(LinkObject, Color, FontSize, NbCol) {

	//	document.all["TDid"+x].style.fontWeight = "bold";
	//	document.all["TDid"+x].style.fontSize = eval(parseInt(FontSize)+1) + "px";

	for (i=0;i<parseInt(NbCol);i++){
		//		var TDid = "TDid_C"+i+"_L"+x;
		LinkObject.style.color = "white";
		LinkObject.style.backgroundColor = Color;

		//		LinkObject.style.background='rgb(122,187,255)';
		//		LinkObject.style.border='solid';
		//		LinkObject.style.borderWidth='1px';
		//		LinkObject.style.borderColor='rgb(49,106,197)';

	}
}

function ItemOff(LinkObject, Color, FontSize, NbCol) {
	for (i=0;i<parseInt(NbCol);i++){
		//		var TDid = "TDid_C"+i+"_L"+x;
		LinkObject.style.color = Color;
		LinkObject.style.backgroundColor = Color;
	}
}


//08/08/2002
//Prmet d'intercepter les erreurs javascript dans un fichier
function DisableError() {
	return true;
}


function show_item(item)
{
	if (document.all[item].style.display=="block")
	{ document.all[item].style.display="none"; }
	else
	{ document.all[item].style.display="block"; }
}


function MM_swapImgRestore() { //v3.0
	var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}


function MM_swapImage() { //v3.0
	var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
	if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}


function MM_findObj(n, d) { //v4.01
	var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
		d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
		if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
		for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
		if(!x && d.getElementById) x=d.getElementById(n); return x;
}


function switch_picture(item, picture) {
	if (picture.substring(picture.length-5,picture.length)=='n.gif') {
		item.src = picture.substring(0,picture.length-6)+"off.gif";
	}
	else {
		item.src = picture.substring(0,picture.length-7)+"on.gif";
	}
	for (i=0;i<450000;i++) {

	}
}

// Fonction d'extraction des paramètres
function TJSExtraireParam() {
	url = window.location.href;
	var exp=new RegExp("[&?]+","g");
	var exp2=new RegExp("[=]+","g");
	var tabNom=url.split(exp);
	var	tabParam=new Array();
	if (tabNom!=null) {
		for (var i=1;i<tabNom.length;i++){
			var tabTemp=tabNom[i].split(exp2);
			tabParam[tabTemp[0]]=tabTemp[1];
		}
	}
	return tabParam;
}
// Appel de la fonction et création du tableau des paramètres
var urlParam = TJSExtraireParam();


function fieldEffect(item,color) {
	//	if (this.focus)
	//	{
	item.style.backgroundColor=color;
	//	}

}


//PERMET DE FAIRE LES MISE A JOUR A PARTIR DU MODE POPUP
function JS_update_listbox_from_popup(MODE, FIELD_DEST_NAME, NEW_NAME, ID_SOURCE) {

	itemReloaded = eval("opener.document.getElementById(FIELD_DEST_NAME)");
	if(itemReloaded == null){
		alert("Votre modification a bien été prise en compte.\nElle ne sera visible seulement après la validation du formulaire principal.")
		//  window.opener.location.reload();
	}
	////////////////////////////////////////////////////
	if (MODE=="nouveau") {

		itemReloaded.length = itemReloaded.length+1;

		itemReloaded.options[itemReloaded.length-1].text = NEW_NAME;
		itemReloaded.options[itemReloaded.length-1].value = ID_SOURCE;


		//si ce n'est pas une liste multiple on pre-selectionne l'element ajoute
		//if (!itemReloaded.multiple)	{
		itemReloaded.options[itemReloaded.length-1].selected = true;
		//}

		window.close();
	}
	////////////////////////////////////////////////////
	else if (MODE=="modif"){

		for (i=0; i<itemReloaded.length;i++) {
			if (itemReloaded.options[i].value==ID_SOURCE) {
				itemReloaded.options[i].text = NEW_NAME;
			}
		}
	}
	////////////////////////////////////////////////////
	else if (MODE=="supr") {
		ar_id		= new Array();
		ar_nom		= new Array();
		ar_select	= new Array();


		mon_index = 0;
		for (i=0; i<itemReloaded.length;i++) {
			if (itemReloaded.options[i].value!=ID_SOURCE) {
				ar_id[mon_index] = itemReloaded.options[i].value;
				ar_nom[mon_index] = itemReloaded.options[i].text;

				//On test les elements deja selectionne
				if (itemReloaded.options[i].selected) {
					ar_select[mon_index] = 1;
				}
				else {
					ar_select[mon_index] = 0;
				}

				mon_index++;
			}
		}

		itemReloaded.length = itemReloaded.length - 1;

		for (i=0; i<ar_id.length;i++) {
			itemReloaded.options[i].value = ar_id[i];
			itemReloaded.options[i].text = ar_nom[i];
			if (ar_select[i] == 1) {
				itemReloaded.options[i].selected = true;
			}
		}
	}
	////////////////////////////////////////////////////
}


function switch_img(me) {

	path = String(me.src);

	//alert(path.substring(path.length-8,path.length));

	if (path.substring(path.length-8,path.length)=='plus.gif') {
		me.src = "images/moins.gif";
	}
	else {
		me.src = "images/plus.gif";
	}

}

function openSelection(table,lib_champs) {
	actu = document.FormDetailTable.elements[lib_champs].value;

	window.open("include/inc_list_mutli_champ.inc.php?TableSelect="+table+"&lib_champs="+lib_champs+"&actu_champs="+actu,"","toolbar=no,directories=no,menubar=no,scrollbars=yes,resizable=no,width=300,height=300");
}

//*************************************************//
//******* 10/09/2007-MVA***************************//
//******* SPECIF-ONGLETS DE TRADUCTION ************//
//*************************************************//

function highlight(param, divToShow)
{


	var tabsDiv = param.parentNode.parentNode.parentNode;


	// Affiche la bonne tab
	for(j=0; j<tabsDiv.childNodes.length; j++)
	{

		a=tabsDiv.childNodes[j].childNodes;
		for(i=0; i<a.length; i++)

		if (a[i].className) a[i].className="";
	}

	param.parentNode.className="active";

	// Affiche le bon contenu
	for (j=0; j<tabsDiv.parentNode.childNodes.length; j++)
	{
		b=tabsDiv.parentNode.childNodes[j];
		a=b.childNodes;
		if (b.id && b.id.indexOf("ctrl")>-1)
		for(i=0; i<a.length; i++)
		{
			a[i].style.display=(a[i].id==divToShow)?"block":"none";
		}
	}
	return false;
}
function getElementByIdOrName(nameOrId){
	if(! document.getElementById(nameOrId))
	return document.getElementsByName(nameOrId)[0];
	else
	return document.getElementById(nameOrId);
}


//*************************************************//
// SPEC ETHIC ETAPES BY TLY						  *//
//*************************************************//
function updateFormJQ(selectId,addedId,img)  // selectId => select clické, addedId => img ajouté dans le portfolio
{
	$(" .allSelectPortfolio").each(function(){

		var mySelectVal = $("option:selected", this).val();
		var mySelect = $(this);
		$.ajax({
			type: "post",
			data: "id="+$(this).attr("id")+"&val="+mySelectVal,
			url: "ajax/updatePortfolio.php",
			success: function(msg){
				mySelect.html(msg);
				var exp ="$(\"#"+selectId+" option[value="+addedId+"]\").attr('selected', 'selected');"//	alert(exp);
				eval(exp);
				var imgExp = "$(\"#img_portfolio_preview_"+selectId+"\").attr('src','../images/upload/portfolio_img/"+img+"');";
				eval(imgExp);
			}
		});

		//			JS_change_portfolio_preview("../images/upload/portfolio_img/",$(this),"img_portfolio_preview_"+$(this).attr("id"));
	});



}

function PopupClose()
{
	window.close();
}



function additionne(id){

	document.getElementById("nb_chambre_"+id).value = parseInt(document.getElementById("nb_lavDouWC_chambre_"+id).value) +
	parseInt(document.getElementById("nb_lavDou_chambre_"+id).value) +
	parseInt(document.getElementById("nb_lavOuWC_chambre_"+id).value) +
	parseInt(document.getElementById("nb_noWC_chambre_"+id).value);


	document.getElementById("nb_lit_"+id).value =     parseInt(document.getElementById("nb_lavDouWC_lit_"+id).value) +
	parseInt(document.getElementById("nb_lavDou_lit_"+id).value) +
	parseInt(document.getElementById("nb_lavOuWC_lit_"+id).value) +
	parseInt(document.getElementById("nb_noWC_lit_"+id).value);

	document.forms.formulaire.field_nb_chambre.value     =    parseInt(document.getElementById("nb_chambre_1").value) +
	parseInt(document.getElementById("nb_chambre_2").value) +
	parseInt(document.getElementById("nb_chambre_3").value) +
	parseInt(document.getElementById("nb_chambre_4").value) +
	parseInt(document.getElementById("nb_chambre_5").value) +
	parseInt(document.getElementById("nb_chambre_6").value) +
	parseInt(document.getElementById("nb_chambre_7").value) +
	parseInt(document.getElementById("nb_chambre_8").value);


	document.forms.formulaire.field_nb_lit.value     =  parseInt(document.getElementById("nb_lit_1").value) +
	parseInt(document.getElementById("nb_lit_2").value) +
	parseInt(document.getElementById("nb_lit_3").value) +
	parseInt(document.getElementById("nb_lit_4").value) +
	parseInt(document.getElementById("nb_lit_5").value) +
	parseInt(document.getElementById("nb_lit_6").value) +
	parseInt(document.getElementById("nb_lit_7").value) +
	parseInt(document.getElementById("nb_lit_8").value);


}


/* ======================================================================================*/
/*							 CONTROLES FORMULAIRES										 */
/* ======================================================================================*/


/* ======================================================================================*/
/*							 FONCTIONS G�N�RIQUES										 */
/* ======================================================================================*/
String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g,"");
}


//-------------------------------------
// Messages d erreurs
//-------------------------------------
function get_trad_champ_bo(champ,table)  // centre par defaut
{
	if(table == "" ) table = "centre";
	var text = "Attention, votre "+table+" ne sera publié que lorsque les champs obligatoires seront remplis.\n";

	switch(champ)
	{
		//CENTRE
		case "field_libelle" : return(text+" Nom du centre obligatoire"); break;
		//case "field_logo" : return(text+" Logo obligatoire"); break;
		case "field_id_centre_environnement" : return(text+" Vous devez choisir un environnement du centre"); break;
		case "field_adresse" : return(text+" Adresse obligatoire"); break;
		case "field_code_postal" : return(text+" Code postal obligatoire"); break;
		case "field_ville" : return(text+" Ville obligatoire"); break;
		case "field_latitude" : return(text+" Latitude obligatoire"); break;
		case "field_longitude" : return(text+" Longiture obligatoire"); break;
		case "field_telephone_1" : return(text+" Téléphone obligatoire"); break;
		case "field_fax_1" : return(text+" Fax obligatoire"); break;
		case "field_id_centre_region" : return(text+" Vous devez sélectionner une région"); break;
		case "field_email" : return(text+" Email obligatoire"); break;
		case "field_acces_route_4" : return(text+" Accès par route ?"); break;
		case "field_acces_train_4" : return(text+" Accès par train ?"); break;
		case "field_acces_avion_4" : return(text+" Accès par avion ?"); break;
		case "field_acces_bus_metro_4" : return(text+" Accès par bus metro ?"); break;
		case "field_presentation_1" : return(text+" Présentation rapide obligatoire"); break;
		case "field_presentation_region_1" : return(text+" Présentation de la région obligatoire"); break;
		//case "field_id_centre_classement" : return(text+" Confort Services"); break;
		//case "field_id_centre_classement_1" : return(text+" Environnement et activités"); break;
		case "field_nb_chambre" : return(text+" Nombre de chambres obligatoire"); break;
		case "field_nb_lit" : return(text+" Nombre de lits obligatoire"); break;
		case "field_nb_chambre_handicap" : return(text+" Nombre de chambre handicap obligatoire"); break;
		case "field_nb_lit_handicap" : return(text+" Nombre de lits handicap obligatoire"); break;
		case "field_nb_couvert" : return(text+" Nombre de couverts obligatoire"); break;
		case "field_nb_salle_reunion" : return(text+" Nombre de salles de réunion obligatoire"); break;
		case "field_capacite_salle_min" : return(text+" Capacité minimale de la salle obligatoire"); break;
		case "field_capacite_salle_max" : return(text+" Capacité maximale de la salle obligatoire"); break;
		case "field_agrement_edu_nationale_4" : return(text+" Education nationale ?"); break;
		case "field_agrement_jeunesse_4" : return(text+" Jeunesse et sport à renseigner"); break;
		case "field_agrement_tourisme_4" : return(text+" Tourisme à renseigner"); break;
		case "field_agrement_ddass_4" : return(text+" DDASS à renseigner"); break;
		case "field_agrement_formation_4" : return(text+" Formation à renseigner"); break;
		case "field_agrement_ancv_4" : return(text+" ANCV à renseigner"); break;
		case "field_agrement_autre_4" : return(text+" Autre à renseigner"); break;
		case "field_presentation_region_1" : return(text+" Présentation de la région obligatoire"); break;
		//case "field_idCentre" : return(text+" IdCentre obligatoire"); break;

		//organisateurCVL
		case "field_libelle_1" : return(text+" Organisateur CVL obligatoire"); break;
		case "field_id_centre" : return(text+" Centre obligatoire"); break;
		case "field_presentation_organisme_1" : return(text+" Présentation organisme obligatoire");break;
		case "field_projet_educatif_1" : return(text+" Projet éducatif obligatoire");break;
		case "field_id_sejour_thematique" : return(text+" Thématique des séjours obligatoire");break;
		case "field_id_participant_age" : return(text+" Age des participants obligatoire");break;
		case "field_telephone" : return(text+" Téléphone obligatoire");break;
		case "field_fax" : return(text+" Fax obligatoire");break;
		case "field_visuel" : return(text+" Visuel obligatoire");break;

		//Classe decouverte
		case "field_nom" : return(text+" Nom du séjour obligatoire");break;
		case "field_id_sejour_theme" : return(text+" Thème obligatoire");break;
		case "field_id_sejour_niveau_scolaire" : return(text+" Niveau scolaire obligatoire");break;
		case "field_duree_sejour_1" : return(text+" Durée du séjour obligatoire");break;
		case "field_id_sejour_periode_disponibilite" : return(text+" Période de disponibilité du séjour obligatoire");break;
		case "field_id_sejour_nb_lit__par_chambre" : return(text+" Nombre de lits par chambre obligatoire");break;
		case "field_a_partir_de_prix" : return(text+" Prix obligatoire");break;
		case "field_prix_par_29" : return(text+" Choix obligatoire");break;
		case "field_prix_comprend_1" : return(text+"\n'Le prix comprend' est obligatoire");break;
		case "field_prix_ne_comprend_pas_1" : return(text+"\n'Le prix ne comprend pas' est obligatoire");break;
		case "field_interet_pedagogique_1" : return(text+" Intérêt pédagogique obligatoire");break;
		case "field_details_1" : return(text+" Détails obligatoire");break;


		//Accueil groupe scolaire
		case "HS_rs" : return(text+" Au moins 1 tarif haute saison obligatoire");break;
		case "HS_rs_n" : return(text+" Au moins 1 tarif haute saison obligatoire");break;
		//case "field_id_sejour_nb_lit__par_chambre" : return(text+" Type d'hébergement obligatoire");break;
		case "field_conditions_scolaires" : return(text+" Conditions scolaires obligatoire");break;
		case "field_gratuite_chauffeur_4" : return(text+" Choix obligatoire");break;
		case "field_gratuite_accompagnateur_4" : return(text+" Choix obligatoire");break;

		//Accueil de reunions
		case "field_id_sejour_materiel_service" : return(text+" Choix obligatoire");break;

		//Seminaire
		case "field_id_sejour_theme_seminaire" : return(text+" Thème obligatoire");break;
		case "field_descriptif_1" : return(text+" Descriptif obligatoire");break;

		//Sejours touristiques
		case "field_nom_sejour_1" : return(text+" Titre du séjour obligatoire");break;
		case "field_id_sejour_duree" : return(text+" Durée du séjour obligatoire");break;
		case "field_adapte_IME_IMP_4" : return(text+" Choix obligatoire");break;

		//stage thematiques groupes
		case "field_nom_stage_1" : return(text+"\nLe titre du séjour est obligatoire");break;
		case "field_id_sejour_stage_theme" : return(text+" Thème obligatoire");break;

		//Short breaks ind
		case "field_nom_1" : return(text+"\nLe titre du séjour est obligatoire");break;
		case "field_id_sejour_short_break_theme" : return(text+" Thème obligatoire");break;

		case "field_visuel_1" : return(text+" Il faut au moins une image obligatoire");break;
		default : return(champ);
	}
	return false;
}


//-------------------------------------
// Test criteres form
//-------------------------------------
//---test champ obligatoire
function testObl(fieldValue,fieldName,offset,table)
{
	if(fieldValue.trim()=="")
	{
		inlineMsg(fieldName,get_trad_champ_bo(fieldName,table),2,offset);
		alert(get_trad_champ_bo(fieldName,table));
		return false;
	}
	else
	{
		return true
	}
}


function testSelectObl(fieldValue,fieldName,offset,table)
{
	if(fieldValue.trim()=="" || fieldValue.trim()=="-1")
	{
		inlineMsg(fieldName,get_trad_champ_bo(fieldName,table),2,offset);
		alert(get_trad_champ_bo(fieldName,table));
		return false;
	}
	else
	{
		return true
	}
}

function getNbCaseCochees(nameElement)
{
	var nbTotal = document.getElementsByName(nameElement).length;
	var nbCaseCochees = 0;
	for(var i=0;i<nbTotal;i++)
	{
		if(document.getElementsByName(nameElement)[i].checked)
		{
			nbCaseCochees++;
		}
	}
	return nbCaseCochees;
}

/* ======================================================================================*/
// Validation
/* ======================================================================================*/
//---------------------
// Form centre
//--------------------
function validFormCentre(testId)
{
	var form = document.getElementById('formulaire');
	if(form.field_etat!=null){
		form.field_etat.checked = true;
	}




	//===================================
	// Valeurs du formulaire
	//===================================
	//text - divers text
	var field_libelle = form.field_libelle.value;
	//var field_logo = form.field_logo_port.value; //	var field_logo = form.field_logo.value;

	//radio - checkbox
	var nb_CentresEnvironnement = getNbCaseCochees("field_id_centre_environnement[]");

	//text - divers text
	var field_adresse = form.field_adresse.value;
	var field_code_postal  = form.field_code_postal.value;
	var field_ville = form.field_ville.value;
	//	var field_paris_arrondissement_1 = form.field_paris_arrondissement_1.value;
	var field_latitude = form.field_latitude.value;
	var field_longitude = form.field_longitude.value;
	var field_telephone_1 = form.field_telephone_1.value;
	var field_fax_1 = form.field_fax_1.value;
	var field_tel_resa_1 = form.field_tel_resa_1.value;
	var field_fax_resa_1  = form.field_fax_resa_1.value;
	var field_id_centre_region = form.field_id_centre_region.value;
	var field_email  = form.field_email.value;

	//radio - checkbox
	var nb_AccesRoute = getNbCaseCochees("field_acces_route_4[]");
	var nb_AccesTrain = getNbCaseCochees("field_acces_train_4[]");
	var nb_AccesAvion = getNbCaseCochees("field_acces_avion_4[]");
	var nb_AccesBusMetro = getNbCaseCochees("field_acces_bus_metro_4[]");

	//text - divers text
	var field_presentation_1  = form.field_presentation_1.value;
	var field_presentation_region_1 = form.field_presentation_region_1.value;
	//	var field_id_centre_classement = form.field_id_centre_classement.value;
	//	var field_id_centre_classement_1 = form.field_id_centre_classement_1.value;
	var field_nb_chambre = form.field_nb_chambre.value;
	var field_nb_lit = form.field_nb_lit.value;
	var field_nb_chambre_handicap = form.field_nb_chambre_handicap.value;
	var field_nb_lit_handicap = form.field_nb_lit_handicap.value;
	var field_nb_couvert = form.field_nb_couvert.value;
	var field_nb_salle_reunion = form.field_nb_salle_reunion.value;
	var field_capacite_salle_min = form.field_capacite_salle_min.value;
	var field_capacite_salle_max = form.field_capacite_salle_max.value;

	//radio - checkbox
	var nb_EduNationale = getNbCaseCochees("field_agrement_edu_nationale_4[]");
	var nb_Jeunesse = getNbCaseCochees("field_agrement_jeunesse_4[]");
	var nb_Tourisme = getNbCaseCochees("field_agrement_tourisme_4[]");
	var nb_DDASS = getNbCaseCochees("field_agrement_ddass_4[]");
	var nb_Formation = getNbCaseCochees("field_agrement_formation_4[]");
	var nb_ANCV = getNbCaseCochees("field_agrement_ancv_4[]");
	var nb_Autres = getNbCaseCochees("field_agrement_autre_4[]");

	var field_presentation_region_1  = form.field_presentation_region_1.value;
	//	var field_idCentre  = form.field_idCentre.value;

	//=============================================
	//controles des champs dans l'ordre d'affichage
	//=============================================
	if(!testObl(field_libelle,"field_libelle",-132,"centre")) { document.formulaire.elements["field_libelle"].focus(); return false;}
	//if(!testObl(field_logo,"field_logo",150,"centre"))  { document.getElementById('field_logo').focus(); return false;}
	if(nb_CentresEnvironnement==0){inlineMsg("field_id_centre_environnement.0",get_trad_champ_bo("field_id_centre_environnement","centre"),2,300); document.getElementById('field_id_centre_environnement.0').focus();return false;}
	if(!testObl(field_adresse,"field_adresse",-132,"centre")) { document.formulaire.elements["field_adresse"].focus(); return false;}
	if(!testObl(field_code_postal,"field_code_postal",-132,"centre")) { document.formulaire.elements["field_code_postal"].focus(); return false;}
	if(!testObl(field_ville,"field_ville",-132,"centre")) { document.formulaire.elements["field_ville"].focus(); return false;}
	//	if(!testObl(field_paris_arrondissement_1,"field_paris_arrondissement_1",3)) { document.formulaire.elements["field_paris_arrondissement_1"].focus(); return false;}
	if(!testObl(field_latitude,"field_latitude",-132,"centre")) { document.formulaire.elements["field_latitude"].focus(); return false;}
	if(!testObl(field_longitude,"field_longitude",-132,"centre")) { document.formulaire.elements["field_longitude"].focus(); return false;}
	if(!testObl(field_telephone_1,"field_telephone_1",3,"centre")) { document.formulaire.elements["field_telephone_1"].focus(); return false;}
	if(!testObl(field_fax_1,"field_fax_1",3,"centre")) { document.formulaire.elements["field_fax_1"].focus(); return false;}
	//	if(!testObl(field_tel_resa_1,"field_tel_resa_1",3,"centre")) { document.formulaire.elements["field_tel_resa_1"].focus(); return false;}
	//	if(!testObl(field_fax_resa_1,"field_fax_resa_1",3,"centre")) { document.formulaire.elements["field_fax_resa_1"].focus(); return false;}
	if(!testSelectObl(field_id_centre_region,"field_id_centre_region",-132,"centre")) { document.formulaire.elements["field_id_centre_region"].focus(); return false;}
	if(!testObl(field_email,"field_email",-132,"centre")) { document.formulaire.elements["field_email"].focus(); return false;}
	if(nb_AccesRoute==0){inlineMsg("field_acces_route_4[]",get_trad_champ_bo("field_acces_route_4","centre"),2,300); document.getElementById('field_acces_route_4[]').focus();return false;}
	if(nb_AccesTrain==0){inlineMsg("field_acces_train_4[]",get_trad_champ_bo("field_acces_train_4","centre"),2,300); document.getElementById('field_acces_train_4[]').focus();return false;}
	if(nb_AccesAvion==0){inlineMsg("field_acces_avion_4[]",get_trad_champ_bo("field_acces_avion_4","centre"),2,300); document.getElementById('field_acces_avion_4[]').focus();return false;}
	if(nb_AccesBusMetro==0){inlineMsg("field_acces_bus_metro_4[]",get_trad_champ_bo("field_acces_bus_metro_4","centre"),2,300); document.getElementById('field_acces_bus_metro_4[]').focus();return false;}
	if(!testObl(field_presentation_1,"field_presentation_1",-133,"centre")) { document.getElementById('t_field_presentation_1').focus(); return false;}
	if(!testObl(field_presentation_region_1,"field_presentation_region_1",-133,"centre")) { document.getElementById('t_field_presentation_region_1').focus(); return false;}
	//	if(!testSelectObl(field_id_centre_classement,"field_id_centre_classement",-132,"centre")) { document.formulaire.elements["field_id_centre_classement"].focus(); return false;}
	//	if(!testSelectObl(field_id_centre_classement_1,"field_id_centre_classement_1",-132,"centre")) { document.formulaire.elements["field_id_centre_classement_1"].focus(); return false;}
	if(!testObl(field_nb_chambre,"field_nb_chambre",-132,"centre")) { document.formulaire.elements["field_nb_chambre"].focus(); return false;}
	if(!testObl(field_nb_lit,"field_nb_lit",-132,"centre")) { document.formulaire.elements["field_nb_lit"].focus(); return false;}
	if(!testObl(field_nb_chambre_handicap,"field_nb_chambre_handicap",-132,"centre")) { document.formulaire.elements["field_nb_chambre_handicap"].focus(); return false;}
	if(!testObl(field_nb_lit_handicap,"field_nb_lit_handicap",-132,"centre")) { document.formulaire.elements["field_nb_lit_handicap"].focus(); return false;}
	if(!testObl(field_nb_couvert,"field_nb_couvert",-132,"centre")) { document.formulaire.elements["field_nb_couvert"].focus(); return false;}
	if(!testObl(field_nb_salle_reunion,"field_nb_salle_reunion",-132,"centre")) { document.formulaire.elements["field_nb_salle_reunion"].focus(); return false;}
	if(!testObl(field_capacite_salle_min,"field_capacite_salle_min",-132,"centre")) { document.formulaire.elements["field_capacite_salle_min"].focus(); return false;}
	if(!testObl(field_capacite_salle_max,"field_capacite_salle_max",-132,"centre")) { document.formulaire.elements["field_capacite_salle_max"].focus(); return false;}
	if(nb_EduNationale==0){inlineMsg("field_agrement_edu_nationale_4[]",get_trad_champ_bo("field_agrement_edu_nationale_4","centre"),2,300); document.getElementById('field_agrement_edu_nationale_4[]').focus();return false;}
	if(nb_Tourisme==0){inlineMsg("field_agrement_tourisme_4[]",get_trad_champ_bo("field_agrement_tourisme_4","centre"),2,300); document.getElementById('field_agrement_tourisme_4[]').focus();return false;}
	if(nb_DDASS==0){inlineMsg("field_agrement_ddass_4[]",get_trad_champ_bo("field_agrement_ddass_4","centre"),2,300); document.getElementById('field_agrement_ddass_4[]').focus();return false;}
	if(nb_Formation==0){inlineMsg("field_agrement_formation_4[]",get_trad_champ_bo("field_agrement_formation_4","centre"),2,300); document.getElementById('field_agrement_formation_4[]').focus();return false;}
	if(nb_ANCV==0){inlineMsg("field_agrement_ancv_4[]",get_trad_champ_bo("field_agrement_ancv_4","centre"),2,300); document.getElementById('field_agrement_ancv_4[]').focus();return false;}
	if(nb_Autres==0){inlineMsg("field_agrement_autre_4[]",get_trad_champ_bo("field_agrement_autre_4","centre"),2,300); document.getElementById('field_agrement_autre_4[]').focus();return false;}
	if(!testObl(field_presentation_region_1,"field_presentation_region_1",-133,"centre")) { document.getElementById('t_field_presentation_region_1').focus(); return false;}
	//	if(!testObl(field_idCentre,"field_idCentre",-132,"centre")) { document.formulaire.elements["field_idCentre"].focus(); return false;}
	if(!verifImage(form,"centre")) return false;

	//controles ok ==> reprise du code existant

	if(testId != 1){

		if(document.getElementById('url_retour')!= null)
		{
			document.getElementById('url_retour').value="";
		}
		if(form.field_droit_utilisation!=null){
			if(form.field_droit_utilisation.checked == false){
				alert("Pour pouvoir valider votre formulaire, vous devez obligatoirement avoir coché la case stipulant que vous disposez des droits d'utilisation des photos téléchargées")
				return false;
			}
		}
		if(form.field_respect_cahier_charge!=null){
			if(form.field_respect_cahier_charge.checked == false){
				alert("Pour pouvoir valider votre formulaire, vous devez obligatoirement avoir coché la case stipulant que vous certifiez respecter le cahier des charges éthic étapes.")
				return false;
			}
		}
		if(form.field_couvert_assiette.checked == false && form.field_couvert_self.checked == false){
			alert("Pour pouvoir valider votre formulaire, vous devez obligatoirement avoir séléctionné au moins un type de restauration (a l'assiette / self service ou plats sur table).")
			form.field_nb_couvert.focus();
			return false;
		}


		document.formulaire.submit();
		return false;
	}else{
		return true;
	}

}



//----------------------------
// Form Organisateurs CVL
//----------------------------
function validFormOrganisateurCVL(testId)
{
	var form = document.getElementById('formulaire');


	if(form.field_etat!=null){
		form.field_etat.checked = true;
	}
	//===================================
	//Valeurs du formulaire
	//===================================
	var field_libelle_1  = form.field_libelle_1.value;

	//var nb_Centres = getNbCaseCochees("field_id_centre[]");

	var field_adresse  = form.field_adresse.value;
	var field_code_postal  = form.field_code_postal.value;
	var field_ville  = form.field_ville.value;
	var field_telephone  = form.field_telephone.value;
	var field_fax  = form.field_fax.value;
	var field_email  = form.field_email.value;

	var field_presentation_organisme_1  = form.field_presentation_organisme_1.value;
	var field_projet_educatif_1  = form.field_projet_educatif_1.value;
	var nb_Thematique = getNbCaseCochees("field_id_sejour_thematique[]");
	var nb_Age = getNbCaseCochees("field_id_sejour_tranche_age[]");
	//	var field_agrement_jeunesse  = form.field_agrement_jeunesse.value;
	var field_visuel  = form.field_visuel_port.value;

	//=============================================
	//controles des champs dans l'ordre d'affichage
	//=============================================
	if(!testObl(field_libelle_1,"field_libelle_1",3,"séjour")) { document.formulaire.elements["field_libelle_1"].focus(); return false;}
	//if(nb_Centres==0){inlineMsg("field_id_centre.0",get_trad_champ_bo("field_id_centre","séjour"),2,300); document.getElementById('field_id_centre.0').focus();return false;}

	if(!testObl(field_adresse,"field_adresse",-132,"séjour")) { document.formulaire.elements["field_adresse"].focus(); return false;}
	if(!testObl(field_code_postal,"field_code_postal",-132,"séjour")) { document.formulaire.elements["field_code_postal"].focus(); return false;}
	if(!testObl(field_ville,"field_ville",-132,"séjour")) { document.formulaire.elements["field_ville"].focus(); return false;}
	if(!testObl(field_telephone,"field_telephone",-132,"séjour")) { document.formulaire.elements["field_telephone"].focus(); return false;}

	if(!testObl(field_fax,"field_fax",-132,"séjour")) { document.formulaire.elements["field_fax"].focus(); return false;}
	if(!testObl(field_email,"field_email",-132,"séjour")) { document.formulaire.elements["field_email"].focus(); return false;}
	if(!testObl(field_presentation_organisme_1,"field_presentation_organisme_1",3,"séjour")) { document.formulaire.elements["field_presentation_organisme_1"].focus(); return false;}
	if(!testObl(field_projet_educatif_1,"field_projet_educatif_1",3,"séjour")) { document.formulaire.elements["field_projet_educatif_1"].focus(); return false;}
	if(nb_Thematique==0){inlineMsg("field_id_sejour_thematique.0",get_trad_champ_bo("field_id_sejour_thematique","séjour"),2,300); alert("La thématique des séjours organisés est obligatoire"); document.getElementById('field_id_sejour_thematique.0').focus();return false;}

	if(nb_Age==0){inlineMsg("field_id_sejour_tranche_age.0",get_trad_champ_bo("field_id_participant_age","séjour"),2,300); alert("L'Age des participants est obligatoire"); document.getElementById('field_id_sejour_tranche_age.0').focus();return false;}

	if(!testObl(field_visuel,"field_visuel",-150,"séjour"))  { document.getElementById('field_visuel').focus(); return false;}
	//if(form.field_visuel_port.value ==""){alert("Le visuel est obligatoire"); return false;}

	//controles ok ==> reprise du code existant


	if(testId != 1){
		if(form.field_droit_utilisation!=null){
			if(form.field_droit_utilisation.checked == false){
				alert("Pour pouvoir valider votre formulaire, vous devez obligatoirement avoir coché la case stipulant que vous disposez des droits d'utilisation des photos téléchargées")
				return false;
			}
		}
		if(form.field_respect_cahier_charge!=null){
			if(form.field_respect_cahier_charge.checked == false){
				alert("Pour pouvoir valider votre formulaire, vous devez obligatoirement avoir coché la case stipulant que vous certifiez respecter le cahier des charges éthic étapes.")
				return false;
			}
		}
		if(document.getElementById('url_retour')!= null)
		{
			document.getElementById('url_retour').value="";
		}
		document.formulaire.submit();
		return false;
	}else{
		return true;
	}

}


//----------------------------
// Form Class d�couverte
//----------------------------
function validFormClasseDecouverte(testId)
{
	var form = document.getElementById('formulaire');

	if(form.field_etat!=null){
		form.field_etat.checked = true;
	}

	//===================================
	//Valeurs du formulaire
	//===================================
	var field_nom  = form.field_nom.value;
	var nb_Themes = getNbCaseCochees("field_id_sejour_theme[]");
	var nb_NiveauxScolaires = getNbCaseCochees("field_id_sejour_niveau_scolaire[]");
	var field_duree_sejour_1  = form.field_duree_sejour_1.value;
	var field_nb_jours = parseInt(form.field_nb_jours.value);
	var field_nb_nuits = parseInt(form.field_nb_nuits.value);
        var nb_Periodes = getNbCaseCochees("field_id_sejour_periode_disponibilite[]");
	var nb_Lits = getNbCaseCochees("field_id_sejour_nb_lit__par_chambre[]");
	var field_a_partir_de_prix  = form.field_a_partir_de_prix.value;
	var nb_Prix = getNbCaseCochees("field_prix_par_29[]");
	var field_prix_comprend_1 = form.field_prix_comprend_1.value;
	var field_prix_ne_comprend_pas_1 = form.field_prix_ne_comprend_pas_1.value;
	var field_interet_pedagogique_1 = form.field_interet_pedagogique_1.value;
	var field_details_1 = form.field_details_1.value;


	//=============================================
	//controles des champs dans l'ordre d'affichage
	//=============================================
	if(!testObl(field_nom,"field_nom",-132,"séjour")) { document.formulaire.elements["field_nom"].focus(); return false;}
	if(nb_Themes==0){inlineMsg("field_id_sejour_theme.0",get_trad_champ_bo("field_id_sejour_theme","séjour"),2,300); document.getElementById('field_id_sejour_theme.0').focus();return false;}
	if(nb_NiveauxScolaires==0){inlineMsg("field_id_sejour_niveau_scolaire.0",get_trad_champ_bo("field_id_sejour_niveau_scolaire","séjour"),2,300); document.getElementById('field_id_sejour_niveau_scolaire.0').focus();return false;}
	if((isNaN(field_nb_jours) && isNaN(field_nb_nuits)) && field_duree_sejour_1.trim()=="") {document.formulaire.elements["field_duree_sejour_1"].focus(); return false;}
	//if(!testObl(field_duree_sejour_1,"field_duree_sejour_1",3,"séjour")) {document.formulaire.elements["field_duree_sejour_1"].focus(); return false;}
	if(nb_Periodes==0){inlineMsg("field_id_sejour_periode_disponibilite.0",get_trad_champ_bo("field_id_sejour_periode_disponibilite","séjour"),2,300); document.getElementById('field_id_sejour_periode_disponibilite.0').focus();return false;}
	if(nb_Lits==0){inlineMsg("field_id_sejour_nb_lit__par_chambre.0",get_trad_champ_bo("field_id_sejour_nb_lit__par_chambre","séjour"),2,300); document.getElementById('field_id_sejour_nb_lit__par_chambre.0').focus();return false;}
	if(!testObl(field_a_partir_de_prix,"field_a_partir_de_prix",-132,"séjour")) { document.formulaire.elements["field_a_partir_de_prix"].focus(); return false;}
	if(nb_Prix==0){inlineMsg("field_prix_par_29[]",get_trad_champ_bo("field_prix_par_29","séjour"),2,300); document.getElementById('field_prix_par_29[]').focus();return false;}
	if(!testObl(field_prix_comprend_1,"field_prix_comprend_1",3,"séjour")) {document.formulaire.elements["field_prix_comprend_1"].focus(); return false;}
	if(!testObl(field_prix_ne_comprend_pas_1,"field_prix_ne_comprend_pas_1",3,"séjour")) {document.formulaire.elements["field_prix_ne_comprend_pas_1"].focus(); return false;}
	if(!testObl(field_interet_pedagogique_1,"field_interet_pedagogique_1",3,"séjour")) {document.formulaire.elements["t_field_interet_pedagogique_1"].focus(); return false;}
	if(!testObl(field_details_1,"field_details_1",3,"séjour")) {document.formulaire.elements["t_field_details_1"].focus(); return false;}
	if(!verifImage(form,"séjour")) return false;

	//controles ok ==> reprise du code existant


	if(testId != 1){
		if(document.getElementById('url_retour')!= null)
		{
			document.getElementById('url_retour').value="";
		}
		if(form.field_droit_utilisation!=null){
			if(form.field_droit_utilisation.checked == false){
				alert("Pour pouvoir valider votre formulaire, vous devez obligatoirement avoir coché la case stipulant que vous disposez des droits d'utilisation des photos téléchargées")
				return false;
			}
		}
		if(form.field_respect_cahier_charge!=null){
			if(form.field_respect_cahier_charge.checked == false){
				alert("Pour pouvoir valider votre formulaire, vous devez obligatoirement avoir coché la case stipulant que vous certifiez respecter le cahier des charges éthic étapes.")
				return false;
			}
		}
		document.formulaire.submit();
		return false;
	}else{
		return true;
	}
}



//----------------------------
// Form Accueil Scolaire
//----------------------------
function validFormAccueilScolaire(testId)
{
	var form = document.getElementById('formulaire');
	if(form.field_etat!=null){
		form.field_etat.checked = true;
	}
	//===================================
	//Valeurs du formulaire
	//===================================
	var HS_bb  = form.HS_bb.value;
	var HS_dp  = form.HS_dp.value;
	var HS_pc  = form.HS_pc.value;
	var HS_rs  = form.HS_rs.value;

	var HS_bb_n  = form.HS_bb_n.value;
	var HS_dp_n  = form.HS_dp_n.value;
	var HS_pc_n  = form.HS_pc_n.value;
	var HS_rs_n  = form.HS_rs_n.value;

	var nb_Lits = getNbCaseCochees("field_id_sejour_nb_lit__par_chambre[]");
	//var field_conditions_scolaires  = form.field_conditions_scolaires.value;
	var nb_Gchauffeur = getNbCaseCochees("field_gratuite_chauffeur_4[]");
	var nb_GAccompagnateur = getNbCaseCochees("field_gratuite_accompagnateur_4[]");


	//=============================================
	//controles des champs dans l'ordre d'affichage
	//=============================================
	if(HS_bb=="" && HS_dp==""  && HS_pc=="" && HS_rs=="")
	{
		inlineMsg("HS_rs",get_trad_champ_bo("HS_rs","séjour"),2,3); document.formulaire.elements["HS_bb"].focus(); return false;
	}
	/*if(HS_bb_n=="" && HS_dp_n==""  && HS_pc_n=="" && HS_rs_n=="")
	{
	inlineMsg("HS_rs_n",get_trad_champ_bo("HS_rs_n","séjour"),2,3); document.formulaire.elements["HS_bb_n"].focus(); return false;
	}*/
	if(nb_Lits==0){inlineMsg("field_id_sejour_nb_lit__par_chambre.0",get_trad_champ_bo("field_id_sejour_nb_lit__par_chambre","séjour"),2,300); document.getElementById('field_id_sejour_nb_lit__par_chambre.0').focus();return false;}
	//if(!testObl(field_conditions_scolaires,"field_conditions_scolaires",3,"séjour")) {document.formulaire.elements["t_field_conditions_scolaires"].focus(); return false;}
	if(nb_Gchauffeur==0){inlineMsg("field_gratuite_chauffeur_4[]",get_trad_champ_bo("field_gratuite_chauffeur_4","séjour"),2,300); document.getElementById('field_gratuite_chauffeur_4[]').focus();return false;}
	if(nb_GAccompagnateur==0){inlineMsg("field_gratuite_accompagnateur_4[]",get_trad_champ_bo("field_gratuite_accompagnateur_4","séjour"),2,300); document.getElementById('field_gratuite_accompagnateur_4[]').focus();return false;}
	if(!verifImage(form,"séjour")) return false;

	//controles ok ==> reprise du code existant

	if(testId != 1){
		if(document.getElementById('url_retour')!= null)
		{
			document.getElementById('url_retour').value="";
		}
		if(form.field_droit_utilisation!=null){
			if(form.field_droit_utilisation.checked == false){
				alert("Pour pouvoir valider votre formulaire, vous devez obligatoirement avoir coché la case stipulant que vous disposez des droits d'utilisation des photos téléchargées")
				return false;
			}
		}
		if(form.field_respect_cahier_charge!=null){
			if(form.field_respect_cahier_charge.checked == false){
				alert("Pour pouvoir valider votre formulaire, vous devez obligatoirement avoir coché la case stipulant que vous certifiez respecter le cahier des charges éthic étapes.")
				return false;
			}
		}
		document.formulaire.submit();
		return false;
	}else{
		return true;
	}

}

//----------------------------
// Form CVL
//----------------------------
function validFormCVL(testId)
{
	var form = document.getElementById('formulaire');
	if(form.field_etat!=null){
		form.field_etat.checked = true;
	}
	//===================================
	//Valeurs du formulaire
	//===================================
	var field_nom  = form.field_nom.value;
	var nb_Themes = getNbCaseCochees("field_id_sejour_theme[]");
	var nb_Age = getNbCaseCochees("field_id_sejour_tranche_age[]");
	var field_duree_sejour_1  = form.field_duree_sejour_1.value;
	var field_nb_jours = parseInt(form.field_nb_jours.value);
	var field_nb_nuits = parseInt(form.field_nb_nuits.value);
	var nb_Lits = getNbCaseCochees("field_id_sejour_nb_lit__par_chambre[]");

	var field_a_partir_de_prix = form.field_a_partir_de_prix.value;
	var field_prix_comprend_1 = form.field_prix_comprend_1.value;
	var field_prix_ne_comprend_pas_1 = form.field_prix_ne_comprend_pas_1.value;
	var field_presentation_1  = form.field_presentation_1.value;


	//=============================================
	//controles des champs dans l'ordre d'affichage
	//=============================================
	if(!testObl(field_nom,"field_nom",3,"séjour")) { document.formulaire.elements["field_nom"].focus(); return false;}
	if(nb_Themes==0){inlineMsg("field_id_sejour_theme.0",get_trad_champ_bo("field_id_sejour_theme","séjour"),2,300); document.getElementById('field_id_sejour_theme.0').focus();return false;}
	if(nb_Age==0){inlineMsg("field_id_sejour_tranche_age.0",get_trad_champ_bo("field_id_participant_age","séjour"),2,300); document.getElementById('field_id_sejour_tranche_age.0').focus();return false;}
	if((isNaN(field_nb_jours) && isNaN(field_nb_nuits)) && field_duree_sejour_1.trim()=="") {document.formulaire.elements["field_duree_sejour_1"].focus(); return false;}
	//if(!testObl(field_duree_sejour_1,"field_duree_sejour_1",3,"séjour")) {document.formulaire.elements["field_duree_sejour_1"].focus(); return false;}
	if(nb_Lits==0){inlineMsg("field_id_sejour_nb_lit__par_chambre.0",get_trad_champ_bo("field_id_sejour_nb_lit__par_chambre","séjour"),2,300); document.getElementById('field_id_sejour_nb_lit__par_chambre.0').focus();return false;}
	if(!testObl(field_a_partir_de_prix,"field_a_partir_de_prix",3,"séjour")) { document.formulaire.elements["field_a_partir_de_prix"].focus(); return false;}
	if(!testObl(field_prix_comprend_1,"field_prix_comprend_1",3,"séjour")) {document.formulaire.elements["field_prix_comprend_1"].focus(); return false;}
	if(!testObl(field_prix_ne_comprend_pas_1,"field_prix_ne_comprend_pas_1",3,"séjour")) {document.formulaire.elements["field_prix_ne_comprend_pas_1"].focus(); return false;}
	if(!testObl(field_presentation_1,"field_presentation_1",3,"séjour")) {document.formulaire.elements["t_field_presentation_1"].focus(); return false;}
	if(!verifImage(form,"séjour")) return false;

	//controles ok ==> reprise du code existant


	if(testId != 1){
		if(document.getElementById('url_retour')!= null)
		{
			document.getElementById('url_retour').value="";
		}
		if(form.field_droit_utilisation!=null){
			if(form.field_droit_utilisation.checked == false){
				alert("Pour pouvoir valider votre formulaire, vous devez obligatoirement avoir coché la case stipulant que vous disposez des droits d'utilisation des photos téléchargées")
				return false;
			}
		}
		if(form.field_respect_cahier_charge!=null){
			if(form.field_respect_cahier_charge.checked == false){
				alert("Pour pouvoir valider votre formulaire, vous devez obligatoirement avoir coché la case stipulant que vous certifiez respecter le cahier des charges éthic étapes.")
				return false;
			}
		}
		document.formulaire.submit();
		return false;
	}else{
		return true;
	}



}

//----------------------------
// Form Accueil de reunions
//----------------------------
function validFormAccueilReunion(testId)
{

	var form = document.getElementById('formulaire');

	if(form.field_etat!=null){
		form.field_etat.checked = true;
	}

	//===================================
	//Valeurs du formulaire
	//===================================
	var nb_Materiel = getNbCaseCochees("field_id_sejour_materiel_service[]");

	//=============================================
	//controles des champs dans l'ordre d'affichage
	//=============================================
	if(nb_Materiel==0){inlineMsg("field_id_sejour_materiel_service.0",get_trad_champ_bo("field_id_sejour_materiel_service","séjour"),2,300); document.getElementById('field_id_sejour_materiel_service.0').focus();return false;}
	if(!verifImage(form,"séjour")) return false;

	//controles ok ==> reprise du code existant


	if(testId != 1){
		if(document.getElementById('url_retour')!= null)
		{
			document.getElementById('url_retour').value="";
		}
		if(form.field_droit_utilisation!=null){
			if(form.field_droit_utilisation.checked == false){
				alert("Pour pouvoir valider votre formulaire, vous devez obligatoirement avoir coché la case stipulant que vous disposez des droits d'utilisation des photos téléchargées")
				return false;
			}
		}
		if(form.field_respect_cahier_charge!=null){
			if(form.field_respect_cahier_charge.checked == false){
				alert("Pour pouvoir valider votre formulaire, vous devez obligatoirement avoir coché la case stipulant que vous certifiez respecter le cahier des charges éthic étapes.")
				return false;
			}
		}
		document.formulaire.submit();
		return false;
	}else{
		return true;
	}

}


//----------------------------
// Form Seminaires
//----------------------------
function validFormSeminaires(testId)
{
	var form = document.getElementById('formulaire');
	if(form.field_etat!=null){
		form.field_etat.checked = true;
	}
	//===================================
	//Valeurs du formulaire
	//===================================
	var field_nom  = form.field_nom.value;
	var nb_Themes = getNbCaseCochees("field_id_sejour_theme_seminaire[]");
	var field_presentation_1  = form.field_presentation_1.value;
	var field_a_partir_de_prix  = form.field_a_partir_de_prix.value;
	var field_prix_comprend_1 = form.field_prix_comprend_1.value;
	var field_prix_ne_comprend_pas_1 = form.field_prix_ne_comprend_pas_1.value;
	var field_descriptif_1 = form.field_descriptif_1.value;

	//=============================================
	//controles des champs dans l'ordre d'affichage
	//=============================================
	if(!testObl(field_nom,"field_nom",3,"séjour")) { document.formulaire.elements["field_nom"].focus(); return false;}
	if(nb_Themes==0){inlineMsg("field_id_sejour_theme_seminaire.0",get_trad_champ_bo("field_id_sejour_theme_seminaire","séjour"),2,300); document.getElementById('field_id_sejour_theme_seminaire.0').focus();return false;}
	if(!testObl(field_presentation_1,"field_presentation_1",3,"séjour")) {document.formulaire.elements["t_field_presentation_1"].focus(); return false;}
	if(!testObl(field_a_partir_de_prix,"field_a_partir_de_prix",3,"séjour")) { document.formulaire.elements["field_a_partir_de_prix"].focus(); return false;}
	if(!testObl(field_prix_comprend_1,"field_prix_comprend_1",3,"séjour")) {document.formulaire.elements["field_prix_comprend_1"].focus(); return false;}
	if(!testObl(field_prix_ne_comprend_pas_1,"field_prix_ne_comprend_pas_1",3,"séjour")) {document.formulaire.elements["field_prix_ne_comprend_pas_1"].focus(); return false;}
	if(!testObl(field_descriptif_1,"field_descriptif_1",3,"séjour")) {document.formulaire.elements["t_field_descriptif_1"].focus(); return false;}
	if(!verifImage(form,"séjour")) return false;

	//controles ok ==> reprise du code existant

	if(testId != 1){
		if(document.getElementById('url_retour')!= null)
		{
			document.getElementById('url_retour').value="";
		}

		if(form.field_droit_utilisation!=null){
			if(form.field_droit_utilisation.checked == false){
				alert("Pour pouvoir valider votre formulaire, vous devez obligatoirement avoir coché la case stipulant que vous disposez des droits d'utilisation des photos téléchargées")
				return false;
			}
		}
		if(form.field_respect_cahier_charge!=null){
			if(form.field_respect_cahier_charge.checked == false){
				alert("Pour pouvoir valider votre formulaire, vous devez obligatoirement avoir coché la case stipulant que vous certifiez respecter le cahier des charges éthic étapes.")
				return false;
			}
		}
		document.formulaire.submit();
		return false;
	}else{
		return true;
	}
}

//----------------------------
// Form Accuel de groupes
//----------------------------
function validFormAccueilGroupes(testId)
{
	var form = document.getElementById('formulaire');
	if(form.field_etat!=null){
		form.field_etat.checked = true;
	}
	//===================================
	//Valeurs du formulaire
	//===================================
	var HS_bb  = form.HS_bb.value;
	var HS_dp  = form.HS_dp.value;
	var HS_pc  = form.HS_pc.value;
	var HS_rs  = form.HS_rs.value;

	var HS_bb_n  = form.HS_bb_n.value;
	var HS_dp_n  = form.HS_dp_n.value;
	var HS_pc_n  = form.HS_pc_n.value;
	var HS_rs_n  = form.HS_rs_n.value;

	var nb_Gchauffeur = getNbCaseCochees("field_gratuite_chauffeur_4[]");

	//=============================================
	//controles des champs dans l'ordre d'affichage
	//=============================================
	if(HS_bb=="" && HS_dp==""  && HS_pc=="" && HS_rs=="")
	{
		inlineMsg("HS_rs",get_trad_champ_bo("HS_rs","séjour"),2,3); document.formulaire.elements["HS_bb"].focus(); return false;
	}
	/*if(HS_bb_n=="" && HS_dp_n==""  && HS_pc_n=="" && HS_rs_n=="")
	{
	inlineMsg("HS_rs_n",get_trad_champ_bo("HS_rs_n","séjour"),2,3); document.formulaire.elements["HS_bb_n"].focus(); return false;
	}*/

	if(nb_Gchauffeur==0){inlineMsg("field_gratuite_chauffeur_4[]",get_trad_champ_bo("field_gratuite_chauffeur_4","séjour"),2,300); document.getElementById('field_gratuite_chauffeur_4[]').focus();return false;}
	if(!verifImage(form,"séjour")) return false;

	//controles ok ==> reprise du code existant

	if(testId != 1){
		if(document.getElementById('url_retour')!= null)
		{
			document.getElementById('url_retour').value="";
		}

		if(form.field_droit_utilisation!=null){
			if(form.field_droit_utilisation.checked == false){
				alert("Pour pouvoir valider votre formulaire, vous devez obligatoirement avoir coché la case stipulant que vous disposez des droits d'utilisation des photos téléchargées")
				return false;
			}
		}
		if(form.field_respect_cahier_charge!=null){
			if(form.field_respect_cahier_charge.checked == false){
				alert("Pour pouvoir valider votre formulaire, vous devez obligatoirement avoir coché la case stipulant que vous certifiez respecter le cahier des charges éthic étapes.")
				return false;
			}
		}
		document.formulaire.submit();
		return false;
	}else{
		return true;
	}
}


//----------------------------
// Form Sejours touristiques
//----------------------------
function validFormSejourTouristique(testId)
{
	var form = document.getElementById('formulaire');
	if(form.field_etat!=null){
		form.field_etat.checked = true;
	}
	//===================================
	//Valeurs du formulaire
	//===================================
	var field_nom_sejour_1  = form.field_nom_sejour_1.value;
	var field_duree_sejour_1  = form.field_duree_sejour_1.value;
	var field_nb_jours = parseInt(form.field_nb_jours.value);
	var field_nb_nuits = parseInt(form.field_nb_nuits.value);
	var field_id_sejour_duree = form.field_id_sejour_duree.value;
	var field_descriptif_1 = form.field_descriptif_1.value;
	var nb_Periodes = getNbCaseCochees("field_id_sejour_periode_disponibilite[]");
	var field_a_partir_de_prix = form.field_a_partir_de_prix.value;
	var field_prix_comprend_1 = form.field_prix_comprend_1.value;
	var field_prix_ne_comprend_pas_1 = form.field_prix_ne_comprend_pas_1.value;
	var nb_IME = getNbCaseCochees("field_adapte_IME_IMP_4[]");
	var field_details_1 = form.field_details_1.value;

	//=============================================
	//controles des champs dans l'ordre d'affichage
	//=============================================
	if(!testObl(field_nom_sejour_1,"field_nom_sejour_1",3,"séjour")) { document.formulaire.elements["field_nom_sejour_1"].focus(); return false;}
	if((isNaN(field_nb_jours) && isNaN(field_nb_nuits)) && field_duree_sejour_1.trim()=="") { document.formulaire.elements["field_duree_sejour_1"].focus(); return false;}
	//if(!testObl(field_duree_sejour_1,"field_duree_sejour_1",3,"séjour")) { document.formulaire.elements["field_duree_sejour_1"].focus(); return false;}
	if(!testSelectObl(field_id_sejour_duree,"field_id_sejour_duree",3,"séjour")) { document.formulaire.elements["field_id_sejour_duree"].focus(); return false;}
	if(!testObl(field_descriptif_1,"field_descriptif_1",3,"séjour")) {document.formulaire.elements["t_field_descriptif_1"].focus(); return false;}
	if(nb_Periodes==0){inlineMsg("field_id_sejour_periode_disponibilite.0",get_trad_champ_bo("field_id_sejour_periode_disponibilite","séjour"),2,300); document.getElementById('field_id_sejour_periode_disponibilite.0').focus();return false;}
	if(!testObl(field_a_partir_de_prix,"field_a_partir_de_prix",3,"séjour")) { document.formulaire.elements["field_a_partir_de_prix"].focus(); return false;}
	if(!testObl(field_prix_comprend_1,"field_prix_comprend_1",3,"séjour")) {document.formulaire.elements["field_prix_comprend_1"].focus(); return false;}
	if(!testObl(field_prix_ne_comprend_pas_1,"field_prix_ne_comprend_pas_1",3,"séjour")) {document.formulaire.elements["field_prix_ne_comprend_pas_1"].focus(); return false;}
	if(!testObl(field_details_1,"field_details_1",3,"séjour")) {document.formulaire.elements["t_field_details_1"].focus(); return false;}
	if(nb_IME==0){inlineMsg("field_adapte_IME_IMP_4[]",get_trad_champ_bo("field_adapte_IME_IMP_4","séjour"),2,300); document.getElementById('field_adapte_IME_IMP_4[]').focus();return false;}
	if(!verifImage(form,"séjour")) return false;

	//controles ok ==> reprise du code existant

	if(testId != 1){
		if(document.getElementById('url_retour')!= null)
		{
			document.getElementById('url_retour').value="";
		}

		if(form.field_droit_utilisation!=null){
			if(form.field_droit_utilisation.checked == false){
				alert("Pour pouvoir valider votre formulaire, vous devez obligatoirement avoir coché la case stipulant que vous disposez des droits d'utilisation des photos téléchargées")
				return false;
			}
		}
		if(form.field_respect_cahier_charge!=null){
			if(form.field_respect_cahier_charge.checked == false){
				alert("Pour pouvoir valider votre formulaire, vous devez obligatoirement avoir coché la case stipulant que vous certifiez respecter le cahier des charges éthic étapes.")
				return false;
			}
		}
		document.formulaire.submit();
		return false;
	}else{
		return true;
	}
}


//----------------------------
// Form Sejours touristiques
//----------------------------
function validFormSejourStageThemGroupe(testId)
{
	var form = document.getElementById('formulaire');
	if(form.field_etat!=null){
		form.field_etat.checked = true;
	}
	//===================================
	//Valeurs du formulaire
	//===================================
	var field_nom_stage_1  = form.field_nom_stage_1.value;
	var nb_Stages = getNbCaseCochees("field_id_sejour_stage_theme[]");
	var field_descriptif_1 = form.field_descriptif_1.value;
	var field_duree_sejour_1  = form.field_duree_sejour_1.value;
	var field_nb_jours = parseInt(form.field_nb_jours.value);
	var field_nb_nuits = parseInt(form.field_nb_nuits.value);
	var nb_Periodes = getNbCaseCochees("field_id_sejour_periode_disponibilite[]");
	var field_a_partir_de_prix = form.field_a_partir_de_prix.value;
	var field_prix_comprend_1 = form.field_prix_comprend_1.value;
	var field_prix_ne_comprend_pas_1 = form.field_prix_ne_comprend_pas_1.value;

	//=============================================
	//controles des champs dans l'ordre d'affichage
	//=============================================
	if(!testObl(field_nom_stage_1,"field_nom_stage_1",3,"séjour")) { document.formulaire.elements["field_nom_stage_1"].focus(); return false;}
	if(nb_Stages==0){inlineMsg("field_id_sejour_stage_theme.0",get_trad_champ_bo("field_id_sejour_stage_theme","séjour"),2,300); document.getElementById('field_id_sejour_stage_theme.0').focus();return false;}
	if(!testObl(field_descriptif_1,"field_descriptif_1",3,"séjour")) {document.formulaire.elements["t_field_descriptif_1"].focus(); return false;}
	if((isNaN(field_nb_jours) && isNaN(field_nb_nuits)) && field_duree_sejour_1.trim()=="") { document.formulaire.elements["field_duree_sejour_1"].focus(); return false;}
	//if(!testObl(field_duree_sejour_1,"field_duree_sejour_1",3,"séjour")) { document.formulaire.elements["field_duree_sejour_1"].focus(); return false;}
	if(nb_Periodes==0){inlineMsg("field_id_sejour_periode_disponibilite.0",get_trad_champ_bo("field_id_sejour_periode_disponibilite","séjour"),2,300); document.getElementById('field_id_sejour_periode_disponibilite.0').focus();return false;}
	if(!testObl(field_a_partir_de_prix,"field_a_partir_de_prix",3,"séjour")) { document.formulaire.elements["field_a_partir_de_prix"].focus(); return false;}
	if(!testObl(field_prix_comprend_1,"field_prix_comprend_1",3,"séjour")) {document.formulaire.elements["field_prix_comprend_1"].focus(); return false;}
	if(!testObl(field_prix_ne_comprend_pas_1,"field_prix_ne_comprend_pas_1",3,"séjour")) {document.formulaire.elements["field_prix_ne_comprend_pas_1"].focus(); return false;}
	if(!verifImage(form,"séjour")) return false;

	//controles ok ==> reprise du code existant

	if(testId != 1){
		if(document.getElementById('url_retour')!= null)
		{
			document.getElementById('url_retour').value="";
		}

		if(form.field_droit_utilisation!=null){
			if(form.field_droit_utilisation.checked == false){
				alert("Pour pouvoir valider votre formulaire, vous devez obligatoirement avoir coché la case stipulant que vous disposez des droits d'utilisation des photos téléchargées")
				return false;
			}
		}
		if(form.field_respect_cahier_charge!=null){
			if(form.field_respect_cahier_charge.checked == false){
				alert("Pour pouvoir valider votre formulaire, vous devez obligatoirement avoir coché la case stipulant que vous certifiez respecter le cahier des charges éthic étapes.")
				return false;
			}
		}
		document.formulaire.submit();
		return false;
	}else{
		return true;
	}
}


//------------------------------------------
// Form Sejours accueil individuels
//-----------------------------------------
function validFormSejourAccueilIndFamille(testId)
{

	var form = document.getElementById('formulaire');
	if(form.field_etat!=null){
		form.field_etat.checked = true;
	}
	//===================================
	//Valeurs du formulaire
	//===================================
	var HS_bb  = form.HS_bb.value;
	var HS_dp  = form.HS_dp.value;
	var HS_pc  = form.HS_pc.value;
	var HS_rs  = form.HS_rs.value;

	/*
	var HS_bb_n  = form.HS_bb_n.value;
	var HS_dp_n  = form.HS_dp_n.value;
	var HS_pc_n  = form.HS_pc_n.value;
	var HS_rs_n  = form.HS_rs_n.value;
	*/

	//=============================================
	//controles des champs dans l'ordre d'affichage
	//=============================================
	if(HS_bb=="" && HS_dp==""  && HS_pc=="" && HS_rs=="")
	{
		inlineMsg("HS_rs",get_trad_champ_bo("HS_rs","séjour"),2,3); document.formulaire.elements["HS_bb"].focus(); return false;
	}
	/*
	if(HS_bb_n=="" && HS_dp_n==""  && HS_pc_n=="" && HS_rs_n=="")
	{
	inlineMsg("HS_rs_n",get_trad_champ_bo("HS_rs_n","séjour"),2,3); document.formulaire.elements["HS_bb_n"].focus(); return false;
	}
	*/
	if(!verifImage(form,"séjour")) return false;

	//controles ok ==> reprise du code existant

	if(testId != 1){
		if(document.getElementById('url_retour')!= null)
		{
			document.getElementById('url_retour').value="";
		}

		if(form.field_droit_utilisation!=null){
			if(form.field_droit_utilisation.checked == false){
				alert("Pour pouvoir valider votre formulaire, vous devez obligatoirement avoir coché la case stipulant que vous disposez des droits d'utilisation des photos téléchargées")
				return false;
			}
		}
		if(form.field_respect_cahier_charge!=null){
			if(form.field_respect_cahier_charge.checked == false){
				alert("Pour pouvoir valider votre formulaire, vous devez obligatoirement avoir coché la case stipulant que vous certifiez respecter le cahier des charges éthic étapes.")
				return false;
			}
		}
		document.formulaire.submit();
		return false;
	}else{
		return true;
	}
}

//------------------------------------------
// Form Short breaks indiv
//-----------------------------------------
function validFormShortBreaksInd(testId)
{
	var form = document.getElementById('formulaire');
	if(form.field_etat!=null){
		form.field_etat.checked = true;
	}
	//===================================
	//Valeurs du formulaire
	//===================================
	var field_nom_1  = form.field_nom_1.value;
	var nb_Short = getNbCaseCochees("field_id_sejour_short_break_theme[]");
	var field_duree_sejour_1  = form.field_duree_sejour_1.value;
	var field_nb_jours = parseInt(form.field_nb_jours.value);
	var field_nb_nuits = parseInt(form.field_nb_nuits.value);
	var nb_Periodes = getNbCaseCochees("field_id_sejour_periode_disponibilite[]");
	var field_a_partir_de_prix = form.field_a_partir_de_prix.value;
	var field_prix_comprend_1 = form.field_prix_comprend_1.value;
	var field_prix_ne_comprend_pas_1 = form.field_prix_ne_comprend_pas_1.value;
	var field_descriptif_1 = form.field_descriptif_1.value;

	//=============================================
	//controles des champs dans l'ordre d'affichage
	//=============================================
	if(!testObl(field_nom_1,"field_nom_1",3,"séjour")) { document.formulaire.elements["field_nom_1"].focus(); return false;}
	if(nb_Short==0){inlineMsg("field_id_sejour_short_break_theme.0",get_trad_champ_bo("field_id_sejour_short_break_theme","séjour"),2,300); document.getElementById('field_id_sejour_short_break_theme.0').focus();return false;}
	if((isNaN(field_nb_jours) && isNaN(field_nb_nuits)) && field_duree_sejour_1.trim()=="") { document.formulaire.elements["field_duree_sejour_1"].focus(); return false;}
	//if(!testObl(field_duree_sejour_1,"field_duree_sejour_1",3,"séjour")) { document.formulaire.elements["field_duree_sejour_1"].focus(); return false;}
	if(nb_Periodes==0){inlineMsg("field_id_sejour_periode_disponibilite.0",get_trad_champ_bo("field_id_sejour_periode_disponibilite","séjour"),2,300); document.getElementById('field_id_sejour_periode_disponibilite.0').focus();return false;}
	if(!testObl(field_a_partir_de_prix,"field_a_partir_de_prix",3,"séjour")) { document.formulaire.elements["field_a_partir_de_prix"].focus(); return false;}
	if(!testObl(field_prix_comprend_1,"field_prix_comprend_1",3,"séjour")) {document.formulaire.elements["field_prix_comprend_1"].focus(); return false;}
	if(!testObl(field_prix_ne_comprend_pas_1,"field_prix_ne_comprend_pas_1",3,"séjour")) {document.formulaire.elements["field_prix_ne_comprend_pas_1"].focus(); return false;}
	if(!testObl(field_descriptif_1,"field_descriptif_1",3,"séjour")) {document.formulaire.elements["t_field_descriptif_1"].focus(); return false;}
	if(!verifImage(form,"séjour")) return false;

	//controles ok ==> reprise du code existant

	if(testId != 1){
		if(document.getElementById('url_retour')!= null)
		{
			document.getElementById('url_retour').value="";
		}

		if(form.field_droit_utilisation!=null){
			if(form.field_droit_utilisation.checked == false){
				alert("Pour pouvoir valider votre formulaire, vous devez obligatoirement avoir coché la case stipulant que vous disposez des droits d'utilisation des photos téléchargées")
				return false;
			}
		}
		if(form.field_respect_cahier_charge!=null){
			if(form.field_respect_cahier_charge.checked == false){
				alert("Pour pouvoir valider votre formulaire, vous devez obligatoirement avoir coché la case stipulant que vous certifiez respecter le cahier des charges éthic étapes.")
				return false;
			}
		}
		document.formulaire.submit();
		return false;
	}else{
		return true;
	}
}



//------------------------------------------
// Form Stage th�matique individuel
//-----------------------------------------
function validFormStageThemIndividuel(testId)
{

	var form = document.getElementById('formulaire');
	if(form.field_etat!=null){
		form.field_etat.checked = true;
	}
	//===================================
	//Valeurs du formulaire
	//===================================
	var field_nom_1  = form.field_nom_1.value;
	var nb_Stages = getNbCaseCochees("field_id_sejour_stage_theme[]");
	var field_duree_sejour_1  = form.field_duree_sejour_1.value;
	var field_nb_jours = parseInt(form.field_nb_jours.value);
	var field_nb_nuits = parseInt(form.field_nb_nuits.value);
	var nb_Periodes = getNbCaseCochees("field_id_sejour_periode_disponibilite[]");
	var field_a_partir_de_prix = form.field_a_partir_de_prix.value;
	var field_prix_comprend_1 = form.field_prix_comprend_1.value;
	var field_prix_ne_comprend_pas_1 = form.field_prix_ne_comprend_pas_1.value;
	var field_descriptif_1 = form.field_descriptif_1.value;

	//=============================================
	//controles des champs dans l'ordre d'affichage
	//=============================================
	if(!testObl(field_nom_1,"field_nom_1",3,"séjour")) { document.formulaire.elements["field_nom_1"].focus(); return false;}
	if(nb_Stages==0){inlineMsg("field_id_sejour_stage_theme.0",get_trad_champ_bo("field_id_sejour_stage_theme","séjour"),2,300); document.getElementById('field_id_sejour_stage_theme.0').focus();return false;}
	if((isNaN(field_nb_jours) && isNaN(field_nb_nuits)) && field_duree_sejour_1.trim()=="") { document.formulaire.elements["field_duree_sejour_1"].focus(); return false;}
	//if(!testObl(field_duree_sejour_1,"field_duree_sejour_1",3,"séjour")) { document.formulaire.elements["field_duree_sejour_1"].focus(); return false;}
	if(nb_Periodes==0){inlineMsg("field_id_sejour_periode_disponibilite.0",get_trad_champ_bo("field_id_sejour_periode_disponibilite","séjour"),2,300); document.getElementById('field_id_sejour_periode_disponibilite.0').focus();return false;}
	if(!testObl(field_a_partir_de_prix,"field_a_partir_de_prix",3,"séjour")) { document.formulaire.elements["field_a_partir_de_prix"].focus(); return false;}
	if(!testObl(field_prix_comprend_1,"field_prix_comprend_1",3,"séjour")) {document.formulaire.elements["field_prix_comprend_1"].focus(); return false;}
	if(!testObl(field_prix_ne_comprend_pas_1,"field_prix_ne_comprend_pas_1",3,"séjour")) {document.formulaire.elements["field_prix_ne_comprend_pas_1"].focus(); return false;}
	if(!testObl(field_descriptif_1,"field_descriptif_1",3,"séjour")) {document.formulaire.elements["t_field_descriptif_1"].focus(); return false;}
	if(!verifImage(form,"séjour")) return false;

	//controles ok ==> reprise du code existant

	if(testId != 1){
		if(document.getElementById('url_retour')!= null)
		{
			document.getElementById('url_retour').value="";
		}

		if(form.field_droit_utilisation!=null){
			if(form.field_droit_utilisation.checked == false){
				alert("Pour pouvoir valider votre formulaire, vous devez obligatoirement avoir coché la case stipulant que vous disposez des droits d'utilisation des photos téléchargées")
				return false;
			}
		}
		if(form.field_respect_cahier_charge!=null){
			if(form.field_respect_cahier_charge.checked == false){
				alert("Pour pouvoir valider votre formulaire, vous devez obligatoirement avoir coché la case stipulant que vous certifiez respecter le cahier des charges éthic étapes.")
				return false;
			}
		}
		document.formulaire.submit();
		return false;
	}else{
		return true;
	}
}

function verifImage(form,table)
{
	for(var i=1;i<=10;i++)
	{
		eval("var field_visuel_"+i+" = form.field_visuel_"+i+"_port.value;");
	}

	var s = " if( 1 == 1 " ;

	for(var i=1;i<=10;i++)
	{
		s +="  && field_visuel_"+i+" == \"\" ";
	}
	s += "){";
	s += "	inlineMsg(\"field_visuel_1\",get_trad_champ_bo(\"field_visuel_1\",\""+table+"\"),2,-172); document.formulaire.elements[\"field_visuel_1_port\"].focus(); var res = false;	";
	s += "}else {var res = true;}";

	eval(s);

	/*
	if( 1 == 1   && field_visuel_1 == ""   && field_visuel_2 == ""   && field_visuel_3 == ""   && field_visuel_4 == ""   && field_visuel_5 == ""   && field_visuel_6 == ""   && field_visuel_7 == ""   && field_visuel_8 == ""   && field_visuel_9 == ""   && field_visuel_10 == "" )
	{	inlineMsg("field_visuel_1",get_trad_champ_bo("field_visuel_1","s�jour"),2,3);
	document.formulaire.elements["field_visuel_1_port"].focus();
	return false;
	}
	*/
	return res;
}


function checkNumeric(obj)
{
	var exp = new RegExp("^[0-9.,]+$","g");
	if( !exp.test(obj.value)  ){
		var  s = obj.value;
		var nb = parseInt(s.length)-1;
		obj.value=s.substr(0,nb);
	}
}


function verif_numeric(obj)
{
	var exp = new RegExp("^[0-9.,]+$","g");
	if( !exp.test(obj.value)  ){
		obj.value="";
	}
}

function ExportContact(){
	window.open("export_contact_centre.php","nom_popup","menubar=no, status=no, scrollbars=no, menubar=no, width=200, height=100");
	
}
function ExportContactGeneral(){
	window.open("export_contact_general.php","nom_popup","menubar=no, status=no, scrollbars=no, menubar=no, width=200, height=100");
	
}
function ExportContactSejour(){
	window.open("export_contact_sejour.php","nom_popup","menubar=no, status=no, scrollbars=no, menubar=no, width=200, height=100");
}
function ExportContactDispo(){
	window.open("export_contact_dispo.php","nom_popup","menubar=no, status=no, scrollbars=no, menubar=no, width=200, height=100");
}
function ExportContactNewsletter(){
	window.open("export_contact_newsletter.php","nom_popup","menubar=no, status=no, scrollbars=no, menubar=no, width=200, height=100");
}
function ExportCentreXML(){
	window.open("export_fiche_centre.php","nom_popup","menubar=no, status=no, scrollbars=no, menubar=no, width=400, height=100");
}
function ExportSejour(id){
  if(id == 1){
    window.open("export_fiche_accueil_groupe_scolaire.php","nom_popup","menubar=no, status=no, scrollbars=no, menubar=no, width=400, height=100");
  }else if(id == 2){
    window.open("export_fiche_accueil_reunions.php","nom_popup","menubar=no, status=no, scrollbars=no, menubar=no, width=400, height=100");
  }else if(id == 3){
    window.open("export_fiche_accueil_groupe_jeune_adulte.php","nom_popup","menubar=no, status=no, scrollbars=no, menubar=no, width=400, height=100");
  }else if(id == 4){
    window.open("export_fiche_accueil_individuel_famille.php","nom_popup","menubar=no, status=no, scrollbars=no, menubar=no, width=400, height=100");
  }else if(id == 5){
    window.open("export_fiche_classe_decouverte.php","nom_popup","menubar=no, status=no, scrollbars=no, menubar=no, width=400, height=100");
  }else if(id == 6){
    window.open("export_fiche_cvl.php","nom_popup","menubar=no, status=no, scrollbars=no, menubar=no, width=400, height=100");
  }else if(id == 7){
    window.open("export_fiche_seminaire.php","nom_popup","menubar=no, status=no, scrollbars=no, menubar=no, width=400, height=100");
  }else if(id == 8){
    window.open("export_fiche_sejour_touristique.php","nom_popup","menubar=no, status=no, scrollbars=no, menubar=no, width=400, height=100");
  }else if(id == 9){
    window.open("export_fiche_stage_groupe.php","nom_popup","menubar=no, status=no, scrollbars=no, menubar=no, width=400, height=100");
  }else if(id == 10){
    window.open("export_fiche_short_breaks.php","nom_popup","menubar=no, status=no, scrollbars=no, menubar=no, width=400, height=100");
  }else if(id == 11){
    window.open("export_fiche_stages_thematiques_individuels.php","nom_popup","menubar=no, status=no, scrollbars=no, menubar=no, width=400, height=100");
  }
	
}