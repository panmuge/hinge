<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/30
 * Time: 21:19
 */

namespace app\api\controller\v1;

use app\api\model\Product as ProductModel;
use app\api\validate\Count;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ProductException;

class Product
{
    public function getRecent($count=20){
        (new Count())->goCheck();
        $product = ProductModel::getMostRecent($count);
        if(empty($product)){
            throw new ProductException();
        }
        return json($product);
    }

    public function getAllInCategory($id){
        (new IDMustBePositiveInt())->goCheck();
        $products = ProductModel::getProductByCategoryID($id);
        if(empty($products)){
            throw new ProductException();
        }
        return json($products);
    }

    public function getOne($id){
        (new IDMustBePositiveInt())->goCheck();
        $product = ProductModel::getProductDetail($id);
        if(empty($product)){
            throw new ProductException();
        }
        return json($product);
    }
}