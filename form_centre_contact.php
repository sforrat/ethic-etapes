<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	GPE 							  
/*	Date : 		MAI 2010
/*	Version :	1.0							  
/*	Fichier :	fiche_centre_contact.php						  
/*										  
/*	Description :	Page sejour
/**********************************************************************************/

function getListeCentreContactType(&$listeContactType, $_params = "")
{
	$sql .= " SELECT 		id_centre_contact_type as id
				  	FROM 			centre_contact_type 
						ORDER BY 	id_centre_contact_type ASC";
	$rst = mysql_query($sql);
	
	if (!$rst)
		echo mysql_error. " - ".$sql;
		
	$nb = mysql_num_rows($rst);
	
	while($row = mysql_fetch_object($rst))
	{		
		$listeContactType[] = array (	"id" =>  			$row->id,
																	"libelle" => 	getTradTable("centre_contact_type",$_SESSION['ses_langue'],"libelle", $row->id));
	}
	
	return $nb;
} // getListeCentreContactType(&$listeContactType, $_params = "")



// Initialisation de la page
$path="./";
require($path."include/inc_header.inc.php");

?>

<script type="text/javascript">

function checkFormCentreContactEnseignant()
{
	var sData = '';
	var newsletterid=new Array();
	$("input[type=checkbox][name=test-Newsletter]").each( 
    function() { 
    	  
    		if(this.checked == true){
	     	 newsletterid.push(this.value);
    		}
	    } 
	);
	listeN = newsletterid.join(",");
	if(!$('#txtContactEnseignantNom').attr('value')) 
	{ 
		alert(get_trad_champ('nom'));
		return ;
	}
	if(!$('#txtContactEnseignantPrenom').attr('value')) 
	{
		alert(get_trad_champ('prenom'));
		return ;
	}
	if(!$('#txtContactEnseignantEcole').attr('value')) 
	{
		alert(get_trad_champ('nom_ecole'));
		return ;
	}
	if(!$('#txtContactEnseignantEmail').attr('value')) 
	{
		alert(get_trad_champ('email'));
		return ;
	}

	if(!isValidEmail($('#txtContactEnseignantEmail').attr('id'))) 
	{
		alert(get_trad_champ('email'));
		return ;
	}

	if(!$('#txtContactEnseignantCp').attr('value')) 
	{
		alert(get_trad_champ('cp'));
		return ;
	}
	if(!$('#txtContactEnseignantVille').attr('value')) 
	{
		alert(get_trad_champ('ville'));
		return ;
	}
	if(!$('#slctContactEnseignantPays').attr('value')) 
	{
		alert(get_trad_champ('pays'));
		return ;
	}
 	
	if(!$('#slctContactEnseignantNivScol').val()) 
	{
		alert(get_trad_champ('niveau_scolaire'));
		return ;
	}
	
	
	
	if(!$('#slctContactEnseignantEtablissType').val()) 
	{
		alert(get_trad_champ('type_etablissement'));
		return ;
	}
	
	sData+='slctContactType='+$('#slctFicheCentreContactType').attr('value');
	sData+='&slctContactCiv='+$('#slctContactEnseignantCiv').attr('value');
	sData+='&txtContactNom='+$('#txtContactEnseignantNom').attr('value');
	sData+='&txtContactPrenom='+$('#txtContactEnseignantPrenom').attr('value');
	sData+='&txtContactEcole='+$('#txtContactEnseignantEcole').attr('value');
	sData+='&txtContactEmail='+$('#txtContactEnseignantEmail').attr('value');
	sData+='&txtContactAdresse='+$('#txtContactEnseignantAdresse').attr('value');
	sData+='&txtContactCp='+$('#txtContactEnseignantCp').attr('value');
	sData+='&txtContactVille='+$('#txtContactEnseignantVille').attr('value');
	sData+='&slctContactPays='+$('#slctContactEnseignantPays').attr('value');
	sData+='&txtContactTel='+$('#txtContactEnseignantTel').attr('value');
	sData+='&txtContactFax='+$('#txtContactEnseignantFax').attr('value');
	sData+='&slctContactNivScol='+$('#slctContactEnseignantNivScol').val();
	sData+='&slctContactEtablissType='+$('#slctContactEnseignantEtablissType').val();
	sData+='&txtaContactCommQuest='+$('#txtaContactEnseignantCommQuest').attr('value');
	sData+='&id_centre='+$('#id_centre').attr('value');
	sData+='&newsletter='+listeN;
	
	$.ajax({
	   type: "POST",
	   url: "send_form_contact_centre.php",
	   data: sData,
	   success: function(response){
	   		//if(response != "") 
                        $('.innerPopin').html(get_trad_champ('reponse_ajax_ok'));
	   		//else $('.innerPopin').html(get_trad_champ('reponse_ajax_failed'));
	   		$.fn.colorbox.resize();
	   }   
	 });
	

}

