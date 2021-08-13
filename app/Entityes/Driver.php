<?php


namespace App\Entityes;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{

    use SoftDeletes;

    protected $guarded = [];

    protected $dates = ['passport_date_of_issue'];

    public function getShortFio()
    {
        return $this->surname . ' ' . mb_substr($this->name, 0, 1) . '. ' . mb_substr($this->middle_name, 0, 1) . '. ';
    }

}