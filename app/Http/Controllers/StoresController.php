<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Stores;
use Illuminate\Http\Request;
use App\Traits\ResponseMessage;


class StoresController extends Controller
{
    use ResponseMessage;
    public function create(Request $request){
        $request->validate([
            'stores_name'                  => 'required|string|max:30|unique:stores,stores_name',
            'regions_id'                   => 'required|exists:regions,id'
        ]);
        
        $regions_ids = $request->regions_id;
        $stores = new Stores();
        $stores->stores_name = $request->input('stores_name');
        $stores->save();
        $stores->regions()->attach($regions_ids);

        return $this->success('stores created successfully',$stores);
    }

    public function list(){
        $stores = Stores::all();
        return $this->success('list stores',$stores);
    }

    public function destory($id){
        $stores = Stores::findOrFail($id);
            $stores->regions()->detach();
            $stores->delete();
            return $this->success('stores deleted successfully');
    }

    public function update(Request $request,Stores $id){
        $request->validate([
            'stores_name'                  => 'required|string|max:30',
            'regions_id'                   => 'required|exists:regions,id'
        ]);
            $regions_ids = $request->regions_id;
            $id->update($request->only('stores_name'));
            $id->regions()->sync($regions_ids);
            return $this->success('Updated stores',$id);
        }

    public function get($id){
        $stores = Stores::findOrFail($id);
            $stores->regions;
            return $this->success('stores Details',$stores); 
        
    }
}