function checkFormCentreContactAssociation()
{
	var sData = '';
	var newsletterid=new Array();
	$("input[type=checkbox][name=test-Newsletter]").each( 
    function() { 
    	  
    		if(this.checked == true){
	     	 newsletterid.push(this.value);
    		}
	    } 
	);
	listeN = newsletterid.join(",");
	if(!$('#txtContactAssociatNom').attr('value')) 
	{ 
		alert(get_trad_champ('nom'));
		return ;
	}
	if(!$('#txtContactAssociatPrenom').attr('value')) 
	{
		alert(get_trad_champ('prenom'));
		return ;
	}

	if(!$('#txtContactAssociatEmail').attr('value')) 
	{
		alert(get_trad_champ('email'));
		return ;
	}

	if(!isValidEmail($('#txtContactAssociatEmail').attr('id'))) 
	{
		alert(get_trad_champ('email'));
		return ;
	}

	if(!$('#txtContactAssociatNomOrg').attr('value')) 
	{
		alert(get_trad_champ('nom_association'));
		return ;
	}

	if(!$('#slctContactAssociatDiscipline').val()) 
	{
		alert(get_trad_champ('discipline'));
		return ;
	}
	
	if(!$('#txtContactAssociatCp').attr('value')) 
	{
		alert(get_trad_champ('cp'));
		return ;
	}
	if(!$('#txtContactAssociatVille').attr('value')) 
	{
		alert(get_trad_champ('ville'));
		return ;
	}

	if(!$('#slctContactAssociatPays').attr('value')) 
	{
		alert(get_trad_champ('pays'));
		return ;
	}
	
	sData+='slctContactType='+$('#slctFicheCentreContactType').attr('value');
	sData+='&slctContactCiv='+$('#slctContactAssociatCiv').attr('value');
	sData+='&txtContactNom='+$('#txtContactAssociatNom').attr('value');
	sData+='&txtContactPrenom='+$('#txtContactAssociatPrenom').attr('value');
	sData+='&txtContactEmail='+$('#txtContactAssociatEmail').attr('value');
	sData+='&slctContactDiscipline='+$('#slctContactAssociatDiscipline').val().join(',');
	sData+='&txtContactAdresse='+$('#txtContactAssociatAdresse').attr('value');
	sData+='&txtContactCp='+$('#txtContactAssociatCp').attr('value');
	sData+='&txtContactVille='+$('#txtContactAssociatVille').attr('value');
	sData+='&slctContactPays='+$('#slctContactAssociatPays').attr('value');
	sData+='&txtContactTel='+$('#txtContactAssociatTel').attr('value');
	sData+='&txtContactFax='+$('#txtContactAssociatFax').attr('value');
	sData+='&txtaContactCommQuest='+$('#txtaContactAssociatCommQuest').attr('value');
	sData+='&id_centre='+$('#id_centre').attr('value');
	sData+='&newsletter='+listeN;
	
	$.ajax({
	   type: "POST",
	   url: "send_form_contact_centre.php",
	   data: sData,
	   success: function(response){
	   		//if(response != "") 
                        $('.innerPopin').html(get_trad_champ('reponse_ajax_ok'));
	   		//else $('.innerPopin').html(get_trad_champ('reponse_ajax_failed'));
	   		$.fn.colorbox.resize();
	   }   
	 });

}

