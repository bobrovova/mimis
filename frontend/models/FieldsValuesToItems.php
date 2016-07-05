<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fields_values_to_items".
 *
 * @property integer $item_id
 * @property integer $value_id
 */
class FieldsValuesToItems extends \yii\db\ActiveRecord
{
    public $value_name;
    public $field_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fields_values_to_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'value_id'], 'required'],
            [['item_id', 'value_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_id' => 'Item ID',
            'value_id' => 'Value ID',
        ];
    }
}
