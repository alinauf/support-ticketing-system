<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TicketService extends Service
{
    public function __construct()
    {
        $this->setModel(new Ticket());
    }

    public function listTickets($search, $searchFilters, $userId = null, $paginatePages = 10)
    {
        $checkTicketStatus = $searchFilters['resolved'] || $searchFilters['pending'];
        $tickets = Ticket::query();

        if (isset($userId)) {
            $tickets->where('user_id', $userId);
        }

        if ($checkTicketStatus) {
            if ($searchFilters['resolved']) {
                $tickets->where('is_open', false);
            } elseif ($searchFilters['pending']) {
                $tickets->where('is_open', true);
            }
        }

        if ($search) {
            $tickets->where('title', 'like', '%' . $search . '%');
        }

        $tickets->orderBy('created_at', $searchFilters['orderBy']);

        return $tickets->paginate($paginatePages);
    }

    public function store($data): array
    {
        DB::beginTransaction();
        try {
            $ticket = Ticket::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'user_id' => $data['user_id'],
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        DB::commit();

        if ($ticket) {
            Log::info('Ticket created', [
                'ticket_id' => $ticket->id,
                'user_id' => $ticket->user_id,
            ]);
            return [
                'status' => true,
                'payload' => 'The ticket has been successfully created',
            ];
        } else {
            return [
                'status' => false,
                'payload' => 'There was an issue with saving the ticket',
            ];
        }
    }

    /**
     * @throws \Exception
     */
    public function update($ticketId, $data): bool|array
    {
        DB::beginTransaction();

        $ticket = Ticket::where('id', $ticketId)->first();

        try {
            $ticket->title = $data['title'] ?? $ticket->title;
            $ticket->description = $data['description'] ?? $ticket->description;
            $ticketSave = $ticket->save();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        DB::commit();

        if ($ticketSave) {
            return [
                'status' => true,
                'payload' => 'Ticket has been successfully updated',
            ];
        } else {
            return [
                'status' => false,
                'payload' => 'There was an issue with updating the ticket',
            ];
        }
    }

    public function addReply($ticketId, $data): bool|array
    {
        DB::beginTransaction();

        $ticket = Ticket::where('id', $ticketId)->first();

        if (!$ticket) {
            return [
                'status' => false,
                'payload' => 'No ticket found with the given id',
            ];
        }

        try {

            $reply = new TicketReply();
            $reply->ticket_id = $ticket->id;
            $reply->user_id = $data['user_id'];
            $reply->reply = $data['reply'];
            $status = $reply->save();

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        DB::commit();

        if ($status) {
            return [
                'status' => true,
                'payload' => 'Reply has been successfully added',
            ];
        } else {
            return [
                'status' => false,
                'payload' => 'There was an issue with adding the reply',
            ];
        }

    }

    public function resolveTicket($ticketId): bool|array
    {
        DB::beginTransaction();

        $ticket = Ticket::where('id', $ticketId)->first();

        if (!$ticket) {
            return [
                'status' => false,
                'payload' => 'No ticket found with the given id',
            ];
        }

        try {
            $ticket->is_open = false;
            $status = $ticket->save();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        DB::commit();

        if ($status) {
            return [
                'status' => true,
                'payload' => 'Ticket has been successfully resolved',
            ];
        } else {
            return [
                'status' => false,
                'payload' => 'There was an issue with resolving the ticket',
            ];
        }
    }


}