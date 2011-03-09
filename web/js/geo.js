var test = 1;

var guff_geo = {
	
	/**
	 * Load the post form
	 */
	loadMap:function() {
		
		$("#form_holder").load('/post/ajaxForm', function(data, status, response) { 
		});
	},
	
	geoHandler:function(location) {
    	//Check acc before bothering
    //	console.log("Location", location);
    	if (location.coords.accuracy<50)
    	{
    		//cancel watch
    		navigator.geolocation.clearWatch(watchId);

    	}
    	if (location.coords.accuracy<100)
    	{
    		$("#post_longitude").attr("value", location.coords.longitude);
    		$("#post_latitude").attr("value", location.coords.latitude);
    		$("#post_accuracy").attr("value", location.coords.accuracy);
    		$("#submit_but").removeAttr("disabled");

    		//get image
    		$("#map_img").attr("src", "http://maps.google.com/maps/api/staticmap?center="+location.coords.latitude+","+location.coords.longitude+"&zoom=15&size=400x300&maptype=roadmap&markers=color:blue|"+location.coords.latitude+","+location.coords.longitude+"&sensor=false").load(function() {
    			$(this).fadeIn();
    			$('#ajax_loader').hide();
    			$("#form_holder").slideDown();
    		});
            
    		//Get messages
    		$("#messages").load("/post/messages/"+location.coords.latitude+"/"+location.coords.longitude);

    		$("#dump").html("Lat: "+location.coords.latitude+", Lng: "+location.coords.longitude+", Acc:"+location.coords.accuracy)
    		
    		navigator.geolocation.watchPosition(guff_geo.geoHandler, guff_geo.errorHandler, {
    			enableHighAccuracy: true,
    			maximumAge: 0
    		});
    	}
    	else
    	{
    		//still waiting
    	}
    },
    
    errorHandler:function(err) {
    	//try again
    	if (err.code>0) {
    	    guff_geo.fail();
        }
    },
    
	fail:function() {
	    $('#content').hide();
		$('#geo-fail').slideDown();
	},
	
	init:function() {	
		
		//Check for geo capability
		if (!$('html').hasClass("geolocation"))
		{
			guff_geo.fail();
			//Do nothing else
			return;
		}
		
		navigator.geolocation.watchPosition(guff_geo.geoHandler, guff_geo.errorHandler, {
			enableHighAccuracy: true,
			maximumAge: 0
		});
		
		if (test)
		{
			setTimeout(function(){
				guff_geo.geoHandler({coords: {latitude: 1, longitude: 2, accuracy: 70}});
			}, 3000);
		}
	
	}
	
	
}

$(document).ready(guff_geo.init);
