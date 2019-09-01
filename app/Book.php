<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // protected $fillable = ['title', 'author'];
    protected $guarded = [];

    public function setAuthorIdAttribute($attribute){
       $this->attributes['author_id'] = Author::firstOrCreate([
            'name' => $attribute,
       ])->id;
    }
}
