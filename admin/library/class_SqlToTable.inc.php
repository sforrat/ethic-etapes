<? 
DEFINE("_TYPE_STRING",		"string");
DEFINE("_TYPE_INTEGER",		"int");
DEFINE("_TYPE_REAL",		"real");
DEFINE("_TYPE_DATE",		"date");
DEFINE("_TYPE_BLOB",		"blob");

//Require Php/mySQL
//NomFichier
//Class Page

class SqlToTable {
		
	function SqlToTable($str_sql,$nb_page=10,$nb_enr_page=20,$PHP_SELF="",$str_param="",$Page=0) {

		$this->set_sql_query($str_sql);

		$this->set_table_bgcolor();
		$this->set_bgcolor1();
		$this->set_bgcolor2();
		$this->set_border();
		$this->set_cellspacing();
		$this->set_cellpadding();
		$this->set_width();
		$this->set_height();
		$this->set_date_format();
		$this->set_nowrap();

		$this->set_target($_SERVER['PHP_SELF'], $str_param);

		$this->set_entete_font_color();
		$this->set_entete_font_weight();


		$this->set_font_size("12");

		if (empty($nb_enr_page)) {
			$nb_enr_page = mysql_num_rows($this->rst);
		}
	
		$this->obj_page = new Page($this->rst,$Page,$nb_page,$nb_enr_page);


		$this->obj_page->AffPageSurNbPage=false;
		$this->obj_page->Fichier=$_SERVER['PHP_SELF'];


		if ($str_param) {
			$this->str_param = $str_param;
		}
		if ($Page) {
			$this->Page = $Page;
		}
		
		if (empty($_SERVER['PHP_SELF'])) {
			$this->display();
		}

	}

	function set_target($target, $str_param) {
		$this->set_target = $target."?".$str_param."&P=";
	}

	function set_font_size($size="12") {
		$this->set_font_size = $size;
	}


	function set_entete_font_color($color="black") {
		$this->entete_font_color = $color;
	}

	function set_entete_font_weight($weight="normal") {
		$this->entete_font_weight = $weight;
	}

	function set_nowrap($value=false) {
		if ($value==true) {
			$this->nowrap = "nowrap";
		}
	}

	function set_sql_query($str_sql) {
		$this->rst =  mysql_query($str_sql);
	}

	function set_border($border=0) {
		$this->border = "border=\"".$border."\"";
	}

	function set_cellspacing($cellspacing=1) {
		$this->cellspacing = "cellspacing=\"".$cellspacing."\"";
	}

	function set_cellpadding($cellpadding=2) {
		$this->cellpadding ="cellpadding=\"".$cellpadding."\"";
	}

	function set_width($width="") {
		if ($width) {
			$this->width = "width=\"".$width."\"";
		}
		else {
			$this->width = "";
		}
	}

	function set_height($height="") {
		if ($height) {
			$this->height = "height=\"".$height."\"";
		}
		else {
			$this->height = "";
		}
	}

	function set_date_format($date_format=2) {
		$this->date_format = $date_format;
	}

	function set_bgcolor1($bgcolor1="white") {
		$this->bgcolor1 = $bgcolor1;
	}

	function set_bgcolor2($bgcolor2="#F2F2F2") {
		$this->bgcolor2 = $bgcolor2;
	}

	function set_table_bgcolor($table_bgcolor="#C1C1C1") {
		if ($table_bgcolor) {
			$this->table_bgcolor = "bgcolor=\"".$table_bgcolor."\"";
		}
		else {
			$this->table_bgcolor = "";
		}
	}

	function align($field_type) {
		if ($field_type==_TYPE_STRING) {
			$align ="left";
		}
		elseif ($field_type==_TYPE_INTEGER) {
			$align ="center";
		}
		elseif ($field_type==_TYPE_REAL) {
			$align ="right";
		}
		elseif ($field_type==_TYPE_DATE) {
			$align ="right";
		}
		else {
			$align ="left";
		}
		return "align=\"".$align."\"";
	}

	function valign($field_type) {
		if ($field_type==_TYPE_STRING) {
			$valign ="top";
		}
		elseif ($field_type==_TYPE_INTEGER) {
			$valign ="top";
		}
		elseif ($field_type==_TYPE_REAL) {
			$valign ="top";
		}
		elseif ($field_type==_TYPE_DATE) {
			$valign ="top";
		}
		else {
			$valign ="top";
		}
		return "valign=\"".$align."\"";
	}

	function format_data($field_value, $field_type, $str_len=10000) {

		if ($field_type==_TYPE_STRING) {
			$field_value = coupe_espace($field_value,$str_len);
		}
		elseif ($field_type==_TYPE_INTEGER) {
			$field_value = $field_value;
		}
		elseif ($field_type==_TYPE_REAL) {
			$field_value = "<b>".number_format($field_value,2,",",".")."&nbsp;</b>&euro;";
		}
		elseif ($field_type==_TYPE_DATE) {
			$field_value = str_replace(" ","&nbsp;",CDate($field_value,$this->date_format));
			if ($field_value=="00/00/0000" || $field_value=="//") {
				$field_value = "";
			}
		}
		elseif ($field_type==_TYPE_BLOB) {
			$field_value = coupe_espace($field_value,$str_len);
		}

		return($field_value);
	}

