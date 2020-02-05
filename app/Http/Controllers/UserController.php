<?php

namespace App\Http\Controllers;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function store(Request $request)
    {
        //dd($request->all());
        try{
            $this->validate($request,[
                'full_name'=> 'required',
                'username'=> 'required',
                'password'=> 'required',
                'email'=> 'required',
                'address'=> 'required',
                'phone'=> 'required',
                'user_type'=> 'required',
                'balance'=> 'required',
            ]);
        }
        catch (ValidationException $e) {
            return response()->json([
                'Success' => False,
                'Message'=> $e->getMessage(),
            ]);
        }

        try{
            $users=User::create([
                'full_name'=>$request->full_name,
                'username'=>$request->username,
                'password'=>Hash::make(trim($request->password)), 
                'email'=>$request->email,
                'address'=>$request->address,
                'phone'=>$request->phone, 
                'user_type'=>$request->user_type,
                'balance'=>$request->balance, 
            ]);

            return response()->json([
                'Success'=>True,
                'Message'=>'Order Created Successfully',
                'data'=>$users
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
        $users=User::all();
        return response()->json($users);

    }

    //Show One Item
    public function show($id)
    {
        $users=User::find($id);
        return response()->json($users);
    }


    //Update
    public function update(Request $request,$id)
    {
        //Validation
        // dd($request->all());
        try{
            $this->validate($request,[
                'full_name'=> 'required',
                'username'=> 'required',
                'password'=> 'required',
                'email'=> 'required',
                'address'=> 'required',
                'phone'=> 'required',
                'user_type'=> 'required',
                'balance'=> 'required',
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
            User::where('id', $id)->update([
                'full_name'=>$request->full_name,
                'username'=>$request->username,
                'password'=>$request->password, 
                'email'=>$request->email,
                'address'=>$request->address,
                'phone'=>$request->phone, 
                'user_type'=>$request->user_type,
                'balance'=>$request->balance,  
            ]);

            $users=User::find($id);

            return response()->json([
                'Success'=>True,
                'Message'=>'User Updated Successfully',
                'data'=>$users
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
            User::find($id)->delete();
            $list = User::all();

            return response()->json([
                'Success'=>True,
                'Message'=>'User Deleted Successfully',
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

    public function authenticate(Request $request)
    {
        // dd($request->all());
        try{
            $this->validate($request,[
                'email'=> 'required',
                'password'=> 'required',
            ]);
        }
        catch (ValidationException $e) {
            return response()->json([
                'success' => False,
                'message'=> $e->getMessage(),
            ]);
        }

        $token = app('auth')->attempt($request->only('email','password'));

        if($token) 
        {
            return response()->json([
                'success' => true,
                'message'=> 'User authenticated',
                'token'=> $token,
            ]);
        }
        return response()->json([
            'success' => false,
            'message'=> 'Invalid credentials',
        ]);
    }
}
