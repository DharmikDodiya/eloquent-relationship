<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_name',
        'product_id'
    ];
    
    public function supplier(){
        return $this->hasOneThrough(Supplier::class,Product::class,'supplier_id','id','product_id','id');    
    }
}
