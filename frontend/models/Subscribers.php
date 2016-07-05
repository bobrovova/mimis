<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subscribers".
 *
 * @property integer $id
 * @property string $email
 * @property string $datetime
 */
class Subscribers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subscribers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['datetime'], 'safe'],
            [['email'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'datetime' => 'Datetime',
        ];
    }
}
