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
            <th>Статус</th>
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
                    <?php
                        switch ($order['status']) {
                            case 0:
                                echo "Новый";
                                break;
                            case 1:
                                echo "Обработка";
                            case 2:
                                echo "Выполнен";
                            default:
                                break;
                        }

                    ?>
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