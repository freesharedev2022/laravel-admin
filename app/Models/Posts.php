<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;
    protected $table = 'posts';
    public $timestamps = true;

    public static function boot()
    {
        parent::boot();
        static::creating(function (Posts $item){
            $item->slug = to_slug($item->title);
        });
    }
}
