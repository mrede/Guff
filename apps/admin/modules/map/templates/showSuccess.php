<style type="text/css" media="screen">
html, body { height:100%; background-color: #ffffff;}
body { margin:0; padding:0; overflow:hidden; }
#flashContent { width:100%; height:100%; border:1px solid green;}
</style>
<script>


var guff_geo_admin = {
    
    parseMessages:function(data, status) {
        //get msgs ul
//        document.getElementById("flashContent").testFunc('asd');     

        $(data.posts).each(function() {
        console.log("Got messages", this.lat, this.lng);            
            document.getElementById("flashContent").testFunc( this.i, this.lat, this.lng, this.e, this.t);
        });
        
    },
    
    getMessages:function() {
        var lat = 51.57119;//$('body').data('lat');
        var lng = -0.10613;//   $('body').data('lng');
        console.log("GETTING");
        $.ajax({
            url: "/post/messages/"+lat+"/"+lng,
            type: 'get',
            dataType: 'json',
            success: guff_geo_admin.parseMessages
        });
    },
    
    init:function() {
        console.log("INIT");
        var lat = String(Math.round(51.57)).replace("-", "m");
        var lng = String(Math.round($('body').data('lng')*1000)).replace("-", "m");
        var channelName = 'c51571_m106';

        var channel = pusher.subscribe(channelName);
        console.log("CHannel", channel);
        
        
        
        channel.bind("new_guff", function(data) {

            //guff_geo.getMessages();
            console.log("MESSAGE HERE");
            
            guff_geo_admin.getMessages();
        });
        
    }
};

$(document).ready(function(){
    guff_geo_admin.init();
    
});

var attributes = {};
   var flashvars = {
       key: '<?php echo sfConfig::get('app_google_api_key')?>',
       lat: '<?php echo $mapView->getLatitude()?>',
       lng: '<?php echo $mapView->getLongitude()?>',
       pitch: '<?php echo $mapView->getPitch()?>',
       yaw: '<?php echo $mapView->getYaw()?>',
       roll: '<?php echo $mapView->getRoll()?>',
       
       };
   var params =   {wmode:'transparent'};
swfobject.embedSWF(
             "/map.swf",
             "flashContent",
             "500px",
             "500px",
             "10.0.0",
             "/flash/expressInstall.swf",
             flashvars,
             params,
             attributes
             );



function testFunc() {
    console.log("YUP")
}

 

function formSend() {   
    //var text = document.htmlForm.sendField.value;   
    console.log(getFlashMovie("test"));
    document.getElementById("flashContent").testFunc('asd');     
    }    
    
function getTextFromFlash(str) {   
    //document.htmlForm.receivedField.value = "From Flash: " + str;   
    return str + " received";  
} </script> 


<a href="#" onclick="javascript:guff_geo_admin.getMessages();" />TEST</a>
<div id="flashContent">

</div>

