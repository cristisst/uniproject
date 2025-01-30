<?php

namespace App\Models;

use App\Core\Database\Model;

class Category extends Model
{
    protected  $table = 'categories';

    protected $fillable = [
        'name'
    ];
}