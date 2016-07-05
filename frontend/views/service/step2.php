<?php
use yii\helpers\Url;
?>
<section class="block wrap ordering">
    <div class="title">
        <span class="hr"></span>
        <span class="text">Оформить заказ</span>
    </div>
    <div class="progressBlock clear">
        <div class="arrow">Доставка</div>
        <div class="arrow actives">Оплата</div>
        <div class="arrow">Подтверждение</div>
    </div>
    <div class="clear">
        <div class="paymentBlock">
            <form method="post" action="<?=Url::to(['service/step3'])?>">
            <div class="titleBlock">Выберите способ оплаты</div>
            <div class="select">
                <div>
                    <input id="r1" type="radio" name="payment[type]" value="1" checked hidden />
                    <label for="r1">
                        <div class="big">Наличный расчет</div>
                        <div class="small">Вы можете оплатить заказ нашему курьеру наличными при получении</div>
                    </label>
                </div>
                <div>
                    <input id="r2" type="radio" name="payment[type]" value="2" hidden />
                    <label for="r2">
                        <div class="big">Онлайн-оплата банковской картой</div>
                        <div class="small">К оплате принимаются карты Visa, MasterCard</div>
                    </label>
                </div>
            </div>
            <div>
                <input type="hidden" name="step1" value="<?=htmlspecialchars(json_encode($order_info))?>" />
                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                <input type="submit" class="btnService" value="Далее">
            </div>
            </form>
        </div>
    </div>
</section>