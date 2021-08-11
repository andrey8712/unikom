<?php


namespace App\Entityes;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Product
 * @package App\Entityes
 *
 * @property int $id
 * @property string $title
 * @property int $variant_price_1
 * @property int $variant_price_2
 * @property int $variant_price_3
 * @property int $variant_price_4
 * @property int $variant_price_5
 */
class Product extends Model
{
    use SoftDeletes;

    protected $guarded = [];

}