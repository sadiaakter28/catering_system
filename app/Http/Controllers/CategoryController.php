<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //Create
    public function store(Request $request)
    {

        // dd($request->all());
        try{
            $this->validate($request,[
                'name'=> 'required',
                'description'=> 'required',
                'slug'=> 'required',
            ]);
        }
        catch (ValidationException $e) {
            return response()->json([
                'Success' => False,
                'Message'=> $e->getMessage(),
            ]);
        }

        try{
            $categories=Category::create([
                'name'=>$request->name,
                'description'=>$request->description, 
                'slug'=>$request->slug,   
            ]);

            return response()->json([
                'Success'=>True,
                'Message'=>'Category Created Successfully',
                'data'=>$categories
            ]);
        }
        catch (\PDOException $e) {
            return response()->json([
                'Success' => False,
                'Message'=> $e->getMessage(),
            ]);
        }
    }
    //Show Category List
    public function index()
    {
        $categories=Category::all();
        return response()->json($categories);
    }
    
    //Show One Category
    public function show($id)
    {
        $categories=Category::find($id);
        return response()->json($categories);
    }
    
    //Update
    public function update(Request $request,$id)
    {
        //Validation
        // dd($request->all());
        try{
            $this->validate($request,[
                'name'=> 'required',
                'description'=> 'required',
                'slug'=> 'required',
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
            Category::where('id', $id)->update([
                'name'=>$request->name,
                'description'=>$request->description, 
                'slug'=>$request->slug,   
            ]);

            $categories=Category::find($id);

            return response()->json([
                'Success'=>True,
                'Message'=>'Category Updated Successfully',
                'data'=>$categories
            ]);
        }
        catch (\PDOException $e) {
            return response()->json([
                'Success' => False,
                'Message'=> $e->getMessage(),
            ]);
        }
    }

    //Delete Category 
    public function destroy($id)
    {
        try{
            Category::find($id)->delete();
            $list = Category::all();

            return response()->json([
                'Success'=>True,
                'Message'=>'Category Deleted Successfully',
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
