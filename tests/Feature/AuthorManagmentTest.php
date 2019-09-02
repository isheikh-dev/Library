<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Author;
use Carbon\Carbon;

class AuthorManagmentTest extends TestCase
{
    use RefreshDatabase;
    /** @test */ 
    public function a_author_can_be_created(){

        $this->withoutExceptionHandling();

        $this->post('/authors/create', $this->AuthorData());
        $author = Author::all();
        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
        $this->assertEquals('1998/04/05', $author->first()->dob->format('Y/d/m'));
    }

    /** @test */ 
    public function a_name_is_required(){ 

        $response = $this->post('/authors/create',array_merge($this->AuthorData(), ['name' => '']));

        $response->assertSessionHasErrors('name');
    }

     /** @test */ 
     public function a_dob_is_required(){ 

        $response = $this->post('/authors/create',array_merge($this->AuthorData(), ['dob' => '']));

        $response->assertSessionHasErrors('dob');
    }



    public function AuthorData(){
        return  [
            'name' => 'Author Name',
            'dob' => '05/04/1998'
        ];
    }

   
}
