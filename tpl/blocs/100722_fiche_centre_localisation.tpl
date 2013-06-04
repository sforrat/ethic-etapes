<div class="innerPopin">
	<h3>#{smarty_trad value='lib_localiser'}#</h3>
	<div id="gMapContainer">
		<!-- Gmap -->
	</div>
	<div class="accessGuide">
		<p class="locate">
			<img src="#{$lstCentre.logo}#" alt="#{$lstCentre.libelle}#" />
			#{$lstCentre.adresse}# - #{$lstCentre.code_postal}# #{$lstCentre.ville}# <br />
			T. #{$lstCentre.telephone}# - F. #{$lstCentre.fax}# <br />
			#{if $lstCentre.site_internet!="" && $lstCentre.site_internet!="http://"}##{smarty_trad value='lib_site_internet'}# : <a target="_blank" href="#{$lstCentre.site_internet}#">#{$lstCentre.site_internet}#</a>#{/if}#
		</p>
		<h4>#{smarty_trad value='lib_acces'}#</h4>
		<dl>	
			#{if $acces_route}#
				<dt>#{smarty_trad value='lib_acces_route'}# :</dt>
				<dd>#{$lstCentre.acces_route_texte}#</dd>
			#{/if}#
			#{if $acces_bus_metro}#
				<dt>#{smarty_trad value='lib_acces_bus_metro'}# : </dt>
				<dd>#{$lstCentre.acces_bus_metro_texte}#</dd>
			#{/if}#
			#{if $acces_train}#
				<dt>#{smarty_trad value='lib_acces_train'}# :</dt>
				<dd>#{$lstCentre.acces_train_texte}#</dd>
			#{/if}#
			#{if $acces_avion}#
				<dt>#{smarty_trad value='lib_acces_avion'}# :</dt>
				<dd>#{$lstCentre.acces_avion_texte}#</dd>
			#{/if}#
		</dl>
		<h4>#{smarty_trad value='lib_coordonnees_gps'}#</h4>
		#{smarty_trad value='lib_longitude'}# : #{$lstCentre.longitude}#&deg; <br />
		#{smarty_trad value='lib_latitude'}# : #{$lstCentre.latitude}#&deg;
	</div>
	
	<script type="text/javascript">
	  function initGMap() {
		var latlng = new google.maps.LatLng(#{$lstCentre.latitude}#,#{$lstCentre.longitude}#);
		var myOptions = {
		  zoom: 13,
		  center: latlng,
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map(document.getElementById("gMapContainer"), myOptions);
			  
		var customImg = 'images/common/custom_marker.png';
		var positionMarker = new google.maps.LatLng(#{$lstCentre.latitude}#,#{$lstCentre.longitude}#); 
		var marker = new google.maps.Marker({		
		  position: positionMarker, 
		  map: map, 
		  title:"#{$lstCentre.libelle}#",
		  icon: customImg
		});  
	  }
	</script>
	<script type="text/javascript"> 		
		$(document).bind('cbox_complete', function(){
			initGMap(); // init de la google map une fois que le contenu a fini de charger dans la popin
		});		
	</script>
</div>