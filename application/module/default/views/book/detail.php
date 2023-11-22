<?php
$bookInfo	= $this->bookInfo;
$name		= $bookInfo['name'];

$picture = Helper::createImage('book','98x150-',$bookInfo['picture']);
$picturePath	= UPLOAD_PATH . 'book' . DS . '98x150-' . $bookInfo['picture'];

$pictureFull	= '';
if (file_exists($picturePath) == true) {
	$pictureFull	= UPLOAD_URL . 'book' . DS . $bookInfo['picture'];
}
$description	= substr($bookInfo['description'], 0, 400);

$priceReal = 0;
if ($bookInfo['sale_off'] > 0) {
	$priceReal = (100 - $bookInfo['sale_off']) * $bookInfo['price'] / 100;
	$price	 = ' <span class="red-through">' . number_format($bookInfo['price']) . '</span>';
	$price	.= ' <span class="red">' . number_format($priceReal) . '</span>';
} else {
	$priceReal = $bookInfo['price'];
	$price	= ' <span class="red">' . number_format($priceReal) . '</span>';
}


$linkOrder 			= URL::createLink('default','user','order',['book_id' => $bookInfo['id'], 'price' => $priceReal]);
$linkRelateBooks 	= URL::createLink('default','book','relate',['book_id' => $bookInfo['id'], 'category_id' => $bookInfo['category_id']]);




?>

<!-- TITLE -->
<div class="title">
	<span class="title_icon"> <img src="<?php echo $imageURL; ?>/bullet1.gif"></span><?php echo $name; ?>
</div>

<!-- BOOK INFO -->
<div class="feat_prod_box_details">
	<div class="prod_img">
		<a href="#"><?php echo $picture; ?></a> <br>
		<br> <a id="single_image" href="<?php echo $pictureFull; ?>" rel="lightbox"> <img src="<?php echo $imageURL; ?>/zoom.gif" alt="" title="" border="0"></a>
	</div>
	<div class="prod_det_box">
		<div class="box_top"></div>
		<div class="box_center">
			<div class="prod_title">Details</div>
			<p class="details"><?php echo $description; ?></p>
			<div class="price">
				<strong>PRICE:</strong><?php echo $price; ?>
			</div>
			<a href="<?= $linkOrder ?>" class="more"><img src="<?php echo $imageURL; ?>/order_now.gif"></a>
			<div class="clear"></div>
		</div>
		<div class="box_bottom"></div>
	</div>
	<div class="clear"></div>
</div>

<!-- RELATE BOOK -->
<div id="demo" class="demolayout">

	<ul id="demo-nav" class="demolayout">
		<li><a class="tab1 active" href="#">More details</a></li>
		<li><a class="tab2" onclick="showRelateBooks('<?= $linkRelateBooks ?>')" href="javascript:void(0)">Related books</a></li>
	</ul>

	<div class="tabs-container">

		<div style="display: block;" class="tab" id="tab1">
			<p class="more_details"><?php echo $bookInfo['description']; ?></p>
		</div>

		<div style="display: none;" class="tab" id="tab2">
			<!-- RELATE BOOK -->
		</div>
	</div>
</div>