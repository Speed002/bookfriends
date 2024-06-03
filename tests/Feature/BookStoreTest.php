<?php
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class); //memory database

it('only allows authenticated users to post', function () {
    $this->post('/books')
    ->assertStatus(302);
});

it('creates a book', function(){
    $user = User::factory()->create();
    $this ->actingAs($user)->post('/books', [
        'title' => 'A book',
        'author'=> 'An author',
        'status' => 'WANT_TO_READ'
    ]);

    $this->assertDatabaseHas('books', [
        'title' => 'A book',
        'author'=> 'An author'
    ])
    //there has to be a pivot table uniting books and users
    ->assertDatabaseHas('book_user', [
        'user_id'=> $user->id,
        'status' => 'WANT_TO_READ'
    ]);

});

// means validation is required
it('requires a title, author and status', function(){
    $user = User::factory()->create();
    $this->actingAs($user)->post('/books')
         ->assertSessionHasErrors(['title', 'author', 'status']);
});
