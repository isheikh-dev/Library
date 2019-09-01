<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Book;
use App\Author;

class BookManagmentTest extends TestCase
{
    use RefreshDatabase;
    /** @test  */
    public function a_book_can_be_added_to_library() {

       $this->withoutExceptionHandling();

        $response = $this->post('/books', $this->bookCreate());

        $book = Book::first();

 
       $this->assertCount(1, Book::all());
       $response->assertRedirect('/books/' . $book->id);
    } 
    /** @test  */
    public function a_title_is_required() {

        // $this->withoutExceptionHandling();
 
         $response = $this->post('/books', $this->bookCreate(''));
 
         $response->assertSessionHasErrors('title');
    } 
     /** @test  */
    public function a_author_is_required() {

        // $this->withoutExceptionHandling();
 
         $response = $this->post('/books', $this->bookCreate('title', ''));
 
         $response->assertSessionHasErrors('author_id');
    } 
     /** @test  */
    public function a_book_can_be_updated_to_library() {

        $this->withoutExceptionHandling();

        $this->post('/books', $this->bookCreate());

        $book = Book::first();
        $response = $this->patch('/books/' . $book->id,[
            'title' => 'new title',
            'author_id' => 'new author'
        ]);

        $this->assertEquals('new title',Book::first()->title);
        $this->assertEquals(2, Book::first()->author_id);
        $response->assertRedirect('/books/' . Book::first()->id);
    }
    /** @test  */
    public function a_book_can_be_deleted_from_library() {

        $this->withoutExceptionHandling();

        $this->post('/books', $this->bookCreate());

        $this->assertCount(1, Book::all());

        $book = Book::first();
        $response = $this->delete('/books/' . $book->id);

        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }


     /** @test */
     public function a_new_author_is_automaticaly_added(){

        $this->withoutExceptionHandling();

        $this->post('/books', $this->bookCreate());

        $book = Book::first();
         $author = Author::first();

        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());
    }

    /** data to create Book */
    public function bookCreate($title  = "Cool Book Title", $author_id = 'ibrahem') : array {
        return [
            'title' => $title,
            'author_id' => $author_id,
        ];
    }
}
 