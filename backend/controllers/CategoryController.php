<?php

namespace backend\controllers;

use app\models\CategoryMenuItem;
use Yii;
use app\models\Category;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Category::find(),
        ]);

        $all = Category::find()
            ->orderBy("left_key ASC")
            ->all();

        //echo var_dump($arrayCategories); die();
        return $this->render('index', [
            'dataProvider' => $all,
        ]);
    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionGetcategories($id)
    {


    }

    public function actionTonestedset(){
        $this->toNestedSet();
        return $this->goBack();
    }

    /**
     * Service function for update item for nested sets structure.
     */
    public function toNestedSet(){
        $stackIn = array();
        $count = 1;
        $level = 0;

        $this->setNestedKey($stackIn, $count, $level, 0);
    }

    public function setNestedKey(&$stackIn, &$count, $level, $idItem){
        $children = Category::findAll([
            'parent_id' => $idItem
        ]);
        if(count($children) > 0){
            foreach($children as $item){
                array_unshift($stackIn, $item['id']);
            }
            foreach($children as $item){
                $idNextChild = array_shift($stackIn);
                $child = Category::findOne($idNextChild);
                $child->level = $level + 1;
                $child->left_key = $count++;
                $child->update();
                self::setNestedKey($stackIn, $count, $level + 1, $idNextChild);
            }
        }

        $childTmp = Category::findOne($idItem);
        if($childTmp != null){
            $childTmp->right_key = ($count++);
            $childTmp->update();
        }
        return;
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
