<?php

namespace App\Models;

use App\Models\Rating;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Instructor extends Model
{
    use HasFactory;

    public function ratings(): MorphMany
    {
        return $this->morphMany(Rating::class,'ratingable');
    }
    public function questionaires():MorphToMany
    {
        return $this->morphToMany(Questionaire::class,'evaluatable')->withTimestamps();
    }
}