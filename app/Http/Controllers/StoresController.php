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

        if(is_null($stores)){
            return $this->DataNotFound();
        }
        return $this->success('list stores',$stores);
    }

    public function destory($id){
        $stores = Stores::find($id);
        
        if(is_null($stores)){
            return $this->DataNotFound();
        }
            $stores->delete();
            $stores->regions()->detach();
            return $this->success('stores deleted successfully');
    }

    public function update(Request $request,Stores $id){
        $validatedata = Validator::make($request->all(), [
            'stores_name'                  => 'required|string|max:30',
            'regions_id'                   => 'required|exists:regions,id'
        ]);
    
        if($validatedata->fails()){
            return $this->ErrorResponse($validatedata);  
        }
        else{
            $regions_ids = $request->regions_id;
            $id->update($request->only('stores_name'));
            $id->regions()->sync($regions_ids);
            return $this->success('Updated stores',$id);
        }
    }

    public function get($id){
        $stores = Stores::find($id);
        if(is_null($stores)){
            return $this->DataNotFound();
        }
        else{
            $stores->regions;
            return $this->success('stores Details',$stores); 
        }
    }
}
