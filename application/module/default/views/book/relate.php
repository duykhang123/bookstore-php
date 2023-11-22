<?php
$xhtmlRelateBooks = '';
if (!empty($this->bookRelate)) {
	foreach ($this->bookRelate as $key => $value) {
		$name			= substr($value['name'], 0, 20);
		$bookID			= $value['id'];
		$catID			= $value['category_id'];
		$bookNameURL	= URL::filterURL($name);
		$catNameURL		= URL::filterURL($value['category_name']);
		$link			= URL::createLink('default', 'book', 'detail', array('category_id' => $value['category_id'], 'book_id' => $value['id']), "$catNameURL/$bookNameURL-$catID-$bookID.html");

		$picture = Helper::createImage('book', '98x150-', $value['picture'], ['class' => 'thumb', 'width' => '60', 'height' => '90']);


		$xhtmlRelateBooks 	.= '<div class="new_prod_box">
									<a href="' . $link . '">' . $name . '</a>
									<div class="new_prod_bg">
										<a href="' . $link . '">' . $picture . '</a>
									</div>
								</div>';
	}
	echo $xhtmlRelateBooks . '<div class="clear"></div>';
}
