<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property string $name_client
 * @property string $phone_client
 * @property string $date
 * @property string $items
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['items'], 'string'],
            [['name_client', 'phone_client'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_client' => 'Name Client',
            'phone_client' => 'Phone Client',
            'date' => 'Date',
            'items' => 'Items',
        ];
    }
}
