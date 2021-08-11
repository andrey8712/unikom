<?php


namespace App\Entityes;


use Illuminate\Database\Eloquent\Model;

class DeliveryProducts extends Model
{

    protected $table = 'delivery_products';

    protected $guarded = [];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

}