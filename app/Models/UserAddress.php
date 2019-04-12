<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'province',
        'city',
        'district',
        'address',
        'zip',
        'contact_name',
        'contact_phone',
        'last_used_at',
    ];
    protected $dates = ['last_used_at'];

    public function user()
    {
        return $this->belongsTo(User::class);  //ORM 连表  关联一对多 一个用户可以有多个收货地址,一个收货地址只对应一个用户
    }

    public function getFullAddressAttribute()  //获取完整的地址属性
    {
        return "{$this->province}{$this->city}{$this->district}{$this->address}";  // 创建了一个访问器，在之后的代码里可以直接通过 $address->full_address 来获取完整的地址，而不用每次都去拼接。
    }
}
