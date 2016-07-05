<?php

namespace backend\controllers;

use app\models\FieldsToCategory;
use Faker\Provider\File;
use Yii;
use app\models\Fields;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FieldsController implements the CRUD actions for Fields model.
 */
class FieldsController extends Controller
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

    /**
     * Lists all Fields models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Fields::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Fields model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Fields model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Fields();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Fields model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->save(['name', 'type']);
            $categories = explode("," ,Yii::$app->request->post('Fields')['categories']);
            FieldsToCategory::deleteAll("field_id=".$model->id);
            $allCategories = [];
            foreach($categories as $cat){
                $tmpCats = FieldsToCategory::getAllCategoriesInBranch($cat);
                foreach($tmpCats as $obj){
                    $allCategories[] = $obj;
                }
                $allCategories[] = $cat;
            }

            foreach($allCategories as $cat){
                $cat = trim($cat);
                if(null == FieldsToCategory::findOne(['field_id'=>$model->id, 'category_id'=> $cat])){
                    $ftc = new FieldsToCategory;
                    $ftc->field_id = $model->id;
                    $ftc->category_id = $cat;
                    $ftc->insert();
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Fields model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        FieldsToCategory::deleteAll(['field_id' => $id]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Fields model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Fields the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Fields::findOneWithAll($id)) !== null) {
            $tmpStr = '';
            foreach($model->categories as $cat){
                $tmpStr .= $cat.", ";
            }
            $model->categories = $tmpStr;
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
