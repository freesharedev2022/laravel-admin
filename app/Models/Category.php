<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';
    public $timestamps = true;

    public static function boot()
    {
        parent::boot();
        static::creating(function (Category $item){
            $item->slug = to_slug($item->name);
        });
    }

    public function listCate()
    {
        $list = [];
        $result = $this->select('name', 'id', 'parent_id')
            ->where('parent_id', null)
            ->where('type', "cate")
            ->get()
            ->toArray();
        foreach ($result as $value) {
            $list[$value['id']] = $value['name'];
            $this->listCateExceptRoot($value['id'], $list);
        }
        return $list;
    }
    public function listCateExceptRoot($id, &$list, $st = '--')
    {
        $result = $this->select('name', 'id', 'parent_id')
            ->where('parent_id', $id)
            ->get()
            ->toArray();
        foreach ($result as $value) {
            $list[$value['id']] = $st . ' ' . $value['name'];
            $this->listCateExceptRoot($value['id'], $list, $st . '--');
        }

    }
}
