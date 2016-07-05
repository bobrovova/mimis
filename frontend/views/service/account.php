<?php

use yii\helpers\Url;

?>
<section class="block wrap">
    <div class="title">
        <span class="hr"></span>
        <span class="text">Аккаунт</span>
    </div>
    <div class="accountBlock clear">
        <div class="accountInfo">
            <div class="finishAddress">
                <div class="titleBlock">Контактное лицо</div>
                <div class="content">
                    <div class="deliveryItem">
                        <div class="labelItem">Имя</div>
                        <div class="valueItem"><?php echo !empty(Yii::$app->user->identity->getAttribute("first_name"))
                                ? Yii::$app->user->identity->getAttribute("first_name")
                                : '-' ?></div>
                    </div>
                    <div class="deliveryItem">
                        <div class="labelItem">Фамилия</div>
                        <div class="valueItem"><?php echo !empty(Yii::$app->user->identity->getAttribute("last_name"))
                                ? Yii::$app->user->identity->getAttribute("last_name")
                                : '-' ?></div>
                    </div>
                    <div class="deliveryItem">
                        <div class="labelItem">Отчество</div>
                        <div class="valueItem"><?php echo !empty(Yii::$app->user->identity->getAttribute("second_name"))
                                ? Yii::$app->user->identity->getAttribute("second_name")
                                : '-' ?></div>
                    </div>
                    <div class="deliveryItem">
                        <div class="labelItem">Телефон</div>
                        <div class="valueItem"><?php echo !empty(Yii::$app->user->identity->getAttribute("mobile_phone"))
                                ? Yii::$app->user->identity->getAttribute("mobile_phone")
                                : '-' ?></div>
                    </div>
                </div>
            </div>
            <div class="finishAddress">
                <div class="titleBlock">Адрес доставки</div>
                <div class="content">
                    <div class="deliveryItem">
                        <div class="labelItem">Город</div>
                        <div class="valueItem"><?php echo !empty(Yii::$app->user->identity->delivery->getAttribute("city"))
                                ? Yii::$app->user->identity->delivery->getAttribute("city")
                                : '-' ?></div>
                    </div>
                    <div class="deliveryItem">
                        <div class="labelItem">Улица</div>
                        <div class="valueItem"><?php echo !empty(Yii::$app->user->identity->delivery->getAttribute("street"))
                                ? Yii::$app->user->identity->delivery->getAttribute("street")
                                : '-' ?></div>
                    </div>
                    <div class="deliveryItem">
                        <div class="labelItem">Индекс</div>
                        <div class="valueItem"><?php echo !empty(Yii::$app->user->identity->delivery->getAttribute("zipcode"))
                                ? Yii::$app->user->identity->delivery->getAttribute("zipcode")
                                : '-' ?></div>
                    </div>
                </div>
            </div>
            <div style="margin-top: 15px;">
                <a href="<?php echo Url::to(["service/changeprofile"]) ?>" class="btnChange">Изменить данные</a>
            </div>
        </div>
        <div class="orderTable">
            <div class="titleBlock">
                Последние заказы
            </div>
            <div class="content">
                <div class="itemTable">Заказ 00000125-53 от 10.02.2015 на сумму 3624 рубля. Статус: обрабатывается</div>
                <div class="itemTable">Заказ 00000125-52 от 10.02.2015 на сумму 1025 рубля. Статус: выполнен</div>
                <div class="itemTable">Заказ 00000125-51 от 10.02.2015 на сумму 7562 рубля. Статус: доставляется</div>
                <div><a href="#" class="simpleLink">Все заказы</a></div>
            </div>
        </div>
    </div>
</section>