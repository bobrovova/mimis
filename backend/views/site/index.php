<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
$this->title = 'My Yii Application';
$this->registerJsFile('js/bootstrap-treeview.js', ['position' => \yii\web\View::POS_END]);
?>
<?php
    $panel = new \yiister\gentelella\widgets\Panel([
        'header' => 'Категории',
        'options' => [
            'class' => 'x_panel treeCategory'
        ]
    ]);
?>
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
            echo "<li><a href='index.php?r=site/index&category=$item[id]'>$item[name] (id: $item[id])</a></li>";
        }
        ?>
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
<?=
    $panelItems->run();
?>