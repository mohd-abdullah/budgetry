<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class CategoriesController extends Controller{

    protected $user;
    /**
     * Instantiate a new CategoriesController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        //get loggedin user details
        $this->user = JWTAuth::user();
    }

    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        try {
            $allList = Categories::whereIn('user_id',[0,$this->user->id])->get();

            //return successful response
            return response()->json(['status' => true, 'message' => 'successful', 'data' => $allList], 201);
        } catch (\Exeption $ex) {
            //return error message
            return response()->json(['status' => false, 'message' => 'Failed!'], 409);
        }
    }

    /**
        * Show the form for creating a new resource.
        *
        * @return Response
        */
    public function create(Request $request)
    {
        //validate incoming request
        $rules = [
            'name' => 'required|regex:/(^[\pL0-9 ]+)$/u'
        ];
        $this->validate($request,$rules);
        try
        {
            $checkIfExist = Categories::where('name',$request->name)->whereIn('user_id',[0,$this->user->id])->count();
            if($checkIfExist)
            {
                //return successful response
                return response()->json(['status' => false, 'message' => $request->name.' already exist'], 409);
            }
            else
            {
                $insert = Categories::create(
                    ['name' => $request->name, 'user_id' => $this->user->id]
                );

                //return successful response
                return response()->json(['status' => true, 'message' => 'succesful', 'data' => $request->name], 201);
            }
        } catch (\Exeption $ex) {
            //return error message
            return response()->json(['status' => false, 'message' => 'Failed!', 'error' => $ex], 409);
        }
    }

    /**
        * Display the specified resource.
        *
        * @param  int  $id
        * @return Response
        */
    public function show($id)
    {
        try {
            $category = Categories::where('id', $id)->first();

            //return successful response
            return response()->json(['status' => true, 'message' => 'successful', 'data' => $category], 201);
        } catch (\Exeption $ex) {
            //return error message
            return response()->json(['status' => false, 'message' => 'Failed!'], 409);
        }
    }

    /**
        * Update the specified resource in storage.
        *
        * @param  int  $id
        * @return Response
        */
    public function update(Request $request,$id)
    {
        //validate incoming request
        $rules = [
            'name' => 'required|regex:/(^[\pL0-9 ]+)$/u'
        ];
        $this->validate($request,$rules);
        try
        {
            $checkIfExist = Categories::where('id',$request->id)->first();
            if($checkIfExist->name == $request->name)
            {
                //return successful response
                return response()->json(['status' => false, 'message' => $request->name.' already exist'], 409);
            }
            else
            {
                $checkIfExist->name = $request->name;
                $checkIfExist->save();

                //return successful response
                return response()->json(['status' => true, 'message' => 'succesful', 'data' => $request->name], 201);
            }
        } catch (\Exeption $ex) {
            //return error message
            return response()->json(['status' => false, 'message' => 'Failed!', 'error' => $ex], 409);
        }
    }

    /**
        * Remove the specified resource from storage.
        *
        * @param  int  $id
        * @return Response
        */
    public function destroy($id)
    {
        try {
            $category = Categories::where('id', $id)->delete();

            //return successful response
            return response()->json(['status' => true, 'message' => 'successful'], 201);
        } catch (\Exeption $ex) {
            //return error message
            return response()->json(['status' => false, 'message' => 'Failed!'], 409);
        }
    }
}