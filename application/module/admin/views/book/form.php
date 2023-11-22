<?php
include_once(MODULE_PATH . 'admin/views/toolbar.php');
include_once('submenu/index.php');

$dataForm         = $this->arrParam['form'] ?? '';
$inputName        = Helper::cmsInput('text', 'form[name]', 'name', $dataForm['name'] ?? '', 'inputbox required', 40);
$inputDescription    = '<textarea name="form[description]">' . ($dataForm['description'] ?? '') . '</textarea>';
$inputPrice            = Helper::cmsInput('text', 'form[price]', 'price', $dataForm['price'] ?? '', 'inputbox required', 40);
$inputSaleOff        = Helper::cmsInput('text', 'form[sale_off]', 'sale_off', $dataForm['sale_off']?? '', 'inputbox', 40);

$inputOrdering    = Helper::cmsInput('text', 'form[ordering]', 'ordering', $dataForm['ordering'] ?? '', 'inputbox', 40);
$inputToken        = Helper::cmsInput('hidden', 'form[token]', 'token', time());
$selectStatus    = Helper::cmsSelecbox('form[status]', null, array('default' => '- Select status -', 1 => 'Publish', 0 => 'Unpublish'), $dataForm['status'] ?? '', 'width: 150px');
$slbSpecial			= Helper::cmsSelecbox('form[special]', null, array('default' => '- Select special -', 1 => 'Yes', 0 => 'No'), $dataForm['special']?? '', 'width: 180px');
$selectCategory    = Helper::cmsSelecbox('form[category_id]', null, $this->slbCategory, $dataForm['category_id'] ?? '', 'width: 150px');
$inputPicture	= Helper::cmsInput('file', 'picture', 'picture', $dataForm['picture'] ?? '', 'inputbox', 40);


$inputID        = '';
$rowID            = '';
if (isset($this->arrParam['id'])) {
    $inputID    = Helper::cmsInput('text', 'form[id]', 'id', $dataForm['id'] ?? '', 'inputbox readonly');
    $rowID        = Helper::cmsRowForm('ID', $inputID);

    $picturePath	= UPLOAD_PATH . 'book' . DS . '98x150-' . $dataForm['picture'];

    if(file_exists($picturePath) == true){
        $picture	= '<img src="'.UPLOAD_URL . 'book' . DS . '98x150-' . $dataForm['picture'] .'">';
    }else{
        $picture	= '<img src="'.UPLOAD_URL . 'category' . DS . '60x90-default.jpg' .'">';
    }
    $inputPictureHidden	= Helper::cmsInput('hidden', 'form[picture_hidden]', 'picture_hidden', $dataForm['picture'], 'inputbox', 40);
}
// Row
$rowName        = Helper::cmsRowForm('Name', $inputName, true);
$rowOrdering    = Helper::cmsRowForm('Ordering', $inputOrdering);
$rowStatus        = Helper::cmsRowForm('Status', $selectStatus);
$rowDescription    = Helper::cmsRowForm('Description', $inputDescription);
$rowPrice        = Helper::cmsRowForm('Price', $inputPrice, true);
$rowSaleOff        = Helper::cmsRowForm('Sale Off', $inputSaleOff, true);
$rowSpecial		= Helper::cmsRowForm('Special', $slbSpecial);
$rowCategory    = Helper::cmsRowForm('Category', $selectCategory);
$rowPicture		= Helper::cmsRowForm('Picture', $inputPicture . ($picture ?? '') . ($inputPictureHidden ?? ''));

// MESSAGE
$message    = Session::get('message');
Session::delete('message');
$strMessage = Helper::cmsMessage($message);


?>
<div id="system-message-container"><?= $strMessage ?? '' ?><?= $this->errors ?? '' ?></div>
<div id="element-box">
    <div class="m">
        <form action="#" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
            <!-- FORM LEFT -->
            <div class="width-100 fltlft">
                <fieldset class="adminform">
                    <legend>Details</legend>
                    <ul class="adminformlist">
                        <?php echo $rowName .$rowPrice . $rowSaleOff .$rowPicture . $rowStatus .$rowSpecial . $rowCategory . $rowOrdering . $rowDescription . $rowID; ?>
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