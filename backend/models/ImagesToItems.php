<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "images_to_items".
 *
 * @property integer $id
 * @property string $small_image
 * @property string $big_image
 * @property integer $item_id
 * @property integer $rank
 */
class ImagesToItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images_to_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['small_image', 'big_image', 'item_id', 'rank'], 'required'],
            [['item_id', 'rank'], 'integer'],
            [['small_image', 'big_image'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'small_image' => 'Small Image',
            'big_image' => 'Big Image',
            'item_id' => 'Item ID',
            'rank' => 'Rank',
        ];
    }
}
