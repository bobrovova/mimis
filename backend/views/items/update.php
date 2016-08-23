<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Items */

$this->title = 'Update Items: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="items-update">
        <div class="form-group">
            <label for="exampleInputEmail1">Наименование</label>
            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Наименование" value="<?=$model->name?>">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Оптовая цена</label>
            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Оптовая цена" value="<?=$model->price_opt?>">
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Параметры</h3>
            </div>
            <div class="panel-body">
                <?php if (!empty($model->color)): ?>
                <ul class="nav nav-pills nav-stacked col-md-2">
                    <?php
                        foreach ($colors as $color) {
                            $activeClass = '';
                            if($color->color == $model->color){
                                $activeClass = ' class="active"';
                            }
                            echo "<li><a".$activeClass." href='".Url::to(['items/update', 'id' => $color->id])."'>".$color->color."</a></li>";
                        }
                    ?>
                </ul>
                <?php endif; ?>
                <div class="panel panel-default col-md-10">
                    <div class="panel-body">
                        <div class="images">
                            <div class="mainSlider">
                                <?php
                                foreach($model['images'] as $image){
                                    ?>
                                    <div class="img"
                                         data-image-id="<?=$image['id']?>">
                                        <img src="../../frontend/web/images/items/<?=$image['big_image'];?>">
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="miniSlider">
                                <?php
                                foreach($model['images'] as $image){
                                    ?>
                                    <div class="miniImg">
                                        <span class="glyphicon glyphicon-remove"
                                              aria-hidden="true"
                                              data-image-id="<?=$image['id']?>"></span>
                                        <img src="../../frontend/web/images/items/<?=$image['small_image'];?>">
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="uploadzone">
                            <form action="index.php?r=service/uploadimages" class="dropzone">
                                <input type="hidden" name="item_id" value="<?php echo $model->id; ?>">
                                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-default">Обновить</button>
</div>
<?php
$js = "$(document).ready(function(){
        $('.mainSlider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            speed: 200,
            asNavFor: '.miniSlider'
        });
        $('.miniSlider').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            asNavFor: '.mainSlider',
            dots: false,
            focusOnSelect: true,
            infinite: false
        });
    });";
$this->registerJsFile("js/slick.js", ['position' => \yii\web\View::POS_BEGIN]);
$this->registerJsFile("js/dropzone.js", ['position' => \yii\web\View::POS_BEGIN]);
$this->registerJsFile("js/main.js", ['position' => \yii\web\View::POS_BEGIN]);
$this->registerJs($js, \yii\web\View::POS_END);
?>
