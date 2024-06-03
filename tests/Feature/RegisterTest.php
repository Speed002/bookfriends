<?php
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class); //memory database
// this test is checking the form is not filled, so it can tell us, yes it is not filled
// the test has to confirm according to what we plan
// high order tests
it('has errors if the details are not provided')
->post('/register')
->assertSessionHasErrors(['name', 'email', 'password']);

// normal order tests
it('registers the user', function () {
    // register a user for testing here and test redirect
    $this->post('/register', [
        'name' => 'Mabel',
        'email'=> 'mabel@codecourse.com',
        'password' => 'password'
    ])->assertRedirect('/');
    // check the database to see if the user is in the database, and then authenticate the user
    $this->assertDatabaseHas('users', [
        'name' => 'Mabel',
        'email'=> 'mabel@codecourse.com',
    ])->assertAuthenticated();

});
