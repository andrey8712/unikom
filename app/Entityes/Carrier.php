<?php


namespace App\Entityes;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carrier extends Model
{

    use SoftDeletes;

    protected $guarded = [];

}