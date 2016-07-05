<?php
namespace backend\controllers;

use app\models\ImagesToItems;
use app\models\Items;
use Yii;
use app\models\Category;
use yii\web\Controller;


class ServiceController extends Controller
{
    public function actionLoadproducts()
    {
        $json = json_decode(file_get_contents("1c.json"));
        if($json != null){
            $numberProducts = $json->count;
            for($i = 0; $i < $numberProducts; $i++){
                $nameProduct = "product".($i+1);
                $product = $json->$nameProduct;
                Items::loadProductFrom1c($product);
            }
        } else {
            echo "Ошибка при парсинге Json";
        }
    }

    public function actionUploadimages(){
        $item = Items::findOne([
            'id' => Yii::$app->request->post("item_id")
        ]);

        if(!empty($item)){
            $item->getImages();
            $name_photo = $item->id . '_' . count($item->images) . '_' . rand(500, 1000) . ".jpg";
            $upload_dir = '../../frontend/web/images/items/';
            if(move_uploaded_file($_FILES['file']['tmp_name'], $upload_dir . $name_photo)){
                $image = new ImagesToItems();
                $image->small_image = $name_photo;
                $image->big_image = $name_photo;
                $image->rank = count($item->images) + 1;
                $image->item_id = $item->id;
                if(count($item->images) == 0){ // set main image to product automatic
                    $image->isThumb = 1;
                } else {
                    $image->isThumb = 0;
                }
                if($image->save()){

                }
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}