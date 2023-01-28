<?php


use App\Http\Livewire\Ticket\Detail;
use App\Models\TicketReply;
use App\Models\User;
use Livewire\Livewire;

test('add reply to a ticket', function (User $user) {
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

test('user can visit ticket details view, see the ticket details and add reply', function (User $user) {

    if ($user->isAdmin()) {
        $ticket = createTicket(createClientUser()->id);
    } else {
        $ticket = createTicket($user->id);
    }

    $response = $this->actingAs($user)->get(route('tickets.show', $ticket->id));

    $response->assertStatus(200);

    $response->assertViewIs('tickets.show');
    $response->assertViewHas('ticket');

    $response->assertSeeLivewire('ticket.detail');

    $response->assertSee('Ticket: ' . $ticket->title);
    $response->assertSee($ticket->description);

    Livewire::test(Detail::class, ['ticket' => $ticket])
        ->set('comment', 'bla bla bla')
        ->call('addTicketReply')
        ->assertEmitted('ticketUpdated');

    expect(
        TicketReply::where('ticket_id', $ticket->id)
            ->where('user_id', $user->id)
            ->where('reply', 'bla bla bla')
            ->exists())
        ->toBeTrue();

    Livewire::test(Detail::class, ['ticket' => $ticket])
        ->set('comment', '')
        ->call('addTicketReply')
        ->assertHasErrors(['comment' => 'required']);

})->with(
    [
        'Client User' => fn() => User::factory()->create(),
        'Admin User' => fn() => User::factory()->create([
            'is_admin' => true,
        ]),
    ]
)->group('tickets');
