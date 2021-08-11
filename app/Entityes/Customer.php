<?php


namespace App\Entityes;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Customer
 * @package App\Entityes
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $inn
 * @property string $ogrn
 * @property string $address
 * @property string $price_limit
 * @property string $phone
 * @property string $email
 * @property string $comment
 */
class Customer extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function addresses()
    {
        return $this->hasMany(Address::class, 'customer_id', 'id');
    }

}