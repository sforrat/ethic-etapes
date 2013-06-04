<? 
//Fonction qui retourne l
function get_dec_hex($color,$mode="") {

	$color = ereg_replace("#","",$color);

	if ($mode=="r") {
		return StrToUpper(hexdec(substr($color, 0, 2)));
	}
	elseif ($mode=="g") {
		return StrToUpper(hexdec(substr($color, 2, 2)));
	}
	elseif ($mode=="b") {
		return StrToUpper(hexdec(substr($color, 4, 2)));
	}
	elseif ($mode=="") {
		return StrToUpper(hexdec(substr($color, 0, 2)).".".hexdec(substr($color, 2, 2)).".".hexdec(substr($color, 4, 2)));
	}
}

//Fonction qui retourne la couleur se trouvant entre la couleur passée en parametre et le blanc
function get_inter_color($color,$Ratio=0.7) {
	
	if (eregi("black",$color)) {
		$color = "#000000";
	}
	elseif (eregi("white",$color)) {
		$color = "#FFFFFF";
	}
	elseif (eregi("red",$color)) {
		$color = "#FF0000";
	}

	$R	= get_dec_hex($color,"r");
	$RN = dechex(intval(255-($Ratio*(255-$R))));
	/** SBA 09/12/05 **/
	if (strlen($RN)==1)
		$RN = "0".$RN;
	if (strlen($RN)==0)
		$RN = "00";
	/** Fin SBA 09/12/05 **/
	$G	= get_dec_hex($color,"g");
	$GN = dechex(intval(255-($Ratio*(255-$G))));
	/** SBA 09/12/05 **/
	if (strlen($GN)==1)
		$GN = "0".$GN;
	if (strlen($GN)==0)
		$GN = "00";
	/** Fin SBA 09/12/05 **/
	$B	= get_dec_hex($color,"b");
	$BN = dechex(intval(255-($Ratio*(255-$B))));
	/** SBA 09/12/05 **/
	if (strlen($BN)==1)
		$BN = "0".$BN;
	if (strlen($BN)==0)
		$BN = "00";
	/** Fin SBA 09/12/05 **/

	return("#".$RN.$GN.$BN);
}

function get_alea_color() {
// initialise avec les microsecondes depuis la dernière seconde entière
  srand((float) microtime()*1000000);

  $r = rand(0,255);
  $rh = dechex($r);
  if ($r<16) {
	  $rh = "0".$rh;
  }

  $g = rand(0,255);
  $gh = dechex($g);
  if ($g<16) {
	  $gh = "0".$gh;
  }

  $b = rand(0,255);
  $bh = dechex($b);
  if ($b<16) {
	  $bh = "0".$bh;
  }

  
  return("#".strtoupper($rh.$gh.$bh));
}

/*
Date : lundi 9 septembre 2002
determine si une couleur est foncée ou non
foncée : false
claire : true
*/
function is_light_color($color,$middle=127) {
	//	echo get_dec_hex($color,"r")."<br>";
	//	echo get_dec_hex($color,"g")."<br>";
	//	echo get_dec_hex($color,"b")."<br>";

	if (get_dec_hex($color,"r")>$middle && get_dec_hex($color,"g")>$middle && get_dec_hex($color,"b")>$middle) {
		return true;
	}
	else {
		return false;
	}
}


