<?php
    $cart = Session::get('cart');

    $totalItems = 0;
    $totalPrices = 0;

    if(!empty($cart)){
        $totalItems = array_sum($cart['quantity']);
        $totalPrices = array_sum($cart['price']);
    }

    $linkCart = URL::createLink('default','user','cart', null, 'cart.html');
?>

<div class="cart">
    <div class="title"><span class="title_icon"><img src="<?php echo $imageURL; ?>/cart.gif" alt="" title="" /></span>My cart</div>
    <div class="home_cart_content">
        <?= $totalItems ?> x items | <span class="red">TOTAL: <?= number_format($totalPrices) ?>$</span>
    </div>
    <a href="<?= $linkCart ?>" class="view_cart">view cart</a>

</div>