<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class); //memory database

it('redirects authenticated users', function () {

    $user = User::factory()->create();
    $this->actingAs($user)
    ->get('/auth/login')->assertStatus(302);

});

it('shows an error if the details are not provided', function(){
    $this->post('/login')->assertSessionHasErrors(['email', 'password']);
});

it('logs the user in', function(){

    // create a user to test the login
    $user = User::factory()->create([
        'password' => Hash::make('password') //this is the default password from fortify
    ]);

    //post the user details to the login route
    $this->post('/login', [
        'email' => $user->email,
        'password' => 'password'
    ])->assertRedirect('/');

    // log the user in
    $this->assertAuthenticated();

});
