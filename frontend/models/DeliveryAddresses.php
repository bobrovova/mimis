<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "delivery_addresses".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $city
 * @property string $street
 * @property string $zipcode
 * @property string $house
 * @property string $stroenie
 * @property string $korpus
 * @property string $podyezd
 * @property string $floor
 * @property string $apartment
 */
class DeliveryAddresses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'delivery_addresses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['city', 'street', 'zipcode', 'house', 'stroenie', 'korpus', 'podyezd', 'floor', 'apartment'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'city' => 'City',
            'street' => 'Street',
            'zipcode' => 'Zipcode',
            'house' => 'House',
            'stroenie' => 'Stroenie',
            'korpus' => 'Korpus',
            'podyezd' => 'Podyezd',
            'floor' => 'Floor',
            'apartment' => 'Apartment',
        ];
    }
}
