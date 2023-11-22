<?php
$controller = $this->arrParam['controller'];


$linkNew = URL::createLink('admin', $controller, 'form');
$btnNew = Helper::cmsButton('New', $linkNew, 'toolbar-popup-new', 'icon-32-new');

$linkPublish = URL::createLink('admin', $controller, 'status', array('type' => 1));
$btnPublish = Helper::cmsButton('Publish', $linkPublish, 'toolbar-publish', 'icon-32-publish', 'submit');

$linkUnpublish = URL::createLink('admin', $controller, 'status', array('type' => 0));
$btnUnpublish = Helper::cmsButton('Unpublish', $linkUnpublish, 'toolbar-unpublish', 'icon-32-unpublish', 'submit');

$linkTrash = URL::createLink('admin', $controller, 'trash');
$btnTrash = Helper::cmsButton('Trash', $linkTrash, 'toolbar-trash', 'icon-32-trash', 'submit');

$linkOrdering = URL::createLink('admin', $controller, 'ordering');
$btnOrdering = Helper::cmsButton('Ordering', $linkOrdering, 'toolbar-checkin', 'icon-32-checkin', 'submit');


$linkSave = URL::createLink('admin', $controller, 'form', array('type' => 'save'));
$btnSave = Helper::cmsButton('Save', $linkSave, 'toolbar-apply', 'icon-32-apply', 'submit');

$linkSaveNew = URL::createLink('admin', $controller, 'form', array('type' => 'save-new'));
$btnSaveNew = Helper::cmsButton('Save & New', $linkSaveNew, 'toolbar-save-new', 'icon-32-save-new', 'submit');

$linkSaveClose = URL::createLink('admin', $controller, 'form', array('type' => 'save-close'));
$btnSaveClose = Helper::cmsButton('Save & Close', $linkSaveClose, 'toolbar-save', 'icon-32-save', 'submit');

$linkCancel = URL::createLink('admin', $controller, 'index');
$btnCancel = Helper::cmsButton('Cancel', $linkCancel, 'toolbar-cancel', 'icon-32-cancel');



switch ($this->arrParams['action']) {
    case 'index':
        $strButton = $btnNew . $btnPublish . $btnUnpublish . $btnOrdering . $btnTrash;
        break;

    case 'form':
        $strButton = $btnSave . $btnSaveNew . $btnSaveClose . $btnCancel;
        break;
    case 'profile':
        $strButton    = $btnSave . $btnSaveClose  . $btnCancel;
        break;
}

?>
<div id="toolbar-box">
    <div class="m">
        <!-- TOOLBAR -->
        <div class="toolbar-list" id="toolbar">

            <ul>
                <?= $strButton ?>
            </ul>
            <div class="clr"></div>
        </div>
        <!-- TITLE -->
        <div class="pagetitle icon-48-module">
            <h2><?= $this->_title ?></h2>
        </div>
    </div>
</div>