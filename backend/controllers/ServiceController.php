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
        $content = file_get_contents("1c.json");
        if (substr($content, 0, 3) == "\xef\xbb\xbf") {
            $content = substr($content, 3);
        }
        $json = json_decode($content);
        if($json != null){
            $numberProducts = $json->count;
            for($i = 0; $i < $numberProducts; $i++){
                $nameProduct = "product".($i+1);
                $product = $json->$nameProduct;
                Items::loadProductFrom1c($product);
            }
        } else {
            echo "Ошибка при парсинге Json";
            switch (json_last_error()) {
                case JSON_ERROR_NONE:
                    echo ' - Ошибок нет';
                break;
                case JSON_ERROR_DEPTH:
                    echo ' - Достигнута максимальная глубина стека';
                break;
                case JSON_ERROR_STATE_MISMATCH:
                    echo ' - Некорректные разряды или не совпадение режимов';
                break;
                case JSON_ERROR_CTRL_CHAR:
                    echo ' - Некорректный управляющий символ';
                break;
                case JSON_ERROR_SYNTAX:
                    echo ' - Синтаксическая ошибка, не корректный JSON';
                break;
                case JSON_ERROR_UTF8:
                    echo ' - Некорректные символы UTF-8, возможно неверная кодировка';
                break;
                default:
                    echo ' - Неизвестная ошибка';
                break;
            }
        }
    }

    function jsondecode ($sText){
        if (!$sText) return false;
        $sText = iconv('cp1251', 'utf8', $sText);
        $aJson = json_decode($sText, true);
        $aJson = iconvarray($aJson);
        return $aJson;
    }

    function iconvarray($aJson){
        foreach ($aJson as $key => $value) {
            if (is_array($value)) {
                $aJson[$key] = iconvarray($value);
            } else {
                $aJson[$key] = iconv('utf8', 'cp1251', $value);
            }
        }
        return $aJson;
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