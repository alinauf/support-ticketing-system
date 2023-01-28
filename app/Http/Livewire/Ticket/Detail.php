<?php

namespace App\Http\Livewire\Ticket;

use App\Services\TicketService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Detail extends Component
{
    public $ticket;
    public $ticketReplies;
    public $comment;

    protected $rules = [
        'comment' => 'required',
    ];

    protected $listeners = ['ticketUpdated' => 'updateTicket'];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($ticket)
    {
        $this->ticket = $ticket;
        $this->ticketReplies = $ticket->ticketReplies;
    }

    public function resolveTicket()
    {
        $ticketService = new TicketService();
        $response = $ticketService->resolveTicket($this->ticket->id);
        $response['status'] ? session()->flash('success', $response['payload']) : session()->flash('failure', $response['payload']);
        $this->emitSelf('ticketUpdated');

    }

    public function updateTicket()
    {
        $this->ticketReplies = $this->ticket->ticketReplies;
    }

    public function addTicketReply()
    {
        $this->validate();

        $ticketService = new TicketService();
        $response = $ticketService->addReply($this->ticket->id, [
            'reply' => $this->comment,
            'user_id' => Auth::id(),
        ]);

        if ($response['status']) {
            $this->comment = '';
            $this->emitSelf('ticketUpdated');
            session()->flash('success', $response['payload']);
        } else {
            session()->flash('failure', $response['payload']);
        }


    }

    public function render()
    {
        return view('livewire.ticket.detail');
    }
}
