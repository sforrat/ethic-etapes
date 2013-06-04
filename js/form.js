function sendDispoCentre(){
	
	var nom = $('[name="test-name"]').val();
	var Pecole = $('[name="test-Pecole"]').val();
	var mail = $('[name="test-email-mail"]').val();
	var Pstructure = $('[name="test-Pstructure"]').val();
	var Passociation = $('[name="test-Passociation"]').val();
	var str = "";
	
	if(document.getElementById("Pniveau").style.display=="block"){
  	$("select[name=test-Pniveau[]] option:selected").each(function () {
  		str += $(this).text() + "<br />";
  	});
	}
	var Pniveau =  str;
	str = "";
  
  if(document.getElementById("Pdiscipline").style.display=="block"){
	$("select[name=test-Pdiscipline[]] option:selected").each(function () {
		str += $(this).text() + "<br />";
	});
	}
	var Pdiscipline =  str;
	str = "";
	
	$("select[name=test-Ppays] option:selected").each(function () {
		str += $(this).text() + "<br />";
	});
	var Ppays =  str;
	str = "";

  if(document.getElementById("Petablissement").style.display=="block"){
	$("select[name=test-Petablissement[]] option:selected").each(function () {
		str += $(this).text() + "<br />";
	});
	}
	var Petablissement =  str;
	str = "";
	/*$("select[name=contact_youAre[]] option:selected").each(function () {
		str += $(this).text() + "<br />";
	});
	var contact_youAre =  str;
	str = "";
	*/
	
	var selectElmnt = document.getElementById('contact_youAre');
	var contact_youAre =  selectElmnt.options[selectElmnt.selectedIndex].value;

	var contact_tel = $('[name="test-contact_tel"]').val();
	var Padresse = $('[name="test-Padresse"]').val();
	var Pcp = $('[name="test-Pcp"]').val();
	var Pville = $('[name="test-Pville"]').val();
	var PDateArrivee = $('[name="test-PDateArrivee"]').val();
	var PDateDepart = $('[name="test-PDateDepart"]').val();
	var PNbPersonne = $('[name="test-PNbPersonne"]').val();
	var commentaire = $('[name="test-commentaire"]').val();

	var ischecked = 0;
	var Newsletter="";
	$("input[type=checkbox][name=test-Newsletter[]][checked]").each(
		function() {
			Newsletter+=$(this).val()+",";
		}
	);


	var dataPost = "centre="+document.getElementById('centre').value+"&Type_de_personne="+contact_youAre+"&Nom="+nom+"&Nom_de_l_ecole="+Pecole+"&Mail="+mail+"&Nom_de_la_structure="+Pstructure+"&Nom_de_l_association="+Passociation+"&Niveau_scolaire="+Pniveau+"&Discipline="+Pdiscipline+"&Pays="+Ppays+"&Type_d_etablissement="+Petablissement+"&Telephone="+contact_tel+"&Adresse="+Padresse+"&Code_postal="+Pcp+"&Ville="+Pville+"&Date_d_arrivee="+PDateArrivee+"&Date_de_depart="+PDateDepart+"&Nombre_de_personne="+PNbPersonne+"&Commentaire="+commentaire+"&Newsletter="+Newsletter+"&userCode="+document.getElementById('userCode').value;
	
	$.ajax({
		type: "POST",
		url: "ajax/disponibilite.action.php",
		data: dataPost,
		success: function(msg){

			tab = msg.split('|');
			if(tab[1] != "BAD_CAPTCHA"){
				alert(tab[1]);
			}else{
				alert(get_trad_champ('bad_captcha'));
			}
		}
	});


}

