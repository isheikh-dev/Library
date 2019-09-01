<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class BookController extends Controller
{
    public function store()
    { 
        $book = Book::create($this->validateRequest()); 
        return redirect('/books/' . $book->id); 
    }

    public function update(Book $book)
    { 
        $book->update($this->validateRequest());    
        return redirect('/books/' . $book->id); 
    }

    public function destory(Book $book)
    { 
        $book->delete();     
        return redirect('books');
    }

    public function checkout(Book $book){
        if(auth()->user())
        {   
            $book->checkout(auth()->user()); 
        } 
        return redirect('/login');    
    }

    public function checkin(Book $book){
        if(auth()->user()){
            try{
                $book->checkin(auth()->user());
            } catch(\Exception $e){
                return response([], 404);
            }  
        } 
        return redirect('/login');    
    }

    public function  validateRequest()
    {
        return  request()->validate([
            'title' => 'required',
            'author_id' => "required"
        ]);
    }
}
