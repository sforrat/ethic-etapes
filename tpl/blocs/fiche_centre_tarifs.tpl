<div class="innerPopin">
	<h3>
	#{if $bAnneePlus1 eq 'true'}# 
		#{smarty_trad value='lib_tarifs_n1'}#
	#{else}# 
		#{smarty_trad value='lib_tarifs'}#
	#{/if}#
	</h3>
	
	#{if $listeTarifsScolaireNb>0}#
	<h4>#{smarty_trad value='lib_groupe_scolaire_enfant'}#</h4>
	<table class="priceList">
		<tbody>
			<tr>
				<td class="emptyCell"></td>
				<th>#{$LIB_BED_BREAKFAST}#</th>
				<th>#{$LIB_DEMI_PENSION}#</th>
				<th>#{$LIB_PENSION_COMPLETE}#</th>
				<th>#{$LIB_REPAS_SEUL}#</th>
			</tr>
			#{section loop=$listeTarifsScolaire name=index}#
				<tr>
					<th>#{$listeTarifsScolaire[index].libelle}#</th>
					<td>#{if $listeTarifsScolaire[index].bb>0}##{$listeTarifsScolaire[index].bb}#&euro;#{/if}#</td>
					<td>#{if $listeTarifsScolaire[index].dp>0}##{$listeTarifsScolaire[index].dp}#&euro;#{/if}#</td>
					<td>#{if $listeTarifsScolaire[index].pc>0}##{$listeTarifsScolaire[index].pc}#&euro;#{/if}#</td>
					<td>#{if $listeTarifsScolaire[index].rs>0}##{$listeTarifsScolaire[index].rs}#&euro;#{/if}#</td>
				</tr>
			#{/section}#
			
		</tbody>
	</table>
	
	<p><em>#{smarty_trad value='lib_tarif_partir_de'}#</em></p>
	<br />
	
	<table>
		#{section loop=$listeTarifsScolaire name=sec1}#
		
		#{if $listeTarifsScolaire[sec1].T_HS != "" || $listeTarifsScolaire[sec1].T_HS_plus != ''}#
		<tr>
			<td>#{smarty_trad value='lib_haute_saison'}# :</td>
			#{if $n1 == '1'}#
			<td>#{$listeTarifsScolaire[sec1].T_HS_plus}#</td>
			#{else}#
			<td>#{$listeTarifsScolaire[sec1].T_HS}#</td>
			#{/if}#
		</tr>
		#{/if}#
		
		#{if $listeTarifsScolaire[sec1].T_MS != "" || $listeTarifsScolaire[sec1].T_MS_plus}#
		<tr>
			<td>#{smarty_trad value='lib_moyenne_saison'}# :</td>
			#{if $n1 == '1'}#
			<td>#{$listeTarifsScolaire[sec1].T_MS_plus}#</td>
			#{else}#
			<td>#{$listeTarifsScolaire[sec1].T_MS}#</td>
			#{/if}#
		</tr>
		#{/if}#
		
		#{if $listeTarifsScolaire[sec1].T_BS != "" || $listeTarifsScolaire[sec1].T_BS_plus}#
		<tr>
			<td>#{smarty_trad value='lib_basse_saison'}# :</td>
			#{if $n1 == '1'}#
			<td>#{$listeTarifsScolaire[sec1].T_BS_plus}#</td>
			#{else}#
			<td>#{$listeTarifsScolaire[sec1].T_BS}#</td>
			#{/if}#
		</tr>
		#{/if}#
		
		
		#{/section}#
	</table>
	#{/if}#
	
	#{if $listeTarifsAdulteNb>0	}#
	<br />	
	<h4>#{smarty_trad value='lib_groupe_jeune_adulte'}#</h4>
	<table class="priceList">
		<tbody>
			<tr>
				<td class="emptyCell"></td>
				<th>#{$LIB_BED_BREAKFAST}#</th>
				<th>#{$LIB_DEMI_PENSION}#</th>
				<th>#{$LIB_PENSION_COMPLETE}#</th>
				<th>#{$LIB_REPAS_SEUL}#</th>
			</tr>
			#{section loop=$listeTarifsAdulte name=index}#
				<tr>
					<th>#{$listeTarifsAdulte[index].libelle}#</th>
					<td>#{if $listeTarifsAdulte[index].bb>0}##{$listeTarifsAdulte[index].bb}#&euro;#{/if}#</td>
					<td>#{if $listeTarifsAdulte[index].dp>0}##{$listeTarifsAdulte[index].dp}#&euro;#{/if}#</td>
					<td>#{if $listeTarifsAdulte[index].pc>0}##{$listeTarifsAdulte[index].pc}#&euro;#{/if}#</td>
					<td>#{if $listeTarifsAdulte[index].rs>0}##{$listeTarifsAdulte[index].rs}#&euro;#{/if}#</td>
				</tr>
			#{/section}#
		</tbody>
	</table>
	
	<p><em>#{smarty_trad value='lib_tarif_partir_de'}#</em></p>
	<br />
	
	<table>
		#{section loop=$listeTarifsAdulte name=sec1}#
		
		#{if $listeTarifsAdulte[sec1].T_HS != ""}#
		<tr>
			<td>#{smarty_trad value='lib_haute_saison'}# :</td>
			<td>#{$listeTarifsAdulte[sec1].T_HS}#</td>
		</tr>
		#{/if}#
		
		#{if $listeTarifsAdulte[sec1].T_MS != ""}#
		<tr>
			<td>#{smarty_trad value='lib_moyenne_saison'}# :</td>
			<td>#{$listeTarifsAdulte[sec1].T_MS}#</td>
		</tr>
		#{/if}#
		
		#{if $listeTarifsAdulte[sec1].T_BS != ""}#
		<tr>
			<td>#{smarty_trad value='lib_basse_saison'}# :</td>
			<td>#{$listeTarifsAdulte[sec1].T_BS}#</td>
		</tr>
		#{/if}#
		
		
		#{/section}#
	</table>
	#{/if}#
	
	#{if $listeTarifsFamilleNb>0}#
	<br />	
	<h4>#{smarty_trad value='lib_individuel_famille'}#</h4>
	<table class="priceList">
		<tbody>
			<tr>
				<td class="emptyCell"></td>
				<th>#{$LIB_BED_BREAKFAST}#</th>
				<th>#{$LIB_DEMI_PENSION}#</th>
				<th>#{$LIB_PENSION_COMPLETE}#</th>
				<th>#{$LIB_REPAS_SEUL}#</th>
			</tr>
			#{section loop=$listeTarifsFamille name=index}#
				<tr>
					<th>#{$listeTarifsFamille[index].libelle}#</th>
					<td>#{if $listeTarifsFamille[index].bb>0}##{$listeTarifsFamille[index].bb}#&euro;#{/if}#</td>
					<td>#{if $listeTarifsFamille[index].dp>0}##{$listeTarifsFamille[index].dp}#&euro;#{/if}#</td>
					<td>#{if $listeTarifsFamille[index].pc>0}##{$listeTarifsFamille[index].pc}#&euro;#{/if}#</td>
					<td>#{if $listeTarifsFamille[index].rs>0}##{$listeTarifsFamille[index].rs}#&euro;#{/if}#</td>
				</tr>
			#{/section}#
		</tbody>
	</table>
	
	<p><em>#{smarty_trad value='lib_tarif_partir_de'}#</em></p>
	<br />
	
	<table>
		#{section loop=$listeTarifsFamille name=sec1}#
		
		#{if $listeTarifsFamille[sec1].T_HS != ""}#
		<tr>
			<td>#{smarty_trad value='lib_haute_saison'}# :</td>
			<td>#{$listeTarifsFamille[sec1].T_HS}#</td>
		</tr>
		#{/if}#
		
		#{if $listeTarifsFamille[sec1].T_MS != ""}#
		<tr>
			<td>#{smarty_trad value='lib_moyenne_saison'}# :</td>
			<td>#{$listeTarifsFamille[sec1].T_MS}#</td>
		</tr>
		#{/if}#
		
		#{if $listeTarifsFamille[sec1].T_BS != ""}#
		<tr>
			<td>#{smarty_trad value='lib_basse_saison'}# :</td>
			<td>#{$listeTarifsFamille[sec1].T_BS}#</td>
		</tr>
		#{/if}#
		
		
		#{/section}#
	</table>
	#{/if}#
	
	<br /><br />
	#{if !$bAnneePlus1 && $afficheBoutonNplus1}#		
		<a href="#" class="btn btn_green" onClick="javascript:window.open('#{$smarty.const._CONST_APPLI_URL}#fiche_centre_tarifs.php?n1=1&id_centre=#{$id_centre}#','Tarifs_annee_prochaine','menubar=no, status=no, scrollbars=no, menubar=no, location=no, width=600, height=700');return false;"><span>#{smarty_trad value='lib_tarifs_n1'}#</span></a>
	#{else}#
		<a href="javascript:this.close();" class="btn"><span>#{smarty_trad value='lib_fermer'}#</span></a>
		<a href="javascript:window.print();" class="btn"><span>#{smarty_trad value='lib_imprimer'}#</span></a>
		<style type="text/css">
			html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code,
			del, dfn, em, font, a img, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, dl, dt, dd, ol, ul, li, fieldset, form, label, legend,
			table, caption, tbody, tfoot, thead, tr, th, td {margin: 0;padding: 0;border: 0;outline: 0;font-weight: inherit;font-style: inherit;font-size: 100%;font-family: inherit;vertical-align: baseline;}
			body {line-height: 1;}
			:focus {outline:1px dotted #acacac}
			ol, ul {list-style: none;}
			table {border-collapse: collapse;border-spacing: 0;}
			caption, th, td {text-align: left;font-weight: normal;}
			blockquote:before, blockquote:after, q:before, q:after {content: "";}
			blockquote, q {quotes: "" "";}
			button {border:0;background:0;display:inline;padding:0;color:#acacac;}
			button:active {position:relative;top:1px;}
			
			body {padding:15px;font-family:Arial, sans-serif;}
			.innerPopin h3 {color:#768D16;margin-bottom:10px;}
			.innerPopin h4 {color:#768D16;font-size:.9em;}
			.btn {background:url(images/common/sprite_btn.png) repeat-x 0 -90px;color:#fff;text-transform:uppercase;text-decoration:none !important;padding:3px 8px;margin:0 1px;font-family:'Futura', Arial , sans-serif;font-size:14px;}
			.btn span {background:url(images/common/sprite_btn.png) no-repeat 0 5px;padding-left:10px;white-space:nowrap}
			table {font-size:12px;}
			table.priceList {clear:both;width:95%;margin:10px auto;font-size:12px;}
			table.priceList th{font-size:13px;border:1px solid #cbc7b8;background:#ede9e0;vertical-align:middle;text-align:center;padding:2px 5px;font-family:Arial , sans-serif;color:#6f6757;}
			table.priceList  td{border:1px solid #cbc7b8;text-align:center;vertical-align:middle;padding:5px;}
			table.priceList  td.emptyCell{border:none;}
		</style>
	#{/if}#	
</div>
