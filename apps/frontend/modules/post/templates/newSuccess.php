<div data-role="page" id="location">
	<div data-role="header" data-backbtn="false">
		<h1>Guff</h1>
		<a href="#about" data-transition='slideup' data-role="button" data-inline="true">About</a>
	</div>
	<div data-role="content">
		<h3 id="location-message">Finding your location...</h3>
		<div id='the_map'>
			<img id='map_img' src="/images/map-holder.png" class="loading" alt="map" />
		</div>
		<div id='loc-buttons' data-inline="true">
			<a href="#" id="refresh-location" data-role="button" data-inline="true" data-ajax="false" data-icon="refresh">Nope</a>
			<a href="#form-messages"  data-inline="true" data-transition='slideup' data-role="button" data-icon="check" data-theme="b">Yup</a>
		</div>
	</div>
</div>

<div data-role="page" id="about">
	<div data-role="header">
	   	<h1>Guff</h1>
		<a href='#location' class='ui-btn-left ui-btn-back' data-transition='slideup' data-icon='arrow-l'>Back</a>
  	</div>
	<div data-role="content">
		<h3>About</h3>
		<p>It's not big and its not clever. Guff is just some experimental fun.</p> 
		<p>The less someone is able to do sometimes makes for interesting results.</p>
		<p>Post a 149 character message anonymously and people will be able to view it for 2 hours, 100m from your location.</p>
		<p>That's it, go gossip in bars and clubs, start a flash mob with strangers or.....</p> 
		<a href="http://www.thisislabel.co.uk">Love from Label</a> 
	</div>
	<!-- <div id='fail'>
			This site requires javascript.
		</div>
		<div id='geo-fail'>
			Your browser doesn't have geo location capability. Sorry
		</div> -->
</div>
	
<div data-role="page" id="form-messages">
	<div data-role="header">
	   	<h1>Guff</h1>
		<a href="#location" data-role="button" data-transition='slideup' data-inline="true" data-icon="refresh">Location</a>
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