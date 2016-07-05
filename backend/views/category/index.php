<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории товаров';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <p>
        <?= Html::a('Обновить Nested Sets', ['tonestedset'], ['class' => 'btn btn-success']) ?>
    </p>
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
            echo "<li><a href='index.php?r=category/view&id=$item[id]'>$item[name] (id: $item[id])</a></li>";
        }
    ?>
    </ul>
</div>
