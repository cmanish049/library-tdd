<?php

namespace Tests\Feature;

use App\Author;
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
        $response = $this->post('books', $this->data());

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
            'author_id' => 'Manish'
        ]);

        $response->assertSessionHasErrors('title');

    }

    /** @test */
    public function author_is_required()
    {
        $response = $this->post('books', array_merge($this->data(), ['author_id' => '']));

        $response->assertSessionHasErrors('author_id');

    }

    /** @test */
    public function it_can_update_book()
    {
        $this->post('books', $this->data());

        $book = Book::first();
        $response = $this->patch($book->path(), [
            'title' => 'New Title',
            'author_id' => 'New Author'
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals(2, Book::first()->author_id);

        $response->assertRedirect($book->path());
    }

    /** @test */
    public function it_can_delete_book()
    {
        $this->post('books', $this->data());

        $book = Book::first();
        $this->assertCount(1, Book::all());
        $response = $this->delete($book->path());

        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');
    }
    /** @test */
    public function it_can_add_author_automatically()
    {
        $this->withoutExceptionHandling();
        $this->post('books', [
            'title' => 'Title',
            'author_id' => 'Arthur',
        ]);
        $book = Book::first();
        $author = Author::first();



        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());
    }

    private function data()
    {
        return [
            'title' => 'Title',
            'author_id' => 'Author'
        ];
    }
}
