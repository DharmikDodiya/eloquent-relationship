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
        return $this->hasManyThrough(Supplier::class,Product::class,'supplier_id','id','id');    
    }
}