function checkFormCentreContactParticulier()
{
	var sData = '';
	
	
	var newsletterid=new Array();
	$("input[type=checkbox][name=test-Newsletter]").each( 
    function() { 
    	  
    		if(this.checked == true){
	     	 newsletterid.push(this.value);
    		}
	    } 
	);
	listeN = newsletterid.join(",");
	
	if(!$('#txtContactParticulNom').attr('value')) 
	{ 
		alert(get_trad_champ('nom'));
		return ;
	}
	if(!$('#txtContactParticulPrenom').attr('value')) 
	{
		alert(get_trad_champ('prenom'));
		return ;
	}

	if(!$('#txtContactParticulEmail').attr('value')) 
	{
		alert(get_trad_champ('email'));
		return ;
	}

	if(!isValidEmail($('#txtContactParticulEmail').attr('id'))) 
	{
		alert(get_trad_champ('email'));
		return ;
	}
	
	if(!$('#txtContactParticulCp').attr('value')) 
	{
		alert(get_trad_champ('cp'));
		return ;
	}
	if(!$('#txtContactParticulVille').attr('value')) 
	{
		alert(get_trad_champ('ville'));
		return ;
	}

	if(!$('#slctContactParticulPays').attr('value')) 
	{
		alert(get_trad_champ('pays'));
		return ;
	}
	
	sData+='slctContactType='+$('#slctFicheCentreContactType').attr('value');
	sData+='&slctContactCiv='+$('#slctContactParticulCiv').attr('value');
	sData+='&txtContactNom='+$('#txtContactParticulNom').attr('value');
	sData+='&txtContactPrenom='+$('#txtContactParticulPrenom').attr('value');
	sData+='&txtContactEmail='+$('#txtContactParticulEmail').attr('value');
	sData+='&txtContactAdresse='+$('#txtContactParticulAdresse').attr('value');
	sData+='&txtContactCp='+$('#txtContactParticulCp').attr('value');
	sData+='&txtContactVille='+$('#txtContactParticulVille').attr('value');
	sData+='&slctContactPays='+$('#slctContactParticulPays').attr('value');
	sData+='&txtContactTel='+$('#txtContactParticulTel').attr('value');
	sData+='&txtaContactCommQuest='+$('#txtaContactParticulCommQuest').attr('value');
	sData+='&id_centre='+$('#id_centre').attr('value');
	sData+='&newsletter='+listeN;
	
	$.ajax({
	   type: "POST",
	   url: "send_form_contact_centre.php",
	   data: sData,
	   success: function(response){
	   		//if(response != "") 
                        $('.innerPopin').html(get_trad_champ('reponse_ajax_ok'));
	   		//else $('.innerPopin').html(get_trad_champ('reponse_ajax_failed'));
	   		$.fn.colorbox.resize();
	   }   
	 });

}

function checkFormCentreContactAutre()
{
	var sData = '';
	
	
	var newsletterid=new Array();
	$("input[type=checkbox][name=test-Newsletter]").each( 
    function() { 
    	  
    		if(this.checked == true){
	     	 newsletterid.push(this.value);
    		}
	    } 
	);
	listeN = newsletterid.join(",");
	
	
	if(!$('#txtContactAutreNom').attr('value')) 
	{ 
		alert(get_trad_champ('nom'));
		return ;
	}
	if(!$('#txtContactAutrePrenom').attr('value')) 
	{
		alert(get_trad_champ('prenom'));
		return ;
	}

	if(!$('#txtContactAutreEmail').attr('value')) 
	{
		alert(get_trad_champ('email'));
		return ;
	}

	if(!isValidEmail($('#txtContactAutreEmail').attr('id'))) 
	{
		alert(get_trad_champ('email'));
		return ;
	}
	
	if(!$('#txtContactAutreStructure').attr('value')) 
	{
		alert(get_trad_champ('nom_structure'));
		return ;
	}
	
	if(!$('#txtContactAutreCp').attr('value')) 
	{
		alert(get_trad_champ('cp'));
		return ;
	}
	if(!$('#txtContactAutreVille').attr('value')) 
	{
		alert(get_trad_champ('ville'));
		return ;
	}

	if(!$('#slctContactAutrePays').attr('value')) 
	{
		alert(get_trad_champ('pays'));
		return ;
	}
	
	sData+='slctContactType='+$('#slctFicheCentreContactType').attr('value');
	sData+='&slctContactCiv='+$('#slctContactAutreCiv').attr('value');
	sData+='&txtContactNom='+$('#txtContactAutreNom').attr('value');
	sData+='&txtContactPrenom='+$('#txtContactAutrePrenom').attr('value');
	sData+='&txtContactEmail='+$('#txtContactAutreEmail').attr('value');
	sData+='&txtContactStructure='+$('#txtContactAutreStructure').attr('value');
	sData+='&txtContactAdresse='+$('#txtContactAutreAdresse').attr('value');
	sData+='&txtContactCp='+$('#txtContactAutreCp').attr('value');
	sData+='&txtContactVille='+$('#txtContactAutreVille').attr('value');
	sData+='&slctContactPays='+$('#slctContactAutrePays').attr('value');
	sData+='&txtContactTel='+$('#txtContactAutreTel').attr('value');
	sData+='&txtaContactCommQuest='+$('#txtaContactAutreCommQuest').attr('value');
	sData+='&id_centre='+$('#id_centre').attr('value');
	sData+='&newsletter='+listeN;
	
	$.ajax({
	   type: "POST",
	   url: "send_form_contact_centre.php",
	   data: sData,
	   success: function(response){
	   		//if(response != "") 
                        $('.innerPopin').html(get_trad_champ('reponse_ajax_ok'));
	   		//else $('.innerPopin').html(get_trad_champ('reponse_ajax_failed'));
	   		$.fn.colorbox.resize();
	   }   
	 });

}

