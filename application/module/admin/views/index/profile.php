<?php 
	include_once (MODULE_PATH . 'admin/views/toolbar.php');
	

	
	// Input
	$dataForm 		= $this->arrParam['form'];
	
	$inputFullName	= Helper::cmsInput('text', 'form[username]', 'username', $dataForm['username'] ?? '', 'inputbox required', 40);
	$inputEmail		= Helper::cmsInput('text', 'form[email]', 'email', $dataForm['email'] ?? '', 'inputbox required', 40);
	$inputID	= Helper::cmsInput('text', 'form[id]', 'id', $dataForm['id'] ?? '', 'inputbox readonly');
	$inputToken        = Helper::cmsInput('hidden', 'form[token]', 'token', time());
	// Row
	$rowEmail		= Helper::cmsRowForm('Email', $inputEmail, true);
	$rowID			= Helper::cmsRowForm('ID', $inputID);
	$rowFullName	= Helper::cmsRowForm('Full Name', $inputFullName);

	
	// MESSAGE
	$message	= Session::get('message');
	Session::delete('message');
	$strMessage = Helper::cmsMessage($message);
?>
<div id="system-message-container"><?=  $strMessage ?? ''?><?= $this->errors ??'' ?></div>
<div id="element-box">
	<div class="m">
		<form action="#" method="post" name="adminForm" id="adminForm" class="form-validate">
			<!-- FORM LEFT -->
			<div class="width-100 fltlft">
				<fieldset class="adminform">
					<legend>Details</legend>
					<ul class="adminformlist">
						<?=    $rowEmail . $rowFullName  . $rowID;?>
					</ul>
					<div class="clr"></div>
					<div>
						<?php echo $inputToken;?>
					</div>
				</fieldset>
			</div>
			<div class="clr"></div>
			<div>
			</div>
		</form>
		<div class="clr"></div>
	</div>
</div>
        
     