<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
$this->title = 'My Yii Application';

?>

<table class="table table-striped">
    <thead>
        <tr>
            <td>Наименование</td>
            <td>Результат</td>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach ($results as $product){
            if ($product['result'] == 1){
                $result = "Успешно";
            } else {
                $result = "<b style='color: red'>$product[result]</b>";
            }
            echo "<tr><td>$product[name]</td><td>$result</td></tr>";
        }
    ?>
    </tbody>
</table>
