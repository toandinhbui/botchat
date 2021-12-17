<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Title extends Model
{
    protected $fillable = ['id', 'title', 'url', 'id_dad', 'id_funtap', 'created_at', 'updated_at'];
    use SoftDeletes;
}