function checkFormCentreContactPresse()
{
	var sData = '';
	var newsletterid=new Array();
	$("input[type=checkbox][name=test-Newsletter]").each( 
    function() { 
    	  
    		if(this.checked == true){
	     	 newsletterid.push(this.value);
    		}
	    } 
	);
	listeN = newsletterid.join(",");
	if(!$('#txtContactPresseNom').attr('value')) 
	{ 
		alert(get_trad_champ('nom'));
		return ;
	}
	if(!$('#txtContactPressePrenom').attr('value')) 
	{
		alert(get_trad_champ('prenom'));
		return ;
	}

	if(!$('#txtContactPresseEmail').attr('value')) 
	{
		alert(get_trad_champ('email'));
		return ;
	}

	if(!isValidEmail($('#txtContactPresseEmail').attr('id'))) 
	{
		alert(get_trad_champ('email'));
		return ;
	}
	
	sData+='slctContactType='+$('#slctFicheCentreContactType').attr('value');
	sData+='&slctContactCiv='+$('#slctContactPresseCiv').attr('value');
	sData+='&txtContactNom='+$('#txtContactPresseNom').attr('value');
	sData+='&txtContactPrenom='+$('#txtContactPressePrenom').attr('value');
	sData+='&txtContactEmail='+$('#txtContactPresseEmail').attr('value');
	sData+='&txtContactMedia='+$('#txtContactPresseMedia').attr('value');
	sData+='&txtContactTel='+$('#txtContactPresseTel').attr('value');
	sData+='&txtContactFax='+$('#txtContactPresseFax').attr('value');
	sData+='&txtaContactCommQuest='+$('#txtaContactPresseCommQuest').attr('value');
	sData+='&id_centre='+$('#id_centre').attr('value');
	sData+='&newsletter='+listeN;
	
	$.ajax({
	   type: "POST",
	   url: "send_form_contact_centre.php",
	   data: sData,
	   success: function(response){
	   		//if(response != "") 
                        $('.innerPopin').html(get_trad_champ('reponse_ajax_ok'));
	   		//else $('.innerPopin').html(get_trad_champ('reponse_ajax_failed'));
	   		$.fn.colorbox.resize();
	   }   
	 });

}

function checkFormCentreContactPartenaire()
{
	var sData = '';
	var newsletterid=new Array();
	$("input[type=checkbox][name=test-Newsletter]").each( 
    function() { 
    	  
    		if(this.checked == true){
	     	 newsletterid.push(this.value);
    		}
	    } 
	);
	listeN = newsletterid.join(",");
	if(!$('#txtContactPartenaireNom').attr('value')) 
	{ 
		alert(get_trad_champ('nom'));
		return ;
	}
	if(!$('#txtContactPartenairePrenom').attr('value')) 
	{
		alert(get_trad_champ('prenom'));
		return ;
	}

	if(!$('#txtContactPartenaireEmail').attr('value')) 
	{
		alert(get_trad_champ('email'));
		return ;
	}

	if(!isValidEmail($('#txtContactPartenaireEmail').attr('id'))) 
	{
		alert(get_trad_champ('email'));
		return ;
	}
	
	if(!$('#txtContactPartenaireStructure').attr('value')) 
	{
		alert(get_trad_champ('nom_structure'));
		return ;
	}
	
	sData+='slctContactType='+$('#slctFicheCentreContactType').attr('value');
	sData+='&slctContactCiv='+$('#slctContactPartenaireCiv').attr('value');
	sData+='&txtContactNom='+$('#txtContactPartenaireNom').attr('value');
	sData+='&txtContactPrenom='+$('#txtContactPartenairePrenom').attr('value');
	sData+='&txtContactEmail='+$('#txtContactPartenaireEmail').attr('value');
	sData+='&txtContactStructure='+$('#txtContactPartenaireStructure').attr('value');
	sData+='&txtContactTel='+$('#txtContactPartenaireTel').attr('value');
	sData+='&txtContactFax='+$('#txtContactPartenaireFax').attr('value');
	sData+='&txtaContactCommQuest='+$('#txtaContactPartenaireCommQuest').attr('value');
	sData+='&id_centre='+$('#id_centre').attr('value');
	sData+='&newsletter='+listeN;
	
	$.ajax({
	   type: "POST",
	   url: "send_form_contact_centre.php",
	   data: sData,
	   success: function(response){
	   		//if(response != "") 
                        $('.innerPopin').html(get_trad_champ('reponse_ajax_ok'));
	   		//else $('.innerPopin').html(get_trad_champ('reponse_ajax_failed'));
	   		$.fn.colorbox.resize();
	   }   
	 });

}

