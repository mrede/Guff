<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    
    
    <script src="http://js.pusherapp.com/1.8.2/pusher.min.js" type="text/javascript"></script>

	<script type="text/javascript">
	<?php if ($_SERVER['ENVIRONMENT']=='DEV'):?>
        // Enable pusher logging - don't include this in production
        Pusher.log = function(message) {
            if (window.console && window.console.log) window.console.log(message);
        };
        
        // Flash fallback logging - don't include this in production
        WEB_SOCKET_DEBUG = true;
        
    <?php endif?>
        var pusher = new Pusher('6b5e2c3e82788a7a4422');
      </script>
      
  </head>
  <body>
    <?php echo $sf_content ?>
  </body>
</html>
