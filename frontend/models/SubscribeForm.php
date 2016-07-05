<?php


namespace frontend\models;

use app\models\Subscribers;
use Yii;
use yii\base\Model;

class SubscribeForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['email'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\app\models\Subscribers', 'message' => 'This email address has already been taken.'],
        ];
    }

    public function subscribe(){
        $subscriber = new Subscribers();
        $subscriber->email = $this->email;
        if ($subscriber->save()) {
            return true;
        }

        return false;
    }
}