@extends('layouts.app')

@section('content')
    <div class="w-2/3 bg-gray-200 mx-auto">
        
       <form action="/authors/create" method="POST" class="flex flex-col items-center" >
        <h1>Add New Author</h1>
            @csrf
            <div class="pt-4">
            <input type="text" name="name" placeholder="Full Name" class="rounded px-4 py-2 w-64" value="{{old('name')}}"> 
                @error('name')   <p class="text-red-600" >{{$message}} </p> @enderror
            </div>
            <div class="pt-4">
                <input type="text" name="dob" placeholder="your date of birth" class="rounded px-4 py-2 w-64"  value="{{old('dob')}}">
                @error('dob')   <p class="text-red-600" >{{$message}} </p> @enderror
            </div>
            <div class="pt-4">
                <button class="bg-blue-400 text-white rounded py-2 px-4" type="submit">Add new Author</button>
            </div>
       </form>
    </div>
@endsection