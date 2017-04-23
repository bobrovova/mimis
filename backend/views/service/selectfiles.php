<?php

use yii\helpers\Url;

$selectFilesPanel = new \yiister\gentelella\widgets\Panel([
    'header' => 'Выбери файл для импорта',
    'options' => [
        'class' => 'x_panel'
    ]
]);
?>
<table class="table">
    <thead>
        <tr>
            <td>Название файла</td>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach ($files as $file) :
    ?>
        <tr>
            <th>
                <a href="<?=Url::to(['service/load-products', 'file' => $file])?>"><?=$file?></a>
            </th>
        </tr>
    <?php
        endforeach;
    ?>
    </tbody>
</table>
<?=$selectFilesPanel->run();?>