function checkFormCentreContactCollectivite()
{
	var sData = '';
	var newsletterid=new Array();
	$("input[type=checkbox][name=test-Newsletter]").each( 
    function() { 
    	  
    		if(this.checked == true){
	     	 newsletterid.push(this.value);
    		}
	    } 
	);
	var listeN = newsletterid.join(",");
	if(!$('#txtContactCollectivNom').attr('value')) 
	{ 
		alert(get_trad_champ('nom'));
		return ;
	}
	if(!$('#txtContactCollectivPrenom').attr('value')) 
	{
		alert(get_trad_champ('prenom'));
		return ;
	}

	if(!$('#txtContactCollectivEmail').attr('value')) 
	{
		alert(get_trad_champ('email'));
		return ;
	}

	if(!isValidEmail($('#txtContactCollectivEmail').attr('id'))) 
	{
		alert(get_trad_champ('email'));
		return ;
	}
	
	if(!$('#txtContactCollectivNomCollec').attr('value')) 
	{
		alert(get_trad_champ('nom_collectivite'));
		return ;
	}
	
	if(!$('#txtContactCollectivCp').attr('value')) 
	{
		alert(get_trad_champ('cp'));
		return ;
	}
	if(!$('#txtContactCollectivVille').attr('value')) 
	{
		alert(get_trad_champ('ville'));
		return ;
	}

	if(!$('#slctContactCollectivPays').attr('value')) 
	{
		alert(get_trad_champ('pays'));
		return ;
	}
	
	sData+='slctContactType='+$('#slctFicheCentreContactType').attr('value');
	sData+='&slctContactCiv='+$('#slctContactCollectivCiv').attr('value');
	sData+='&txtContactNom='+$('#txtContactCollectivNom').attr('value');
	sData+='&txtContactPrenom='+$('#txtContactCollectivPrenom').attr('value');
	sData+='&txtContactEmail='+$('#txtContactCollectivEmail').attr('value');
	sData+='&txtContactNomCollec='+$('#txtContactCollectivNomCollec').attr('value');
	sData+='&txtContactFonction='+$('#txtContactCollectivFonction').attr('value');
	sData+='&txtContactAdresse='+$('#txtContactCollectivAdresse').attr('value');
	sData+='&txtContactCp='+$('#txtContactCollectivCp').attr('value');
	sData+='&txtContactVille='+$('#txtContactCollectivVille').attr('value');
	sData+='&slctContactPays='+$('#slctContactCollectivPays').attr('value');
	sData+='&txtContactTel='+$('#txtContactCollectivTel').attr('value');
	sData+='&txtContactFax='+$('#txtContactCollectivFax').attr('value');
	sData+='&txtaContactCommQuest='+$('#txtaContactCollectivCommQuest').attr('value');
	sData+='&id_centre='+$('#id_centre').attr('value');
	sData+='&newsletter='+listeN;
	
	$.ajax({
	   type: "POST",
	   url: "send_form_contact_centre.php",
	   data: sData,
	   success: function(response){
	   		//if(response != "") 
                        $('.innerPopin').html(get_trad_champ('reponse_ajax_ok'));
	   		//else $('.innerPopin').html(get_trad_champ('reponse_ajax_failed'));
	   		$.fn.colorbox.resize();
	   }   
	 });

}

