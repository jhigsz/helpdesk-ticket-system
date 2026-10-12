<?php

namespace App\Http\Requests;

use App\Models\Ticket;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreTicketRequest extends FormRequest
{
    // Check if this user is allowed to create tickets.
    public function authorize(): bool
    {
        return Gate::allows('create', Ticket::class);
    }

    // Validate all ticket fields before saving.
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:5', 'max:255'],

            'description' => ['required', 'string', 'min:10'],

            'priority' => [
                'required',
                Rule::in(['Low', 'Medium', 'High', 'Urgent']),
            ],

            'status' => [
                'required',
                Rule::in(['Open', 'In Progress', 'Resolved', 'Closed']),
            ],

            'category' => [
                'required',
                Rule::in([
                    'Hardware',
                    'Software',
                    'Network',
                    'Account',
                    'Other',
                ]),
            ],
        ];
    }
}
