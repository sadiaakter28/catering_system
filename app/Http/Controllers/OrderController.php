<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Package;
use App\Models\OrderDetails;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        //dd($request->all());
        try{
            $this->validate($request,[
                'user_id'=> 'required',
                'shipping_name'=> 'required',
                'shipping_phone'=> 'required',
                'shipping_address'=> 'required',
                'total'=> 'required',
                'from_date'=> 'required',
                'to_date'=> 'required',
                'status'=> 'required',
            ]);
        }
        catch (ValidationException $e) {
            return response()->json([
                'Success' => False,
                'Message'=> $e->getMessage(),
            ]);
        }

        try{
            $orders=Order::create([
                'user_id'=>$request->user_id,
                'shipping_name'=>$request->shipping_name,
                'shipping_phone'=>$request->shipping_phone, 
                'shipping_address'=>$request->shipping_address,
                'total'=>$request->total,
                'from_date'=>$request->from_date, 
                'to_date'=>$request->to_date,
                'status'=>$request->status, 
            ]);

             $packageId =($request->input('package'));
             //dd($packageId);
                foreach ($packageId as $package){
                    $data=Package::where('id',$package['package_id'])->first();
                   // dd($data);
                     // dd($package);
                OrderDetails::create([
                    'package_id' => $package['package_id'],
                    'order_id' => $orders->id,
                    'quantity' => $package['quantity'],
                    'price' => $data->price,
                ]);
            }
            return response()->json([
                'Success'=>True,
                'Message'=>'Order Created Successfully',
                'data'=>$orders
            ]);
        }
        catch (\PDOException $e) {
            return response()->json([
                'Success' => False,
                'Message'=> $e->getMessage(),
            ]);
        }
    
    }


    //Show Item List
    public function index()
    {
        $orders=Order::all();
        return response()->json($orders);
    }

    //Show One Item
    public function show($id)
    {
        $orders=Order::where('id',$id)->with('orderDetails')->first();
        return response()->json($orders);
    }


    //Update
    public function update(Request $request,$id)
    {
        //Validation
        // dd($request->all());
        try{
            $this->validate($request,[
                'user_id'=> 'required',
                'shipping_name'=> 'required',
                'shipping_phone'=> 'required',
                'shipping_address'=> 'required',
                'total'=> 'required',
                'from_date'=> 'required',
                'to_date'=> 'required',
                'status'=> 'required',
            ]);
        }
        catch (ValidationException $e) {
            return response()->json([
                'Success' => False,
                'Message'=> $e->getMessage(),
            ]);
        }

        //Create
        try{
            Order::where('id', $id)->update([
                'user_id'=>$request->user_id,
                'shipping_name'=>$request->shipping_name,
                'shipping_phone'=>$request->shipping_phone, 
                'shipping_address'=>$request->shipping_address,
                'total'=>$request->total,
                'from_date'=>$request->from_date, 
                'to_date'=>$request->to_date,
                'status'=>$request->status,    
            ]);

            $orders=Order::find($id);

            return response()->json([
                'Success'=>True,
                'Message'=>'Order Updated Successfully',
                'data'=>$orders
            ]);
        }
        catch (\PDOException $e) {
            return response()->json([
                'Success' => False,
                'Message'=> $e->getMessage(),
            ]);
        }
    }


    //Delete Item 
    public function destroy($id)
    {
        try{
            Order::find($id)->delete();
            $list = Order::all();

            return response()->json([
                'Success'=>True,
                'Message'=>'Order Deleted Successfully',
                'data'=>$list
            ]);

        }
        catch (\PDOException $e) {
            return response()->json([
                'Success' => False,
                'Message'=> $e->getMessage(),
            ]);

        }

    }
}
