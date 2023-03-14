<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable =[
        'supplier_name'
    ];
    public function orders(){
        return $this->hasOneThrough(Order::class,Product::class,'supplier_id','product_id','id','id');
    }
}
