function Guff() {
}

Guff.prototype = {
    loc: null,
    watchId: null,
    maxchars: 141,
    
    init: function() {
        //bind interactions
        this.postMessage();
        this.refreshLocation();
        this.countDown();
        //kick things off
        this.getLocation();
    },
    
    getLocation: function() {
        console.log('getting location');
        var o = this;
        console.log(this.watchId);
        this.watchId = navigator.geolocation.watchPosition(function(loc) {  o.checkAccuracy(loc); }, function(error) { o.errorHandler('geo', 'Unable to get location', error); }, {
            enableHighAccuracy: true,
            maximumAge: 1000
        });
    },
    
    refreshLocation: function() {
        var o = this;
        $("#locationRefresh").on("click", function(e) {
            console.log('refreshing location');
            o.getLocation();
        });
    },
    
    followLocation: function() {
        var o = this;
        fb = $("#follow");
        fb.show();
        fb.on('click',function() {
            //1mb db, probably far more than needed
            var db = window.openDatabase('guff_followed_locations', "1.0", 'Guff DB', 1048576);
            db.transaction(function(tx) {
               tx.executeSql('CREATE TABLE IF NOT EXISTS followed_locations (id INTEGER PRIMARY KEY AUTOINCREMENT, latitude, longitude)');
               tx.executeSql('INSERT INTO followed_locations (latitude, longitude) VALUES ('+o.loc.coords.latitude+','+o.loc.coords.longitude+')');
            },
            function(err) {
               o.errorHandler('db', 'Error storing location', err);
            },
            function(){
               o.notificationHandler('success', 'Location saved');
            });
        });
    },
    
    checkAccuracy: function(loc) {
        // put check in for accuracy location.coords.accuracy
        console.log('checking accuracy');
        console.log('accuracy at: ' + loc.coords.accuracy);
        if(loc.coords.accuracy < 100) {
            console.log('accurate location obtained');
            console.log(loc.coords.accuracy);
            navigator.geolocation.clearWatch(this.watchId); 
            this.loc = loc;
            
            //set hidden fields for message
            $("#accuracy").attr('value', this.loc.coords.accuracy);
            $("#latitude").attr('value', this.loc.coords.latitude);
            $("#longitude").attr('value', this.loc.coords.longitude);
            
            this.setMap();
            this.getMessages();
            //this.followLocation();
        }
    },
    
    setMap: function() {
        console.log('setting map:' + this.loc.coords.latitude + this.loc.coords.longitude);
        $("#loading").show();
        var img = new Image();
        img.src = "http://maps.google.com/maps/api/staticmap?center="+this.loc.coords.latitude+","+this.loc.coords.longitude+"&zoom=15&size=200x200&maptype=roadmap&markers=color:blue|"+this.loc.coords.latitude+","+this.loc.coords.longitude+"&sensor=true";
        console.log(img.src);
        img.onload = function() {
            console.log('loaded map image from google');
            $("#loading").hide();
            $("#map span").html(img);
            $(img).css({width: '100%', height: 'auto'});
        }
    },
    
    getMessages: function() {
        console.log('getting messages');
        var o = this;
        var message_data = "http://guff.local:4567/messages/"+this.loc.coords.latitude+"/"+this.loc.coords.longitude;
        $.ajax({
          type: 'get',
          url: message_data,
          dataType: 'json',
          timeout: 300,
          context: $('body'),
          success: function(data){ o.parseMessages(data); },
          error: function(xhr, type){ o.errorHandler('ajax', xhr, type); }
        });
    },
    
    parseMessages: function(data) {
        var o = this;
        var append = '';
        $(data).each(function(){
            append += "<li><p>"+this.message+"</p><span>"+o.remaningMessageTime(7190)+"</span></li>";
        });
        $("#messages").html(append);
    },
        
    postMessage: function() {
        var o = this;
        $('#send-guff').on('submit', function(e){
            if ($('#message').attr('value').length>0) {
                $.ajax({
                     url: $('#send-guff').attr('action'),
                     type: 'post',
                     data: $('#send-guff').serialize(),
                     dataType: 'json',
                     timeout: 300,
                     success: function(data) { 
                        o.notificationHandler('success','Message posted');
                        $("#back").trigger('click');
                        o.resetMessageField();
                        o.getMessages(); 
                     }
                });
            } else {
                o.errorHandler('user', 'You need to write something', '');
            }
            return false;
        });
    },
    
    resetMessageField: function() {
        $("#message").val('');
        $("#counter").html(this.maxchars);
    },
    
    newMessage: function() {
        //needs to be changed for new push updates
        var o = this;
        this.channel.bind("new_guff", function(data) {
            $("#messages").prepend("<li><p>"+data+"</p><span>"+o.remaningMessageTime(7200)+"</span></li>");
         });  
    },
    
    countDown: function() {
        var o = this;
        $('#message').bind('keydown', function(e) {
            text = $(this).val();
            noc = text.length;
            chars_left = o.maxchars - noc;
            $("#counter").html(chars_left);
            if(noc > o.maxchars) {
                $("#counter").css('color', 'red');
            } else {
                $("#counter").css('color', '#4D4D4D');
            }
        });
    },
    
    remaningMessageTime: function(seconds) {
        minutes = Math.round(seconds / 60);
        hours = minutes / 60;
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
        } else if (minutes <= 30 && minutes > 2) {
            time_message = 'under 30 minutes left';
        } else {
            time_message = 'nearly outta here';
        }
        return time_message;
    },
    
    notificationHandler: function(type, message) {
      switch(type)
      {
          case 'success':
                console.log(message);
            break;
      }  
    },
    
    errorHandler: function(type, message, error) {
        switch(type)
        {
        case 'geo':
                if (error.code>0) {
                    if (error.code===1) {
                        $("#error").append("Denied");
                    } else if (error.code===2) {
                        $("#error").append("Position Unavailable");
                    } else if (error.code===3) {
                        $("#error").append("Timeout");
                    }
                }
            break;
        case 'ajax':
                $("#error").append(message);
            break;
        case 'user':
                $("#error").append(message);
            break;
        case 'db':
                $("#error").append(message);
                console.log(error);
            break;
        }
        
    }
};

$(function(){
    var guff = new Guff();
    guff.init();
});

var jQT = new $.jQTouch({
    icon: 'jqtouch.png',
    addGlossToIcon: false,
    startupScreen: '/images/apple-touch-icon.png',
    statusBar: 'black',
    fixedViewport: true,
    formSelector: '.form'
});