<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fields_to_category".
 *
 * @property integer $field_id
 * @property integer $category_id
 */
class FieldsToCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fields_to_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['field_id', 'category_id'], 'required'],
            [['field_id', 'category_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'field_id' => 'Field ID',
            'category_id' => 'Category ID',
        ];
    }

    public static function getAllCategoriesInBranch($category_id){
        //echo $category_id;
        $categories = Category::findAll(['parent_id'=>$category_id]);
        //echo var_dump($categories);
        if(empty($categories)){
           return [$category_id];
        }
        $tmpCategories = [];
        foreach($categories as $cat){
            if(null != ($newCats = FieldsToCategory::getAllCategoriesInBranch($cat->getAttribute('id')))){
                foreach($newCats as $obj){
                    $tmpCategories[] = $obj;
                }
            }
            $tmpCategories[] = $cat->getAttribute('id');
        }
        //die();
        return $tmpCategories;
    }
}
