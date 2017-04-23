<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use app\models\Category;
use app\models\Items;
use app\models\Orders;
use app\models\ExtraVariations;
use yii\data\Pagination;

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
                        'actions' => ['logout', 'index', 'dashboard'],
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
            $right_key = Category::find()
                ->count() * 2;
            $level = 0;
            $bread = [];
            $title_category = "Каталог";
            $category = null;
        }
        $categories = Category::find()
            ->select(['id', 'name'])
            ->where([
                "AND",
                [">=", "left_key", $left_key],
                ["<=", "right_key", $right_key],
                [
                    "OR",
                    ["=", "level", ($level + 1)],
                    ["=", "level", $level]
                ]
            ])
            ->orderBy("left_key")
            ->all();

        if(count($categories) == 0){
            $categories = Category::find()
                ->select(["id", "name"])
                ->where(["parent_id", $category->parent_id])
                ->orderBy("left_key")
                ->all();

            $sqlSize = "SELECT value FROM extra_variations exv
                        LEFT JOIN items ON exv.item_id = items.id GROUP BY exv.value";
            $allSizes = ExtraVariations::find()
                ->select("value")
                ->leftJoin("items", "extra_variations.item_id = items.id")
                ->groupBy("extra_variations.value")
                ->all();
        }

        foreach($categories as $cat){
            $childCatsIds[] = $cat->id;
        }

        $query = Items::find()->
            select("items.id_product, items.name, items.price_opt, items.online, 
                MIN(items.id) as id, COUNT(iti.id) as number_imgs")
            ->leftJoin("images_to_items iti", "items.id = iti.item_id");

        if(empty(Yii::$app->request->post('search'))){
            $query->where(["IN", "category_id", $childCatsIds]);
        } else {
            $query->where([
                "AND",
                [
                    "LIKE",
                    "items.name",
                    Yii::$app->request->post('search')
                ],
                [
                    "IN",
                    "category_id",
                    $childCatsIds
                ]
            ]);
        }

        $query->groupBy("items.id_product, items.name, items.price_opt, items.online");
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 1]);
        $products = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'dataProvider' => $all,
            'items' => $products,
            'category' => $category,
            'pagination' => $pagination
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

    public function actionDashboard()
    {
        $data['allOrders'] = Orders::find()->count();
        $data['todayOrders'] = Orders::find()
            ->where("date >= CURDATE()")
            ->count();
        $data['allNotProcessedOrders'] = Orders::find()
            ->where("status = 0")
            ->count();
        $data['todayNotProcessedOrders'] = Orders::find()
            ->where("date >= CURDATE() AND status = 0")
            ->count();
        return $this->render('dashboard', [
            'data' => $data,
        ]);
    }
}
