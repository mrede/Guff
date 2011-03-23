<!DOCTYPE html> 
<html> 
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
	<meta name="apple-mobile-web-app-capable" content="yes" />
    <?php include_title() ?>
	<link rel="apple-touch-icon" href="/images/apple-touch-icon.png" /> 
    <?php #include_stylesheets() ?>
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.min.css" />
	<link rel="stylesheet" href="/css/guff.css" />
	<link rel="stylesheet" href="/css/add2home.css">
	<script src="http://code.jquery.com/jquery-1.5.min.js" type="text/javascript"></script>
	<script src="/js/modernizr-1.6.min.js" type="text/javascript"></script>
	<script src="/js/geo.js" type="text/javascript"></script>
	<script src="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.min.js" type="text/javascript"></script>
	<script type="application/javascript" src="/js/add2home.js"></script>
  </head>
  <body>
	<?php echo $sf_content ?>
  </body>
</html>
