<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;
?>
<?php
    $searchPanel = new \yiister\gentelella\widgets\Panel([
        'header' => 'Поиск',
        'options' => [
            'class' => 'x_panel'
        ]
    ]);
?>
    <form action="<?=Url::to(["site/index", 'category' => (!empty($category->id)) ? $category->id : ''])?>" method="post">
        <div class="input-group">
            <input class="form-control" type="text" name="search" placeholder="Введите наименование товара">
            <input type="hidden" name="category" value="<?=(!empty($category)) ? $category->id : ''?>">
            <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
            <span class="input-group-btn">
                <button type="submit" class="btn btn-primary">Искать!</button>
            </span>
        </div>
    </form>
<?=$searchPanel->run();?>

<?php
    $panel = new \yiister\gentelella\widgets\Panel([
        'header' => 'Категории',
        'options' => [
            'class' => 'x_panel treeCategory'
        ]
    ]);
?>
    <ul>
        <li>
            <a href='index.php?r=site/index'>Все</a>
            <ul>
                <?php
                $lastLevel = 1;
                foreach($dataProvider as $item){
                    if($lastLevel < $item['level']){
                        echo "<ul>";
                    }
                    if($lastLevel > $item['level']){
                        echo "</ul>";
                    }
                    $lastLevel = $item['level'];
                    echo "<li><a href='index.php?r=site/index&category=$item[id]'>$item[name]</a></li>";
                }
                ?>
            </ul>
        </li>
    </ul>
<?=
    $panel->run();
?>
<?php
    $panelItems =  new \yiister\gentelella\widgets\Panel([
        'header' => 'Товары ('. (!empty($category) ? $category->name : 'Все') . ')',
        'options' => [
            'class' => 'x_panel itemsCategory'
        ]
    ]);
?>
    <table class="table">
        <tr>
            <th>Наименование</th>
            <th>Оптовая цена</th>
            <th>Опубликовано</th>
            <th>Действия</th>
        </tr>
        <?php foreach($items as $item):?>
        <tr>
            <td>
                <?=$item['name']?>
                <?php
                    if ($item['number_imgs'] == 0):
                ?>
                        <small class="label-danger label pull-right">Нет картинок</small>
                <?php
                    endif;
                ?>
            </td>
            <td>
                <?=$item['price_opt']?>
            </td>
            <td>
                <?=($item['online'] == 1) ? 'Да' : 'Нет'; ?>
            </td>
            <td>
                <a href="<?=Url::to(['items/update', 'id' => $item['id']]);?>">Изменить</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php
    echo LinkPager::widget([
        'pagination' => $pagination,
    ]);
    $panelItems->run();
?>