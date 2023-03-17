<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Traits\ResponseMessage;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    use ResponseMessage;
    public function create(Request $request){
        $request->validate([
            'supplier_name'         => 'required|string|max:30',
        ]);

        $supplier = Supplier::create($request->only('supplier_name'));
        return $this->success('supplier inserted successfully',$supplier);//changes
    }

    public function update(Request $request,Supplier $id){
        $validatedata = Validator::make($request->all(), [
            'supplier_name'                  => 'required|string|max:30',
        ]);

        if($validatedata->fails()){
            return $this->ErrorResponse($validatedata);  
        }
        else{
            $id->update($request->only('supplier_name'));
            return $this->success('Updated supplier',$id);
        }
    }

    public function get($id){
        $supplier = Supplier::with('orders')->findOrFail($id);
        return $this->success('suppliers all data',$supplier);
    }

    public function destory($id){
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return $this->success('supplier deleted successfully');
    }

    public function list(){
        $supplier = Supplier::all();
        return $this->success('suppliers details',$supplier);
    }
}
