<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Book;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;
   /** @test  */
   public function a_book_can_be_add_to_library() {

       $this->withoutExceptionHandling();

        $response = $this->post('/books', [
                        'title' => "Cool Book Title",
                        'author' => "ibrahem",
                    ]);

        $response->assertOk();
       $this->assertCount(1, Book::all());
   }


    /** @test  */
    public function a_title_is_required() {

        $this->withoutExceptionHandling();
 
         $response = $this->post('/books', [
                         'title' => "",
                         'author' => "ibrahem",
                     ]);
 
         $response->assertSessionHasErrors('title');
     }


     /** @test  */
    public function a_author_is_required() {

        $this->withoutExceptionHandling();
 
         $response = $this->post('/books', [
                         'title' => "Cool Book Title",
                         'author' => " ",
                     ]);
 
         $response->assertSessionHasErrors('author');
     }


     /** @test  */
   public function a_book_can_be_update_to_library() {

        $this->withoutExceptionHandling();

        $this->post('/books', [
                'title' => "Cool Book Title",
                'author' => "ibrahem",
        ]);

        $book = Book::first();
        $this->patch('/books/' . $book->id, [
            'title' => "new title",
            'author' => "ibrahem",
        ]);

        $this->assertEquals('new title', Book::first()->title);
        $this->assertEquals('ibrahem', Book::first()->author);
}
}
