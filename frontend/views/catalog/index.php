<?php

use yii\helpers\Url;

?>

<section class="block">
    <nav class="left-nav">
        <ul class="left-nav_wrap">
            <?php foreach($childCategories as $category): ?>
                <li class="left-nav_item">
                    <a class="left-nav_link" href="<?=Url::to(["catalog/index", 'category' => $category->id])?>">
                        <?=$category->name?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <div class="catalog_wrap">
        <div class="tabs_content_wrap">
            <?php
            if (!empty($products)):
                foreach($products as $product):
                    ?>
                    <div class="tabs_item">
                            <div class="tabs_img">
                                <img src="<?=Yii::$app->params['itemsImagesPath'].$product->thumb;?>">
                            </div>
                        <a href="<?=Url::to(['catalog/item', 'id' => $product->id]);?>" class="tabs_link_item">
                            <div class="tabs_descrip">
                                <span><?=$product->name;?></span>
                            </div>
                            <span class="tabs_price"><?=$product->price;?> <img src="images/rub.png" alt=""></span>
                        </a>
                        <a href="<?=Url::to(['catalog/item', 'id' => $product->id]);?>" class="tabs_btn">Купить</a>
                    </div>
                    <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section><!--Section Left_Menu and Main_Head-->