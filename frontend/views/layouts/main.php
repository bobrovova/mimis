<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Cart;
use frontend\controllers\CatalogController;
use frontend\assets\AppAsset;

AppAsset::register($this);

if(!empty($_COOKIE['cart'])){
    $cart = json_decode($_COOKIE['cart']);
    $cart_sum = $cart->Sum;
    $cart_items = $cart->Count;
    if( $cart->Sum == null){
        $cart_sum = 0;
    }
} else {
    if(Yii::$app->user->isGuest){
        $cart = Cart::getInfoBySession();
    } else {
        $cart = Cart::getInfoByUser();
    }
    if(empty($cart)){
        $cart_sum = 0;
        $cart_items = '0 товаров';
        $cart['Count'] = 0;
        $cart['Sum'] = 0;
    } else {
        $cart_sum = $cart['Sum'];
        $cart_items = $cart['Count'];
    }

    $cart['Count'] = $cart['Count'] . " " .CatalogController::num2word($cart['Count'], ['товар', 'товара', 'товаров']);
    setcookie('cart', json_encode($cart), time()+60*60*24*30);
}

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php $this->registerJsFile("js/jquery.min.js", ['position' => \yii\web\View::POS_HEAD]); ?>
    <?php $this->registerJsFile("js/local.js", ['position' => \yii\web\View::POS_HEAD]); ?>
    <?php $this->registerJsFile("//code.jquery.com/jquery-migrate-1.2.1.min.js", ['position' => \yii\web\View::POS_HEAD]); ?>
</head>
<body>
<!--Header-->
<header class="header">
    <div class="header_wrap">
        <div class="b-phone">
            <span class="phone">+7 (383) 284-90-60</span>
        </div>
        <a href="<?=Url::to(['site/index'])?>" class="b-logo">
            <img src="images/logo.png" alt="Логотип" class="b-logo_img">
            <span class="b-logo_title"><span class="red">Miss</span>&Mister</span>
        </a>
        <div class="b-user">
            <a href="<?=Url::to(['catalog/cart'])?>" class="b-user_basket"><span class="price"><span id="cart_sum"><?=$cart_sum?></span> <img src="images/rub.png" alt=""></span>
                - <span id="cart_items"><?=$cart_items?></span></a>
            <!--<a href="#" class="b-user_entrance">Войти на сайт</a>-->
        </div>
    </div>
    <nav class="header_nav">
        <div class="navi_wrap">
            <ul class="navi">
                <li class="navi_item"><a href="<?=Url::to(['catalog/index'])?>" class="navi_link">Каталог</a></li>
                <!--<li class="navi_item "><a href="#" class="navi_link navi_link_active">Новинки</a></li>
                <li class="navi_item"><a href="#" class="navi_link">Скидки и акции</a></li>
                <li class="navi_item"><a href="#" class="navi_link">Тренды</a></li>
                <li class="navi_item"><a href="#" class="navi_link">О компании</a></li>
                <li class="navi_item"><a href="#" class="navi_link">Доставка и оплата</a></li>
                -->
            </ul>
            <!--<a href="#" class="navi_search" title="Поиск">
                <img src="images/search-ico.png" alt="Иконка поиска">
            </a>-->
        </div>
    </nav>
</header>
<!--Header-->
<?php $this->beginBody() ?>
<main>
    <?= $content ?>
</main>
<!--Footer-->
<footer class="footer">
    <div class="footer_wrap">
        <div class="footer_list">
            <h5 class="footer_h5">ТЕЛЕФОНЫ</h5>
            <ul>
                <li class="footer_item"><a href="#" class="footer_link">+7 (383) 284-90-60</a></li>
                <li class="footer_item"><a href="#" class="footer_link">+7 913 924 0100</a></li>
                <li class="footer_item"><a href="#" class="footer_link">+7 923 224 8401</a></li>
            </ul>
        </div>
        <div class="footer_list">
            <h5 class="footer_h5">В НАЛИЧИИ</h5>
            <ul>
                <li class="footer_item"><a href="#" class="footer_link">Мужское</a></li>
                <li class="footer_item"><a href="#" class="footer_link">Женское</a></li>
                <li class="footer_item"><a href="#" class="footer_link">Смотреть все</a></li>
            </ul>
        </div>
        <div class="footer_list">
            <h5 class="footer_h5">Наш сервис</h5>
            <ul>
                <li class="footer_item">
                    <div class="footer_link">Прием заказов по SMS</div>
                </li>
                <li class="footer_item">
                    <div class="footer_link">Пригласи подругу и получи бонус</div>
                </li>
            </ul>
        </div>
        <div class="footer_social">
            <h5 class="footer_h5">Мы в соц. сетях:</h5>
            <div class="footer_social_wrap">
                <a href="#" class="footer_social_link vk"></a>
                <a href="#" class="footer_social_link inst"></a>
                <a href="#" class="footer_social_link tw"></a>
            </div>
        </div>
    </div>
    <div class="footer_bottom"></div>
</footer><!--Footer-->


<!--Section Script-->
<script type="text/javascript" src="js/tabs.js"></script>
<script type="text/javascript" src="js/main.js"></script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
