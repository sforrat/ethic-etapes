<table id="sitemap">
#{section name=sec1 loop=$TabNav}#
	#{if $TabNav[sec1].retourLigne==1 && !$smarty.section.sec1.first}#
	</tr>
	#{/if}#

	#{if $smarty.section.sec1.first}#
		<tr>
	#{/if}#
	<td>
	<h2>#{$TabNav[sec1].libelle}#</h2>
	#{section name=sec2 loop=$TabNav[sec1].ss_rub}#
	
	#{if $smarty.section.sec2.first}#
	<ul>						
	#{/if}#
		<li><a href="#{$TabNav[sec1].ss_rub[sec2].url}#">#{$TabNav[sec1].ss_rub[sec2].libelle}#</a>
			#{section name=sec3 loop=$TabNav[sec1].ss_rub[sec2].ss_rub}#
			#{if $smarty.section.sec3.first}#
				<ul>
			#{/if}#
			<li><a href="#{$TabNav[sec1].ss_rub[sec2].ss_rub[sec3].url}#">#{$TabNav[sec1].ss_rub[sec2].ss_rub[sec3].libelle}#</a></li>
			
			#{if $smarty.section.sec3.last}#
				</ul>
			#{/if}#
			#{/section}#						
		</li>
		
	#{if $smarty.section.sec2.last}#	
	</ul>
	#{/if}#
	
	#{/section}#
	</td>
#{/section}#
</tr>
</table>