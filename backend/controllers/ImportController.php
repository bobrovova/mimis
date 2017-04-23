<?php
/**
 * Created by PhpStorm.
 * User: vladimir
 * Date: 22.04.17
 * Time: 21:24
 */

namespace backend\controllers;
use app\models\ExtraVariations;
use app\models\Items;
use app\models\Category;
use yii\base\Exception;

/**
 * Class ImportController
 * Abstract Class for all methods of import
 * @package backend\controllers
 */
abstract class ImportController
{
    abstract public function import($stream);

    public function importProduct($product){
        if(($item = Items::find()->where(['article'=>$product->article])->one()) != null){
            return $this->importExistProduct($item, $product);
        } else {
            return $this->importNewProduct($product);
        }
    }

    public function importNewProduct($product){
        $newItem = new Items();
        $newItem->name = $product->name;
        $newItem->price = intval($product->price);
        $newItem->price_opt = intval($product->price);
        $newItem->article = $product->article;
        if (empty($product->description)){
            $product->description = "Нет описания";
        }
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
                return $newItem->getErrors();
            } else {
                return true;
            }
        } else if(!empty($product->size)){
            if(!$newItem->save()){
                return $newItem->getErrors();
            } else {
                $sizes = json_decode(json_encode($product->size), true);
                $i = 0;
                foreach($sizes as $size_key => $size_params){
                    ExtraVariations::setValue($newItem->id, $size_key, $size_params['price_opt'], $i);
                    $i++;
                }
                return true;
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
                    return $clone->getErrors();
                } else {
                    $i = 0;
                    foreach($color_params as $size_key => $size_params){
                        ExtraVariations::setValue($clone->id, $size_key, $size_params['price_opt'], $i);
                        $i++;
                    }
                    return true;
                }
                $rank++;
            }
        }
    }

    public function importExistProduct($item, $product){
        $item->name = $product->name;
        $item->price = intval($product->price);
        $item->price_opt = intval($product->price);
        $item->article = $product->article;
        if (empty($product->description)){
            $product->description = "Нет описания";
        }
        $item->description = $product->description;
        $item->online = 1;
        $item->materials = '';
        $category = Category::getCategoryByName($product->category);
        if($category != null){
            $item->category_id = $category->id;
        } else {
            return "Неправильное название категории!";
        }
        if(empty($product->sizecolor) && empty($product->size)){
            if(!$item->save()){
                return $item->getErrors();
            } else {
                return true;
            }
        } else if(!empty($product->size)){
            if(!$item->save()){
                return $item->getErrors();
            } else {
                $sizes = json_decode(json_encode($product->size), true);
                $i = 0;
                ExtraVariations::deleteAll(["item_id" => $item->id]);
                foreach($sizes as $size_key => $size_params){
                    ExtraVariations::setValue($item->id, $size_key, $size_params['price_opt'], $i);
                    $i++;
                }
                return true;
            }
        } else if(!empty($product->sizecolor)){
            $sizecolors = json_decode(json_encode($product->sizecolor), true);
            $rank = 0;
            $except_id = [];
            foreach($sizecolors as $color_title => $color_params){
                if(($clone = Items::find()->where(['article' => $item->article, 'color' => $color_title])->one()) == null) {
                    $clone = new Items();
                } else {
                    $except_id[] = $clone->id;
                }
                $clone->attributes = $item->attributes;
                $clone->color = $color_title;
                $clone->color_rank = $rank;
                if(!$clone->save()){
                    return $clone->getErrors();
                } else {
                    $i = 0;
                    ExtraVariations::deleteAll(["item_id" => $clone->id]);
                    foreach($color_params as $size_key => $size_params){
                        ExtraVariations::setValue($clone->id, $size_key, $size_params['price_opt'], $i);
                        $i++;
                    }
                    return true;
                }
                $rank++;
            }
            Items::deleteAll(['AND', 'id_product = :id_product', ['NOT IN', 'id', $except_id]], [':id_product'=>$item->id_product]);
        }
    }
}