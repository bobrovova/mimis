<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "values".
 *
 * @property integer $id
 * @property integer $field_id
 * @property string $name
 */
class Values extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'values';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['field_id', 'name'], 'required'],
            [['field_id'], 'integer'],
            [['name'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'field_id' => 'Field ID',
            'name' => 'Name',
        ];
    }
}
