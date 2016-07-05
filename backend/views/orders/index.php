<?php
use yii\helpers\Url;
$panelItems =  new \yiister\gentelella\widgets\Panel([
    'header' => 'Заказы',
    'options' => [
        'class' => 'x_panel'
    ]
]);
?>
    <table class="table">
        <tr>
            <th>Имя клиента</th>
            <th>Дата заказа</th>
            <th>Действия</th>
        </tr>
        <?php foreach($orders as $order):?>
            <tr>
                <td>
                    <?=$order['name_client']?>
                </td>
                <td>
                    <?=$order['date']?>
                </td>
                <td>
                    <a href="<?=Url::to(['orders/view', 'id' => $order['id']]);?>">Просмотреть</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?=
$panelItems->run();
?>