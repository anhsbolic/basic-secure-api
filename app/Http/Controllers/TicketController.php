<?php

namespace App\Http\Controllers;

use App\Ticket;

class TicketController extends Controller
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

    public function tickets() {
        // tickets
        $tickets = Ticket::all();

        // response
        $response = [
            'code' => 1,
            'message' => 'Ticket List',
            'data' => [
                'tickets' => $tickets,
            ]
        ];

        return response()->json($response, 200);
    }

    public function ticketDetail($id_ticket) {
        // find ticket  
        $ticket = Ticket::find($id_ticket);

        // response
        $response = [
            'code' => 1,
            'message' => 'Ticket',
            'data' => [
                'ticket' => $ticket,
            ]
        ];

        return response()->json($response, 200);
    }

}
