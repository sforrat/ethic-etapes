<tr>
  <td colspan="3">
  <?
    if($_REQUEST["mode"] == "modif"){
      $sql_S = "select flash_x,flash_y,flash_paris from centre where id_centre=".$_GET["ID"];
      $result_S = mysql_query($sql_S);
      $flash_paris = mysql_result($result_S,0,"flash_paris");
      $flash_x = mysql_result($result_S,0,"flash_x");
      $flash_y = mysql_result($result_S,0,"flash_y");
      
      if($_SESSION["ses_profil_user"] == _PROFIL_CENTRE){
        $centre = 1;
      }else{
        $centre = 0;
      }
    }
  ?>
  <hr /><strong>G&eacute;olocalisation du centre sur la carte</strong><br /><br />
  <div id='geolocalisation'>
  
			<script type="text/javascript">
			
			//<![CDATA[
				var flashvars = {};
				<?
        if($flash_paris != ""){
          echo "flashvars.isOnParis =  $flash_paris;";
        }
        if($flash_x != ""){
          echo "flashvars.xPoint =  $flash_x;";
        }
        if($flash_y != ""){
          echo "flashvars.yPoint =  $flash_y;";
        }
        
        if($centre!=""){
			   echo "flashvars.centre =  $centre;";
        }
        echo "flashvars.id_centre =  ".$_GET["ID"].";";
        ?>
				var params = {};
				params.wmode = "transparent";
				params.allowScriptAccess = "sameDomain";
				var attributes = {};
				swfobject.embedSWF("flash/localisationCentre2.swf", "geolocalisation", "265", "229", "8", false, flashvars, params, attributes);
			//]]>
			</script>
		

  </td>
</tr>