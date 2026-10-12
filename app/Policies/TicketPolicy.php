<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    // Logged-in users can list their own tickets.
    public function viewAny(User $user): bool
    {
        return true;
    }

    // Users can create tickets.
    public function create(User $user): bool
    {
        return true;
    }

    // Only the owner can view a ticket.
    public function view(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->user_id;
    }

    // Only the owner can edit a ticket.
    public function update(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->user_id;
    }

    // Only the owner can delete a ticket.
    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->user_id;
    }
}
