<?php

namespace App\Http\Livewire\Admin\Ticket;

use App\Models\Ticket;
use App\Services\TicketService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search;

    public $pending = false;
    public $resolved = false;

    public $orderByDesc = true;

    public $openTicketsCount;
    public $resolvedTicketsCount;


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
        $this->openTicketsCount = Ticket::where('is_open', true)->count();
        $this->resolvedTicketsCount = Ticket::where('is_open', false)->count();

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

        $tickets = $ticketService->listTickets($this->search, $searchFilters);
        return view('livewire.admin.ticket.index', [
            'tickets' => $tickets
        ]);
    }

}
