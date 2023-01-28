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


test('add client reply to a ticket', function (User $user) {
    if ($user->isAdmin()) {
        $user = createClientUser();
    }

    $ticket = createTicket($user->id);

    $ticketSl = new App\Services\TicketService();

    $data = [
        'ticket_id' => $ticket->id,
        'user_id' => $user->id,
        'reply' => 'Test reply',
    ];

    $response = $ticketSl->addReply($ticket->id, $data);

    expect($response['status'])->toBeTrue();
    expect($response['payload'])->toBe('Reply has been successfully added');

    $this->assertDatabaseHas('ticket_replies', [
        'ticket_id' => $ticket->id,
        'user_id' => $ticket->user_id,
        'reply' => 'Test reply',
    ]);

})->with(
    [
        'Client User' => fn() => User::factory()->create(),
        'Admin User' => fn() => User::factory()->create([
            'is_admin' => true,
        ]),
    ]
)->group('tickets');

test('client can visit a page to view all his/her tickets');

test('a user can clost a ticket');