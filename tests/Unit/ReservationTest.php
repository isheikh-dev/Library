<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Book;
use App\User;
use App\Reservation;

class ReservationTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_book_can_be_check_out(){

       $this->withoutExceptionHandling();
    
       $book  =  factory(Book::class)->create();
       $user =  factory(User::class)->create();

       $book->checkout($user);

       $this->assertCount(1, Reservation::all());
       $this->assertEquals($user->id, Reservation::first()->user_id );
       $this->assertEquals($book->id, Reservation::first()->book_id ); 
       $this->assertEquals(now() ,  Reservation::first()->checkout_at );

    }

     /** @test */
     public function a_book_can_be_checkin(){

        $this->withoutExceptionHandling();
     
        $book  =  factory(Book::class)->create();
        $user =  factory(User::class)->create();

        $book->checkout($user);
        $book->checkin($user);
 
        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id );
        $this->assertEquals($book->id, Reservation::first()->book_id );
        $this->assertEquals(now()  ,  Reservation::first()->checkin_at );
 
     }

    /** @test */
    public function a_book_can_be_checkout_with_user_twice(){

        $this->withoutExceptionHandling();
        
        $book =  factory(Book::class)->create();
        $user =  factory(User::class)->create();

        $book->checkout($user);
        $book->checkin($user);

        $book->checkout($user);

        $this->assertCount(2, Reservation::all());
        $this->assertEquals($user->id, Reservation::find(2)->user_id );
        $this->assertEquals($book->id, Reservation::find(2)->book_id );
        $this->assertNull(Reservation::find(2)->checkin_at );
        $this->assertEquals(now()  ,  Reservation::find(2)->checkout_at );

        $book->checkin($user);

        $this->assertCount(2, Reservation::all());
        $this->assertEquals($user->id, Reservation::find(2)->user_id );
        $this->assertEquals($book->id, Reservation::find(2)->book_id );
        $this->assertNotNull(Reservation::find(2)->checkin_at );
        $this->assertEquals(now() , Reservation::find(2)->checkin_at );

    }

    /** @test */
    public function book_id_not_checked_out_throw_exception(){

        $this->withoutExceptionHandling();

        $this->expectException(\Exception::class); 
        
        $book =  factory(Book::class)->create();
        $user =  factory(User::class)->create(); 
       
        $book->checkin($user);
    }
}
