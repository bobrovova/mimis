<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cart".
 *
 * @property integer $item_id
 * @property integer $param
 * @property integer $price
 * @property integer $count
 * @property integer $user_id
 * @property string $session_id
 * @property integer $id
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cart';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'param', 'price', 'count', 'user_id'], 'integer'],
            [['session_id'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_id' => 'Item ID',
            'param' => 'Param',
            'price' => 'Price',
            'count' => 'Count',
            'user_id' => 'User ID',
            'session_id' => 'Session ID',
            'id' => 'ID',
        ];
    }

    /**
     * Return content of cart by user id
     *
     * @return array|bool
     */
    public function getInfoByUser(){
        $connection = \Yii::$app->db;
        $sql = "SELECT SUM((c.price * c.count)) as 'Sum', COUNT(*) as 'Count' FROM `cart` c WHERE user_id = ".yii::$app->user->id;
        $model = $connection->createCommand($sql);
        $result = $model->queryOne();
        return $result;
    }

    /**
     * Return content of cart by session id
     *
     * @return array|bool|null
     */
    public function getInfoBySession(){
        if(!empty($_COOKIE["crtss"])) {
            $connection = \Yii::$app->db;
            $sql = "SELECT SUM((c.price * c.count)) as 'Sum', COUNT(*) as 'Count' FROM `cart` c WHERE session_id = '" . $_COOKIE["crtss"] . "'";
            $model = $connection->createCommand($sql);
            $result = $model->queryOne();
            return $result;
        } else {
            return null;
        }
    }

    /**
     * Translate numbers to words
     *
     * @param $num
     * @param $words
     * @return mixed
     */
    public function num2word($num,$words) {
        $num=$num%100;
        if ($num>19) { $num=$num%10; }
        switch ($num) {
            case 1:  { return($words[0]); }
            case 2: case 3: case 4:  { return($words[1]); }
            default: { return($words[2]); }
        }
    }
}
