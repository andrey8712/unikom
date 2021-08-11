<?php


namespace App\Entityes;


use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderProduct
 * @package App\Entityes
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $self_price
 * @property integer $customer_price
 * @property integer $count
 *
 * @property Product $product
 */
class OrderProduct extends Model
{

    protected $table = 'order_products';

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

}