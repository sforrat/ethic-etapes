
function checkForm(els){
    var els = els.elements; // éléments du formulaire
    var regEx =/^test-(.+)/; // expression régulière testant si le champs est à valider
      for ( var i = 0 ; i < els.length ; i++ ) { // on boucle sur les éléments du formulaire
        if(regEx.test(trim(els[i].name.toString()))){ // test si le champs est à valider
             switch(els[i].type){ //Chaque élément à son test personnalisé

             //test des champs de type text
                case "text":
                    if(trim(els[i].value).length <= 0){
                        alert("vous devez remplir le champs de text");
                        els[i].focus();
                        return false;
                    }else{ // test si c'est un champs contenant un email
                        regExEmail = /^test-email-(.+)/;
                        if(regExEmail.test(trim(els[i].name.toString()))){
                            if(!isEmail(els[i].value)){
                                alert("l'email saisie est invalide");
                                els[i].focus();
                                return false;
                            }
                        }
                    }
                 break;


              //test des champs de type textarea
                case "textarea":
                    if(trim(els[i].value).length <= 0){
                        alert("vous devez remplir le champs de text");
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
                    var nom_champ = els[i].name; // si des champs radio se suivent et ne porte pas le même nom on les traites séparément
                    // on boucle sur les champs radio pour savoir si au moins un champs est sélectionné
                        while(els[i].type == "radio" && nom_champ == els[i].name){
                            if(els[i].checked){
                                test = true;
                            }
                            i++;
                        }
                        i--;
                    if(!test){
                        alert("vous devez sélectionner une option radio");
                        els[i].focus();
                        return false;
                    }
                 break;


            //test des champs de type checkbox
                case "checkbox":
                    if(!els[i].checked){
                        alert("vous devez sélectionner une option chekbox");
                        els[i].focus();
                        return false;
                    }
                 break;


            //test des champs de type select où une seul sélection est possible
                case "select-one":
                    var test = false;
                    for(var x=0; x < els[i].length; x++){
                        if(els[i][x].selected && els[i][x].value != '-1'&& trim(els[i][x].value) != ''){
                            test = true;
                        }
                    }
                    if(!test){
                        alert("vous devez sélectionner une option dans la liste déroulante");
                        els[i].focus();
                        return false;
                    }
                 break;


            //test des champs de type select où plusieurs sélections sont possible
                case "select-multiple":
                    var test = false;
                    for(var x=0; x < els[i].length; x++){
                        if(els[i][x].selected && els[i][x].value != '-1'&& trim(els[i][x].value) != ''){
                            test = true;
                        }
                    }
                    if(!test){
                        alert("vous devez sélectionner une option dans la liste multipe");
                        els[i].focus();
                        return false;
                    }
                 break;
             } // fin du switch
          } // fin du for
        } // fin du if
        if(test){
            return false;
        }
}


function isEmail(strSaisie) {
    var verif = /^[^@]+@(([\w\-]+\.){1,4}[a-zA-Z]{2,4}|(([01]?\d?\d|2[0-4]\d|25[0-5])\.){3}([01]?\d?\d|2[0-4]\d|25[0-5]))$/
    return ( verif.test(strSaisie) );
}

//fonction trouvé à l'adresse suivante
//http://anothergeekwebsite.com/fr/2007/03/trim-en-javascript
function trim(aString) {
    var regExpBeginning = /^\s+/;
    var regExpEnd       = /\s+$/;
    return aString.replace(regExpBeginning, "").replace(regExpEnd, "");
}
