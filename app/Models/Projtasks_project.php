<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projtasks_project extends Model
{
    use HasFactory;

    protected $fillable = ["project_id", "projtask_id"];


    public function projtasks(){
        return $this->belongsTo(Project::class);
    }

    public function projtask(){
        return $this->belongsTo(Projtask::class);
    }

}
