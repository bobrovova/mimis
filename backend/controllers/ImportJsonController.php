<?php
/**
 * Created by PhpStorm.
 * User: vladimir
 * Date: 22.04.17
 * Time: 21:28
 */

namespace backend\controllers;

/**
 * Class Import1cController
 * Import from json file
 * @package backend\controllers
 */
class ImportJsonController extends ImportController
{

    public function import ($stream)
    {
        $results = [];
        $content = file_get_contents($stream);
        if (substr($content, 0, 3) == "\xef\xbb\xbf") {
            $content = substr($content, 3);
        }
        $json = json_decode($content);
        if($json != null){
            $numberProducts = $json->count;
            for($i = 0; $i < $numberProducts; $i++){
                $nameProduct = "product".($i+1);
                $product = $json->$nameProduct;
                $results[] = [
                    "name" => $product->name,
                    "result" => $this->importProduct($product)
                ];
            }
            return $results;
        } else {
            switch (json_last_error()) {
                case JSON_ERROR_DEPTH:
                    throw new Exception(' - Достигнута максимальная глубина стека');
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    throw new Exception(' - Некорректные разряды или не совпадение режимов');
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    throw new Exception(' - Некорректный управляющий символ');
                    break;
                case JSON_ERROR_SYNTAX:
                    throw new Exception(' - Синтаксическая ошибка, не корректный JSON');
                    break;
                case JSON_ERROR_UTF8:
                    throw new Exception(' - Некорректные символы UTF-8, возможно неверная кодировка');
                    break;
                default:
                    throw new Exception(' - Неизвестная ошибка');
                    break;
            }
        }
    }
}