<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Author;

class AuthorTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function  only_name_required_to_create_author()
    {
        Author::firstOrCreate([
            'name' => 'joe dhon'
        ]);

        $this->assertCount(1, Author::all());
    }
}
