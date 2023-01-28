<?php

namespace App\Http\Livewire\Client\Ticket;

use App\Services\TicketService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search;
    public $user;
    public $pending = false;
    public $resolved = false;

    public $orderByDesc = true;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function onPendingClick()
    {
        $this->resolved = false;
    }

    public function onResolvedClick()
    {
        $this->pending = false;
    }

    public function toggleOrder()
    {
        $this->orderByDesc = !$this->orderByDesc;
    }

    public function render()
    {
        $ticketService = new TicketService();
        $filterResolved = false;
        $filterPending = false;

        if ($this->pending) {
            $filterPending = true;
            $this->resolved = false;
        } elseif ($this->resolved) {
            $filterResolved = true;
            $this->pending = false;
        } else {
            $this->pending = false;
            $this->resolved = false;
        }

        if ($this->orderByDesc) {
            $orderBy = 'desc';
        } else {
            $orderBy = 'asc';
        }

        $searchFilters = [
            'resolved' => $filterResolved,
            'pending' => $filterPending,
            'orderBy' => $orderBy
        ];

        $tickets = $ticketService->listTickets($this->search, $searchFilters, $this->user->id);
        return view('livewire.client.ticket.index', ['tickets' => $tickets]);
    }
}
