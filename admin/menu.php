
			<script language="JavaScript">
		        function expand_and_collapse(mode) {
			        if (document.all) {
			        	for (var i=0; i < document.all.length; i++) {
			                	if (document.all(i).tagName == 'TABLE' && document.all(i).id != '') {
			                        	if (mode=='expand') {
			                                	document.all(i).style.display = 'block';
			                                }else {
								if (document.all(i).id.substring(document.all(i).id.lastIndexOf("_")+1, document.all(i).id.length) > 1) {
			                                        	document.all(i).style.display = 'none';
				                                }
			                                }
						}else if (document.all(i).tagName == 'IMG' && document.all(i).id != '') {
			                                if (mode=='expand') {
								document.all(i).src = 'images/moins.gif';
			                                }else {
								if (document.all(i).id.substring(document.all(i).id.lastIndexOf("_")+1, document.all(i).id.length) > 1) {
			                                        	document.all(i).src = 'images/plus.gif';
								}
			                                }
						}
					}
				}
			}
		        </script>
	            	<table cellspacing="1" cellpadding="2" border="0" width="250">
	                <tr><td colspan="2"></td><td align="right">
	                <table border="0" cellpadding="1" cellspacing="0">
	                <tr>
	                <td>&nbsp;<img style="cursor:pointer" alt="Fermer tous" onClick="expand_and_collapse('collapse')" hspace=10 src='images/moins.gif'>
	                    <img style="cursor:pointer" alt="Ouvrir tous" onClick="expand_and_collapse('expand')" hspace=10 src='images/plus.gif'>
			</td>
	                </tr>
	                </table>
	                </td></tr>
<tr><td valign=top></td><td colspan=2 width='100%'>

<table id='table_1_1'  border=0 cellpadding=0 cellspacing=1 bgcolor="#eaeef3"  width='100%'><tr><td style="color:black" bgcolor="#d6dee8" align=center valign=top ></td><td  style="color:black" bgcolor="#d6dee8" align=left valign=top >&nbsp;&nbsp;1.</td><td style="color:black" bgcolor="#d6dee8" width='100%'>&nbsp;<a href="bo.php?TableDef=3&idItem=19" class="LienNoir"><i><u>test</u></i><img src='images/pasvu.gif' width=17 height=14 border=0 valign=baseline alt='Non visible'></a></td></tr>
<tr><td style="color:black" bgcolor="#d6dee8" align=center valign=top ><img id='img_nav_2_2' vspace=3 hspace=3 style='cursor:pointer' src='images/plus.gif' border='0' onclick="switch_img(this);show_item('table_2_2');"></td><td  style="color:black" bgcolor="#d6dee8" align=left valign=top >&nbsp;&nbsp;2.</td><td style="color:black" bgcolor="#d6dee8" width='100%'>&nbsp;<a href="bo.php?TableDef=3&idItem=20" class="LienNoir">Mazak</a></td></tr>
<tr><td valign=top></td><td colspan=2 width='100%'>

<table id='table_2_2' style='display:none' border=0 cellpadding=0 cellspacing=1 bgcolor="#f2f5f8"  width='100%'><tr><td style="color:black" bgcolor="#e6ebf1" align=center valign=top ></td><td  style="color:black" bgcolor="#e6ebf1" align=left valign=top >&nbsp;&nbsp;2.1.</td><td style="color:black" bgcolor="#e6ebf1" width='100%'>&nbsp;<a href="bo.php?TableDef=3&idItem=25" class="LienNoir">Tournage</a></td></tr>
<tr><td style="color:black" bgcolor="#e6ebf1" align=center valign=top ></td><td  style="color:black" bgcolor="#e6ebf1" align=left valign=top >&nbsp;&nbsp;2.2.</td><td style="color:black" bgcolor="#e6ebf1" width='100%'>&nbsp;<a href="bo.php?TableDef=3&idItem=26" class="LienNoir">Fraisage</a></td></tr>
<tr><td style="color:black" bgcolor="#e6ebf1" align=center valign=top ></td><td  style="color:black" bgcolor="#e6ebf1" align=left valign=top >&nbsp;&nbsp;2.3.</td><td style="color:black" bgcolor="#e6ebf1" width='100%'>&nbsp;<a href="bo.php?TableDef=3&idItem=27" class="LienNoir">Usinage multi-fonction</a></td></tr>
</table>

