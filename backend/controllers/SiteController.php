<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use app\models\Category;
use app\models\Items;
use app\models\ExtraVariations;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $all = Category::find()
            ->orderBy("left_key ASC")
            ->all();

        if(!empty(Yii::$app->request->get("category"))){
            $category_id = Yii::$app->request->get("category");
            $category = Category::findOne([
                'id' => $category_id
            ]);
            $left_key = $category->left_key;
            $right_key = $category->right_key;
            $level = $category->level;
            //$bread = $this->getBreadcrumbs($category_id);
            $title_category = $category->name;
        } else {
            $category_id = 0;
            $left_key = 1;
            $right_key = Category::findBySql("SELECT * FROM categories")->count() * 2;
            $level = 0;
            $bread = [];
            $title_category = "Каталог";
            $category = null;
        }
        $sql = "SELECT id, name FROM categories
                WHERE left_key >= $left_key AND right_key <= $right_key AND (level = ($level + 1) OR level = ($level))
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

        $sql = "SELECT items.id_product, items.name, items.price_opt, items.online, 
                MIN(items.id) as id, COUNT(iti.id) as number_imgs FROM items
                LEFT JOIN images_to_items iti ON items.id = iti.item_id
                WHERE category_id IN (".implode(",", $childCatsIds).")
                GROUP BY items.id_product, items.name, items.price_opt, items.online";
        $products = Items::findBySql($sql)->all();

        //echo var_dump($arrayCategories); die();
        return $this->render('index', [
            'dataProvider' => $all,
            'items' => $products,
            'category' => $category
        ]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

	$this->layout = 'login';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
