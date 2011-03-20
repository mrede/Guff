<div data-role="page" id="location">
	<div data-role="header">
		<h1>Guff</h1>
	</div>
	<div data-role="content">
		<h3>Close enough?</h3>
		<div id='the_map'>
			<img id='map_img' src="/images/map-holder.png" class="loading" alt="map" />
		</div>
		<div id='loc-buttons' data-inline="true">
			<a href="/" data-role="button" data-inline="true" data-ajax="false" data-icon="refresh">Nope</a>
			<a href="#form-messages"  data-inline="true" data-transition='slideup' data-role="button" data-icon="check" data-theme="b">Yup</a>
		</div>
	</div>
</div>
	
<div data-role="page" id="form-messages">
	<div data-role="header">
	   	<h1>Guff</h1>
		<a href="#location" data-role="button" data-transition='slidedown' data-inline="true" data-icon="refresh">Location</a>
  	</div>
	<div data-role="content">
		<div id='form_holder'>
			<?php include_partial("form", array('form' => $form))?>
		</div>
		<h2>Messages</h2>
		<ul data-role="listview" role="listbox" data-inset="true" id="msgs" data-theme='d'>
		
		</ul>
	</div>
	<!-- <div id='fail'>
			This site requires javascript.
		</div>
		<div id='geo-fail'>
			Your browser doesn't have geo location capability. Sorry
		</div> -->
</div>