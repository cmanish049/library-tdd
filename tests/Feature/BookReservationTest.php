<?php

namespace Tests\Feature;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_can_add_book()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('books', [
            'title' => 'Title',
            'author' => 'Author'
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());
    }

    public function test_title_is_required()
    {
        // $this->withoutExceptionHandling();
        $response = $this->post('books', [
            'title' => '',
            'author' => 'Manish'
        ]);

        $response->assertSessionHasErrors('title');

    }

    /** @test */
    public function author_is_required()
    {
        // $this->withoutExceptionHandling();
        $response = $this->post('books', [
            'title' => 'Rich Dad',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');

    }

    /** @test */
    public function it_can_update_book()
    {
        $this->withoutExceptionHandling();
        $this->post('books', [
            'title' => 'Title',
            'author' => 'Author'
        ]);

        $book = Book::first();
        $response = $this->patch('/books/'. $book->id, [
            'title' => 'New Title',
            'author' => 'New Author'
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);
    }
}
