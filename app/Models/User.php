<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use SebastianBergmann\CodeUnit\FunctionUnit;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function isAdmin(){
        return array_search("admin", array_column(json_decode($this->roles, true), "value")) !== false ? true : false;
    }

    public function isWorker(){
        return array_search("worker", array_column(json_decode($this->roles, true), "value")) !== false ? true : false;
    }

    public function isUser(){
        return array_search("user", array_column(json_decode($this->roles, true), "value")) !== false ? true : false;
    }

    public function getRole(){
        return array_column(json_decode($this->roles, true), "value");
    }
}
