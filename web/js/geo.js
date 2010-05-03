function geoHandler(location) {
	/*var message = document.getElementById("message");
	message.innerHTML ="<img src='http://maps.google.com/staticmap?center=" + location.coords.latitude + "," + location.coords.longitude + "&size=300x200&maptype=hybrid&zoom=16&key=YOURGOOGLEAPIKEY' />";
	message.innerHTML+="<p>Longitude: " + location.coords.longitude + "</p>";
	message.innerHTML+="<p>Latitude: " + location.coords.latitude + "</p>";
	message.innerHTML+="<p>Accuracy: " + location.coords.accuracy + "</p>";*/
	console.log("Here:", location.coords.longitude);
	$("#post_longitude").attr("value", location.coords.longitude);
	$("#post_latitude").attr("value", location.coords.latitude);
	$("#post_accuracy").attr("value", location.coords.accuracy);
	$("#submit_but").removeAttr("disabled");
	$("#form_div").show();
	//Get messages
	$("#messages").load("/post/"+location.coords.latitude+"/"+location.coords.longitude);
}


var guff_geo = {
	

	
	init:function() {	
		console.log("YO:");
		$("#form_div").hide();
		navigator.geolocation.getCurrentPosition(geoHandler);
	}
	
	
}

$(document).ready(guff_geo.init);
