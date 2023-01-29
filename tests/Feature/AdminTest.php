<?php

use App\Models\Ticket;

test('admin user can visit dashboard and see tickets, stats', function () {

    createMultipleTickets(null, 100);

    $latestTicket = Ticket::orderBy('created_at', 'desc')->get()->first();

    $openTicketsCount = Ticket::where('is_open', true)->count();
    $resolvedTicketsCount = Ticket::where('is_open', false)->count();

    adminLogin()->get(route('admin-dashboard'))
        ->assertStatus(200)
        ->assertSee('Admin Dashboard')
        ->assertSee($openTicketsCount)
        ->assertSee($resolvedTicketsCount)
        ->assertSee($latestTicket->title)
        ->assertSee('Name')
        ->assertSee('Title')
        ->assertSeeLivewire('admin.ticket.index');

})->group('tickets');



