<?php

namespace Tests\Feature;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     * @test
     */
    public function it_can_add_book()
    {
        $response = $this->post('books', [
            'title' => 'Title',
            'author' => 'Author'
        ]);

        $book = Book::first();
        // $response->assertOk();
        $this->assertCount(1, Book::all());

        $response->assertRedirect($book->path());
    }

    /** @test */
    public function title_is_required()
    {
        $response = $this->post('books', [
            'title' => '',
            'author' => 'Manish'
        ]);

        $response->assertSessionHasErrors('title');

    }

    /** @test */
    public function author_is_required()
    {
        $response = $this->post('books', [
            'title' => 'Rich Dad',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');

    }

    /** @test */
    public function it_can_update_book()
    {
        $this->post('books', [
            'title' => 'Title',
            'author' => 'Author'
        ]);

        $book = Book::first();
        $response = $this->patch($book->path(), [
            'title' => 'New Title',
            'author' => 'New Author'
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);

        $response->assertRedirect($book->path());
    }

    /** @test */
    public function it_can_delete_book()
    {
        $this->post('books', [
            'title' => 'Title',
            'author' => 'Author'
        ]);

        $book = Book::first();
        $this->assertCount(1, Book::all());
        $response = $this->delete($book->path());

        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');
    }
}
