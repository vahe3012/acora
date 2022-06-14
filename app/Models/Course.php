<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends AppModel
{
    use HasFactory;

    protected $fillable = ['title_am', 'title_en', 'description_am', 'description_en', 'is_main'];
}
