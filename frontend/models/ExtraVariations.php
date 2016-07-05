<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "extra_variations".
 *
 * @property integer $id
 * @property string $value
 * @property string $opt_price
 * @property integer $item_id
 * @property integer $rank
 */
class ExtraVariations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'extra_variations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', 'opt_price', 'item_id'], 'required'],
            [['item_id'], 'integer'],
            [['value'], 'string', 'max' => 250],
            [['opt_price'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'opt_price' => 'Opt Price',
            'item_id' => 'Item ID',
        ];
    }

    public static function setValue($item_id, $name_value, $opt_price){
        echo $item_id.$name_value.$opt_price;
        $variant = ExtraVariations::findOne([
            'value' => $name_value,
            'item_id' => $item_id
        ]);

        if($variant != null){
            $variant->opt_price = $opt_price;
        } else {
            $variant = new ExtraVariations();
            $variant->item_id = $item_id;
            $variant->value = $name_value;
            $variant->opt_price = $opt_price;
        }

        if(!$variant->save()){
            echo "Ошибка записи характеристики товара";
            var_dump($variant->getErrors());
        }
    }
}
