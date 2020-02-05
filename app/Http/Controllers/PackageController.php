<?php

namespace App\Http\Controllers;
use App\Models\Package;
use App\Models\PackageDetails;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function store(Request $request)
    {

        // dd($request->all());
        try{
            $this->validate($request,[
                'name'=> 'required',
                'status'=> 'required',
                'price'=> 'required',
                'remarks'=> 'required',
            ]);
        }
        catch (ValidationException $e) {
            return response()->json([
                'Success' => False,
                'Message'=> $e->getMessage(),
            ]);
        }

        try{
            $packages=Package::create([
                'name'=>$request->name,
                'status'=>$request->status,
                'price'=>$request->price,
                'remarks'=>$request->remarks,
            ]);

             $itemId = $request->input('item_id');
                foreach ($itemId as $item) {
                PackageDetails::create([
                    'package_id' => $packages->id,
                    'item_id' => $item,
                ]);
            }

            return response()->json([
                'Success'=>True,
                'Message'=>'Package Created Successfully',
                'data'=>$packages
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
        $packages=Package::all();
        return response()->json($packages);
    }

    //Show One Item
    public function show($id)
    {
       // $packages=Package::(); //For Show Only Item
         $packages=Package::where('id',$id)->with('packageDetails')->first(); //For Show Each Category

        return response()->json($packages);

    }

    //Update
    public function update(Request $request,$id)
    {
        //Validation
        // dd($request->all());
        try{
            $this->validate($request,[
                'name'=> 'required',
                'status'=> 'required',
                'price'=> 'required',
                'remarks'=> 'required',
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
            Package::where('id', $id)->update([
                'name'=>$request->name,
                'status'=>$request->status,
                'price'=>$request->price,
                'remarks'=>$request->remarks,  
            ]);

            $packages=Package::find($id);

            return response()->json([
                'Success'=>True,
                'Message'=>'Package Updated Successfully',
                'data'=>$packages
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
            Package::find($id)->delete();
            $list = Package::all();

            return response()->json([
                'Success'=>True,
                'Message'=>'Package Deleted Successfully',
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
