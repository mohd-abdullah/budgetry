<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transactions;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class TransactionController extends Controller{

    /**
     * Instantiate a new TransactionController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addExpense(Request $request)
    {
        //validate incoming request
        $rules = [
            'category' => 'required',
            'transaction_details' => 'required|string',
            'type' => 'required',
            'amount' => 'required',
            'transaction_date' => 'required'
        ];
        $this->validate($request,$rules);
        try {
            //get loggedin user details
            $user = JWTAuth::user();

            //create new transaction
            $expense = new Transactions;
            $expense->user_id = $user->id;
            $expense->category_id = $request->input('category');
            $expense->transaction_details = $request->input('transaction_details');
            $expense->type = $request->input('type');
            $expense->amount = $request->input('amount');
            $expense->transaction_date = $request->input('transaction_date');
            $expense->note = $request->input('note');
            $expense->save();

            //return successful response
            return response()->json(['expense' => $expense, 'message' => 'Expense added succesfully'], 201);
        } catch (\Exeption $ex) {
            //return error message
            return response()->json(['message' => 'Adding expense Failed!'], 409);
        }
    }
}