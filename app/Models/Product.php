<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'title', 'description', 'image', 'on_sale',
        'rating', 'sold_count', 'review_count', 'price'
    ];

    protected $casts = [
      'on_sale' => 'boolean'  //on_sale 是一个布尔类型的字段
    ];

    //与商品sku关联
    public function skus()
    {
        return $this->hasMany(ProductSku::class); //1对多关联
    }

    /**
     * 图片URL获取
     * // 如果 image 字段本身就已经是完整的 url 就直接返回
     * 这里 \Storage::disk('public') 的参数 public 需要和我们在 config/admin.php 里面的 upload.disk 配置一致。
     */
    public function getImageUrlAttribute()
    {
        if (Str::startsWith($this->attributes['image'], ['http://', 'https://'])){
            return $this->attributes['image'];
        }
        return Storage::disk('public')->url($this->attributes['image']);
    }
}
