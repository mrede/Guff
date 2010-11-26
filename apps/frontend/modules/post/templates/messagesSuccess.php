<h2>Recent Messages</h2>
<ul>
<?php foreach($posts as $p):?>
	<li><?php echo $p->getText()?></li>
<?php endforeach?>
</ul>