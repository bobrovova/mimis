<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use app\models\Cart;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\models\Items;

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
                'only' => ['logout', 'signup', 'login'],
                'rules' => [
                    [
                        'actions' => ['signup', 'login', 'resetpassword'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get', 'post'],
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

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $categories = \app\models\Category::find()
            ->where("parent_id = 0")
            ->with('childCategories')
            ->orderBy("left_key")
            ->all();

        foreach($categories as $cat){
            $cat->childCategories;
        }

        $sql = "SELECT items.*, iti.small_image as thumb FROM items
                LEFT JOIN images_to_items iti ON items.id = iti.item_id
                WHERE category_id = 2 AND iti.isThumb = 1 LIMIT 0,4";
        $products = Items::findBySql($sql)->all();

        $firstBlock = [
            'name' => 'Нижнее белье',
            'items' => $products
        ];

        $sql = "SELECT items.*, iti.small_image as thumb FROM items
                LEFT JOIN images_to_items iti ON items.id = iti.item_id
                WHERE category_id = 3 AND iti.isThumb = 1 LIMIT 0,4";
        $products = Items::findBySql($sql)->all();

        $secondBlock = [
            'name' => 'Купальники',
            'items' => $products
        ];

        $sql = "SELECT items.*, iti.small_image as thumb FROM items
                LEFT JOIN images_to_items iti ON items.id = iti.item_id
                WHERE category_id = 1 AND iti.isThumb = 1 LIMIT 0,4";
        $products = Items::findBySql($sql)->all();

        $thirdBlock = [
            'name' => 'Домашняя одежда',
            'items' => $products
        ];

        return $this->render('indexnew', [
            'categories' => $categories,
            'firstBlock' => $firstBlock,
            'secondBlock' => $secondBlock,
            'thirdBlock' => $thirdBlock
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if(!empty($_COOKIE['crtss'])){
                $cart = Cart::findAll([
                    'session_id' => $_COOKIE['crtss'],
                ]);
                foreach($cart as $item_cart){
                    if(empty($item_cart->user_id)){
                        $item_cart->user_id = Yii::$app->user->id;
                        $item_cart->update();
                    }
                }
            }
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        if(Yii::$app->request->post('pass1') == Yii::$app->request->post('pass2')){
            $model = new SignupForm();
            $data['SignupForm']['email'] = Yii::$app->request->post('email');
            $data['SignupForm']['password'] = Yii::$app->request->post('pass1');
            if ($model->load($data)) {
                if ($user = $model->signup()) {
                    if (Yii::$app->getUser()->login($user)) {
                        return $this->goHome();
                    }
                }
            }
        } else {
            \Yii::$app->response->redirect(Url::to(["site/login", "error_join" => 1, "ec" => 1]), 301)->send();
        }
        \Yii::$app->response->redirect(Url::to(["site/login", "error_join" => 1]), 301)->send();
        return;
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestpasswordreset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                //Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return Yii::$app->getResponse()->redirect(Url::to(["site/requestpasswordreset", "success" => 1]));
            } else {
                return Yii::$app->getResponse()->redirect(Url::to(["site/requestpasswordreset", "error_send" => 1]));
            }
        }
        if(!empty($model->errors)){
            Yii::$app->session->setFlash('error', $model->errors['email'][0]);
        }
        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionDeliverypay(){
        return $this->render('deliverypay');
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
