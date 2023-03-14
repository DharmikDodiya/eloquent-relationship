<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Traits\ResponseMessage;

class SupplierController extends Controller
{
    use ResponseMessage;
    public function create(Request $request){
        $request->validate([
            'supplier_name'         => 'required|string|max:30',
            'product_name'                 => 'required|string|max:30',
            'order_name'              => 'required|string|max:30',
        ]);


        $user = Supplier::create($request->only('supplier_name'));
        $supplier = Supplier::where('supplier_name',$request->supplier_name)->first();
       
        $product = Product::create([
            'product_name'      => $request->product_name,
            'supplier_id'       => $supplier->id
        ]);

        $product = Product::where('product_name',$product->product_name)->first();

        $order = Order::create([
            'order_name'              => $request->order_name,
            'product_id'              => $product->id
        ]);
        
        return $this->success('data inserted successfully',$user,$product ,$order);//changes
    }

    


    public function get($id){
        $supplier = Supplier::with('orders')->find($id);

        if(is_null($supplier)){
            return $this->DataNotFound();
        }
        return $this->success('suppliers all data',$supplier);
    }

    public function destory($id){
        $supplier = Supplier::find($id);

        if(is_null($supplier)){
            return $this->DataNotFound();
        }
        $supplier->delete();
        return $this->success('supplier deleted successfully');
    }

    public function list(){
        $supplier = Supplier::all();

        if(is_null($supplier)){
            return $this->DataNotFound();
        }
        return $this->success('suppliers details',$supplier);
    }
}
