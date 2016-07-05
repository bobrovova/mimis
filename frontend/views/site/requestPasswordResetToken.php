<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Url;

?>
<section class="wrap block loginBlock">
    <div class="title">
        <span class="hr"></span>
        <span class="text">Восстановление пароля</span>
    </div>
    <div class="content clear">
        <div class="col-2">
            <?php
            if(!empty($_GET['error_send'])) :
                if($_GET['error_send'] == 1){
                    $error = "Ошибка отправки письма. Попробуйте позже";
                } else if($_GET['error_send'] == 2){

                }
                ?>
                <div class="error notify">
                    <div class="title">Ошибка</div>
                    <div class="subtitle"><? echo $error; ?></div>
                </div>
                <?php
            endif;
            if(!empty($_GET['success'])) :
            ?>
                <div class="success notify">
                    <div class="title">Письмо отправлено</div>
                    <div class="subtitle">Письмо для восстановления пароля уже отправлено на указанный E-mail. Если вы не обнаружите письма в папке "Входящие", проверьте папку "Спам".</div>
                </div>
            <?php
            endif;
            ?>
            <form class="form" method="POST" action="<? echo Url::to(["site/requestpasswordreset"]);?>">
                <div class="row">
                    <div class="labelForm">E-mail</div>
                    <div class="input"><input type="text" name=PasswordResetRequestForm[email]"></div>
                </div>
                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                <input type="submit" class="btn" value="Восстановить пароль">
            </form>
        </div>
        <div class="col-2">
            <div class="labelMain">
                Введите E-mail указанный при регистрации. На этот E-mail вам придет письмо, в котором будет ссылка на страницу ввода нового пароля.
            </div>
        </div>
    </div>
</section>