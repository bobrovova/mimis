<?php

namespace frontend\controllers;

use app\models\Cart;
use app\models\Category;
use app\models\ExtraVariations;
use app\models\FieldsValuesToItems;
use app\models\Items;
use frontend\models\AddItemToCartForm;
use Yii;
use yii\web\Controller;
use app\models\Orders;
use yii\db\Query;

class CatalogController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        if(!empty(Yii::$app->request->get("category"))){
            $category_id = Yii::$app->request->get("category");
            $category = Category::findOne([
                'id' => $category_id
            ]);
            $left_key = $category->left_key;
            $right_key = $category->right_key;
            $level = $category->level;
            $bread = $this->getBreadcrumbs($category_id);
            $title_category = $category->name;
        } else {
            $category_id = 0;
            $left_key = 1;
            $right_key = Category::findBySql("SELECT * FROM categories")->count() * 2;
            $level = 0;
            $bread = [];
            $title_category = "Каталог";
        }
        $sql = "SELECT id, name FROM categories
                WHERE left_key >= $left_key AND right_key <= $right_key AND level = ($level + 1)
                ORDER BY left_key";
        $categories = Category::findBySql($sql)->all();
        if(count($categories) == 0){
            $sql = "SELECT id, name FROM categories WHERE parent_id = ".$category->parent_id." ORDER BY left_key";
            $categories = Category::findBySql($sql)->all();

            $sqlSize = "SELECT value FROM extra_variations exv
                        LEFT JOIN items ON exv.item_id = items.id GROUP BY exv.value";
            $allSizes = ExtraVariations::findBySql($sqlSize)->all();
        }

        foreach($categories as $cat){
            $childCatsIds[] = $cat->id;
        }

        $sql = "SELECT items.*, iti.small_image as thumb FROM items
                LEFT JOIN images_to_items iti ON items.id = iti.item_id
                WHERE category_id IN (".implode(",", $childCatsIds).") AND iti.isThumb = 1";
        $products = Items::findBySql($sql)->all();

        return $this->render('index', [
            'childCategories' => $categories,
            'breadcrumbs' => $bread,
            'filter_sizes' => (!empty($allSizes)) ? $allSizes : null,
            'title_category' => $title_category,
            'products' => (!empty($products)) ? $products : null
        ]);
    }

    public function actionItem(){
        $item = Items::findOne([
            'id' => Yii::$app->request->get('id'),
        ]);
        if($item != null && $item['online'] == 1){
            $item->images;

            $fields = ExtraVariations::findAll([
                'item_id' => $item->id,
            ]);
            
            $bread = $this->getBreadcrumbs($item['category_id']);
            $bread[] = [
                'title' => $item['name'],
                'id' => null
            ];

            $colors = Items::findBySql("SELECT id, color FROM items WHERE id_product = ".$item->id_product. " ORDER BY color_rank")->all();

            return $this->render('item', [
                'item' => $item,
                'breadcrumbs' => $bread,
                'fields' => $fields,
                'colors' => !(empty($colors[0]->color)) ? $colors : null
            ]);
        } else {
            return $this->goHome();
        }
    }

    public function actionCart(){
        if(empty($_COOKIE["crtss"])){
            $crtss = uniqid('', true);
            setcookie("crtss", $crtss);
        }

        if(yii::$app->user->isGuest){
            $cartItems = Cart::findAll([
                'session_id' => $_COOKIE['crtss']
            ]);
        } else {
            $cartItems = Cart::findAll([
                'user_id' => Yii::$app->user->id
            ]);
        }

        //var_dump($cartItems);

        $items = [];
        $i = 0;
        foreach ($cartItems as &$item) {
            $items[$i]['cart'] = $item;
            $items[$i]['idcart'] = $item->id;
            $items[$i]['info'] = \app\models\Items::findOne(['id' => $item->item_id]);
            $items[$i]['param'] = ExtraVariations::findOne(['id' => $item->param]);
            $i++;
        }


        return $this->render('cart', [
            'items' => $items
        ]);
    }

    public function actionDeletefromcart(){
        $record = Cart::findOne([
            'id' => Yii::$app->request->post("idcart")
        ]);

        if($record->session_id == $_COOKIE['crtss']){
            $record->delete();
            $cart = Cart::getInfoBySession();
            $cart['Count'] = $cart['Count'] . " " .CatalogController::num2word($cart['Count'], ['товар', 'товара', 'товаров']);
            setcookie('cart', json_encode($cart), time()+60*60*24*30);
            return true;
        } else {
            return;
        }
    }

    public function actionRefreshcart(){
        $connection = \Yii::$app->db;
        if(yii::$app->user->isGuest) {
            $sql = "SELECT SUM((c.price * c.count)) as 'Sum', COUNT(*) as 'Count' FROM `cart` c WHERE session_id = '" . Yii::$app->request->post("crtss") . "'";
            $model = $connection->createCommand($sql);
            $result = $model->queryOne();
        }
        $result['Count'] = $result['Count'] . " " .$this->num2word($result['Count'], ['товар', 'товара', 'товаров']);
        setcookie("cart", json_encode($result), time()+60*60*24*30);
        return json_encode($result);
    }

    public function actionOrder(){
        $orderItems = Cart::findAll([
            'session_id' => $_COOKIE['crtss']
        ]);
        foreach($orderItems as &$item){
            $item = $item->toArray();
        }
        unset($item);
        $orderItemsJson = json_encode($orderItems);

        $order = new Orders();
        $order->name_client = Yii::$app->request->post("nameClient");
        $order->phone_client = Yii::$app->request->post("phoneClient");
        $order->items = $orderItemsJson;
        if($order->validate()){
            $order->save();
            foreach($orderItems as $item){ //Удаляем все записи из корзины
                $item->delete();
            }

            $cart['Count'] = '0 товаров'; //устанавливаем новую информацию о корзине
            $cart['Sum'] = 0;
            setcookie("cart", json_encode($cart), time()+60*60*24*30);

            return $order->id;
        } else {
            return $order->errors;
        }
    }

    public function actionChangecountcart(){
        $cart_record = Cart::findOne([
            'id' => Yii::$app->request->post("idcart")
        ]);
        if($cart_record->session_id == $_COOKIE['crtss']){
            $cart_record->count = Yii::$app->request->post("count");
            $cart_record->update();
            $cart = Cart::getInfoBySession();
            $cart['Count'] = $cart['Count'] . " " .CatalogController::num2word($cart['Count'], ['товар', 'товара', 'товаров']);
            setcookie('cart', json_encode($cart), time()+60*60*24*30);
            $cart['ItemSum'] = $cart_record->count * $cart_record->price;
            return json_encode($cart);
        } else {
            return false;
        }
    }

    public function actionAddtocart(){
        $connection = \Yii::$app->db;
        if(yii::$app->user->isGuest){
            if(empty(Yii::$app->request->post("crtss"))){
                $crtss = uniqid('', true);
                setcookie("crtss", $crtss);
            } else {
                $crtss = Yii::$app->request->post("crtss");
            }
            $cart = Cart::findOne([
                'session_id' => $crtss,
                'item_id' => Yii::$app->request->post("idItem"),
                'param' => Yii::$app->request->post("param")
            ]);

            $item = Items::findOne(Yii::$app->request->post("idItem"));
            if($cart != null){
                $cart->count += Yii::$app->request->post("count");
                $cart->price = $item->price;
                $cart->update();
            } else {
                $cart = new Cart();
                $cart->session_id = $crtss;
                $cart->item_id = Yii::$app->request->post("idItem");
                $cart->param = Yii::$app->request->post("param");
                $cart->count = Yii::$app->request->post("count");
                $cart->price = $item->price;
                $cart->save();
            }
            $sql = "SELECT SUM((c.price * c.count)) as 'Sum', COUNT(*) as 'Count' FROM `cart` c WHERE session_id = '".Yii::$app->request->post("crtss")."'";
            $model = $connection->createCommand($sql);
            $result = $model->queryOne();
        } else {
            $cart = Cart::findOne([
                'user_id' => yii::$app->user->id,
                'item_id' => Yii::$app->request->post("idItem"),
                'param' => Yii::$app->request->post("param")
            ]);

            if($cart != null){
                $item = Items::findOne($cart->item_id); // Доп проверка на существование товара
                $cart->count += Yii::$app->request->post("count");
                $cart->price = $item->price;
                $cart->update();
            } else {
                $cart = new Cart();
                $cart->user_id = yii::$app->user->id;
                $cart->item_id = Yii::$app->request->post("idItem");
                $cart->param = Yii::$app->request->post("param");
                $cart->count = Yii::$app->request->post("count");
                $cart->save();
            }
            $sql = "SELECT SUM((c.price * c.count)) as 'Sum', COUNT(*) as 'Count' FROM `cart` c WHERE user_id = ".yii::$app->user->id;
            $model = $connection->createCommand($sql);
            $result = $model->queryOne();
        }
        $result['Count'] = $result['Count'] . " " .$this->num2word($result['Count'], ['товар', 'товара', 'товаров']);
        setcookie("cart", json_encode($result), time()+60*60*24*30);
        return json_encode($result);
    }

    public function num2word($num,$words) {
        $num=$num%100;
        if ($num>19) { $num=$num%10; }
        switch ($num) {
            case 1:  { return($words[0]); }
            case 2: case 3: case 4:  { return($words[1]); }
            default: { return($words[2]); }
        }
    }

    public function getBreadcrumbs($idCategory){
        $cat = Category::findOne($idCategory);
        if($cat != null) {
            $categories = Category::find()
                ->where("left_key <= " . $cat->left_key . " AND right_key >= " . $cat->right_key)
                ->orderBy("left_key ASC")
                ->all();
            $bread = [];
            foreach ($categories as $tmpCat) {
                $tmp = [
                    'title' => $tmpCat['name'],
                    'id' => $tmpCat['id'],
                ];
                $bread[] = $tmp;
            }
            return $bread;
        }
        else return null;
    }
}