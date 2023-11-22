<?php 
 $linkBook 		= URL::createLink('admin', 'book', 'index'); 
 $linkCategory = URL::createLink('admin','category','index');

?>

<div id="submenu-box">
	<div class="m">
		<ul id="submenu">
			<li><a href="<?= $linkBook ?>">Book</a></li>
			<li><a class="active" href="#">Category</a></li>
		</ul>
		<div class="clr"></div>
	</div>
</div>