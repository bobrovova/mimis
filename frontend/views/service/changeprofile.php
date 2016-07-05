<?php

?>
<section class="block wrap settingsProfile">
    <div class="title">
        <span class="hr"></span>
        <span class="text">Настройки аккаунта</span>
    </div>
    <div class="content clear ordering">
        <div class="col-2 personBlock">
            <div class="titleBlock">Контактные данные</div>
            <div class="form">
                <div class="row">
                    <div class="labelForm">Имя</div>
                    <div class="input"><input type="text" name="first_name" value="<?php echo !empty(Yii::$app->user->identity->getAttribute("first_name"))
                            ? Yii::$app->user->identity->getAttribute("first_name")
                            : '' ?>"></div>
                </div>
                <div class="row">
                    <div class="labelForm">Фамилия</div>
                    <div class="input"><input type="text" name="last_name" value="<?php echo !empty(Yii::$app->user->identity->getAttribute("last_name"))
                            ? Yii::$app->user->identity->getAttribute("last_name")
                            : '' ?>"></div>
                </div>
                <div class="row">
                    <div class="labelForm">Отчество</div>
                    <div class="input"><input type="text" name="second_name" value="<?php echo !empty(Yii::$app->user->identity->getAttribute("second_name"))
                            ? Yii::$app->user->identity->getAttribute("second_name")
                            : '' ?>"></div>
                </div>
                <div class="row">
                    <div class="labelForm">Телефон</div>
                    <div class="input"><input type="text" name="mobile_phone" value="<?php echo !empty(Yii::$app->user->identity->getAttribute("mobile_phone"))
                            ? Yii::$app->user->identity->getAttribute("mobile_phone")
                            : '' ?>"></div>
                </div>
            </div>
        </div>
        <div class="col-2">
            <div class="titleBlock">Адрес доставки</div>
            <div class="clear">
                <div class="form">
                    <div class="row">
                        <div class="labelForm">Город</div>
                        <div class="input"><input type="text" name="city" value="<?php echo !empty(Yii::$app->user->identity->delivery->getAttribute("city"))
                                ? Yii::$app->user->identity->delivery->getAttribute("city")
                                : '' ?>"></div>
                    </div>
                    <div class="row">
                        <div class="labelForm">Улица</div>
                        <div class="input"><input type="text" name="street" value="<?php echo !empty(Yii::$app->user->identity->delivery->getAttribute("street"))
                                ? Yii::$app->user->identity->delivery->getAttribute("street")
                                : '' ?>"></div>
                    </div>
                    <div class="row">
                        <div class="labelForm">Индекс</div>
                        <div class="input"><input type="text" name="zipcode" value="<?php echo !empty(Yii::$app->user->identity->delivery->getAttribute("zipcode"))
                                ? Yii::$app->user->identity->delivery->getAttribute("zipcode")
                                : '' ?>"></div>
                    </div>
                </div>
                <div class="col-3 form details">
                    <div class="clear">
                        <div class="row">
                            <div class="labelForm">Дом</div>
                            <div class="input"><input type="text" name="house" value="<?php echo !empty(Yii::$app->user->identity->delivery->getAttribute("house"))
                                    ? Yii::$app->user->identity->delivery->getAttribute("house")
                                    : '' ?>"></div>
                        </div>
                        <div class="row">
                            <div class="labelForm">Строение</div>
                            <div class="input"><input type="text" name="stroenie" value="<?php echo !empty(Yii::$app->user->identity->delivery->getAttribute("stroenie"))
                                    ? Yii::$app->user->identity->delivery->getAttribute("stroenie")
                                    : '' ?>"></div>
                        </div>
                        <div class="row">
                            <div class="labelForm">Корпус</div>
                            <div class="input"><input type="text" name="korpus" value="<?php echo !empty(Yii::$app->user->identity->delivery->getAttribute("korpus"))
                                    ? Yii::$app->user->identity->delivery->getAttribute("korpus")
                                    : '' ?>"></div>
                        </div>
                    </div>
                    <div class="clear">
                        <div class="row">
                            <div class="labelForm">Подъезд</div>
                            <div class="input"><input type="text" name="podyezd" value="<?php echo !empty(Yii::$app->user->identity->delivery->getAttribute("podyezd"))
                                    ? Yii::$app->user->identity->delivery->getAttribute("podyezd")
                                    : '' ?>"></div>
                        </div>
                        <div class="row">
                            <div class="labelForm">Этаж</div>
                            <div class="input"><input type="text" name="floor" value="<?php echo !empty(Yii::$app->user->identity->delivery->getAttribute("floor"))
                                    ? Yii::$app->user->identity->delivery->getAttribute("floor")
                                    : '' ?>"></div>
                        </div>
                        <div class="row">
                            <div class="labelForm">Квартира</div>
                            <div class="input"><input type="text" name="apartment" value="<?php echo !empty(Yii::$app->user->identity->delivery->getAttribute("apartment"))
                                    ? Yii::$app->user->identity->delivery->getAttribute("apartment")
                                    : '' ?>"></div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
            <div class="saveBtn">
                <a class="btnService">Сохранить</a>
            </div>
        </div>
    </div>
</section>
<?php
    $this->registerJs("changeProfileForm();", \yii\web\View::POS_END);
?>