function checkFormCentreContactFuturEE()
{
	var sData = '';
	
	if(!$('#txtContactFuturEENom').attr('value')) 
	{ 
		alert(get_trad_champ('nom'));
		return ;
	}
	if(!$('#txtContactFuturEEPrenom').attr('value')) 
	{
		alert(get_trad_champ('prenom'));
		return ;
	}

	if(!$('#txtContactFuturEEEmail').attr('value')) 
	{
		alert(get_trad_champ('email'));
		return ;
	}

	if(!isValidEmail($('#txtContactFuturEEEmail').attr('id'))) 
	{
		alert(get_trad_champ('email'));
		return ;
	}
	
	if(!$('#txtContactFuturEENomEquipmt').attr('value'))
	{
		alert(get_trad_champ('nom_equipement'));
		return ;
	}
	
	if(!$('#txtContactFuturEECp').attr('value')) 
	{
		alert(get_trad_champ('cp'));
		return ;
	}
	if(!$('#txtContactFuturEEVille').attr('value')) 
	{
		alert(get_trad_champ('ville'));
		return ;
	}

	if(!$('#slctContactFuturEEPays').attr('value')) 
	{
		alert(get_trad_champ('pays'));
		return ;
	}
	
	if(!$('#txtContactFuturEETel').attr('value')) 
	{
		alert(get_trad_champ('tel'));
		return ;
	}
	
	sData+='slctContactType='+$('#slctFicheCentreContactType').attr('value');
	sData+='&slctContactCiv='+$('#slctContactFuturEECiv').attr('value');
	sData+='&txtContactNom='+$('#txtContactFuturEENom').attr('value');
	sData+='&txtContactPrenom='+$('#txtContactFuturEEPrenom').attr('value');
	sData+='&txtContactEmail='+$('#txtContactFuturEEEmail').attr('value');
	sData+='&txtContactNomEquipmt='+$('#txtContactFuturEENomEquipmt').attr('value');
	sData+='&txtContactFonction='+$('#txtContactFuturEEFonction').attr('value');
	sData+='&txtContactAdresse='+$('#txtContactFuturEEAdresse').attr('value');
	sData+='&txtContactCp='+$('#txtContactFuturEECp').attr('value');
	sData+='&txtContactVille='+$('#txtContactFuturEEVille').attr('value');
	sData+='&slctContactPays='+$('#slctContactFuturEEPays').attr('value');
	sData+='&txtContactTel='+$('#txtContactFuturEETel').attr('value');
	sData+='&txtContactFax='+$('#txtContactFuturEEFax').attr('value');
	sData+='&txtaContactPresentStruct='+$('#txtaContactFuturEEPresentStruct').attr('value');
	sData+='&id_centre='+$('#id_centre').attr('value');
	
	$.ajax({
	   type: "POST",
	   url: "send_form_contact_centre.php",
	   data: sData,
	   success: function(response){
	   		//if(response != "") 
                        $('.innerPopin').html(get_trad_champ('reponse_ajax_ok'));
	   		//else alert(get_trad_champ('reponse_ajax_failed'));
	   		$.fn.colorbox.resize();
	   }   
	 });

}
</script>
<?

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");

$iNbContactType = getListeCentreContactType($listeContactType,array('id_centre'=>array($iIdCentre)));//$_GET['id_centre']
$iNbContactCiv = getListeCivilite($listeCivilite);
$iNbContactPays = getListePays($listePays);
$iNbNiveauScolaire = getListeSejourInfos('niveau_scolaire', $listeSejourInfo);
$iNbContactEtablissementType = getListeEtablissementType($listeEtablissementType);
$iNbContactDiscipline = getListeDiscipline($listeDiscipline);


if($iNbContactType) 
{
	$template->assign("is_contact_type",true);
	$template->assign("listeContactType",$listeContactType);
}

$template->assign("id_centre",$_GET["id_centre"]);
if($iNbContactCiv) $template->assign("listeCivilite",$listeCivilite);
if($iNbContactPays) $template->assign("listePays",$listePays);
if($iNbNiveauScolaire) $template->assign("listeNiveauScolaire",$listeSejourInfo);
if($iNbContactEtablissementType) $template->assign("listeEtablissementType",$listeEtablissementType);
if($iNbContactDiscipline) $template->assign("listeDiscipline",$listeDiscipline);

//------- Type newsletter
$sql = "SELECT libelle,id__types_newsletter FROM trad_types_newsletter WHERE id__langue=".$_SESSION["ses_langue"];
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
	$tab["libelle"] = $myrow["libelle"];
	$tab["id"] = $myrow["id__types_newsletter"];
	$TabTypeNL[] = $tab;
	unset($tab);
}
$template->assign("TabTypeNews",$TabTypeNL);

//------- Nom centre pour envoi de mail
$template->assign("nom_centre", $_SESSION['nom_centre']);

$template->display('form_centre_contact.tpl');

?>