<?php 
 $linkGroup = URL::createLink('admin','group','index');
 $linkUser = URL::createLink('admin','user','index');

?>

<div id="submenu-box">
	<div class="m">
		<ul id="submenu">
			<li><a href="<?= $linkGroup ?>">Group</a></li>
			<li><a class="active" href="#">User</a></li>
		</ul>
		<div class="clr"></div>
	</div>
</div>