var watchId;

function geoHandler(location) {
	//Check acc before bothering
	if (location.coords.accuracy<100)
	{
		
		//cancel watch
		navigator.geolocation.clearWatch(watchId);
		
		$("#post_longitude").attr("value", location.coords.longitude);
		$("#post_latitude").attr("value", location.coords.latitude);
		$("#post_accuracy").attr("value", location.coords.accuracy);
		$("#submit_but").removeAttr("disabled");

	
		//get image
		$("#img").attr("src", "http://maps.google.com/maps/api/staticmap?center="+location.coords.latitude+","+location.coords.longitude+"&zoom=15&size=150x150&maptype=roadmap&markers=color:blue|"+location.coords.latitude+","+location.coords.longitude+"&sensor=false")
		$("#form_div").show();
		//Get messages
		$("#messages").load("/post/"+location.coords.latitude+"/"+location.coords.longitude);
	
		$("#dump").html("Lat: "+location.coords.latitude+", Lng: "+location.coords.longitude+", Acc:"+location.coords.accuracy)
	}
	else
	{
		$("#dump").append('.');
	}
}

function updatePos(location)
{
	
	$("#dump").append("Lat: "+location.coords.latitude+", Lng: "+location.coords.longitude+", Acc:"+location.coords.accuracy)
}

function errorHandler(err) {
	//try again
	alert("ERROR"+err);
}


var guff_geo = {

	init:function() {	
		$("#form_div").hide();
		/*navigator.geolocation.getCurrentPosition(geoHandler, errorHandler, {
			enableHighAccuracy: true,
			maximumAge: 0
		});*/
		watchId = navigator.geolocation.watchPosition(geoHandler, errorHandler, {
			enableHighAccuracy: true,
			maximumAge: 0
		});
	
	}
	
	
}

$(document).ready(guff_geo.init);
