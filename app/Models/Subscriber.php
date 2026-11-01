<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Subscriber extends Model
{
    use Notifiable;

    protected $fillable = [
        'email',
        'token', 
        'is_verified',
        'verified_at',
        
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    protected static function boot(): void{
        parent::boot();

        static::creating(callback: function ($subscriber): void{
            $subscriber->token = \Str::random(length: 32);
        });
    }

    // required for sending notificaitons to subscribers

    public function routeNotificationforMain(): mixed {
        return $this->email;
    }
}