/*
Date : lundi 17 février 2003
Retourne la couleur inverse
Requiere unbe valeur Hexa
*/
function get_reverse_color($color) {
	$r = get_dec_hex($color,"r");
	$g = get_dec_hex($color,"g");
	$b = get_dec_hex($color,"b");

	$r_rev = 255 - $r;
	$g_rev = 255 - $g;
	$b_rev = 255 - $b;

	if ($r_rev<16) {
		$r_rev = "0".dechex($r_rev);
	}
	else {
		$r_rev = dechex($r_rev);
	}

	if ($g_rev<16) {
		$g_rev = "0".dechex($g_rev);
	}
	else {
		$g_rev = dechex($g_rev);
	}

	if ($b_rev<16) {
		$b_rev = "0".dechex($b_rev);
	}
	else {
		$b_rev = dechex($b_rev);
	}
  
	$return_color = "#".strtoupper($r_rev.$g_rev.$b_rev);

	//if (!is_light_color($color) && !is_light_color($return_color)) {
	//	return(get_inter_color($return_color,0.1));	
	//}
	//else {
		return($return_color);	
	//}

}

  function get_hsv_color($color){

	$r = get_dec_hex($color,"r");
	$g = get_dec_hex($color,"g");
	$b = get_dec_hex($color,"b");

    $max = max($r,$g,$b);
    $min = min($r,$g,$b);
    $delta = $max-$min;
    $v = round(($max / 255) * 100);
    if($max != 0){
      $s = round($delta/$max * 100);
    }else{
      $s = 0;
    }

    if($s == 0){
      $h = false;
    }else{
      if($r == $max){
	$h = ($g - $b) / $delta;
      }elseif($g == $max){
	$h = 2 + ($b - $r) / $delta;
      }elseif($b == $max){
	$h = 4 + ($r - $g) / $delta;
      }
      $h = round($h * 60);
      if($h > 360){
	$h = 360;
      }
      if($h < 0){
	$h += 360;
      }
    }

	
	$arr_color_hsv = array($h, $s, $v);

	return($arr_color_hsv);
  }





function hsv2hex($h, $s, $v) {

	//Get decimal values (Between 0 and 1) for Hue and Saturation

	$value = $v / 100;
	$saturation = $s / 100;

	if($h == false){
		//Undefined hue means grey.  Adjust value to RGB 0-255 range and return
			$value = floor($value * 255);
			$r = $value;
			$g = $value;
			$b = $value;
		}
		else{

		$hue = $h / 60; //Get local value of hue, ranging from 1-6
		$i = floor($hue);
		$f = $hue - $i;
		if(!($i & 1)){ //(If $i is even)
			$f = 1 - $f;
		}

		$m = $value * (1 - $saturation);
		$n = $value * (1 - $saturation * $f);


		//Adjust $value, $m, and $n to 0-255 scale

		$value = floor(255 * $value);
		$m = floor(255 * $m);
		$n = floor(255 * $n);

		switch($i){
			case 6: 
			case 0: 
			$r = $value;
			$g = $n;
			$b = $m;
			$newcolor = array($r, $g, $b);
			return "#".sprintf('%02X%02X%02X',$newcolor[0],$newcolor[1],$newcolor[2]);

			case 1: 
			$r = $n;
			$g = $value;
			$b = $m;
			$newcolor = array($r, $g, $b);
			return "#".sprintf('%02X%02X%02X',$newcolor[0],$newcolor[1],$newcolor[2]);

			case 2: 
			$r = $m;
			$g = $value;
			$b = $n;
			$newcolor = array($r, $g, $b);
			return "#".sprintf('%02X%02X%02X',$newcolor[0],$newcolor[1],$newcolor[2]);

			case 3:
			$r = $m;
			$g = $n;
			$b = $value;
			$newcolor = array($r, $g, $b);
			return "#".sprintf('%02X%02X%02X',$newcolor[0],$newcolor[1],$newcolor[2]);

			case 4:
			$r = $n;
			$g = $m;
			$b = $value;
			$newcolor = array($r, $g, $b);
			return "#".sprintf('%02X%02X%02X',$newcolor[0],$newcolor[1],$newcolor[2]);

			case 5: 
			$r = $value;
			$g = $m;
			$b = $n;
			$newcolor = array($r, $g, $b);
			return "#".sprintf('%02X%02X%02X',$newcolor[0],$newcolor[1],$newcolor[2]);

		}
	}
}

/*
$color = "#66FF33";
$hsv = get_hsv_color($color);


echo "COLOR :".$color;
echo "<br>HSV:".$hsv[0]." ".$hsv[1]." ".$hsv[2];

echo "<br>RETURN :".hsv2hex($hsv[0],$hsv[1],$hsv[2]);

Hue --> teinte
S   --> satura
V   --> lumino
*/
function get_s_color($color,$ratio=0) {

	$hsv = get_hsv_color($color);

	return hsv2hex($hsv[0],$ratio,$hsv[2]);
}

function get_h_color($color,$ratio=0) {

	$hsv = get_hsv_color($color);

	return hsv2hex($ratio,$hsv[1],$hsv[2]);
}

