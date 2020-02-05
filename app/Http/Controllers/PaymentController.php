<?php

namespace App\Http\Controllers;
use App\Models\Payment;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->all());
        try{
            $this->validate($request,[
                'transaction_id'=> 'required',
                'user_id'=> 'required',
                'type'=> 'required',
                'status'=> 'required',
                'received_amount'=> 'required',
                'sent_from'=> 'required',
            ]);
        }
        catch (ValidationException $e) {
            return response()->json([
                'Success' => False,
                'Message'=> $e->getMessage(),
            ]);
        }

        try{
            $payments=Payment::create([
                'transaction_id'=>$request->transaction_id,
                'user_id'=>$request->user_id,
                'type'=>$request->type,
                'status'=>$request->status,
                'received_amount'=>$request->received_amount,
                'sent_from'=>$request->sent_from,
            ]);

            return response()->json([
                'Success'=>True,
                'Message'=>'Payment Created Successfully',
                'data'=>$payments
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
        $payments=Payment::all();
        return response()->json($payments);
    }

    //Show One Item
    public function show($id)
    {
        $payments=Payment::find($id); //For Show Only Item
        // $items=Item::where('id',$id)->with('itemCategory')->first(); //For Show Each Category

        return response()->json($payments);

    }

    //Update
    public function update(Request $request,$id)
    {
        //Validation
        // dd($request->all());
        try{
            $this->validate($request,[
                'transaction_id'=> 'required',
                'user_id'=> 'required',
                'type'=> 'required',
                'status'=> 'required',
                'received_amount'=> 'required',
                'sent_from'=> 'required',
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
            Payment::where('id', $id)->update([
               'transaction_id'=>$request->transaction_id,
                'user_id'=>$request->user_id,
                'type'=>$request->type,
                'status'=>$request->status,
                'received_amount'=>$request->received_amount,
                'sent_from'=>$request->sent_from,
            ]);

            $payments=Payment::find($id);

            return response()->json([
                'Success'=>True,
                'Message'=>'Payment Updated Successfully',
                'data'=>$payments
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
            Payment::find($id)->delete();
            $list = Payment::all();

            return response()->json([
                'Success'=>True,
                'Message'=>'Payment Deleted Successfully',
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
