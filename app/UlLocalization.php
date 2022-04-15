<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UlLocalization extends Model
{
    Use SoftDeletes;

    protected $fillable = [
        'key', 'english', 'brazilian', 'old_english', 'old_brazilian', 'verificado'
    ];

}
