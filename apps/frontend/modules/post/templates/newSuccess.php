<div id='content'>
	<div class='loader'>
		<img id='ajax_loader' src='/images/ajax-loader.gif' alt='loading' />
		<p>Checking your position</p>
	</div>
	<div id='the_map'>
		
		<img id='map_img' src="" alt="map" />
	</div>
	<div id='form_holder'>
		<?php include_partial("form", array('form' => $form))?>
	</div>
	<div id='messages'>
	    <h2>Messages</h2>
	    <ul id='msgs'>
	    </ul>
	</div>
	<div id='debug'>
	
	</div>
</div>
<div id='fail'>
	This site requires javascript.
</div>
<div id='geo-fail'>
	Your browser doesn't have geo location capability. Sorry
</div>