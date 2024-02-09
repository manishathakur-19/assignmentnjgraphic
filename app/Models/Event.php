<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
   protected $fillable = ['name', 'description', 'start_date', 'end_date', 'is_active'];

    public function bookings()
    {
        return $this->hasMany(UserBooking::class, 'event_id');
    }


}