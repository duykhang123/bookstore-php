<?php
$model 	= new Model();
$query    = "SELECT `b`.`id`, `b`.`name`, `b`.`picture`,`b`.`category_id`,`c`.`name` as `category_name` FROM `" . TBL_BOOK . "` as `b`, `".TBL_CATEGORY."` as `c`  WHERE `b`.`status`  = 1 AND `b`.`sale_off` > 0 AND `b`.`category_id` = `c`.`id` ORDER BY `b`.`ordering` ASC LIMIT 0,2";

$listBooks    = $model->listRecord($query);


$xhtml        = '';
if (!empty($listBooks)) {
    foreach ($listBooks as $key => $value) {
        $name    = URL::filterURL($value['name']);
        $catID = $value['category_id'];
        $bookID = $value['id'];
        $catNameURL = URL::filterURL($value['category_name']);
        $link    = URL::createLink('default', 'book', 'detail', array('category_id' => $value['category_id'],'book_id' => $value['id']),"$catNameURL/$name-$catID-$bookID.html");
        $picture = Helper::createImage('book','98x150-',$value['picture'],['class' => 'thumb', 'width' => 60,'height' => 90]);



        $xhtml    .= '<div class="new_prod_box">
	                        <a href="' . $link . '">' . $name . '</a>
	                        <div class="new_prod_bg">
	                        <span class="new_icon"><img src="' . $imageURL . '/promo_icon.png" alt="" title="" /></span>
	                        <a href="' . $link . '">' . $picture . '</a>
	                        </div>           
	                    </div>';
    }
}
?>
<div class="right_box">

    <div class="title">
        <span class="title_icon"><img src="<?php echo $imageURL; ?>/bullet4.gif" alt="" title="" /></span>Promotions
    </div>
    <?php echo $xhtml; ?>
</div>