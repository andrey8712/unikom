<?php


namespace App\Entityes;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    use SoftDeletes;

    const STATUS_NEW = 1;
    const STATUS_DRIVER = 2;
    const STATUS_DELIVERY = 3;
    const STATUS_COMPLETE = 4;
    const STATUS_PAYMENT = 5;

    public $table = 'deliveries';

    public $guarded = [];

    protected $dates = ['desired_date'];

    public function carrier()
    {
        return $this->hasOne(Carrier::class, 'id', 'carrier_id');
    }

    public function driver()
    {
        return $this->hasOne(Driver::class, 'id', 'driver_id');
    }

    public function car()
    {
        return $this->hasOne(Car::class, 'id', 'car_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function products()
    {
        return $this->hasMany(DeliveryProducts::class, 'delivery_id', 'id');
    }

    public function getStatuses()
    {
        $statuses = [
            //self::STATUS_NEW => 'Новая',
            //self::STATUS_DRIVER => 'Водитель назначен',
            self::STATUS_DELIVERY => 'Отгружена',
            self::STATUS_COMPLETE => 'Доставлена',
            self::STATUS_PAYMENT => 'Оплачена'
        ];

        $out = [];

        foreach ($statuses as $i => $status) {
            if($this->current_status < $i) $out[$i] = $status;
        }

        return $out;
    }

    public function getStatusBadge()
    {
        if($this->current_status == self::STATUS_NEW) {
            return '<span class="badge badge-danger">Новая</span>';
        } elseif($this->current_status == self::STATUS_DRIVER) {
            return '<span class="badge badge-light">Водитель назначен</span>';
        } elseif($this->current_status == self::STATUS_DELIVERY) {
            return '<span class="badge badge-info">Отгружена</span>';
        } elseif($this->current_status == self::STATUS_COMPLETE) {
            return '<span class="badge badge-secondary">Доставлена</span>';
        } elseif($this->current_status == self::STATUS_PAYMENT) {
            return '<span class="badge badge-success">Оплачена</span>';
        }
    }
}