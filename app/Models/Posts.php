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

    public function getCategoryOtherAttribute($value)
    {
        return explode(',', $value);
    }

    public function setCategoryOtherAttribute($value)
    {
        $this->attributes['category_other'] = implode(',', $value)  ? ','.implode(',', $value) .',' : '';
    }


    public function getKeywordAttribute($value)
    {
        return explode(',', $value);
    }

    public function setKeywordAttribute($value)
    {
        $this->attributes['keyword'] = implode(',', $value) ? ','.implode(',', $value) .',' :  '';
    }
}
