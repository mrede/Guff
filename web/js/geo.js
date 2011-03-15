var watchId;



function updatePos(location)
{
	//$('#form_holder').slideDown();
	guff_geo.loadMap();
	//console.log("Position located", "Lat: "+location.coords.latitude+", Lng: "+location.coords.longitude+", Acc:"+location.coords.accuracy);
	//$("#debug").append("Lat: "+location.coords.latitude+", Lng: "+location.coords.longitude+", Acc:"+location.coords.accuracy)
	$('#map_img').attr('src', 'image.jpg').load(function() {
		alert('Image Loaded');
	});
}




var test = 1;
var screen_width;

var guff_geo = {
	
	/**
	 * Load the post form
	 */
	loadMap:function() {
		$("#form_holder").load('/post/ajaxForm', function(data, status, response) { });
	},
	
	getMessages:function() {
	    var lat = $('body').data('lat');
	    var lng = $('body').data('lng');
	    
	    $.ajax({
		    
		    url: "/post/messages/"+lat+"/"+lng,
		    type: 'get',
		    dataType: 'json',
		    success: function(data, status) {
		        //get msgs ul
		        var list = $('#msgs');
		        var append = '';
		        
		        $(data.posts).each(function() {
		            append += '<li>'+this.text+'</li>';
		        });
		        list.append(append);
		    },
		})
	},
	
	geoHandler:function(location) {
	    
    	//Check acc before bothering
    	//console.log("Location", location);
    	if (location.coords.accuracy<50)
    	{
    		//cancel watch
    		navigator.geolocation.clearWatch(watchId);
			//cancel page loading
			$.mobile.pageLoading(true);
    	}
    	if (location.coords.accuracy<100)
    	{
			//cancel page loading

			
    		$("#post_longitude").attr("value", location.coords.longitude);
    		$("#post_latitude").attr("value", location.coords.latitude);
    		$("#post_accuracy").attr("value", location.coords.accuracy);
    		$("#submit_but").removeAttr("disabled");

    		//get image
    		$("#map_img").attr("src", "http://maps.google.com/maps/api/staticmap?center="+location.coords.latitude+","+location.coords.longitude+"&zoom=15&size="+ (screen_width - 30) +"x200&maptype=roadmap&markers=color:blue|"+location.coords.latitude+","+location.coords.longitude+"&sensor=false").load(function() {
				$.mobile.pageLoading(true);
				$(this).removeClass('loading');
    		});

    		//Get messages
    		//$("#messages").load("/post/messages/"+location.coords.latitude+"/"+location.coords.longitude);
    		$('body').data('lat', location.coords.latitude);
    		$('body').data('lng', location.coords.longitude);
    		guff_geo.getMessages();

    		//$("#dump").append("Lat: "+location.coords.latitude+", Lng: "+location.coords.longitude+", Acc:"+location.coords.accuracy)
    		$("#accuracy").text(location.coords.accuracy);
    	}
    	else
    	{
    		
    	}
    },
    
    errorHandler:function(err) {
    	//try again
    	if (err.code>0) {
    	    if (err.code==1) {
    	        $("#geo-fail").append("DENIED");
	        } else if (err.code==2) {
        	    $("#geo-fail").append("Position Unavailable");
    	    } else if (err.code==3) {
    	        $("#geo-fail").append("Timeout");
    	    }
    	    guff_geo.fail();
        }
    },
    
	fail:function() {
	    $('#content').hide();
		$('#geo-fail').slideDown();
	},
	
	init:function() {	
		
		screen_width = screen.width;
		$.mobile.pageLoading();
		
		/*$('#msg-post').live('submit', function() {
		    guff_geo.getMessages();
		    return false;
		});*/
		
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
				guff_geo.geoHandler({coords: {latitude: 51, longitude: 2, accuracy: 70}});
			}, 3000);
		}
	
	}
	
	
}

$(document).ready(function(){
	
	guff_geo.init();
	
	var max_length = 149;
		
		
	whenkeydown = function(max_length)
	{
	    $("#post_text").unbind().keyup(function()
	    {
	        //check if the appropriate text area is being typed into
	        if(document.activeElement.id === "post_text")
	        {
	            //get the data in the field
	            var text = $(this).val();

	            //set number of characters
	            var numofchars = text.length;

	            //set the chars left
	            var chars_left = max_length - numofchars;

	            //check if we are still within our maximum number of characters or not
	            if(numofchars <= max_length)
	            {
	                //set the length of the text into the counter span
	                $("#counter").html("").html(chars_left).css("color", "#000000");
	            }
	            else
	            {
	                //style numbers in red
	                $("#counter").html("").html(chars_left).css("color", "#FF0000");
	            }
	        }
	    });
	}
	//run listen key press
    whenkeydown(max_length);
	
});