</td></tr><tr><td style="color:black" bgcolor="#d6dee8" align=center valign=top ><img id='img_nav_3_2' vspace=3 hspace=3 style='cursor:pointer' src='images/plus.gif' border='0' onclick="switch_img(this);show_item('table_3_2');"></td><td  style="color:black" bgcolor="#d6dee8" align=left valign=top >&nbsp;&nbsp;3.</td><td style="color:black" bgcolor="#d6dee8" width='100%'>&nbsp;<a href="bo.php?TableDef=3&idItem=21" class="LienNoir">Brother</a></td></tr>
<tr><td valign=top></td><td colspan=2 width='100%'>

<table id='table_3_2' style='display:none' border=0 cellpadding=0 cellspacing=1 bgcolor="#f2f5f8"  width='100%'><tr><td style="color:black" bgcolor="#e6ebf1" align=center valign=top ></td><td  style="color:black" bgcolor="#e6ebf1" align=left valign=top >&nbsp;&nbsp;3.1.</td><td style="color:black" bgcolor="#e6ebf1" width='100%'>&nbsp;<a href="bo.php?TableDef=3&idItem=28" class="LienNoir">Centre d'usinage monopalette</a></td></tr>
<tr><td style="color:black" bgcolor="#e6ebf1" align=center valign=top ></td><td  style="color:black" bgcolor="#e6ebf1" align=left valign=top >&nbsp;&nbsp;3.2.</td><td style="color:black" bgcolor="#e6ebf1" width='100%'>&nbsp;<a href="bo.php?TableDef=3&idItem=29" class="LienNoir">Centre d'usinage rotopalette</a></td></tr>
</table>

</td></tr><tr><td style="color:black" bgcolor="#d6dee8" align=center valign=top ><img id='img_nav_4_2' vspace=3 hspace=3 style='cursor:pointer' src='images/plus.gif' border='0' onclick="switch_img(this);show_item('table_4_2');"></td><td  style="color:black" bgcolor="#d6dee8" align=left valign=top >&nbsp;&nbsp;4.</td><td style="color:black" bgcolor="#d6dee8" width='100%'>&nbsp;<a href="bo.php?TableDef=3&idItem=24" class="LienNoir">Les Occasions</a></td></tr>
<tr><td valign=top></td><td colspan=2 width='100%'>

<table id='table_4_2' style='display:none' border=0 cellpadding=0 cellspacing=1 bgcolor="#f2f5f8"  width='100%'><tr><td style="color:black" bgcolor="#e6ebf1" align=center valign=top ></td><td  style="color:black" bgcolor="#e6ebf1" align=left valign=top >&nbsp;&nbsp;4.1.</td><td style="color:black" bgcolor="#e6ebf1" width='100%'>&nbsp;<a href="bo.php?TableDef=3&idItem=30" class="LienNoir">Tournage</a></td></tr>
<tr><td style="color:black" bgcolor="#e6ebf1" align=center valign=top ></td><td  style="color:black" bgcolor="#e6ebf1" align=left valign=top >&nbsp;&nbsp;4.2.</td><td style="color:black" bgcolor="#e6ebf1" width='100%'>&nbsp;<a href="bo.php?TableDef=3&idItem=31" class="LienNoir">Fraisage</a></td></tr>
</table>

</td></tr><tr><td style="color:black" bgcolor="#d6dee8" align=center valign=top ><img id='img_nav_5_2' vspace=3 hspace=3 style='cursor:pointer' src='images/plus.gif' border='0' onclick="switch_img(this);show_item('table_5_2');"></td><td  style="color:black" bgcolor="#d6dee8" align=left valign=top >&nbsp;&nbsp;5.</td><td style="color:black" bgcolor="#d6dee8" width='100%'>&nbsp;<a href="bo.php?TableDef=3&idItem=22" class="LienNoir">Nos compétences</a></td></tr>
<tr><td valign=top></td><td colspan=2 width='100%'>

