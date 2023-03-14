<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    use HasFactory;

    protected $fillable = [
        'stores_name'
    ];

    /**
     * Many To Many Relationship 
     */

    public function regions(){
        return $this->belongsToMany(Region::class,'regions_stores','stores_id','regions_id');
    }
}
