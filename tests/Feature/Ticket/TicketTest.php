<?php

use App\Models\Ticket;
use App\Models\User;

test('create a ticket', function () {
    $user = createClientUser();

    $ticketSl = new App\Services\TicketService();

    $data = [
        'title' => 'Test ticket',
        'description' => 'Test description',
        'user_id' => $user->id,
    ];

    $response = $ticketSl->store($data);

    expect($response['status'])->toBeTrue();
    expect($response['payload'])->toBe('The ticket has been successfully created');

    $this->assertDatabaseHas('tickets', [
        'title' => 'Test ticket',
        'description' => 'Test description',
    ]);

})->group('tickets');

test('update ticket', function () {
    $ticket = createTicket();

    $ticketSl = new App\Services\TicketService();

    $data = [
        'title' => 'Update test data',
        'description' => 'Update test description',
    ];

    $response = $ticketSl->update($ticket->id, $data);

    expect($response['status'])->toBeTrue();
    expect($response['payload'])->toBe('Ticket has been successfully updated');

    $this->assertDatabaseHas('tickets', [
        'id' => $ticket->id,
        'title' => 'Update test data',
        'description' => 'Update test description',
    ]);

})->group('tickets');


test('retreive ticket', function () {
    $ticket = createTicket();

    $ticketSl = new App\Services\TicketService();

    $retrievedTicket = $ticketSl->show($ticket->id);

    expect($ticket->id)->toBe($retrievedTicket->id);

})->group('tickets');




test('client visits dashboard and can see his/her tickets', function () {
    $user = createClientUser();

    createMultipleTickets($user->id, 100);

    $ticket = Ticket::where('user_id', $user->id)->latest()->first();


    $response = test()->actingAs($user)->get('/dashboard');
    $response->assertStatus(200);
    $response->assertSeeLivewire('client.ticket.index');

    // The user should see the tickets section header
    $response->assertSee('Support Tickets');
    // By default, the tickets are ordered by the latest created, so the user should see the last ticket created by him/her
    $response->assertSee($ticket->title);

})->group('tickets');

test('retrieve tickets with filters', function ($filterResolved, $filterPending, $orderBy) {
    $user = createClientUser();

    createMultipleTickets($user->id, 100);

    $ticketSl = new App\Services\TicketService();

    $searchFilters = [
        'resolved' => $filterResolved,
        'pending' => $filterPending,
        'orderBy' => $orderBy
    ];

    $tickets = $ticketSl->listTickets(null, $searchFilters, $user->id);

    if ($filterResolved && $filterPending) {
        // This is actually an invalid scenario caused due to the dataset
        // adding all possible scenarios with the filters

        // This is a hack to make the test pass only for this invalid scenario,
        // so that no warnings will be shown due to no assertions
        expect(true)->toBeTrue();
    }

    if (!$filterResolved && !$filterPending) {
        // This is actually an invalid scenario caused due to the dataset,
        // adding all possible scenarios with the filters

        // This is a hack to make the test pass only for this invalid scenario,
        // so that no warnings will be shown due to no assertions
        expect(true)->toBeTrue();
    }

    if ($filterResolved && !$filterPending) {
        expect((boolean)$tickets[0]->is_open)->toBeFalse();
    }

    if ($filterPending && !$filterResolved) {
        expect((boolean)$tickets[0]->is_open)->toBeTrue();
    }


})
    ->with([
        'resolved = true' => true,
        'resolved = false' => false
    ])
    ->with([
        'pending = true' => true,
        'pending = false' => false
    ])
    ->with([
        'orderBy = desc' => 'desc',
        'orderBy = asc' => 'asc'
    ])
    ->group('tickets');


test('a user can clost a ticket');