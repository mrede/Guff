<!DOCTYPE html> 
<html> 
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php #include_stylesheets() ?>
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.min.css" />
	<link rel="stylesheet" href="css/guff.css" />
	<script src="http://code.jquery.com/jquery-1.5.min.js" type="text/javascript"></script>
	<script src="/js/modernizr-1.6.min.js" type="text/javascript"></script>
	<script src="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.min.js" type="text/javascript"></script>
	<script src="/js/geo.js" type="text/javascript"></script>
  </head>
  <body>
	<?php echo $sf_content ?>
  </body>
</html>
