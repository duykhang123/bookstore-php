<?php
	require_once LIBRARY_EXT_PATH . 'XML.php';
	$data = XML::getContentXML('categories.xml');

	$cateID = '';
	if(isset($this->arrParams['category_id'])){
		$cateID	= $this->arrParams['category_id'];
	}
	
	
	$xhtml		= '';
	if(!empty($data)){
		foreach($data as $key => $value){
			$id	 = $value->id;
			$name	 = $value->name;
			$nameURL		= URL::filterURL($name);
			$link	= URL::createLink('default', 'book', 'list', array('category_id' => $value->id), "$nameURL-$id.html");
			if($cateID == $value->id){
				$xhtml	.= '<li><a class="active" title="'.$name.'" href="'.$link.'">'.$name.'</a></li>';
			}else{
				$xhtml	.= '<li><a title="'.$name.'" href="'.$link.'">'.$name.'</a></li>';
			}
		}
	}
?>
<div class="right_box">

	<div class="title">
		<span class="title_icon"><img src="<?php echo $imageURL; ?>/bullet5.gif" alt="" title="" /></span>Categories
	</div>

	<ul class="list">
		<?php echo $xhtml;?>
	</ul>
</div>
<div class="clear"></div>