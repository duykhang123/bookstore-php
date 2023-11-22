<?php
	$query	= "SELECT `b`.`id`, `b`.`name`, `c`.`name` AS `category_name`, `b`.`picture`, `b`.`category_id` FROM `".TBL_BOOK."` AS `b`, `".TBL_CATEGORY."` AS `c` WHERE `b`.`status`  = 1 AND `b`.`special`  = 1 AND `b`.`category_id` = `c`.`id` ORDER BY `b`.`ordering` ASC LIMIT 0,2";

	$listBooksSecial	= $model->listRecord($query);
	$xhtmlSecial		= '';

	if(!empty($listBooksSecial)){
		foreach($listBooksSecial as $key => $value){
			$name	 = $value['name'];
			$bookID			= $value['id'];
			$catID			= $value['category_id'];
			$bookNameURL	= URL::filterURL($name);
			$catNameURL		= URL::filterURL($value['category_name']);
			$picture = Helper::createImage('book','98x150-',$value['picture'],['class' => 'thumb', 'width' => '60','height' => '90']);
			
			$link	= URL::createLink('default', 'book', 'detail', array('category_id' => $value['category_id'],'book_id' => $value['id']), "$catNameURL/$bookNameURL-$catID-$bookID.html");
			
			$xhtmlSecial	.= '<div class="new_prod_box">
	                        <a href="'.$link.'">'.$name.'</a>
	                        <div class="new_prod_bg">
	                        <span class="new_icon"><img src="'.$imageURL.'/special_icon.gif" alt="" title="" /></span>
	                        <a href="'.$link.'">'.$picture.'</a>
	                        </div>           
	                    </div>';
		}
	}
?>
<div class="right_box">

	<div class="title">
		<span class="title_icon"><img src="<?php echo $imageURL; ?>/bullet4.gif" alt="" title="" /></span>Specials
	</div>
	<?php echo $xhtmlSecial;?>
</div>