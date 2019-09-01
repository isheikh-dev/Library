<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Author;
use App\Http\Requests\AuthorCreateRequest;

class AuthorController extends Controller
{
    public function store(AuthorCreateRequest $authorCreateRequest){
        Author::create([
            'name' => request('name'),
            'dob' => request('dob')
        ]);
    }
}
