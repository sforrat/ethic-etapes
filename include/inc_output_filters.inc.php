<?
/**********************************************************************************/
/*	C2IS : 		xxprojetxx
/*	Auteur : 	LAC 							 
/*	Date : 		Juillet 2004						  
/*	Version :	1.0							  
/*	Fichier :	inc_output_filters.inc.php				  
/*										  
/*	Description :	Inclus les filtres à appliquer avant le display du tpl    
/*										  
/**********************************************************************************/

// Filtre de sortie des templates
function protect_email($tpl_output, &$smarty)
{
    $tpl_output =
       preg_replace('!(\S+)@([a-zA-Z0-9\.\-]+\.([a-zA-Z]{2,3}|[0-9]{1,3}))!',
                    '$1&#64;$2', $tpl_output);
    return $tpl_output;
}

// enregistre le filtre de sortie et l'applique avant la génération du template final
$template->register_outputfilter("protect_email");

?>