	function display() {

		echo "<table ".$this->table_bgcolor." ".$this->border." ".$this->cellspacing." ".$this->cellpadding." ".$this->width." ".$this->height.">";
		echo "<tr>\n";
		for ($j=0; $j<@mysql_num_fields($this->rst) ; $j++) {
					$field_name =	@mysql_field_name($this->rst, $j);
					$field_type =	@mysql_field_type($this->rst, $j);
					//$field_len  =	@mysql_field_len($this->rst, $j);
					//$table_name =	@mysql_field_table($this->rst, $j);

			if ($field_name != "ID") {

				if ($j==1) {
					$field_name= "<img src='images/angle7.gif' border='0'>";
				}
				elseif ($j==@mysql_num_fields($this->rst)-1) {
					$field_name= "<img src='images/angle8.gif' border='0'>";
					$field_type= "real";

				}
				elseif (@mysql_field_name($this->rst, $j) == "promo") {
					$field_name = "&nbsp;";
				}
				//ACCES FICHE
				elseif (@mysql_field_name($this->rst, $j) == "acces_fiche") {
					$field_name = "Détail";
				}


				echo "<td style=\"color:'".$this->entete_font_color."';font-size='".$this->set_font_size."';font-weight='".$this->entete_font_weight."'\" ".$this->nowrap." ".$this->align($field_type).">".ucfirst(strtolower($field_name))."</td>\n";
			}
		}
		echo "</tr>\n";

		for ($k=$this->obj_page->Min;$k<$this->obj_page->Max;$k++) {

			//Gestion de la couleur de fond des lignes   0A307B   495F94
			if ( $bgcolor == "bgcolor=\"".$this->bgcolor1."\"") {
				$bgcolor ="bgcolor=\"".$this->bgcolor2."\"";
			}
			else {
				$bgcolor ="bgcolor=\"".$this->bgcolor1."\"";
			}



				echo "<tr ".$bgcolor.">\n";

					for ($l=0; $l<@mysql_num_fields($this->rst); $l++) {

						$field_name		=	@mysql_field_name($this->rst, $l);
						$field_type		=	@mysql_field_type($this->rst, $l);
						//$field_len		=	@mysql_field_len($this->rst, $l);
						//$table_name		=	@mysql_field_table($this->rst, $l);
						$field_value	=	@mysql_result($this->rst, $k ,$field_name);

						if ($field_value == "&nbsp;&nbsp;" || $field_value=="&nbsp;&nbsp;&nbsp;") {
							$field_value = "&nbsp;";
						}

						$id_value		= @mysql_result($this->rst, $k ,@mysql_field_name($this->rst, 0));

						//style=\"cursor:hand\"

						if (@mysql_field_name($this->rst, $l) != "ID") {

							echo "<td ".$this->height." style=\"color:'".$this->entete_font_color."';font-size='".$this->set_font_size."'\" ".$this->valign($field_type)." ".$this->nowrap." ".$this->align($field_type)."><a href='".$this->set_target.$id_value."'>";
							
								//title=\"".strip_tags($this->format_data($field_value, $field_type))."\"

							if ($field_value != "(Aucun)") {
								
								//ICONE LOGO + %AGE PROMO
								if (eregi("promo", @mysql_field_name($this->rst, $l)) && $field_value>0) {
	
									echo "<img src='images/promo.gif' border='0' alt='".get_promo_percent(@mysql_result($this->rst, $k ,@mysql_field_name($this->rst, $l-2)),$field_value)."'>";
								}
								//PRIX
								elseif (eregi("prix", @mysql_field_name($this->rst, $l)) && @mysql_result($this->rst, $k ,@mysql_field_name($this->rst, $l+2))>0) {
									echo $this->format_data(@mysql_result($this->rst, $k ,@mysql_field_name($this->rst, $l+2)), $field_type,200);
								}
								//PROMO
								elseif (eregi("promo", @mysql_field_name($this->rst, $l))) {
									echo "&nbsp;";
								}
								//ICONE FICHE D'ACCES AU PRODUIT
								elseif (eregi("acces_fiche", @mysql_field_name($this->rst, $l))) {

									if (eregi($this->bgcolor1,$bgcolor)) {
										$img_color = "vert";
									}
									else {
										$img_color = "bleu";
									}
									echo "<table width='100%' border='0' cellpadding='0' cellspacing='0'><tr><td align='center'><a href='".$this->set_target.$id_value."'><img src='images/fiche_".$img_color.".gif' border='0' alt='Accès fiche'></a></td></tr></table>";
								}
								//ELSE
								else {
									if ($field_value) {
										echo $this->format_data($field_value, $field_type,200);
									}
									else {
										echo "&nbsp;";
									}
								}
								
							}

							echo "</a></td>\n";

						}
					}

				echo "</tr>\n";

		}

		//Bas du tableau
		echo "<tr><td valign='bottom'><img src='images/angle9.gif' border='0'></td><td colspan='".intval(@mysql_num_fields($this->rst)-3)."'>&nbsp;</td><td align='right' valign='bottom'><img src='images/angle10.gif' border='0'></td></tr>";

		echo "</table><br>\n";

		$this->obj_page->Affiche($this->rst, $this->Page, $this->str_param);
		
	}
}
?>
