<?php

use App\Models\User;
use Livewire\Livewire;


test('retreive users', function () {

    User::factory([
        'name' => 'John Doe',
        'email' => 'jon.doe@example.test'
    ])->create();

    createMultipleUsers(50);

    $userSl = new App\Services\UserService();

    $users = $userSl->listUsers(null);

    expect($users->total())->toBe(51);

    $users = $userSl->listUsers('John Doe');

    expect(count($users))->toBe(1);
    expect($users->first()->name)->toBe('John Doe');

})
    ->group('tickets');

test('admin user can visit users index page and view users', function () {

    User::factory([
        'name' => 'John Doe',
        'email' => 'jon.doe@example.test'
    ])->create();

    createMultipleUsers(50);

    $latestUser = User::latest()->first();

    adminLogin()->get(route('users'))
        ->assertStatus(200)
        ->assertSee('Users')
        ->assertSee('Name')
        ->assertSee('Email')
        ->assertSee('Registered Date')
        ->assertSeeLivewire('user.index')
        ->assertSee($latestUser->name);


    Livewire::test(App\Http\Livewire\User\Index::class)
        ->set('search', 'John Doe')
        ->assertSee('John Doe');


})->group('tickets');


test('admin user can visit users show page and view user information', function () {

    $clientUser = User::factory([
        'name' => 'John Doe',
        'email' => 'jon.doe@example.test'
    ])->create();

    adminLogin()->get(route('users.show', $clientUser->id))
        ->assertStatus(200)
        ->assertSee($clientUser->id)
        ->assertSee('John Doe')
        ->assertSee('jon.doe@example.test')
        ->assertSee($clientUser->created_at->format('d/m/Y'))
        ->assertSeeLivewire('client.ticket.index');

})->group('tickets');
