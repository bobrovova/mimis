<?php

namespace app\models;

use Yii;
use yii\base\Exception;

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
 */
class Items extends \yii\db\ActiveRecord
{
    public $number_imgs;

    public function getImages(){
        return $this->hasMany(ImagesToItems::className(), ['item_id' => 'id']);
    }

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
            [['name', 'price', 'category_id', 'article', 'description'], 'required'],
            [['online', 'price', 'category_id', 'price_opt', 'color_rank', 'id_product'], 'integer'],
            [['description', 'materials', 'color'], 'string'],
            [['name', 'article'], 'string', 'max' => 250]
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
            'color' => 'Color',
            'color_rank' => 'Color order',
            'id_product' => 'id product'
        ];
    }

    public static function getNextIdProduct(){
        $sql = "SELECT MAX(id_product) as id_product FROM items";
        return Items::findBySql($sql)->one()->id_product + 1;
    }
    

    /**
     * @inheritdoc
     */
    public function getMainthumb(){
        return $this->hasMany(ImagesToItems::className(), ['item_id' => 'id'])
            ->where('isThumb = 1');
    }


    public static function loadProductFrom1c($product){
        $sqlProduct = "SELECT id FROM items WHERE article = '".$product->article."'";
        if(($item = Items::findBySql($sqlProduct)->one()) != null){
            $item->name = $product->name;
            $item->price = (int) $product->price;
            $item->price_opt = (int) $product->price;
            $item->article = $product->article;
            $item->description = $product->description;
            $item->online = 1;
            $item->materials = '';
            $category = Category::getCategoryByName($product->category);
            if($category != null){
                $item->category_id = $category->id;
            } else {
                throw new Exception("Неправильное название категории!");
            }
            if(empty($product->sizecolor) && empty($product->size)){
                if(!$item->save()){
                    var_dump($item->getErrors());
                } else {
                    echo "Продукт ".$product->article." сохранен";
                }
            } else if(!empty($product->size)){
                if(!$item->save()){
                    var_dump($item->getErrors());
                } else {
                    $sizes = json_decode(json_encode($product->size), true);
                    $i = 0;
                    foreach($sizes as $size_key => $size_params){
                        ExtraVariations::setValue($item->id, $size_key, $size_params['price_opt'], $i);
                        $i++;
                    }
                    echo "Продукт ".$product->article." и его размеры сохранены";
                }
            } else if(!empty($product->sizecolor)){
                $sizecolors = json_decode(json_encode($product->sizecolor), true);
                $rank = 0;
                foreach($sizecolors as $color_title => $color_params){
                    $clone = new Items();
                    $clone->attributes = $item->attributes;
                    $clone->color = $color_title;
                    $clone->color_rank = $rank;
                    if(!$clone->save()){
                        var_dump($clone->getErrors());
                    } else {
                        $i = 0;
                        foreach($color_params as $size_key => $size_params){
                            ExtraVariations::setValue($clone->id, $size_key, $size_params['price_opt'], $i);
                            $i++;
                        }
                        echo "Продукт ".$product->article." и его размеры сохранены";
                    }
                    $rank++;
                }
            }
        } else {
            $newItem = new Items();
            $newItem->name = $product->name;
            $newItem->price = (int) $product->price;
            $newItem->price_opt = (int) $product->price;
            $newItem->article = $product->article;
            $newItem->description = $product->description;
            $newItem->online = 1;
            $newItem->materials = '';
            $nextIdProduct = Items::getNextIdProduct();
            $category = Category::getCategoryByName($product->category);
            if($category != null){
                $newItem->category_id = $category->id;
            } else {
                throw new Exception("Неправильное название категории!");
            }
            $newItem->id_product = $nextIdProduct;
            if(empty($product->sizecolor) && empty($product->size)){
                if(!$newItem->save()){
                    var_dump($newItem->getErrors());
                } else {
                    echo "Продукт ".$product->article." сохранен";
                }
            } else if(!empty($product->size)){
                if(!$newItem->save()){
                    var_dump($newItem->getErrors());
                } else {
                    $sizes = json_decode(json_encode($product->size), true);
                    $i = 0;
                    foreach($sizes as $size_key => $size_params){
                        ExtraVariations::setValue($newItem->id, $size_key, $size_params['price_opt'], $i);
                        $i++;
                    }
                    echo "Продукт ".$product->article." и его размеры сохранены";
                }
            } else if(!empty($product->sizecolor)){
                $sizecolors = json_decode(json_encode($product->sizecolor), true);
                $rank = 0;
                foreach($sizecolors as $color_title => $color_params){
                    $clone = new Items();
                    $clone->attributes = $newItem->attributes;
                    $clone->color = $color_title;
                    $clone->color_rank = $rank;
                    if(!$clone->save()){
                        var_dump($clone->getErrors());
                    } else {
                        $i = 0;
                        foreach($color_params as $size_key => $size_params){
                            ExtraVariations::setValue($clone->id, $size_key, $size_params['price_opt'], $i);
                            $i++;
                        }
                        echo "Продукт ".$product->article." и его размеры сохранены";
                    }
                    $rank++;
                }
            }
        }
    }
}
