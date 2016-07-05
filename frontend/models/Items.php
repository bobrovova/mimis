<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "items".
 *
 * @property integer $id
 * @property string $name
 * @property integer $online
 * @property integer $price
 * @property integer $category_id
 * @property integer $price_opt
 * @property string $article
 * @property string $description
 * @property string $materials
 * @property integer $id_product
 * @property string $color
 * @property integer $color_rank
 */
class Items extends \yii\db\ActiveRecord
{

    public $thumb;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'price', 'category_id', 'article', 'description', 'id_product', 'color', 'color_rank'], 'required'],
            [['online', 'price', 'category_id', 'price_opt', 'id_product', 'color_rank'], 'integer'],
            [['description', 'materials'], 'string'],
            [['name', 'article'], 'string', 'max' => 250],
            [['color'], 'string', 'max' => 30]
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
            'online' => 'Online',
            'price' => 'Price',
            'category_id' => 'Category ID',
            'price_opt' => 'Price Opt',
            'article' => 'Article',
            'description' => 'Description',
            'materials' => 'Materials',
            'id_product' => 'Id Product',
            'color' => 'Color',
            'color_rank' => 'Color Rank',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getImages(){
        return $this->hasMany(ImagesToItems::className(), ['item_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function getMainthumb(){
        return $this->hasMany(ImagesToItems::className(), ['item_id' => 'id'])
            ->where('isThumb = 1');
    }

    /**
     * @inheritdoc
     */
    public function getFields(){
        return $this->hasMany(FieldsValuesToItems::className(), ['item_id' => 'id']);
    }
}