function sendProjet(){
	var nom = $('[name="test-contact_name"]').val();
	var Pecole = $('[name="test-Pecole"]').val();
	var mail = $('[name="test-email-contact_mail"]').val();
	var Pstructure = $('[name="test-Pstructure"]').val();
	var Passociation = $('[name="test-Passociation"]').val();
	var str = "";
	$("select[name=test-Pniveau] option:selected").each(function () {
		str += $(this).text() ;
	});
	var Pniveau =  str;
	str = "";

	$("select[name=test-Pdiscipline] option:selected").each(function () {
		str += $(this).text() ;
	});
	var Pdiscipline =  str;

	str = "";
	$("select[name=test-Ppays] option:selected").each(function () {
		str += $(this).text() ;
	});
	var Ppays =  str;
	str = "";


	$("select[name=test-Petablissement] option:selected").each(function () {
		str += $(this).text() ;
	});
	var Petablissement =  str;
	str = "";
	
	$("select[name=contact_youAre] option:selected").each(function () {
		str += $(this).text() ;
		youAre_id = $(this).val();
	});
	var contact_youAre =  str; 
	str = "";

	var contact_tel = $('[name="test-contact_tel"]').val();
	var Padresse = $('[name="test-Padresse"]').val();
	var Pcp = $('[name="test-Pcp"]').val();
	var Pville = $('[name="test-Pville"]').val();
	var PDateArrivee = $('[name="test-PDateArrivee"]').val();
	var PDateDepart = $('[name="test-PDateDepart"]').val();
	var PNbPersonne = $('[name="test-PNbPersonne"]').val();
	var commentaire = $('[name="test-contact_commentaire"]').val();
	var Newsletter = $('[name="test-Newsletter"]').val();


	var dataPost = "youAre_id="+youAre_id+"&Type_de_personne="+contact_youAre+"&Nom="+nom+"&Nom_de_l_ecole="+Pecole+"&Mail="+mail+"&Nom_de_la_structure="+Pstructure+"&Nom_de_l_association="+Passociation+"&Niveau_scolaire="+Pniveau+"&Discipline="+Pdiscipline+"&Pays="+Ppays+"&Type_d_etablissement="+Petablissement+"&Telephone="+contact_tel+"&Adresse="+Padresse+"&Code_postal="+Pcp+"&Ville="+Pville+"&Date_d_arrivee="+PDateArrivee+"&Date_de_depart="+PDateDepart+"&Nombre_de_personne="+PNbPersonne+"&Commentaire="+commentaire+"&Newsletter="+Newsletter+"&userCode="+document.getElementById('userCode').value;

	$.ajax({
		type: "POST",
		url: "ajax/sendProjet.action.php",
		data: dataPost,
		success: function(msg){

			tab = msg.split('|');
			if(tab[1] != "BAD_CAPTCHA"){
				alert(tab[1]);
			}else{
				alert(get_trad_champ('bad_captcha'));
			}
		}
	});


}

// RPL - 24/05/2011 : declinaison de checkForm avec prise en charge du captcha.
function checkFormCaptcha(idForm,func,doAction){
	// RPL - 24/05/2011
	// validation captcha
	$.ajax({
		type: "POST",
		url: "ajax/testCaptcha.php",
		data: "userCode="+document.getElementById('userCode').value,
		success: function(msg){

			tab = msg.split('|');

			if(tab[1] == "BAD_CAPTCHA"){
				alert(get_trad_champ('bad_captcha'));
				document.getElementById('userCode').focus();
				return false;
			}
			else
				return checkForm(idForm,func,doAction);
		}
	});
}


