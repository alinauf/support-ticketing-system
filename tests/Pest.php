<?php

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(TestCase::class, RefreshDatabase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function createAdminUser()
{
    $user = User::factory(
        [
            'name' => 'Admin',
            'email' => 'info@codingmonkeys.nl',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]
    )->create();

    return $user;
}

function adminLogin()
{
    $user = User::factory(
        [
            'name' => 'Admin',
            'email' => 'info@codingmonkeys.nl',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]
    )->create();

    return test()->actingAs($user);
}

function getAdminUser()
{
    $user = User::where('is_admin', true)->first();
    if (!$user) {
        $user = createAdminUser();
    }
    return $user;
}

function createClientUser()
{
    return User::factory()->create();
}

function createTicket($userId = null)
{
    return Ticket::factory([
        'user_id' => $userId ?? createClientUser()->id,
    ])
        ->create();
}

function createMultipleTickets($userId = null, $count = 1)
{
    return Ticket::factory([
        'user_id' => $userId ?? createClientUser()->id,
    ])
        ->state(new Sequence(
            ['is_open' => true],
            ['is_open' => false],
        ))
        ->count($count)
        ->create();
}


function clientLogin()
{
    $user = User::factory()->create();
    return test()->actingAs($user);
}


