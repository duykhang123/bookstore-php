<?php 
 $linkBook 		= URL::createLink('admin', 'book', 'index'); 
 $linkCategory = URL::createLink('admin','category','index');

?>

<div id="submenu-box">
	<div class="m">
		<ul id="submenu">
			<li><a class="active" href="#">Book</a></li>
			<li><a  href="<?= $linkCategory ?>">Category</a></li>
		</ul>
		<div class="clr"></div>
	</div>
</div>