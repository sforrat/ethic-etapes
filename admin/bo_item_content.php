<?
	$strSQL =  "Select table_ref_req, name_req, date_update_auto, bo_workflow_state from bo_object, bo_workflow_state 
            where bo_object.id_bo_workflow_state = bo_workflow_state.id_bo_workflow_state AND id_bo_nav = ".$idItem." 
            ORDER BY table_ref_req, date_update_auto";

	//echo "<br><br>> Table ".$ar[$i];
	$Requete = new SqlToTable($strSQL,20,10,NomFichier($_SERVER['PHP_SELF'],0),"",$Page);		
	//$Requete->obj_page->Label=$ar[$i]." :";
	$Requete->display();

?>
