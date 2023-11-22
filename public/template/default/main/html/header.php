<?php $imageURL = $this->_dirImg;

$userObj        = Session::get('user');

$linkHome        = URL::createLink('default', 'user', 'index', null, 'index.html');
$linkCat        = URL::createLink('default', 'category', 'index', null, 'category.html');
$linkMyAccount    = URL::createLink('default', 'user', 'index', null, 'my-account.html');
$linkRegister    = URL::createLink('default', 'index', 'register', null, 'register.html');
$linkLogin        = URL::createLink('default', 'index', 'login', null, 'login.html');


$arrayMenu        = array();
$arrayMenu[]    = array('class' => 'index-index',         'link' => $linkHome,     'name' => 'Home');
$arrayMenu[]    = array('class' => 'category-index',     'link' => $linkCat,     'name' => 'Categories');
$xhtml = '';

if (isset($userObj) && $userObj['login'] == true) {
    $arrayMenu[] = array('class' => 'user-index user-cart user-history',     'link' => $linkMyAccount,     'name' => 'My account');
    $arrayMenu[] = array('class' => 'index-logout', 'link' => URL::createLink('default', 'index', 'logout'), 'name' => 'Logout');
} else {
    $arrayMenu[] = array('class' => 'index-register',     'link' => $linkRegister,     'name' => 'Register');
    $arrayMenu[] = array('class' => 'index-login',         'link' => $linkLogin,     'name' => 'Login');
}

if (isset($userObj) && $userObj['group_acp'] == true) {
    $arrayMenu[] = array('class' => 'index-group',         'link' => URL::createLink('admin', 'index', 'index'),     'name' => 'Admin Control Panel');
}
foreach ($arrayMenu as $key => $value) {
    $xhtml .= '<li class="' . $value['class'] . '"><a href="' . $value['link'] . '">' . $value['name'] . '</a></li>';
}

$controller = !empty($this->arrParam['controller']) ? $this->arrParam['controller'] : 'index';
$action     = !empty($this->arrParam['action']) ? $this->arrParam['action'] : 'index';

?>

<div class="header">
    <div class="logo"><a href="index.html"><img src="<?= $imageURL ?>/logo.gif" alt="" title="" border="0" /></a></div>
    <div id="menu">
        <ul>
            <?= $xhtml ?>
        </ul>
    </div>


</div>

<script type="text/javascript">
    $(document).ready(function() {
        var controller = '<?php echo $controller; ?>';
        var action = '<?php echo $action; ?>';
        var classSelect = controller + '-' + action;
        $('#menu ul li.' + classSelect).addClass('selected');
    });
</script>