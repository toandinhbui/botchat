<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Access_token extends Model
{
    protected $fillable = ['id', 'name', 'id_page', 'token','created_at','updated_at'];
    use SoftDeletes;
}
