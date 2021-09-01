<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use \Illuminate\Foundation\Auth\User;
class Order extends Model{
    use HasFactory;
    protected $table = "orders";
    public function user(){
        return $this->belongsTo(User::class,'id');
    }
    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }
    public function shipping(){
        return $this->hasOne(Shipping::class,'orderId');
    }
    public function transaction(){
        return $this->hasOne(Transaction::class,'orderId');
    }
}
