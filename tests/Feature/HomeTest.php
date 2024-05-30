<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class); //memory database

it('greets the user if they are signed out.', function () {
    $this->get('/')->assertSee(['Bookfriends', 'Sign up to get started.'])
                   ->assertDontSee(['Feed']);
});

it('shows authenticated menu items if the user is signed in', function(){
    //sign in
    $user = User::factory()->create();
    //act as user
    $this->ActingAs($user)->get('/')->assertSeeText(['Feed', 'My books', 'Add a book', 'Friend', $user->name]);
    //check to see the correct user item

});

it('shows unauthenticated menu items if the user is not signed in', function(){
    $this->get('/')->assertSeeText(['Home', 'Login', 'Register']);
    //check to see the correct user item

});
