<?php

namespace frontend\controllers;

use app\models\DeliveryAddresses;
use frontend\models\ChangeProfileForm;
use frontend\models\SubscribeForm;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class ServiceController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'subscribeuser' => ['post', 'get'],
                ],
            ],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('account');
    }

    public function actionStep1(){
        if(!yii::$app->user->isGuest){
            $user = yii::$app->user->identity;
            $shipping = DeliveryAddresses::findOne(['user_id' => yii::$app->user->id]);
        }

        return $this->render('step1', [
            'user' => $user,
            'shipping' => $shipping
        ]);
    }

    public function actionStep2(){
        var_dump(yii::$app->request->post());
        return $this->render('step2', [
            'order_info' => [
                'shipping' => yii::$app->request->post('shipping'),
                'client' => yii::$app->request->post('client')
            ],
        ]);
    }

    public function actionStep3(){
        $info_order = json_decode(yii::$app->request->post('step1'));
        $info_order->payment = yii::$app->request->post('payment');
        if(yii::$app->user->isGuest){
            $cart = \app\models\Cart::getInfoBySession();
        } else {
            $cart = \app\models\Cart::getInfoByUser();
        }
        $cart['Count'] = $cart['Count'] . " " . \app\models\Cart::num2word($cart['Count'], ['товар', 'товара', 'товаров']);
        return $this->render('step3', [
            'order' => $info_order,
            'cart' => $cart
        ]);
    }

    public function actionChangeprofile(){
        return $this->render('changeprofile.php');
    }

    public function actionChangeprofileajax(){
        $model = new ChangeProfileForm();
        $data[$model->formName()] = Yii::$app->request->post()['changeform'];
        if($model->load($data) && $model->validate()){
            return $model->changeInfo();
        } else {
            return $model->getErrors();
        }
    }

    public function actionSubscribeuser(){
        $model = new SubscribeForm();
        $data[$model->formName()]['email'] = Yii::$app->request->post('email');
        if($model->load($data) && $model->validate()){
            if($model->subscribe()){
                return 0;
            } else {
                return 2;
            }
        } else {
            return 1;
        }
    }
}