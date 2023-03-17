<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Stores;
use Illuminate\Http\Request;
use App\Traits\ResponseMessage;
use Illuminate\Support\Facades\Validator; 

class RegionController extends Controller
{
    use ResponseMessage;

    public function create(Request $request){
        $request->validate([
            'regions_name'                 => 'required|string|max:30|unique:regions,regions_name',
        ]);

        $region = Region::create($request->only('regions_name'));

        return $this->success('regions created successfully');
    }

    public function update(Request $request ,Region $id){
        $request->validate([
            'regions_name'                  => 'required|string|max:30',
        ]);
            $id->update($request->only('regions_name'));
            return $this->success('Updated Region',$id);
        
    }

    public function list(){
        $region = Region::all();
        return $this->success('list region',$region);
    }

    public function destory($id){
        $region = Region::findOrFail($id);
            $region->stores()->detach();
            $region->delete();
            return $this->success('Region Deleted Successfuly');
        
    }

    public function get($id){
        $region = Region::with('stores')->findOrFail($id);
        return $this->success('region detail',$region);
    }


}
