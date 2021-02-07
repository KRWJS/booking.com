<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{

	public $timestamps = false;

    protected $table = 'city';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country',
        'city',
        'city_cn',
    ];


}
