function get_trad_champ(champ) 
{
		switch(champ)
		{
        case "newsletter" :
						return("Veuillez sélectionner un type de newsletter.");
						break;
        case "type_media" :
						return("Veuillez sélectionner un type de média.");
						break;
        case "media" :
						return("Veuillez renseigner le nom du média.");
						break;
				case "fonction" :
						return("Veuillez saisir votre fonction.");
						break;		
				case "civilite" :
						return("Veuillez selectionner votre civilité.");
						break;
        case "types_public" :
						return("Veuillez cocher au moins une case du champ 'Lectorat / Public'.");
						break;
case "nb_personne" :
						return("Veuillez renseigner le nombre de personnes.");
						break;
        case "bad_captcha" :
						return("Le code saisi ne correspond pas à l'image proposée.");
						break;
        case "commentaire" :
						return("Vous devez saisir votre avis ou commentaire.");
						break;
        case "test_champs_obl_option_liste" :
						return("Vous devez sélectionner une option dans la liste : ");
						break;
        case "test_champs_obl_option" :
						return("Vous devez sélectionner une option pour :");
						break;
        case "test_champs_obl" :
						return("Vous devez remplir le champs : ");
						break;
        case "niveau_scolaire" :
						return("Vous devez séléctionner au moins un niveau scolaire.");
						break;
				case "nom_ecole" :
						return("Vous devez saisir le nom de l'école");
						break;
				case "postulerMessage" :
						return("Vous devez saisir un texte de description de votre projet");
						break;	
				case "datepiker" :
						return("Vous devez selectionner une date de souhait d'embauche");
						break;	
				case "form_cours" :
						return("Vous devez selectionner au moins un critère");
						break;	
				case "form_equipe" :
						return("Vous devez selectionner au moins un critère");
						break;	
				case "nom" :
						return("Veuillez indiquer votre nom");
						break;	
				case "nom_ecole" :
						return("Veuillez indiquer le nom de votre école");
						break;							
				case "prenom" :
						return("Veuillez indiquer votre prénom");
						break;	
				case "tel" :
						return("Veuillez indiquer votre numéro de téléphone");
						break;								
				case "email" :
						return("L'email que vous avez rentrée n'est pas valide.\nVeuillez la ressaisir s'il vous plaît.");
						break;	
				case "adresse" :
						return("Veuillez indiquer votre adresse");
						break;	
				case "cp" :
						return("Veuillez indiquer votre code postal");
						break;	
				case "ville" :
						return("Veuillez indiquer votre ville");
						break;	
				case "pays" :
						return("Veuillez indiquer votre pays");
						break;			
				case "objet" :
						return("Veuillez sélectionner l'objet de votre message");
						break;	
				case "message" :
						return("Veuillez saisir votre message");
						break;	
				case "numeric" :
						return("Ce champ doit être numérique, il ne peut contenir aucun autre type de caratères.");
						break;	
				case "niveau_scolaire" :
						return("Veuillez sélectionner un niveau scolaire");
						break;	
				case "type_etablissement" :
						return("Veuillez sélectionner un type d'établissement");
						break;		
				case "age_enfant" :
						return("Veuillez indiquer l'âge de l'enfant");
						break;	
				case "nom_structure" :
						return("Veuillez indiquer le nom de la structure");
						break;		
				case "nom_association" :
						return("Veuillez indiquer le nom de l'association ou de l'organisme");
						break;
				case "nom_collectivite" :
						return("Veuillez indiquer le nom de la collectivité");
						break;
				case "nom_equipement" :
						return("Veuillez indiquer le nom de l'équipement");
						break;		
				case "discipline" :
						return("Veuillez sélectionner une discipline");
						break;
				case "reponse_ajax_ok" :
						return("Merci, votre demande a bien été prise en compte.");
						break;
				case "reponse_ajax_failed" :
						return("ATTENTION ! Une erreur est survenue lors de l'envoi.");
						break;		
				case "preciser_type_contact" :
						return ("Veuillez préciser qui vous êtes ");
						break;
				default :
						return(champ);
		}
}

function get_trad_lib(lib) 
{
		switch(lib)
		{
				case "vide" :
						return("Le champ XX est obligatoire.\nVeuillez le ressaisir s'il vous plaît.");
						break;
				default : 
						return(lib)
		}
}

function replace_lib(expr,a,b) {
   var i=0
   while (i!=-1) {
      i=expr.indexOf(a,i);
      if (i>=0) {
         expr=expr.substring(0,i)+b+expr.substring(i+a.length);
         i+=b.length;
      }
   }
   return expr
}