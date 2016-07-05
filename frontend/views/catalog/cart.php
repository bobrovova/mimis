<?php

use yii\helpers\Url;

?>
<section class="block wrap cart">
    <div class="cartItem">
        <div class="title">Наименование</div>
        <div class="extra">Цвет</div>
        <div class="param">
            Размер
        </div>
        <div class="count">
            Количество
        </div>
        <div class="price">
            Цена
        </div>
        <div class="price">
            Всего
        </div>
        <div class="actions">

        </div>
    </div>
    <?php
        $sum = 0;
        foreach ($items as $item) :
        $sum += $item['info']->price * $item['cart']->count;
    ?>
        <div class="cartItem">
            <div class="title"><?=$item['info']->name?></div>
            <div class="extra">
                <?php if (!empty($item['info']->color)) : ?>
                    (<?=$item['info']->color?>)
                <?php else: ?>
                    -
                <?php endif; ?>
            </div>
            <div class="param">
                <?php if(!empty($item['param'])) : ?>
                    <?=$item['param']->value?>
                <?php else: ?>
                    -
                <?php endif; ?>
            </div>
            <div class="count">
                <input type="text" class="inputCount" data-idcart="<?=$item['idcart']?>" value="<?=$item['cart']->count?>">
            </div>
            <div class="price">
                <?=$item['info']->price?> р.
            </div>
            <div class="price allprice">
                <?=$item['info']->price * $item['cart']->count?> р.
            </div>
            <div class="actions">
                <a href="#" class="deleteActionCart" data-idcart="<?=$item['idcart']?>">Удалить</a>
            </div>
        </div>
    <?php
        endforeach;
    ?>
    <div class="total">Всего: <span><?=$sum?></span> р.</div>
    <div class="buttons">
        <a href="#" class="tabs_btn checkOrder">Оформить заказ</a>
    </div>
</section>
<div class="modal modal_order_data">
    <span class="close">X</span>
    <div class="introText">
        Пожалуйста, заполните следующую информацию, чтобы мы могли связаться с вами для предоставления дальнейшей информации по вашему заказу:
    </div>
    <div class="inputField">
        <div>
            Ваше имя:
        </div>
        <input type="text" name="nameClient">
    </div>
    <div class="inputField">
        <div>
            Ваш телефон:
        </div>
        <input type="text" name="phoneClient">
    </div>
    <div class="buttons">
        <a href="#" class="tabs_btn finalOrder">Все, готово!</a>
    </div>
</div>
    <div class="modal modal_order_thanks">
        <span class="close">X</span>
        <div class="introText">
            <span>Спасибо за ваш заказ!</span><br>
            Скоро Вам позвонит наш менеджер и уточнит все детали
        </div>
    </div>
<?php
    $this->registerJs("manageCart();", \yii\web\View::POS_END);
?>