<?php
use yii\helpers\Url;
$this->registerCssFile("css/slick.css");

?>
<section class="block wrap">
    <?php if(!empty($breadcrumbs)) : ?>
    <div class="bread">
        <ul>
            <li><a href="#">Главная</a></li>
            <li>-</li>
            <?php
                foreach($breadcrumbs as $crumb){
                    if(!empty($crumb['id'])){
                        $url = Url::to(['catalog/index', 'category' => $crumb['id']]);
                        echo '<li><a href="'.$url.'">'.$crumb['title'].'</a></li> <li>-</li> ';
                    } else {
                        echo '<li class="last">'.$crumb['title'].'</li>';
                    }
                }
            ?>
        </ul>
    </div>
    <?php endif; ?>
    <div class="productBlock">
        <div class="images">
            <div class="mainSlider">
                <?php
                    foreach($item['images'] as $image){
                ?>
                    <div class="img">
                        <img src="<?=Yii::$app->params['itemsImagesPath'].$image['big_image'];?>">
                    </div>
                <?php
                    }
                ?>
            </div>
            <div class="miniSlider">
                <?php
                foreach($item['images'] as $image){
                    ?>
                    <div class="miniImg">
                        <img src="<?=Yii::$app->params['itemsImagesPath'].$image['small_image'];?>">
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="info">
            <div class="title">
                <?=$item['name'];?>
            </div>
            <div class="price">
                <div class="label">Цена:</div>
                <div class="currentPrice tabs_price"><?=$item['price'];?> <img src="images/rub.png" alt=""></div>
            </div>
            <?php if(!empty($colors)): ?>
                <div class="params">
                    <div class="label">Цвет</div>
                    <div class="selectParams colors">
                        <ul>
                            <?php
                            foreach ($colors as $color) {
                                $activeClass = '';
                                if($color->color == $item['color']){
                                    $activeClass = ' class="active"';
                                }
                                echo "<li><a".$activeClass." href='".Url::to(['catalog/item', 'id' => $color->id])."'>".$color->color."</a></li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(!empty($fields)): ?>
            <div class="params">
                <div class="label">Размер</div>
                <div id="size" class="selectParams" data-param="">
                    <ul>
                        <?php
                            foreach ($fields as $field) {
                                echo "<li><a data-id-param='$field->id'>".$field->value."</a></li>";
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
            <div class="number">
                <div class="label">Количество:</div>
                <div>
                    <input type="text" name="Product[count]" value="1">
                </div>
            </div>
            <input type="hidden" name="Product[id]" value="<?=$item['id'];?>">
            <div class="addToCart">
                <a href="#" class="tabs_btn">В корзину</a>
            </div>
            <div class="descBlock">
                <div class="label">Описание товара:</div>
                <div class="text">
                    <?=$item['description'];?>
                </div>
            </div>
        </div>
    </div>
</section>
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
$this->registerJs("selectParams();", \yii\web\View::POS_END);
$this->registerJs("Cart();", \yii\web\View::POS_END);
$this->registerJs($js, \yii\web\View::POS_END);
?>
