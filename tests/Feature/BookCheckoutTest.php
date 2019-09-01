<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Book;
use App\Reservation;

class BookCheckoutTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_book_can_be_checkout_by_a_signed_user()
    {  
        // $this->withoutExceptionHandling();

        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user)
             ->post('/checkout/'. $book->id);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id );
        $this->assertEquals($book->id, Reservation::first()->book_id ); 
        $this->assertEquals(now() ,  Reservation::first()->checkout_at );
    }

    /** @test */
    public function only_signed_users_can_be_checkout_book()
    {
        $this->withoutExceptionHandling();

        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        $this->post('/checkout/'. $book->id)->assertRedirect('/login'); 
        $this->assertCount(0, Reservation::all());  
    }

    /** @test */
    public function only_exist_books_can_be_checked_out()
    { 
        $user = factory(User::class)->create();
        
        $this->actingAs($user)
             ->post('/checkout/123')->assertStatus(404); 
 
        $this->assertCount(0, Reservation::all());   
    }


    /** @test */
    public function a_book_can_checkin_by_signed_user()
    { 
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user)->post('/checkout/'. $book->id); 
        $this->actingAs($user)->post('/checkin/'. $book->id);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id );
        $this->assertEquals($book->id, Reservation::first()->book_id ); 
        $this->assertEquals(now() ,  Reservation::first()->checkin_at );
        
    }


    /** @test */
    public function only_signed_users_can_be_checkin_book()
    {  
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user)->post('/checkout/'. $book->id); 
        auth()->logout();
        $this->post('/checkin/'. $book->id)->assertRedirect('/login');   

        $this->assertCount(1, Reservation::all());
        $this->assertNull( Reservation::first()->checkin_at );
    }


    /** @test */
    public function a_404_is_thrown_if_a_book_is_not_checked_out_first()
    {  
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();
 
        $this->actingAs($user)
             ->post('/checkin/'. $book->id)
             ->assertStatus(404);

        $this->assertCount(0, Reservation::all()); 
    }


}
