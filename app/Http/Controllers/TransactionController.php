<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transactions;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class TransactionController extends Controller{
    protected $user;
    /**
     * Instantiate a new TransactionController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        //get loggedin user details
        $this->user = JWTAuth::user();
    }

    //list of all expenses
    public function index()
    {
        try {
            $allList = Transactions::where('user_id', $this->user->id)->get();

            //return successful response
            return response()->json(['status' => true, 'message' => 'successful', 'data' => $allList], 201);
        } catch (\Exeption $ex) {
            //return error message
            return response()->json(['status' => false, 'message' => 'Failed!'], 409);
        }
    }

    //add new expense
    public function create(Request $request)
    {
        //validate incoming request
        $rules = [
            'category_id' => 'required',
            'transaction_details' => 'required|string',
            'type' => 'required',
            'amount' => 'required',
            'transaction_date' => 'required'
        ];
        $this->validate($request,$rules);
        try {
            //create new transaction
            $expense = new Transactions;
            $expense->user_id = $this->user->id;
            $expense->category_id = $request->input('category_id');
            $expense->transaction_details = $request->input('transaction_details');
            $expense->type = $request->input('type');
            $expense->amount = $request->input('amount');
            $expense->transaction_date = $request->input('transaction_date');
            $expense->note = $request->input('note');
            $expense->save();

            //return successful response
            return response()->json(['status' => true, 'message' => 'successful', 'data' => $expense], 201);
        } catch (\Exeption $ex) {
            //return error message
            return response()->json(['status' => false, 'message' => 'Failed!'], 409);
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
                $transaction = Transactions::where('id', $id)->first();
    
                //return successful response
                return response()->json(['status' => true, 'message' => 'successful', 'data' => $transaction], 201);
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
                'category_id' => 'required',
                'transaction_details' => 'required|string',
                'type' => 'required',
                'amount' => 'required',
                'transaction_date' => 'required'
            ];
            $this->validate($request,$rules);
            try
            {
                $transactions = Transactions::where('id',$request->id)
                                            ->update($request->all());

                //return successful response
                return response()->json(['status' => true, 'message' => 'succesful'], 201);
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
                $category = Transactions::where('id', $id)->delete();
    
                //return successful response
                return response()->json(['status' => true, 'message' => 'successful'], 201);
            } catch (\Exeption $ex) {
                //return error message
                return response()->json(['status' => false, 'message' => 'Failed!'], 409);
            }
        }
}