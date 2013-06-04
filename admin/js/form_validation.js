<!--
//**********************************************************************
//*	FULLSUD IT LYON : 11/10/2002								       *
//*			   Form Validation client scripts						   *
//*			   V 2.3.1	English										   *
//**********************************************************************
//
// Global vars definition
//
FS_VarAlpha='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
FS_VarDigit='0123456789';
FS_VarWhite=' \t\r\f\n';
FS_VarMaskNames=new Array('digit','alphabetic','non-blank','space');

// Error messages definitions
//FS_MsgLTMinSize='Warning: %1 must be at least %2 characters in length.';
FS_MsgLTMinSize='Attention: %1 la longueur doit �tre au mois de %2 caract�res.';
//FS_MsgNotInCharset='Warning: Character %2 is not allowed in %1.';
FS_MsgNotInCharset='Attention: Le caract�re %2 n\'est pas autoris� dans %1.';
//FS_MsgReqdFldEmpty='Sorry, %1 cannot be empty.';
FS_MsgReqdFldEmpty='Désolé, le champ \"%1\" ne peut pas être vide.';
//FS_MsgNotEmailFormat='It seems that %1 is not a valid email address.';
FS_MsgNotEmailFormat='Il semble que %1 n\'est pas une adresse email valide.';

//***************************************************************************************************
//* Function FS_FmtMsg									            *
//* Description :									            *
//* Function to substitute args (as strings) for positional markers %1, %2 etc. in source string    *
//*												    *
//* Args: InString - format specification; e.g. "Error %1 in Object %2" or "Object %2 has Error %1" *
//*		Args 2-n - substitution parameters						    *
//***************************************************************************************************
//
function FS_FmtMsg (MsgStr, Args)
{
	var i, c, Start;
	var OutStr = "";			
	for (i=0; i < MsgStr.length; i++)  
	{
		c = MsgStr.charAt (i);
		if ((c == '%') && (i < (MsgStr.length-1)))
		{
			i++;   c = MsgStr.charAt(i);
			if ((c == '%') || (FS_VarDigit.indexOf(c, 0) == -1))
				OutStr += '%';
			else
			{	
				Start = i++;
				while (i < MsgStr.length)
				{	// Scan until we hit a nondigit
					c = MsgStr.charAt(i);
					if (FS_VarDigit.indexOf(c, 0) == -1)
					{
						i--;	break;
					}
					i++;
				}
				Start = parseInt(MsgStr.substring(Start, i+1));
				if (Start < FS_FmtMsg.arguments.length)
				{
					OutStr += FS_FmtMsg.arguments[Start];
				}
				// otherwise leave it empty
			}
		}
		else
			OutStr += c;
	}
	return OutStr;
}
//***************************************************************************************************
//* Function FS_TextCharset								    *
//* Description :									            *
//* Test field to ensure all chars in specified charset; also tests fields for min len.             *
//*												    *
//* Args: formName, formField to be tested, min length, 
//*	  maskStr : =   # : field must be in numerical format			                    *
//* 	            or  W : white space forbidden in field					    *
//*		    or  A : field must be in alphabetic format					    *
//*	  otherStr : list of digits and or alphabetics cars authorized in this field 		    *
//*                              								    *
//***************************************************************************************************
//
function FS_TextCharset (formName, formField, minL, maskStr, otherStr, formLabel)
{
	var s = formName.elements[formField.name].value;
	var i,c;

	if (s.length == 0)
	{
		c = FS_TextCharset.caller.toString();
		if ((c.indexOf('onblur') != -1) || (c.indexOf('onBlur') != -1) || (c.indexOf('ONBLUR') != -1))
			return true;
		else if ((navigator.appName == 'Netscape')
			&& ((c.indexOf('onchange') != -1) || (c.indexOf('onChange') != -1) || (c.indexOf('ONCHANGE') != -1)))
			return true;
	}

	if ((minL != '') && (s.length < minL))
	{
		alert (FS_FmtMsg(FS_MsgLTMinSize, formField.name, minL)); 
		formName.elements[formField.name].focus(); return false;
	}
	if ((maskStr != '') || (otherStr != ''))
	{
		for (i = 0; i < s.length; i++)
		{	// Iterate through str, testing each char - as part of set if so; else as itself
			c = s.charAt(i);
			if (FS_VarDigit.indexOf(c) != -1) c = '#';
			else if (FS_VarWhite.indexOf(c) != -1) c = 'W';
			else if (FS_VarAlpha.indexOf(c) != -1) c = 'A';
			// Else use char itself. Test both as pseudo and as itself - user may
			//   list a single alphabetic (A, B) or digit (7) character in the "otherStr"
			if (((maskStr == '') || (maskStr.indexOf(c) == -1)) && 
				((otherStr == '') || (otherStr.indexOf(s.charAt(i)) == -1)))
			{
				alert (FS_FmtMsg(FS_MsgNotInCharset, formLabel, s.charAt(i)));
				formName.elements[formField.name].focus(); return false;
			}
		}
	}
	return true;
}
//***************************************************************************************************
//* Function FS_ReqdFlds								            *
//* Description :									            *
//* Function to test a form for empty 'required' fields and notify the user if any are found        *
//*												    *
//* Args: formName, formField to test, label of tested formfield for error message	            *
//***************************************************************************************************
//
function FS_ReqdFlds (formName, formField, formLabel, fieldLen)
{
	if (formField.type == "text" ||
		formField.type == "password" ||
		formField.type == "textarea")
	{
		var i,j;
		var failed = false;
		var s = formName.elements[formField.name].value;

		if (s == '') failed = true;
		else
		{
			for(j=0;(j < s.length) && (s.charAt(j)==' '); j++);
			if (j == s.length) failed = true;
		}
		if (failed)
		{
			alert (FS_FmtMsg(FS_MsgReqdFldEmpty, formLabel));

			if (fieldLen < 16777215){
				formField.focus();
			}
			return false;
		}
	}
	else if (formField.type == "select-one" ||
			 formField.type == "select-multiple")
	{
		if (formField.selectedIndex == -1)
		{
			alert(FS_FmtMsg(FS_MsgReqdFldEmpty, formLabel));
			formField.focus();
			return false;
		}
	}

	return true;
}
//***************************************************************************************************
//* Function FS_CheckEmail								            *
//* Description :									            *
//* Function to test if the format of a field is in a good email format	                            *
//*												    *
//* Args: formName, formField to test, label of tested formfield for error message	            *
//***************************************************************************************************
// 
function FS_CheckEmail(formName, formField, formLabel) 
{
    var  s = formName.elements[formField.name].value;
    
    // test using regular expression
    if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(s)))
    {
		alert(FS_FmtMsg(FS_MsgNotEmailFormat, formLabel));
		formField.focus();
		return false;
    }	

    return true;
}

function isPrix(obj){
  var  variable = obj.value;
  var exp = new RegExp("^[0-9\.,]+$","g");

  if (!exp.test(variable)){
    obj.value="";
  }
}


function valid_form_avec_desactivation(mode,id,tableId){
  if(confirm('Attention, en cliquant sur ce bouton, votre séjour ne sera plus visible sur le site.\nToute fois, il sera tout de mème enregistré.\nVoulez vous continuer ?')){
    

  document.forms.formulaire.field_etat.checked = false;
  
        
  document.forms.formulaire.url_retour.value="";    
  document.forms.formulaire.url_retour_2.value="";  
      
  if(mode == "modif"){
    $.ajax({
		    	type: "post",			 		
		    	data: "id="+id+"&tableId="+tableId,
  		 		url: "ajax/desactive_sejour.php",
  		 		success: function(msg){
  		 		 if(msg){
  		 		    document.forms.formulaire.noVerif.value = 1;
  		 			  document.formulaire.submit();
  		      }else{
              alert("Une erreur est survenue.\nCode erreur : 01\nVeuillez contacter votre Administrateur");
            }
  		    }});
	 }else{
	    
      document.formulaire.submit();
   }
  }
}


//-->