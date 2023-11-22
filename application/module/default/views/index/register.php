<?php

$dataForm = $this->arrParam['form'] ?? '';

$inputSubmit    = Helper::cmsInput('submit', 'form[submit]', 'submit', 'register', 'register');
$inputToken        = Helper::cmsInput('hidden', 'form[token]', 'token', time());

$rowUserName    = Helper::cmsRow('Username', Helper::cmsInput('text', 'form[username]', 'username', $dataForm['username'] ?? '', 'contact_input'));
$rowFullName    = Helper::cmsRow('Full Name', Helper::cmsInput('text', 'form[fullname]', 'fullname', $dataForm['fullname'] ?? '', 'contact_input'));
$rowPassword    = Helper::cmsRow('Password', Helper::cmsInput('text', 'form[password]', 'password', $dataForm['password'] ?? '', 'contact_input'));
$rowEmail        = Helper::cmsRow('Email', Helper::cmsInput('text', 'form[email]', 'email', $dataForm['email'] ?? '', 'contact_input'));
$rowSubmit        = Helper::cmsRow('Submit', $inputToken . $inputSubmit, true);


$linkAction = URL::createLink('default', 'user', 'register');
?>

<div class="title"><span class="title_icon"><img src="<?= $imageURL ?>/bullet1.gif" alt="" title="" /></span>Đăng ký thành viên</div>

<div class="feat_prod_box_details">

    <div class="contact_form">
        <div class="form_subtitle">create new account</div>
        <?= $this->errors ?? ''?>
        <form name="adminForm" action="<?= $linkAction ?>" method="post">
            <?= $rowUserName . $rowFullName . $rowEmail . $rowPassword . $rowSubmit ?>
        </form>
    </div>

</div>






<div class="clear"></div>