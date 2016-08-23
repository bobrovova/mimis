<?php
/**
 * Created by PhpStorm.
 * User: vladimir
 * Date: 18.08.16
 * Time: 21:16
 */

namespace backend\controllers;


use Faker\Provider\Image;
use yii\web\Controller;
use app\models\ImagesToItems as Images;
use yii\filters\VerbFilter;
use Yii;

class ImagesController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionDelete()
    {
        $image = Images::findOne(Yii::$app->request->post('id'));

        return ($image->delete()) ? 1 : 0;
    }
}