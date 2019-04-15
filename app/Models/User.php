<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);  //1对多  1个用户对应多个收货地址
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * belongsToMany() 方法用于定义一个多对多的关联，第一个参数是关联的模型类名，第二个参数是中间表的表名。
       withTimestamps() 代表中间表带有时间戳字段。
       orderBy('user_favorite_products.created_at', 'desc') 代表默认的排序方式是根据中间表的创建时间倒序排序。
     */
    public function favoriteProducts()
    {
        return $this->belongsToMany(Product::class, 'user_favorite_products')
            ->withTimestamps()
            ->orderBy('user_favorite_products.created_at', 'desc');
    }

    /**
     * 购物车
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
