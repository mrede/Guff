var watchId;
var test = 0;
var screen_width;



var guff_geo = {
    
    /**
     * Load the post form
     */
    loadMap:function() {
        $("#form_holder").load('/post/ajaxForm', function(data, status, response) { });
    },
    
    parseMessages:function(data, status) {
        //get msgs ul
        var list = $('#msgs');
        $.mobile.pageLoading(true);
        var append = '';
        $(data.posts).each(function() {
			left_to_go = guff_geo.leftToGo(this.e);
            append += '<li><p style="font-size: 1em;">'+this.t+'</p><span>'+left_to_go+'</span></li>';
        });
        list.html(append);
        if ($('#msgs').listview()) {
            $('#msgs').listview('refresh');
			$('textarea').val('');
        }
    },
    
    getMessages:function() {
        var lat = $('body').data('lat');
        var lng = $('body').data('lng');
        
        $.ajax({
            url: "/post/messages/"+lat+"/"+lng,
            type: 'get',
            dataType: 'json',
            success: guff_geo.parseMessages
        });
    },

    leftToGo:function(seconds) {
		minutes = Math.round(seconds / 60);
		hours = minutes / 60;
		//maybe 2 hours to go, 1 hour to go, 30 minutes, 2 minutes, count down?
		if(hours > 1) {
		    if (minutes > 115) {
		        var mOld = 121-minutes;
		        var mS = mOld > 1 ? 's':'';
		        time_message = "posted less than "+mOld+" minute"+mS+" ago";
		    } else {
		        time_message = 'under 2 hours left ';
		    }
			
		} else if (hours <= 1 && minutes > 30) {
			time_message = 'under 1 hour left';
		} else if (minutes <= 30 && minutes > 2) {60
			time_message = 'under 30 minutes left';
		} else {
			time_message = 'nearly outta here';
		}
		return time_message;
	},
    
    geoHandler:function(location) {
        //Check acc before bothering
        //console.log("Location", location);
        
            //cancel watch
            navigator.geolocation.clearWatch(watchId);
            //cancel page loading
            $.mobile.pageLoading(true);
    

            
            //cancel page loading
            $('#loc-buttons').fadeIn();
            
            
            $("#post_longitude").attr("value", location.coords.longitude);
            $("#post_latitude").attr("value", location.coords.latitude);
            $("#post_accuracy").attr("value", location.coords.accuracy);
            $("#submit_but").removeAttr("disabled");

            //get image
            $("#map_img").attr("src", "http://maps.google.com/maps/api/staticmap?center="+location.coords.latitude+","+location.coords.longitude+"&zoom=15&size="+ (screen_width - 30) +"x200&maptype=roadmap&markers=color:blue|"+location.coords.latitude+","+location.coords.longitude+"&sensor=true").load(function() {
                $(this).removeClass('loading');
				$('#location-message').text('Close enough?');
            });

            //Get messages
            //$("#messages").load("/post/messages/"+location.coords.latitude+"/"+location.coords.longitude);
            $('body').data('lat', location.coords.latitude);
            $('body').data('lng', location.coords.longitude);
            guff_geo.getMessages();

            //$("#dump").append("Lat: "+location.coords.latitude+", Lng: "+location.coords.longitude+", Acc:"+location.coords.accuracy)
            $("#accuracy").text(location.coords.accuracy);
        
        
    },
    
    errorHandler:function(err) {
        //try again
        if (err.code>0) {
            if (err.code===1) {
                $("#geo-fail").append("Denied");
            } else if (err.code===2) {
                $("#geo-fail").append("Position Unavailable");
            } else if (err.code===3) {
                $("#geo-fail").append("Timeout");
            }
            guff_geo.fail();
        }
    },
    
    fail:function() {
        $('#content').hide();
        $('#geo-fail').slideDown();
    },
    
    locate:function() {
        watchId = navigator.geolocation.watchPosition(guff_geo.geoHandler, guff_geo.errorHandler, {
            enableHighAccuracy: true,
            maximumAge: 0
        });
    },
    
    
    
    init:function() {    
        
        
        Pusher.log = function(message) {
            if (window.console && window.console.log) window.console.log(message);
        };
        
        // Flash fallback logging - don't include this in production
        WEB_SOCKET_DEBUG = true;
        
        
        $('#loc-buttons').hide();
        $('#location-message').fadeIn();
        
        screen_width = screen.width;
        $.mobile.pageLoading();
        
        $('#msg-post').unbind('submit');
        $('#msg-post').submit(function(){
            if ($('#post_text').attr('value').length>0) {
                $.mobile.pageLoading();
                $.ajax({
                    url: $('#msg-post').attr('action'),
                    type: 'post',
                    data: $('#msg-post').serialize()+'&sockID='+pusher.socket_id,
                    dataType: 'json',
                    success: guff_geo.parseMessages
                });
            }
            return false;
        });
        
        //Check for geo capability
        if (!$('html').hasClass("geolocation"))
        {
            guff_geo.fail();
            //Do nothing else
            return;
        }
        
        //user would like to try again...
        $("#refresh-location").click(function(){
			navigator.geolocation.clearWatch(watchId);
			$.mobile.pageLoading();
            guff_geo.locate();
            $('#location-message').text('Finding your location...');
            return false;
        });

		$("#got-location").click(function(){
			navigator.geolocation.clearWatch(watchId);
			$.mobile.changePage($("#form-messages"), "slideup", true, true);
			//Get Messages
			
			//Register push
			//Set up PUSH
            
            
            
            
            var lat = String(Math.round($('body').data('lat')*1000)).replace("-", "m");
            var lng = String(Math.round($('body').data('lng')*1000)).replace("-", "m");
			var channelName = 'c'+lat+'_'+lng;

			var channel = pusher.subscribe(channelName);
//			alert(channelName);
			channel.bind("new_guff", function(data) {

                //guff_geo.getMessages();
                var list = $('#msgs');

                var append = '';
                
        			left_to_go = guff_geo.leftToGo(7200);
                    append += '<li><p style="font-size: 1em;">'+data+'</p><span>'+left_to_go+'</span></li>';
                
                list.prepend(append);
                if ($('#msgs').listview()) {
                    $('#msgs').listview('refresh');
        			$('textarea').val('');
                }

                
            });
            
            return false;
        });
        
        guff_geo.locate();
        
        if (test)
        {
            setTimeout(function(){
                guff_geo.geoHandler({coords: {latitude: 51, longitude: 2, accuracy: 70}});
            }, 3000);
        }
    
    }
    
    
};


$(document).bind("mobileinit", function(){
  //apply overrides here
  $.extend(  $.mobile , {
     ajaxFormsEnabled: false
   });
  
  //if you are on the post page without a location....
  $('#form-messages').live('pagebeforecreate',function(event, ui){
      if($('body').data('lat') === undefined) {
        document.location = "http://" + document.location.href.split('/')[2];
    }
  });

});


$(document).ready(function(){
    guff_geo.init();

    var max_length = 148;    
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
    };
    //run listen key press
    whenkeydown(max_length);
    
});



