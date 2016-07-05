<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */


$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
use yii\helpers\Url;

?>
<section class="block wrap loginBlock">
    <div class="title">
        <span class="hr"></span>
        <span class="text">Вход / Регистрация</span>
    </div>
    <div class="content clear">
        <div class="col-2">
            <?php
                if(!empty($_GET['error_login'])) :
            ?>
            <div class="error notify">
                <div class="title">Ошибка входа</div>
                <div class="subtitle">Неправильный логин и\или пароль</div>
            </div>
            <?php
                endif;
            ?>
            <form class="form" method="post" action="index.php?r=site/login">
                <div class="row">
                    <div class="labelForm">E-mail</div>
                    <div class="input"><input type="text" name="LoginForm[email]"></div>
                </div>
                <div class="row">
                    <div class="labelForm">Пароль</div>
                    <div class="input"><input type="password" name="LoginForm[password]"></div>
                </div>
                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                <div class="clear myContainer">
                    <div id="containerSubmit">
                        <input type="submit" class="btn" value="Войти">
                    </div>
                    <div id="containerResetPass">
                        <a href="<?php echo Url::to(["site/requestpasswordreset"]); ?>" class="simpleLink">Забыли пароль?</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-2">
            <?php
                if(!empty($_GET['error_join'])) :
                    $error_code = "Неизвестная ошибка";
                    if(!empty($_GET['ec'])){
                        switch($_GET['ec']){
                            case 1: $error_code = "Пароли не совпадают"; break;
                            case 2: $error_code = "Введите правильный  E-mail"; break;
                        }
                    }
            ?>
                <div class="error notify">
                    <div class="title">Ошибка регистрации</div>
                    <div class="subtitle"><?php echo $error_code; ?></div>
                </div>
            <?php
                endif;
            ?>
            <form class="form" method="post" action="index.php?r=site/signup">
                <div class="row">
                    <div class="labelForm">E-mail</div>
                    <div class="input"><input type="text" name="email"></div>
                </div>
                <div class="row">
                    <div class="labelForm">Пароль</div>
                    <div class="input"><input type="password" name="pass1"></div>
                </div>
                <div class="row">
                    <div class="labelForm">Еще раз пароль</div>
                    <div class="input"><input type="password" name="pass2"></div>
                </div>
                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                <input type="submit" class="btn reg" value="Зарегестрироваться">
            </form>
        </div>
    </div>
</section>