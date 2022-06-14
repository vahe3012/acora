<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends AppModel
{
    use HasFactory;

    protected $fillable = ['fullname_am', 'fullname_en', 'position_am', 'position_en', 'description_am', 'description_en', 'attachment_id'];

    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'id', 'attachment_id');
    }
}
