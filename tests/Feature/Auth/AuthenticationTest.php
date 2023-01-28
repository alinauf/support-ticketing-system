<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::HOME);
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('admin user should be redirected to admin dashboard ', function () {
    $user = createAdminUser();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::ADMIN_HOME);
})->group('admin');

test('admin user should have the email info@codingmonkeys.nl', function () {
    adminLogin()->assertAuthenticated();

    $user = getAdminUser();

    expect($user->is_admin)->toBe(1);
    expect($user->email)->toBe('info@codingmonkeys.nl');
})->group('admin');
