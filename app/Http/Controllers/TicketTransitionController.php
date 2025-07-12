<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TicketTransition;

class TicketTransitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         // Validate the request data including ticket_id
         $validated = $request->validate([
            'ticket_id' => 'required|integer', // Ensure the ticket_id exists in the tickets table
            'from_state' => 'required|string|max:255',
            'to_state' => 'required|string|max:255',
        ]);

        // Create and save the ticket transition with ticket_id
        $ticketTransition = TicketTransition::create([
            'ticket_id' => $validated['ticket_id'], // Include ticket_id in the creation
            'from_state' => $validated['from_state'],
            'to_state' => $validated['to_state'],
        ]);

        // Return a response, could be a redirect or a JSON response, depending on your app's needs
        return response()->json([
            'message' => 'Ticket transition created successfully!',
            'data' => $ticketTransition,
        ], 201);
    }

    public function showByTicketId($ticketId)
    {
        // Retrieve all transitions for the given ticket ID
        $transitions = TicketTransition::where('ticket_id', $ticketId)->get();

        // Check if transitions exist for the given ticket ID
        if ($transitions->isEmpty()) {
            return response()->json([
                'message' => 'No transitions found for the provided ticket ID.',
            ], 404);
        }

        // Return a successful response with the transitions
        return response()->json([
            'message' => 'Transitions retrieved successfully.',
            'data' => $transitions,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
