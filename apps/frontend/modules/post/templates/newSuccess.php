<div data-role="page" id="location">
	<div data-role="header" data-backbtn="false">
		<h1>Guff</h1>
		<a href="#help" data-transition='slideup' data-role="button" data-inline="true">Help</a>
	</div>
	<div data-role="content">
		<h3 id="location-message">Finding your location...</h3>
		<div id='the_map'>
			<img id='map_img' src="/images/map-holder.gif" class="loading" alt="map" />
		</div>
		<div id='loc-buttons' data-inline="true">
			<a href="#" id="refresh-location" data-role="button" data-inline="true" data-ajax="false" data-icon="refresh">Nope</a>
			<a href="#form-messages" id="got-location"  data-inline="true" data-transition='slideup' data-role="button" data-icon="check" data-theme="b">Yup</a>
		</div>
	</div>
</div>

<div data-role="page" id="help">
	<div data-role="header">
	   	<h1>Guff</h1>
		<a href='#location' class='ui-btn-left ui-btn-back' data-transition='slideup' data-icon='arrow-l'>Back</a>
  	</div>
	<div data-role="content">
		<h3>Help</h3>
		<p><strong>Problems with location?</strong></p>
		<p>iPhone 3's can be a bit rubbish at this when it comes to web apps. Try opening the map application that comes with the iPhone. Let it locate you. Then go back to Guff.</p>
		<p><strong>I want it on my phone with my other apps</strong></p>
		<p>There should be useful popup that helps you do this. If not just click bookmark (on iPhone) and select add to home screen.</p> 	
		<h3>About</h3>
		<p>It's not big and its not clever. Guff is just some experimental fun.</p> 
		<p>Unnecessary obstacles often make for interesting results.</p>
		<p>Post a 148 character message, anonymously. People will be able to view it for 2 hours, 100m from your location.</p>
		<p>That's it, go gossip in bars and clubs, start a flash mob with strangers or.....</p> 
		<a href="mailto:howdy@thisislabel.co.uk">Show us some love</a> 
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
		<h2>Messages near you</h2>
		<hr/>
		<h4 style="margin:0; padding:0;">Popular Tags:</h4>
		<ul id="popular-tags">
		</ul>
		<br/>
		<hr/>
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