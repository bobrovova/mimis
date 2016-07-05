<?php

namespace frontend\models;

use app\models\DeliveryAddresses;
use common\models\User;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ChangeProfileForm extends Model
{
    public $first_name          = null;
    public $second_name         = null;
    public $last_name           = null;
    public $mobile_phone        = null;
    public $city                = null;
    public $street              = null;
    public $zipcode             = null;
    public $house               = null;
    public $stroenie            = null;
    public $korpus              = null;
    public $podyezd             = null;
    public $floor               = null;
    public $apartment           = null;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['first_name', 'string', 'max' => 255],
            ['second_name', 'string', 'max' => 255],
            ['last_name', 'string', 'max' => 255],
            ['mobile_phone', 'string', 'max' => 255],
            ['city', 'string', 'max' => 255],
            ['street', 'string', 'max' => 255],
            ['zipcode', 'string', 'max' => 255],
            ['house', 'string', 'max' => 255],
            ['stroenie', 'string', 'max' => 255],
            ['korpus', 'string', 'max' => 255],
            ['podyezd', 'string', 'max' => 255],
            ['floor', 'string', 'max' => 255],
            ['apartment', 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

        ];
    }

    public function changeInfo(){
        $user = User::findIdentity(yii::$app->user->id);
        $user->first_name = $this->first_name;
        $user->second_name = $this->second_name;
        $user->last_name = $this->last_name;
        $user->mobile_phone = $this->mobile_phone;
        if (!$user->update()) {
            var_dump($user->getErrors());
        }
        $delivery = DeliveryAddresses::findOne(['user_id' => yii::$app->user->id]);
        $delivery->city = $this->city;
        $delivery->street = $this->street;
        $delivery->zipcode = $this->zipcode;
        $delivery->house = $this->house;
        $delivery->stroenie = $this->stroenie;
        $delivery->korpus = $this->korpus;
        $delivery->podyezd = $this->podyezd;
        $delivery->floor = $this->floor;
        $delivery->apartment = $this->apartment;
        if($delivery->update()){
            return true;
        } else {
            var_dump($delivery->getErrors());
        }
    }
}