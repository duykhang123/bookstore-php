<?php
	
	// Input
	$inputSubmit	= Helper::cmsInput('submit', 'form[submit]', 'submit', 'login', 'register');
	$inputToken		= Helper::cmsInput('hidden', 'form[token]', 'token', time()); 
	
	// Row
	$rowPassword	= Helper::cmsRow('Password', Helper::cmsInput('text', 'form[password]', 'password', null, 'contact_input'));
	$rowEmail		= Helper::cmsRow('Email', Helper::cmsInput('text', 'form[email]', 'email', null, 'contact_input'));
	$rowSubmit		= Helper::cmsRow('Submit', $inputToken . $inputSubmit, true);
	
	$linkAction		= URL::createLink('default', 'index', 'login');
?>
<div class="title">
	<span class="title_icon"><img src="<?php echo $imageURL;?>/bullet1.gif"/></span>Đăng nhập
</div>

<div class="feat_prod_box_details">
	<div class="contact_form">
		<div class="form_subtitle">login</div>
		<?php echo $this->errors ?? '';?>
		<form name="adminform" action="<?php echo $linkAction?>" method="POST">
			<?php echo $rowEmail . $rowPassword .  $rowSubmit;?>
		</form>
	</div>
</div>
<div class="clear"></div>