<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Author;
use Carbon\Carbon;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function it_can_add_author()
    {
        $this->post('/authors', $this->data());

        $author = Author::all();
        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);

        $this->assertEquals('1992/14/05', $author->first()->dob->format('Y/d/m'));
    }

    /** @test */
    public function name_is_required()
    {
        $response = $this->post('authors', array_merge($this->data(), ['name' =>'']));
        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function dob_is_required()
    {
        $response = $this->post('authors', array_merge($this->data(), ['dob' =>'']));
        $response->assertSessionHasErrors('dob');
    }

    private function data()
    {
        return [
            'name' => 'New Author',
            'dob' => '05/14/1992',
        ];
    }
}
