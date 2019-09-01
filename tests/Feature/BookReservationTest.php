<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReservationTest extends TestCase
{
   /** @test **/
   public function a_book_can_be_add_to_library() {

       $this->withoutExceptionHandling();
       
        $response = $this->post('/books', [
                        'title' => "Cool Book Title",
                        'author' => "ibrahem",
                    ]);

        $response->assertOk();
       $this->assertCount(1, Book::all());
   }
}
