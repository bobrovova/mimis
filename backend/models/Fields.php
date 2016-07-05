<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fields".
 *
 * @property integer $id
 * @property string $name
 * @property string $type
 */
class Fields extends \yii\db\ActiveRecord
{
    public $categories;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fields';
    }

    public static function findOneWithAll($id){
        $model = Fields::findOne($id);
        if($model == null){
            return null;
        }

        $categories = [];
        $k = FieldsToCategory::findAll(['field_id' => $model->id]);
        foreach($k as $obj){
            $categories[] = $obj->getAttributes(['category_id'])['category_id'];
        }
        $model->categories = $categories;
        return $model;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type'], 'string'],
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
            'type' => 'Type',
        ];
    }
}
