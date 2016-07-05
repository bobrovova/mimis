<?php

use yii\helpers\Url;

switch($order->shipping->type_shipping){
    case '1': $type_shipping = 'Самовывоз'; $cost = 0; break;
    case '2': $type_shipping = 'Бесплатная доставка по Новосибирску'; $cost = 0; break;
    case '3': $type_shipping = 'Обсудить с менеджером другие способы доставки'; $cost = 0; break;
    case '4': $type_shipping = 'Почта России'; $cost = 300; break;
}

switch($order->payment['type']){
    case '1': $textFinalButton = 'Подтвердить заказ';
    case '2': $textFinalButton = 'Перейти к оплате';
}
?>
<section class="block wrap">
    <div class="title">
        <span class="hr"></span>
        <span class="text">Оформить заказ</span>
    </div>
    <div class="progressBlock clear">
        <div class="arrow">Доставка</div>
        <div class="arrow">Оплата</div>
        <div class="arrow actives">Подтверждение</div>
    </div>
    <div class="finishBlock clear">
        <form method="post" action="<?Url::to('service/neworder')?>">
        <div class="finishAddress">
            <div class="titleBlock">Доставка <a href="<?=Url::to(['service/step1'])?>" class="btnChange">Изменить</a></div>
            <div class="content">
                <div class="deliveryItem">
                    <div class="labelItem">Тип доставки</div>
                    <div class="valueItem"><?=$type_shipping?></div>
                </div>
                <?php if(!empty($order->shipping->city)): ?>
                <div class="deliveryItem">
                    <div class="labelItem">Город</div>
                    <div class="valueItem"><?=$order->shipping->city?></div>
                </div>
                <?php endif; ?>
                <?php if(!empty($order->shipping->street)): ?>
                <div class="deliveryItem">
                    <div class="labelItem">Улица</div>
                    <div class="valueItem"><?=$order->shipping->street?></div>
                </div>
                <?php endif; ?>
                <?php if(!empty($order->shipping->zipcode)): ?>
                <div class="deliveryItem">
                    <div class="labelItem">Индекс</div>
                    <div class="valueItem"><?=$order->shipping->zipcode?></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="total">
            <div class="titleBlock">Ваш товар</div>
            <div class="stuffInCart"><a href="<?=Url::to(['catalog/cart'])?>"><?=$cart['Count']?> в корзине</a></div>
            <div class="totalMoney">
                <div class="forItems clear">
                    <div class="labelItem">Сумма</div>
                    <div class="valueItem"><?=$cart['Sum']?> р.</div>
                </div>
                <div class="forDelivery clear">
                    <div class="labelItem">Доставка</div>
                    <div class="valueItem"><?=$cost?> р.</div>
                </div>
            </div>
            <div class="totalMoneyAll clear">
                <div class="labelItem">Всего к оплате</div>
                <div class="valueItem"><?=$cart['Sum'] + $cost?> р.</div>
            </div>
            <div class="buttons">
                <input type="hidden" name="order" value="<?=htmlspecialchars(json_encode($order))?>" />
                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                <input type="submit" class="btnService" value="<?=$textFinalButton?>">
            </div>
        </div>
        </form>
    </div>
</section>