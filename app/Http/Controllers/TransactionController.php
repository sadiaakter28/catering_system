<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->all());
        try{
            $this->validate($request,[
                'user_id'=> 'required',
                'order_id'=> 'required',
                'amount'=> 'required',
                'type'=> 'required',
            ]);
        }
        catch (ValidationException $e) {
            return response()->json([
                'Success' => False,
                'Message'=> $e->getMessage(),
            ]);
        }

        try{
            $transactions=Transaction::create([
                'user_id'=>$request->user_id,
                'order_id'=>$request->order_id,
                'amount'=>$request->amount,
                'type'=>$request->type,
            ]);

            return response()->json([
                'Success'=>True,
                'Message'=>'Transaction Created Successfully',
                'data'=>$transactions
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
        $transactions=Transaction::all();
        return response()->json($transactions);
    }

    //Show One Item
    public function show($id)
    {
        $transactions=Transaction::find($id); //For Show Only Item
        // $items=Item::where('id',$id)->with('itemCategory')->first(); //For Show Each Category

        return response()->json($transactions);

    }

    //Update
    public function update(Request $request,$id)
    {
        //Validation
        // dd($request->all());
        try{
            $this->validate($request,[
                'user_id'=> 'required',
                'order_id'=> 'required',
                'amount'=> 'required',
                'type'=> 'required',
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
            Transaction::where('id', $id)->update([
                'user_id'=>$request->user_id,
                'order_id'=>$request->order_id,
                'amount'=>$request->amount,
                'type'=>$request->type,  
            ]);

            $transactions=Transaction::find($id);

            return response()->json([
                'Success'=>True,
                'Message'=>'Transaction Updated Successfully',
                'data'=>$transactions
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
            Transaction::find($id)->delete();
            $list = Transaction::all();

            return response()->json([
                'Success'=>True,
                'Message'=>'Transaction Deleted Successfully',
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
