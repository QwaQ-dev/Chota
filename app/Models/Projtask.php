<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projtask extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "text", "status"];


    public function user(){
        return $this->belongsTo(User::class);
    }
}
