<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'regions_name'
    ];
    /**
     * Many To Many Relationship on Region
     */
    public function stores(){
        return $this->belongsToMany(Stores::class,'regions_stores','regions_id','stores_id');
    }
}
