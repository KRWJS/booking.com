<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

	public $timestamps = false;

    protected $table = 'country';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'short',
        'country',
        'country_cn',
    ];




}
