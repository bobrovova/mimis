<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'parent_id'], 'required'],
            [['parent_id'], 'integer'],
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
            'name' => 'Name',
            'parent_id' => 'Parent ID',
            'left_key' => 'Left key',
            'right_key' => 'right_key',
            'level' => 'level'
        ];
    }

    public static function getCategoryByName($name){
        return Category::findOne([
            'name' => $name
        ]);
    }
}
