<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class AddItemToCartForm extends Model {

    public $idItem;
    public $count;
    public $param;

    public function rules(){
        return [
            [['idItem', 'count', 'param'], 'required'],
            [['idItem', 'count', 'param'], 'integer']
        ];
    }
}