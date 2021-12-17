<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Botchat extends Model
{
    protected $fillable = ['id', 'chat', 'time', 'id_page', 'id_user', 'created_at', 'updated_at'];
    use SoftDeletes;
}
