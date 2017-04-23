<?php
namespace backend\controllers;

use app\models\ImagesToItems;
use app\models\Items;
use Yii;
use app\models\Category;
use yii\web\Controller;
use backend\controllers\ImportJsonController;


class ServiceController extends Controller
{
    public function actionLoadProducts()
    {
        $importController = new ImportJsonController();
        $results = $importController->import("1c.json");
        return $this->render('import', [
            'results' => $results,
        ]);
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
            $upload_dir = '../../images/';
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