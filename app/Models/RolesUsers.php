<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesUsers extends Model
{
    use HasFactory;
    protected $table = "role_user";

    protected $fillable = [
        'user_id',
        'role_id'
    ];
    
    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
