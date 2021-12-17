<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Funtap extends Model
{
    protected $fillable = ['id', 'title_element', 'image_url', 'id_token', 'content', 'subtitle','created_at','updated_at'];
    use SoftDeletes;
}
