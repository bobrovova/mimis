<?php
/**
 * Created by PhpStorm.
 * User: vladimir
 * Date: 04.07.16
 * Time: 21:23
 */

namespace backend\controllers;


use yii\web\Controller;
use app\models\Orders;
use app\models\Items;
use app\models\Fields;

class OrdersController extends Controller
{
    public function actionIndex()
    {
        $orders = Orders::find()->all();
        
        return $this->render('index', [
            'orders' => $orders
        ]);
    }

    public function actionView()
    {
        $order = Orders::findOne([
            'id' => \Yii::$app->request->get("id")
        ]);

        $items_order = json_decode($order->items);

        foreach ($items_order as &$item){
            $item = (array) $item;
            $item['product'] = Items::findOne($item['item_id']);
            if(!empty($item['params'])){
                $field = Fields::findOne($item['params']);
                $item['params'] = $field->name;
            }
        }

        return $this->render('view', [
            'order' => $order,
            'items_order' => $items_order
        ]);
    }
}