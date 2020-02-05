<?php

namespace App\Http\Controllers;
use App\Models\Item;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function store(Request $request)
    {

        // dd($request->all());
        try{
            $this->validate($request,[
                'category_id'=> 'required',
                'name'=> 'required',
                'price'=> 'required',
                
            ]);
        }
        catch (ValidationException $e) {
            return response()->json([
                'Success' => False,
                'Message'=> $e->getMessage(),
            ]);
        }

        try{
            $items=Item::create([
                'category_id'=>$request->category_id,
                'name'=>$request->name,
                'price'=>$request->price, 
                  
            ]);

            return response()->json([
                'Success'=>True,
                'Message'=>'Item Created Successfully',
                'data'=>$items
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
        $items=Item::all();
        return response()->json($items);
    }

    //Show One Item
    public function show($id)
    {
        // $items=Item::find($id); //For Show Only Item
        $items=Item::where('id',$id)->with('itemCategory')->first(); //For Show Each Category

        return response()->json($items);

    }

    //Update
    public function update(Request $request,$id)
    {
        //Validation
        // dd($request->all());
        try{
            $this->validate($request,[
                'category_id'=> 'required',
                'name'=> 'required',
                'price'=> 'required',
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
            Item::where('id', $id)->update([
                'category_id'=>$request->category_id,
                'name'=>$request->name,
                'price'=>$request->price,   
            ]);

            $items=Item::find($id);

            return response()->json([
                'Success'=>True,
                'Message'=>'Item Updated Successfully',
                'data'=>$items
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
            Item::find($id)->delete();
            $list = Item::all();

            return response()->json([
                'Success'=>True,
                'Message'=>'Item Deleted Successfully',
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