function get_v_color($color,$ratio=0) {

	$hsv = get_hsv_color($color);

	return hsv2hex($hsv[0],$hsv[1],$ratio);
}

function get_portfolio_img($id) {

        $str_portfolio_img = "
                                SELECT  
                                        * 
                                FROM 
                                        portfolio_img  
                                WHERE 
                                        id_portfolio_img = ".$id." 
                                ORDER BY 
                                        portfolio_img 

        ";
        $rst_portfolio_img = mysql_query($str_portfolio_img);

        //echo get_sql_format($str_portfolio_img);

        $id_portfolio_img       = @mysql_result($rst_portfolio_img,0,0);
        $portfolio_img          = @mysql_result($rst_portfolio_img,0,1);
        $portfolio_img_name     = @mysql_result($rst_portfolio_img,0,2);

        return $portfolio_img_name;
}

function get_portfolio_img_name($id) {

        $str_portfolio_img = "
                                SELECT  
                                        * 
                                FROM 
                                        portfolio_img  
                                WHERE 
                                        id_portfolio_img = ".$id." 
                                ORDER BY 
                                        portfolio_img 

        ";
        $rst_portfolio_img = mysql_query($str_portfolio_img);

        //echo get_sql_format($str_portfolio_img);

        $id_portfolio_img       = @mysql_result($rst_portfolio_img,0,0);
        $portfolio_img          = @mysql_result($rst_portfolio_img,0,1);
        $portfolio_img_name     = @mysql_result($rst_portfolio_img,0,2);

        return $portfolio_img;
}

// fct qui génère automatiquement les images thumbnail à partir d'une image de base
function make_thumb_GD2($largeFile,$thumbFile,$pathtoimage,$nw=120,$nh=120)
{      
   
   DeleteFile($thumbFile, $pathtoimage); // on efface le fichier s'il existe déja
   
   $result = false;
   
   if (is_file($pathtoimage.$largeFile))
   {               
      $result = true;      
      
      list($width_orig, $height_orig) = getimagesize($pathtoimage.$largeFile);
      
      $width = $nw;
      $height = $nh;
      
      if ($nw && ($width_orig < $height_orig)) {
         $width = ($nh / $height_orig) * $width_orig;
      } else {
         $height = ($nw / $width_orig) * $height_orig;
      }
      
      // Resample
      $image_p = imagecreatetruecolor($width, $height);
      $image = imagecreatefromjpeg($pathtoimage.$largeFile);
      if(!imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig)) return false;
      
      // Ecriture fichier resizé
      if (!imagejpeg($image_p, $pathtoimage.$thumbFile, 100)) return false;
      
      return true; 
   }
   else
   {
   		return false;
   }   
}





// fct qui génère automatiquement les images thumbnail à partir d'une image de base
// Compatible GD1.0 !
function make_thumb($largeFile,$thumbFile,$pathtoimage,$nw=120,$nh=120)
{
  $im=imagecreatefromjpeg($pathtoimage.$largeFile);
  
  
   if (is_file($pathtoimage.$largeFile))
   {                     
		$size = getimagesize($pathtoimage.$largeFile); 
		$largeur_src=$size[0]; 
		$hauteur_src=$size[1]; 

    $image_src=imagecreatefromjpeg($pathtoimage.$largeFile);
    
    // on verifie que l'image source ne soit pas plus petite que l'image de destination 
		if ($largeur_src>$nw || $hauteur_src>$nh){ 
			// si la largeur est plus grande que la hauteur 
			if ($hauteur_src<=$largeur_src)
					{ 
					$ratio=$nw/$largeur_src; 
					}
					else
					{ 
					$ratio=$nh/$hauteur_src; 
					}
		}
		else
		{ 
		$ratio=1; // l'image créee sera identique à l'originale 
		} 
 

		$image_dest=imagecreate(round($largeur_src*$ratio), round($hauteur_src*$ratio)); 
		
		if(!imagecopyresized($image_dest,$image_src,0,0,0,0,round($largeur_src*$ratio),round($hauteur_src*$ratio),$largeur_src,$hauteur_src)) return false; 
		$prefixe="img_pt_";

    if(!imagejpeg($image_dest, $pathtoimage.$prefixe.$image)) { return false; };            
    return true;       
   }
   else
   {
   		return false;
   }   
}

?>