<table id='table_5_2' style='display:none' border=0 cellpadding=0 cellspacing=1 bgcolor="#f2f5f8"  width='100%'><tr><td style="color:black" bgcolor="#e6ebf1" align=center valign=top ></td><td  style="color:black" bgcolor="#e6ebf1" align=left valign=top >&nbsp;&nbsp;5.1.</td><td style="color:black" bgcolor="#e6ebf1" width='100%'>&nbsp;<a href="bo.php?TableDef=3&idItem=32" class="LienNoir">Ingénierie</a></td></tr>
<tr><td style="color:black" bgcolor="#e6ebf1" align=center valign=top ></td><td  style="color:black" bgcolor="#e6ebf1" align=left valign=top >&nbsp;&nbsp;5.2.</td><td style="color:black" bgcolor="#e6ebf1" width='100%'>&nbsp;<a href="bo.php?TableDef=3&idItem=33" class="LienNoir">Formation</a></td></tr>
<tr><td style="color:black" bgcolor="#e6ebf1" align=center valign=top ></td><td  style="color:black" bgcolor="#e6ebf1" align=left valign=top >&nbsp;&nbsp;5.3.</td><td style="color:black" bgcolor="#e6ebf1" width='100%'>&nbsp;<a href="bo.php?TableDef=3&idItem=34" class="LienNoir">Service technique</a></td></tr>
<tr><td style="color:black" bgcolor="#e6ebf1" align=center valign=top ></td><td  style="color:black" bgcolor="#e6ebf1" align=left valign=top >&nbsp;&nbsp;5.4.</td><td style="color:black" bgcolor="#e6ebf1" width='100%'>&nbsp;<a href="bo.php?TableDef=3&idItem=35" class="LienNoir">Ing. financière</a></td></tr>
</table>

</td></tr><tr><td style="color:black" bgcolor="#d6dee8" align=center valign=top ><img id='img_nav_6_2' vspace=3 hspace=3 style='cursor:pointer' src='images/plus.gif' border='0' onclick="switch_img(this);show_item('table_6_2');"></td><td  style="color:black" bgcolor="#d6dee8" align=left valign=top >&nbsp;&nbsp;6.</td><td style="color:black" bgcolor="#d6dee8" width='100%'>&nbsp;<a href="bo.php?TableDef=3&idItem=23" class="LienNoir">L'entreprise</a></td></tr>
<tr><td valign=top></td><td colspan=2 width='100%'>

<table id='table_6_2' style='display:none' border=0 cellpadding=0 cellspacing=1 bgcolor="#f2f5f8"  width='100%'><tr><td style="color:black" bgcolor="#e6ebf1" align=center valign=top ></td><td  style="color:black" bgcolor="#e6ebf1" align=left valign=top >&nbsp;&nbsp;6.1.</td><td style="color:black" bgcolor="#e6ebf1" width='100%'>&nbsp;<a href="bo.php?TableDef=3&idItem=36" class="LienNoir">Nous contacter</a></td></tr>
<tr><td style="color:black" bgcolor="#e6ebf1" align=center valign=top ></td><td  style="color:black" bgcolor="#e6ebf1" align=left valign=top >&nbsp;&nbsp;6.2.</td><td style="color:black" bgcolor="#e6ebf1" width='100%'>&nbsp;<a href="bo.php?TableDef=3&idItem=37" class="LienNoir">Actualités</a></td></tr>
<tr><td style="color:black" bgcolor="#e6ebf1" align=center valign=top ></td><td  style="color:black" bgcolor="#e6ebf1" align=left valign=top >&nbsp;&nbsp;6.3.</td><td style="color:black" bgcolor="#e6ebf1" width='100%'>&nbsp;<a href="bo.php?TableDef=3&idItem=38" class="LienNoir">Nos références</a></td></tr>
<tr><td style="color:black" bgcolor="#e6ebf1" align=center valign=top ></td><td  style="color:black" bgcolor="#e6ebf1" align=left valign=top >&nbsp;&nbsp;6.4.</td><td style="color:black" bgcolor="#e6ebf1" width='100%'>&nbsp;<a href="bo.php?TableDef=3&idItem=39" class="LienNoir">Nos agences</a></td></tr>
</table>

</td></tr></table>

</td></tr></table>