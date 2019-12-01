<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function detail($id_transaction) {
        // find transaction  
        $transaction = Transaction::find($id_transaction);

        // response
        $response = [
            'code' => 1,
            'message' => 'transaction',
            'data' => [
                'transaction' => $transaction,
            ]
        ];

        return response()->json($response, 200);
    }

    public function book(Request $request) {
        // get value
        $user_id = $request->user_id;
        $ticket_id = $request->ticket_id;
        $total_ticket = $request->total_ticket;
        $price = $request->price;

        // find ticket  
        $ticket = Ticket::find($ticket_id);

        // check ticket
        if (!$ticket) {

            $response = [
                'code' => 2,
                'message' => 'Ticket not found',
                'data' => []
            ];
    
            return response()->json($response, 200);
        }

        // save transaction, with booked status
        try {
            DB::beginTransaction();

            $transaction = new Transaction();
            $transaction->user_id = $user_id;
            $transaction->ticket_id = $ticket->id;
            $transaction->total = ($total_ticket * $price);
            $transaction->status_id = Transaction::BOOKED;
            $transaction->save();

            DB::commit();
        } catch(Exception $e) {
            Log::error($e);
            DB::rollback();

            $response = [
                'code' => 500,
                'message' => 'Internal Server Error',
                'data' => []
            ];

            return response()->json($response, 500);
        }

        $response = [
            'code' => 1,
            'message' => 'Ticket Booked',
            'data' => []
        ];

        return response()->json($response, 200);

    }

    public function pay(Request $request) {
        // get value
        $transaction_id = $request->transaction_id;

        // find transaction
        $transaction = Transaction::find($transaction_id);

        // check ticket
        if (!$transaction) {

            $response = [
                'code' => 2,
                'message' => 'Transaction not found',
                'data' => []
            ];
    
            return response()->json($response, 200);
        }

        // save transaction, with booked status
        try {
            DB::beginTransaction();
            
            $transaction->status_id = Transaction::PAID;
            $transaction->save();

            DB::commit();
        } catch(Exception $e) {
            Log::error($e);
            DB::rollback();

            $response = [
                'code' => 500,
                'message' => 'Internal Server Error',
                'data' => []
            ];

            return response()->json($response, 500);
        }

        $response = [
            'code' => 1,
            'message' => 'Ticket Paid',
            'data' => []
        ];

        return response()->json($response, 200);

    }

    public function cancel(Request $request) {
        // get value
        $transaction_id = $request->transaction_id;

        // find transaction
        $transaction = Transaction::find($transaction_id);

        // check ticket
        if (!$transaction) {

            $response = [
                'code' => 2,
                'message' => 'Transaction not found',
                'data' => []
            ];
    
            return response()->json($response, 200);
        }

        // save transaction, with booked status
        try {
            DB::beginTransaction();
            
            $transaction->status_id = Transaction::CANCELLED;
            $transaction->save();

            DB::commit();
        } catch(Exception $e) {
            Log::error($e);
            DB::rollback();

            $response = [
                'code' => 500,
                'message' => 'Internal Server Error',
                'data' => []
            ];

            return response()->json($response, 500);
        }

        $response = [
            'code' => 1,
            'message' => 'Ticket Cancelled',
            'data' => []
        ];

        return response()->json($response, 200);

    }

}
