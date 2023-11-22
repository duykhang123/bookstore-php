<?php
include_once (MODULE_PATH . 'admin/views/toolbar.php');
include_once('submenu/index.php');

$dataForm         = $this->arrParam['form'] ?? '';
$inputName        = Helper::cmsInput('text', 'form[name]', 'name', $dataForm['name'] ?? '', 'inputbox required', 40);
$inputOrdering    = Helper::cmsInput('text', 'form[ordering]', 'ordering', $dataForm['ordering']?? '', 'inputbox', 40);
$inputToken        = Helper::cmsInput('hidden', 'form[token]', 'token', time());
$selectStatus    = Helper::cmsSelecbox('form[status]', null, array('default' => '- Select status -', 1 => 'Publish', 0 => 'Unpublish'), $dataForm['status'] ?? '', 'width: 150px');
$inputPicture	= Helper::cmsInput('file', 'picture', 'picture', $dataForm['picture'] ?? '', 'inputbox', 40);

$inputID        = '';
$rowID            = '';
if (isset($this->arrParam['id'])) {
    $inputID    = Helper::cmsInput('text', 'form[id]', 'id', $dataForm['id'] ?? '', 'inputbox readonly');
    $rowID        = Helper::cmsRowForm('ID', $inputID);
    $picturePath	= UPLOAD_PATH . 'category' . DS . '60x90-' . $dataForm['picture'];

    if(file_exists($picturePath) == true){
        $picture	= '<img src="'.UPLOAD_URL . 'category' . DS . '60x90-' . $dataForm['picture'] .'">';
    }else{
        $picture	= '<img src="'.UPLOAD_URL . 'category' . DS . '60x90-default.jpg' .'">';
    }
    

	$inputPictureHidden	= Helper::cmsInput('hidden', 'form[picture_hidden]', 'picture_hidden', $dataForm['picture'], 'inputbox', 40);
}
// Row
$rowName        = Helper::cmsRowForm('Name', $inputName, true);
$rowOrdering    = Helper::cmsRowForm('Ordering', $inputOrdering);
$rowStatus        = Helper::cmsRowForm('Status', $selectStatus);
$rowPicture		= Helper::cmsRowForm('Picture', $inputPicture . ($picture ?? '') . ($inputPictureHidden ?? ''));
// MESSAGE
$message    = Session::get('message');
Session::delete('message');
$strMessage = Helper::cmsMessage($message);


?>
<div id="system-message-container"><?=  $strMessage ?? ''?><?= $this->errors ??'' ?></div>
<div id="element-box">
    <div class="m">
        <form action="#" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
            <!-- FORM LEFT -->
            <div class="width-100 fltlft">
                <fieldset class="adminform">
                    <legend>Details</legend>
                    <ul class="adminformlist">
                        <?php echo $rowName . $rowStatus .$rowPicture . $rowOrdering . $rowID; ?>
                    </ul>
                    <div class="clr"></div>
                    <div>
                        <?php echo $inputToken; ?>
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