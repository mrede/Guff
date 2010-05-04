	<div id='map_canvas' style='width:100%;height:500px;border:1px solid red'>
		ASDASDAS
	</div>


<div class='hidden'>
	<div id='panel_loader'>
		<div class="map-popup">
			<img src='/images/ajax-loader.gif' alt='Loading'/>
		</div>
	</div>
</div>

<script type='text/javascript'>
var nf_maps = {
	
	init:function() {	


		var myOptions = {
			zoom: 9,
			center: new google.maps.LatLng(<?php echo $centerLat?>, <?php echo $centerLng?>),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		
		
		/**
		 * Data for the markers consisting of a name, a LatLng and a zIndex for
		 * the order in which these markers should display on top of each
		 * other.
		 */
		var locations = [
		<?php for ($i=1; $i<=count($posts); $i++) :?>
			<?php $address = $posts[$i-1]?>
			
		  ['<?php echo str_replace(array("\r\n", "\n", "\r"), "", $address->getText())?>', <?php echo $address->getLatitude()?>, <?php echo $address->getLongitude()?>, <?php echo $i ?>, '<?php echo str_replace(array("\r\n", "\n", "\r"), '', $address->getText() )?>'],
		<?php endfor ?>
		];

		var infowindow = new google.maps.InfoWindow({
				maxWidth: 420,
		});
		
		var bounds = new google.maps.LatLngBounds();

		for (var i = 0; i < locations.length; i++) {
	    var beach = locations[i];
	    var myLatLng = new google.maps.LatLng(beach[1], beach[2]);
	    var marker = new google.maps.Marker({
	        position: myLatLng,
	        map: map,
	        title: beach[0],
	        zIndex: beach[3]
	    });
	
			bounds.extend(marker.getPosition());
	  
			google.maps.event.addListener(marker, 'click', function(e,x) {
				console.log("locations", locations[0])
				infowindow.setContent(locations[this.getZIndex()-1][0]);//+this.getZIndex()).html());
			  infowindow.open(map,this);

				/*$.get('/church/googlePanel/'+locations[this.getZIndex()-1][4], function(data) {
				  infowindow.setContent(data);

				});
				*/
			});
			
			//map.setZoom(map.getBoundsZoomLevel(bounds));
			      map.setCenter(bounds.getCenter());
		}
	}
	
}

$(document).ready(nf_maps.init);
</script>