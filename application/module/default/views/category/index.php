<?php
	$xhtml = '';
	if(!empty($this->Items)){
		foreach($this->Items as $key => $value){
			$name	= $value->name;
			$nameURL		= URL::filterURL($name);
			$id				= $value->id;
			
			$link	= URL::createLink('default','book','list', ['category_id' => $value->id], "$nameURL-$id.html");
			$picture = Helper::createImage('category','60x90-',$value->picture,['class' => 'thumb']);


			
			$xhtml 	.= '<div class="new_prod_box">
							<a href="'.$link.'">'.$name.'</a>
							<div class="new_prod_bg">
								<a href="'.$link.'">'.$picture.'</a>
							</div>           
						</div>';
		}
	}
?>

<!-- TITLE -->
<div class="title">
	<span class="title_icon">
		<img src="<?php echo $imageURL;?>/bullet1.gif" alt="" title="">
	</span>Category books
</div>

<!-- LIST CATEGORIES -->
<div class="new_products">
	<?php echo $xhtml;?>
</div>