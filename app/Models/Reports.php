<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reports extends AppModel
{
    use HasFactory;

    protected $fillable = ['title_am', 'title_en', 'description_en', 'description_am', 'attachments'];

    public function setAttachmentsAttribute($value)
    {
        $this->attributes['attachments'] = is_array($value) ? json_encode($value) : $value;
    }

    public function getAttachmentsAttribute()
    {
        return $this->attributes['attachments'] ? json_decode($this->attributes['attachments']) : [];
    }

    public function getAttachments($attachment)
    {
        $files = 'files_' . \App::getLocale();
        return Attachment::whereIn('id', $attachment->$files)->get();
    }
}
