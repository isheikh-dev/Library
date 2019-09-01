<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Reservation;

class Book extends Model
{
    // protected $fillable = ['title', 'author'];
    protected $guarded = [];

    public function setAuthorIdAttribute($attribute){
       $this->attributes['author_id'] = Author::firstOrCreate([
            'name' => $attribute,
       ])->id;
    }

    public function reservations(){
        return $this->hasMany(Reservation::class);
    }

    public function checkout(User $user){
        $this->reservations()->create([
            'user_id' => $user->id,
            'checkout_at' => now(), 
        ]);
    }

    public function checkin(User $user){
        $reservation = $this->reservations()->where('user_id', $user->id)
                             ->whereNotNull('checkout_at')
                             ->whereNull('checkin_at')
                             ->first();

        if(is_null($reservation)){
            throw new \Exception();
        };

        $reservation->update([
            'checkin_at' => now()
        ]);
    }
}