function checkForm(idForm,func,doAction){

	
	//var els = els.elements; // elements du formulaire
	var els = document.forms[idForm].elements;
	var regEx =/^test-(.+)/; // expression reguliere testant si le champs est a valider
	
	for ( var i = 0 ; i < els.length ; i++ ) { // on boucle sur les elements du formulaire
		
		if(els[i].name != undefined && els[i].name != "" && els[i].name != "userCode"){
			
			id_P = str_replace("test-","",els[i].name);
			id_P = str_replace("[]","",id_P);
			if(document.getElementById(id_P) != null && document.getElementById(id_P).style.display=="none"){
				passe=1;
			}else{
				passe=0;
			}


			if(passe == 0){
				if(regEx.test(trim(els[i].name.toString()))){ // test si le champs est a valider
					txt = str_replace("_"," ",els[i].id);
					txt = str_replace("[]"," ",txt);
					
					switch(els[i].type){ //Chaque element a son test personnalise

						//test des champs de type text
						case "text":
						
						if(trim(els[i].value).length <= 0){

							alert(get_trad_champ('test_champs_obl')+txt);
							els[i].focus();
							return false;
						}else{ // test si c'est un champs contenant un email
							regExEmail = /^test-email-(.+)/;
							if(regExEmail.test(trim(els[i].name.toString()))){
								if(!isEmail(els[i].value)){

									alert(get_trad_champ('email'));
									els[i].focus();
									return false;
								}
							}
						}
						break;


						//test des champs de type textarea
						case "textarea":
						
						if(trim(els[i].value).length <= 0){
							alert(get_trad_champ('test_champs_obl')+txt);
							els[i].focus();
							return false;
						}
						break;

						//test des champs de type file
						case "file":
						
						if(trim(els[i].value).length <= 0){
							alert("vous devez envoyer un fichier");
							els[i].focus();
							return false;
						}else{
							//test si l'extention est valide
							if( /^(.+)\.(pdf|jpg|gif|avi)/i.test(trim(els[i].value.toLowerCase())) == false){
								alert("vous n'avez pas choisi le bon type de fichier");
								els[i].focus();
								return false;
							}
						}
						break;


						//test des champs de type radio
						case "radio": // test pour les champs radio
						
						var test = false;
						var nom_champ = els[i].name; // si des champs radio se suivent et ne porte pas le meme nom on les traites separement
						// on boucle sur les champs radio pour savoir si au moins un champs est selectionne
						while(els[i].type == "radio" && nom_champ == els[i].name){
							if(els[i].checked){
								test = true;
							}
							i++;
						}
						i--;
						if(!test){
							alert(get_trad_champ('test_champs_obl_option')+" "+str_replace("test-","",els[i].name));
							els[i].focus();
							return false;
						}
						break;


						//test des champs de type checkbox
						case "checkbox":
			
							var ischecked = 0;
							
							$("input[type=checkbox][name="+els[i].name+"][checked]").each(
								function() {
									ischecked++;
								}
							);
														
							if(ischecked==0){
								txt = str_replace("test-","",els[i].name);
								txt = str_replace("[]","",txt);
								alert(get_trad_champ('test_champs_obl_option')+" "+txt);
								els[i].focus();
								return false;
							}
						break;


						//test des champs de type select ou une seul selection est possible
						case "select-one":
						
						var test = false;
						for(var x=0; x < els[i].length; x++){
							if(els[i][x].selected && els[i][x].value != '-1'&& trim(els[i][x].value) != ''){
								test = true;
							}
						}
						if(!test){
							alert(get_trad_champ('test_champs_obl_option_liste')+txt);
							els[i].focus();
							return false;
						}
						break;


						//test des champs de type select ou plusieurs selections sont possible
						case "select-multiple":
						
						var test = false;
						for(var x=0; x < els[i].length; x++){
							if(els[i][x].selected && els[i][x].value != '-1'&& trim(els[i][x].value) != ''){
								test = true;
							}
						}
						if(!test){
							alert(get_trad_champ('test_champs_obl_option_liste')+txt);
							els[i].focus();
							return false;
						}
						break;
					} // fin du switch
				}
			}
		} // fin du if
	} // fin du for
	
	if(test){

		if(func == "sendDispoCentre()"){			
			sendDispoCentre();
		}
		else if(func == "sendProjet()"){
			sendProjet();
		}else{
			document.forms[idForm].submit();
		}
	}else{
		return false;
	}
}


