<?php


namespace App\Entityes;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Order
 * @package App\Entityes
 *
 *
 * @property OrderProduct[] $products
 * @property Delivery[] $deliveries
 */
class Order extends Model
{

    use SoftDeletes;

    const PAYMENT_NOT = 0;
    const PAYMENT_YES = 1;

    protected $table = 'orders';

    protected $dates = ['desired_date'];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'order_id', 'id');
    }

    public function productsWithDeliveries()
    {
        $out = [];

        if(!$products = $this->products) {
            return $out;
        }

        $deliveriesId = [];

        foreach ($this->deliveries as $delivery) {
            $deliveriesId[] = $delivery->id;
        }

        foreach ($products as $product) {

            $delivery = DeliveryProducts::whereIn('delivery_id', $deliveriesId)->where('product_id', $product->product_id)->get();
            //dd($delivery->sum('product_count'));
            $out[] = [
                'title' => $product->product->title,
                'count' => $product->count,
                'delivery_count' => $delivery ? $delivery->count() : 0,
                'delivery_product_count' => $delivery ? $delivery->sum('product_count') : 0
            ];

        }

        return $out;
    }

}