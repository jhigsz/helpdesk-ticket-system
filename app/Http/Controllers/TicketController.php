<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class TicketController extends Controller
{
    // Display the logged-in user's tickets.
    public function index(Request $request): Response
    {
        Gate::authorize('viewAny', Ticket::class);

        $tickets = $request->user()
            ->tickets()
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('tickets/index', [
            'tickets' => $tickets,
        ]);
    }

    // Display the form for creating a ticket.
    public function create(): Response
    {
        Gate::authorize('create', Ticket::class);

        return Inertia::render('tickets/create');
    }

    // Validate and save a new ticket.
    public function store(
        StoreTicketRequest $request
    ): RedirectResponse {
        // Set the owner using the logged-in user,
        // never using a user_id sent from the form.
        $request->user()->tickets()->create(
            $request->validated()
        );

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket created.');
    }

    // Display one ticket's information.
    public function show(Ticket $ticket): Response
    {
        Gate::authorize('view', $ticket);

        return Inertia::render('tickets/show', [
            'ticket' => $ticket,
        ]);
    }

    // Display the pre-filled edit form.
    public function edit(Ticket $ticket): Response
    {
        Gate::authorize('update', $ticket);

        return Inertia::render('tickets/edit', [
            'ticket' => $ticket,
        ]);
    }

    // Validate and update the ticket.
    public function update(
        UpdateTicketRequest $request,
        Ticket $ticket
    ): RedirectResponse {
        Gate::authorize('update', $ticket);

        $ticket->update($request->validated());

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket updated.');
    }

    // Delete a ticket owned by the user.
    public function destroy(
        Ticket $ticket
    ): RedirectResponse {
        Gate::authorize('delete', $ticket);

        $ticket->delete();

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket deleted.');
    }
}
