<?php

namespace App\Http\Controllers\Api\V1\TicketControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\TicketRequests\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\TicketRequests\StoreTicketRequest;
use App\Http\Requests\Api\V1\TicketRequests\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TicketController extends Controller
{
    use ApiResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TicketResource::collection(Ticket::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        try {
            $user = User::query()->findOrFail($request->input('data.relationships.author.data.id'));
        }
        catch (ModelNotFoundException $exception) {
            return $this->ok('User not found', [
                'error' => "The provided user does not exist."
            ]);
        }

        $ticket = [
            'title' => $request->input('data.attributes.title'),
            'description' => $request->input('data.attributes.description'),
            'status' => $request->input('data.attributes.status'),
            'user_id' => $request->input('data.relationships.author.data.id'),
        ];
        // or you can do it like this
//         $newTicket = Ticket::query()->create($ticket);
        return new TicketResource(Ticket::query()->create($ticket));
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return new TicketResource($ticket);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, int $ticketId)
    {
        //
    }

    public function replace(ReplaceTicketRequest $request, int $ticketId)
    {
        try {
            $ticket = Ticket::query()->findOrFail($ticketId);

            $model = [
                'title' => $request->input('data.attributes.title'),
                'description' => $request->input('data.attributes.description'),
                'status' => $request->input('data.attributes.status'),
                'user_id' => $request->input('data.relationships.author.data.id'),
            ];

            $ticket->update($model);
        }
        catch (ModelNotFoundException $exception) {
            return $this->error('ticket cannot be found', 404);
        }

        return new TicketResource($ticket);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
