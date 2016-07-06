<?php

use yii\helpers\Url;

?>
    <!--Section Left_Menu and Main_Head-->
    <section class="block">
        <nav class="left-nav">
            <ul class="left-nav_wrap">
                <?php foreach($categories as $category): ?>
                <li class="left-nav_item">
                    <a class="left-nav_link" href="<?=Url::to(["catalog/index", 'category' => $category->id])?>">
                        <?=$category->name?>
                    </a>
                    <?php if(count($category->childCategories) != 0): ?>
                    <nav class="subnav">
                        <ul>
                            <?php foreach($category->childCategories as $cat): ?>
                                <li class="subnav_item">
                                    <a href="<?=Url::to(["catalog/index", 'category' => $cat->id])?>" class="subnav_link">
                                        <?=$cat->name?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </nav>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <div class="content">
            <div class="content_head">
                <h1 class="content_head_h1">Распродажа</h1>
                <h2 class="content_head_h2">Женского белья</h2>
                <p class="content_head_p">Скидки 70% на вещи
                    <br> из нашей новой коллекции</p>
            </div>
            <div class="content_wrap">
                <h3 class="content_wrap_h3">Это Miss&Mister</h3>
                <h4 class="content_wrap_h4">Твои любимые брены <br> под одной крышей</h4>
                <p class="content_wrap_p">Более 850 всемирно известных лейблов, включая собственную линию ASOS.</p>
                <a href="#" class="content_wrap_btn">Мужчинам</a>
                <a href="#" class="content_wrap_btn">Женщинам</a>
            </div>
        </div>
    </section><!--Section Left_Menu and Main_Head-->


    <!--Section Tabs-->
    <section class="section_tabs">
        <div id="js-tabs" class="b-tabs">

            <ul class="tabs">
                <li class="tabs_tab"><?php echo $firstBlock['name']; ?></li>
                <li class="tabs_tab"><?php echo $secondBlock['name']; ?></li>
                <li class="tabs_tab"><?php echo $thirdBlock['name']; ?></li>
            </ul>

            <div class="tabs_content">

                <div class="tabs_content_wrap">
                    <?php foreach ($firstBlock['items'] as $item) : ?>
                        <div class="tabs_item">
                            <div class="tabs_img">
                                <img src="images/items/<?php echo $item->thumb; ?>" alt="">
                            </div>
                            <div class="tabs_descrip">
                                <span><?php $item->name; ?></span>
                            </div>
                            <span class="tabs_price"><?php echo $item->price; ?> <img src="images/rub.png" alt=""></span>
                            <a href="#" class="tabs_btn">Купить</a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="tabs_content_wrap">
                    <?php foreach ($secondBlock['items'] as $item) : ?>
                        <div class="tabs_item">
                            <div class="tabs_img">
                                <img src="images/items/<?php echo $item->thumb; ?>" alt="">
                            </div>
                            <div class="tabs_descrip">
                                <span><?php $item->name; ?></span>
                            </div>
                            <span class="tabs_price"><?php echo $item->price; ?> <img src="images/rub.png" alt=""></span>
                            <a href="#" class="tabs_btn">Купить</a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="tabs_content_wrap">
                    <?php foreach ($thirdBlock['items'] as $item) : ?>
                        <div class="tabs_item">
                            <div class="tabs_img">
                                <img src="images/items/<?php echo $item->thumb; ?>" alt="">
                            </div>
                            <div class="tabs_descrip">
                                <span><?php $item->name; ?></span>
                            </div>
                            <span class="tabs_price"><?php echo $item->price; ?> <img src="images/rub.png" alt=""></span>
                            <a href="#" class="tabs_btn">Купить</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section><!--Section Tabs-->