<?php
use yii\helpers\Url;
$panelItems =  new \yiister\gentelella\widgets\Panel([
    'header' => 'Заказ',
    'options' => [
        'class' => 'x_panel'
    ]
]);
?>
    <div class="row">
        <div class="col-xs-12 invoice-header">
            <h1>
                <i class="fa fa-globe"></i> Данные заказа
                <small class="pull-right"><?=$order->date?></small>
            </h1>
        </div>
        <!-- /.col -->
    </div>
    <div class="row">
        <div class="col-sm-4">
            <address>
                <strong>Имя: <?=$order->name_client?></strong>
                <br>
                Телефон: <?=$order->phone_client?>
            </address>
        </div>
    </div>
    <?php

    ?>
    <table class="table">
        <tr>
            <th>Наименование</th>
            <th>Цвет</th>
            <th>Размер</th>
            <th>Количество</th>
            <th>Цена за шт.</th>
            <th>Стоимость</th>
        </tr>
        <?php
        $all_price = 0;
        foreach($items_order as $item):
            $all_price += $item['count'] * $item['price'];
        ?>
        <tr>
            <td>
                <?=$item['product']->name;?>
            </td>
            <td>
                <?=$item['product']->color;?>
            </td>
            <td>
                <?=$item['param'];?>
            </td>
            <td>
                <?=$item['count']?>
            </td>
            <td>
                <?=$item['price']?>
            </td>
            <td>
                <?=$item['count'] * $item['price']?>
            </td>
        </tr>
    <?php endforeach; ?>
    </table>
    <div class="table-responsive" style="width: 50%; float: right">
        <table class="table">
            <tbody>
            <tr>
                <th>Итого к оплате:</th>
                <td><?=$all_price?> р.</td>
            </tr>
            </tbody>
        </table>
    </div>
<?=
$panelItems->run();
?>