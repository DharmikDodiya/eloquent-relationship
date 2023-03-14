<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Stores;
use Illuminate\Http\Request;

class StoresController extends Controller
{
    public function create(Request $request){
        $request->validate([
            'stores_name'                  => 'required|string|max:30',
            'regions_name'                 => 'required|string',
        ]);

        $region = Region::create($request->only('regions_name'));

        $regions  = 1;

        $stores = new Stores();
        $stores->stores_name = $request->input('stores_name');
        $stores->save();
        $stores->regions()->attach(2);


    }
}
