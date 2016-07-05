<?php
use yii\helpers\Url;
?>
<section class="block wrap ordering">
    <div class="title">
        <span class="hr"></span>
        <span class="text">Оформить заказ</span>
    </div>
    <div class="progressBlock clear">
        <div class="arrow actives">Доставка</div>
        <div class="arrow">Оплата</div>
        <div class="arrow">Подтверждение</div>
    </div>
    <div class="clear">
        <form method="post" action="<?=Url::to(['service/step2']);?>">
        <div class="deliveryBlock">
            <div class="titleBlock">Выберите способ доставки</div>
            <div class="select">
                <div>
                    <input id="r1" type="radio" name="shipping[type_shipping]" value="1" checked hidden />
                    <label for="r1">Самовывоз</label>
                </div>
                <div>
                    <input id="r2" type="radio" name="shipping[type_shipping]" value="2"  hidden />
                    <label for="r2">Бесплатная доставка по Новосибирску</label>
                </div>
                <div>
                    <input id="r3" type="radio" name="shipping[type_shipping]" value="3"  hidden />
                    <label for="r3">Обсудить с менеджером другие способы доставки</label>
                </div>
                <div>
                    <input id="r4" type="radio" name="shipping[type_shipping]" value="4"  hidden />
                    <label for="r4">Доставка Почтой России</label>
                </div>
            </div>
        </div>
        <div class="personBlock">
            <div class="titleBlock">Контактное лицо</div>
            <div class="form">
                <div class="row">
                    <div class="labelForm">Фамилия</div>
                    <div class="input"><input type="text" name="client[last_name]" value="<?=!empty($user->last_name) ? $user->last_name : ''?>"></div>
                </div>
                <div class="row">
                    <div class="labelForm">Имя</div>
                    <div class="input"><input type="text" name="client[first_name]" value="<?=!empty($user->first_name) ? $user->first_name : ''?>"></div>
                </div>
                <div class="row">
                    <div class="labelForm">Отчество</div>
                    <div class="input"><input type="text" name="client[second_name]" value="<?=!empty($user->second_name) ? $user->second_name : ''?>"></div>
                </div>
                <div class="row">
                    <div class="labelForm">Телефон</div>
                    <div class="input"><input type="text" name="client[mobile_phone]" value="<?=!empty($user->mobile_phone) ? $user->mobile_phone : ''?>"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="separate"></div>
    <div class="address">
        <div class="titleBlock">Адрес доставки</div>
        <div class="clear">
            <div class="col-3 form">
                <div class="row">
                    <div class="labelForm">Город</div>
                    <div class="input"><input type="text" name="shipping[city]" value="<?=!empty($shipping->city) ? $shipping->city : ''?>"></div>
                </div>
                <div class="row">
                    <div class="labelForm">Улица</div>
                    <div class="input"><input type="text" name="shipping[street]" value="<?=!empty($shipping->street) ? $shipping->street : ''?>"></div>
                </div>
                <div class="row">
                    <div class="labelForm">Индекс</div>
                    <div class="input"><input type="text" name="shipping[zipcode]" value="<?=!empty($shipping->zipcode) ? $shipping->zipcode : ''?>"></div>
                </div>
            </div>
            <div class="col-3 form details">
                <div class="clear">
                    <div class="row">
                        <div class="labelForm">Дом</div>
                        <div class="input"><input type="text" name="shipping[house]" value="<?=!empty($shipping->house) ? $shipping->house : ''?>"></div>
                    </div>
                    <div class="row">
                        <div class="labelForm">Стр.</div>
                        <div class="input"><input type="text" name="shipping[stroenie]" value="<?=!empty($shipping->stroenie) ? $shipping->stroenie : ''?>"></div>
                    </div>
                    <div class="row">
                        <div class="labelForm">Корп.</div>
                        <div class="input"><input type="text" name="shipping[korpus]" value="<?=!empty($shipping->korpus) ? $shipping->korpus : ''?>"></div>
                    </div>
                </div>
                <div class="clear">
                    <div class="row">
                        <div class="labelForm">Подъезд</div>
                        <div class="input"><input type="text" name="shipping[podyezd]" value="<?=!empty($shipping->podyezd) ? $shipping->podyezd : ''?>"></div>
                    </div>
                    <div class="row">
                        <div class="labelForm">Этаж</div>
                        <div class="input"><input type="text" name="shipping[floor]" value="<?=!empty($shipping->floor) ? $shipping->floor : ''?>"></div>
                    </div>
                    <div class="row">
                        <div class="labelForm">Кв.</div>
                        <div class="input"><input type="text" name="shipping[apartment]" value="<?=!empty($shipping->apartment) ? $shipping->apartment : ''?>"></div>
                    </div>
                </div>
            </div>
            <div class="col-3">
            </div>
        </div>
        <div>
            <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
            <input type="submit" class="btnService" value="Далее">
        </div>
        </form>
    </div>
</section>