function checkFormAjax(idForm,func,doAction){


	//var els = els.elements; // elements du formulaire
	var els = document.forms[idForm].elements;
	var regEx =/^test-(.+)/; // expression reguliere testant si le champs est a valider
	for ( var i = 0 ; i < els.length ; i++ ) { // on boucle sur les elements du formulaire

		if(els[i].name != undefined){
			id_P = str_replace("test-","",els[i].name);
			id_P = str_replace("[]","",id_P);
			if(document.getElementById(id_P) != null && document.getElementById(id_P).style.display=="none"){
				passe=1;
			}else{
				passe=0;
			}


			if(passe == 0){
				if(regEx.test(trim(els[i].name.toString()))){ // test si le champs est a valider
					txt = str_replace("_"," ",els[i].id);
					txt = str_replace("[]"," ",txt);
					switch(els[i].type){ //Chaque element a son test personnalise

						//test des champs de type text
						case "text":
						if(trim(els[i].value).length <= 0){

							alert(get_trad_champ('test_champs_obl')+txt);
							els[i].focus();
							return false;
						}else{ // test si c'est un champs contenant un email
							regExEmail = /^test-email-(.+)/;
							if(regExEmail.test(trim(els[i].name.toString()))){
								if(!isEmail(els[i].value)){

									alert(get_trad_champ('email'));
									els[i].focus();
									return false;
								}
							}
						}
						break;


						//test des champs de type textarea
						case "textarea":
						if(trim(els[i].value).length <= 0){
							alert(get_trad_champ('test_champs_obl')+txt);
							els[i].focus();
							return false;
						}
						break;

						//test des champs de type file
						case "file":
						if(trim(els[i].value).length <= 0){
							alert("vous devez envoyer un fichier");
							els[i].focus();
							return false;
						}else{
							//test si l'extention est valide
							if( /^(.+)\.(pdf|jpg|gif|avi)/i.test(trim(els[i].value.toLowerCase())) == false){
								alert("vous n'avez pas choisi le bon type de fichier");
								els[i].focus();
								return false;
							}
						}
						break;


						//test des champs de type radio
						case "radio": // test pour les champs radio
						var test = false;
						var nom_champ = els[i].name; // si des champs radio se suivent et ne porte pas le meme nom on les traites separement
						// on boucle sur les champs radio pour savoir si au moins un champs est selectionne
						while(els[i].type == "radio" && nom_champ == els[i].name){
							if(els[i].checked){
								test = true;
							}
							i++;
						}
						i--;
						if(!test){
							alert(get_trad_champ('test_champs_obl_option')+" "+str_replace("test-","",els[i].name));
							els[i].focus();
							return false;
						}
						break;


						//test des champs de type checkbox
						case "checkbox":
						if(!els[i].checked){
							alert(get_trad_champ('test_champs_obl_option')+txt);
							els[i].focus();
							return false;
						}
						break;


						//test des champs de type select a une seul selection est possible
						case "select-one":
						var test = false;
						for(var x=0; x < els[i].length; x++){
							if(els[i][x].selected && els[i][x].value != '-1'&& trim(els[i][x].value) != ''){
								test = true;
							}
						}
						if(!test){
							alert(get_trad_champ('test_champs_obl_option_liste')+txt);
							els[i].focus();
							return false;
						}
						break;


						//test des champs de type select ou plusieurs selections sont possible
						case "select-multiple":
						var test = false;
						for(var x=0; x < els[i].length; x++){
							if(els[i][x].selected && els[i][x].value != '-1'&& trim(els[i][x].value) != ''){
								test = true;
							}
						}
						if(!test){
							alert(get_trad_champ('test_champs_obl_option_liste')+txt);
							els[i].focus();
							return false;
						}
						break;
					} // fin du switch
				}
			}
		} // fin du for
	} // fin du if

	if(test){

		return true;

	}else{
		return false;
	}
}


function isEmail(strSaisie) {
	var verif = /^[^@]+@(([\w\-]+\.){1,4}[a-zA-Z]{2,4}|(([01]?\d?\d|2[0-4]\d|25[0-5])\.){3}([01]?\d?\d|2[0-4]\d|25[0-5]))$/
	return ( verif.test(strSaisie) );
}

function trim(aString) {
	var regExpBeginning = /^\s+/;
	var regExpEnd       = /\s+$/;
	return aString.replace(regExpBeginning, "").replace(regExpEnd, "");
}

function str_replace(a, b, str) {
	return str_replace2(str, a, b);
}
function str_replace2(SRs, SRt, SRu) {
	SRRi = SRs.indexOf(SRt);
	SRRr = '';
	if (SRRi == -1) return SRs;
	SRRr += SRs.substring(0,SRRi) + SRu;
	if ( SRRi + SRt.length < SRs.length)
	SRRr += str_replace2(SRs.substring(SRRi + SRt.length, SRs.length), SRt, SRu);
	return SRRr;
}