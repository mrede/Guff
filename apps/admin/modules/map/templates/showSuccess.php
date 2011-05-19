<style type="text/css" media="screen">
html, body { height:100%; background-color: #ffffff;}
body { margin:0; padding:0; overflow:hidden; }
#flashContent { width:100%; height:100%; border:1px solid green;}
</style>
<script>


var guff_geo_admin = {
    
    parseMessages:function(data, status) {
        //get msgs ul
console.log(data, status);
        $(data.posts).each(function() {
        console.log("Got messages", this.lat, this.lng);            
            document.getElementById("flashContent").testFunc( this.i, this.lat, this.lng, this.e, this.t);
        });
        
    },
    
    getMessages:function() {
        var lat = <?php echo $mapView->getLatitude()?>;//$('body').data('lat');
        var lng = <?php echo $mapView->getLongitude()?>;//   $('body').data('lng');
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
        var lat = String(Math.round(<?php echo $mapView->getLatitude()?>*10)).replace("-", "m");
        var lng = String(Math.round(<?php echo $mapView->getLongitude()?>*10)).replace("-", "m");
        var channelName = 'c'+lat+'_'+lng;//'c51571_m106';

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


function updateLoc(lat, lng, msg) {

    $('#post_latitude').attr('value', lat);
    $('#post_longitude').attr('value', lng);
    $('#post_text').html(msg);

    $.ajax({
        url: $('#msg-post').attr('action'),
        type: 'post',
        data: $('#msg-post').serialize()+'&sockID='+pusher.socket_id,
        dataType: 'json',
        success: guff_geo_admin.parseMessages
    });
}


</script> 


<a href="#" onclick="javascript:guff_geo_admin.getMessages();" />TEST</a>
<div id="flashContent">

</div>

<div style='display:none'>
<form id='msg-post' action="/message" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  
  <?php echo $form->renderGlobalErrors() ?>

  <?php echo $form['text']->renderLabel('Post a message [<span id="counter">148</span> characters]') ?><br/>
  
          <?php echo $form['text']->renderError() ?>
          <?php echo $form['text'] ?><br/>
		  <strong>Your message will be visible within a 100m range of here for 2hrs</strong> <!-- / Accuracy: <span id="accuracy"> --></span><br/>
		  <input id='submit_but' data-inline="true" data-ajax="false" data-theme="b" class='button' type="submit" value="send"/>
		   <?php echo $form->renderHiddenFields()?>
          
      
</form>
</div>
