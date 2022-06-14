<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as ImageStore;


class Attachment extends Model
{
    use HasFactory;

    public $timestamps = false;

    const UPLOAD_DIR = 'media/';
    const VIDEO_FORMATS = [
        'mp4', 'avi', 'flv', 'mov', 'wmv', '3gp', 'ts', 'm3u8'
    ];

    protected $appends = ['urls'];
    protected $guarded = [];

    public function getUrlsAttribute(): array
    {

        $urls["original"] = asset('storage/' . self::UPLOAD_DIR . $this->path . '.' . $this->format);

        foreach (config('image.sizes') as $sizeName => $size) {
            $urls[$sizeName] = asset('storage/' . self::UPLOAD_DIR . $this->path . '_' . $size['width'] . 'x' . $size['height'] . '.' . $this->format);
            $path = (self::UPLOAD_DIR . $this->path . '_' . $size['width'] . 'x' . $size['height'] . '.' . $this->format);
            if (!Storage::disk('public')->exists($path)) {
                $urls[$sizeName] = $urls["original"];
//                $urls['small'] = $urls["original"];
//                $urls['large'] = $urls["original"];
            }
        }


        return $urls;
    }

    public static function upload($file)
    {
        try {
            $publicDisk = Storage::disk('public');
            $fileName = $file->getClientOriginalName();
            $lastPos = 0;
            $positions = [];

            while (($lastPos = strpos($fileName, '.', $lastPos)) !== false) {
                $positions[] = $lastPos;
                $lastPos = $lastPos + strlen('.');
            }

            $fileName = substr($fileName, 0, end($positions));
            $now = Carbon::now();
            $format = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $uploadPath = $now->year . '-' . ($now->month < 10 ? '0' : '') . $now->month . '/' . $fileName . '_' . microtime();
            $videoFormats = static::VIDEO_FORMATS;
            array_push($videoFormats, 'pdf');

            if (!in_array($format, (array)$videoFormats)) {
                $attachment = ImageStore::make($file);
                $attachment->backup();
                $publicDisk->put(self::UPLOAD_DIR . $uploadPath . '.' . $format, $attachment->encode()->__toString());

                if (strstr(url()->previous(), 'news')) {
                    foreach (config('image.sizes') as $size) {
                        $attachment->resize(null, $size['height'], function ($constraint) {
                            $constraint->aspectRatio();
                        });

                        $publicDisk->put(self::UPLOAD_DIR . $uploadPath . '_' . $size['width'] . 'x' . $size['height'] . '.' . $format, $attachment->encode()->__toString());
                        $attachment->reset();
                    }
                }
            } else {
                $attachment = $file;
                $publicDisk->put(self::UPLOAD_DIR . $uploadPath . '.' . $format, file_get_contents($attachment));
            }

            return [
                'path' => $uploadPath,
                'format' => $format,
                'name' => $fileName,
            ];
        } catch (\Exception $exception) {
            return false;
        }
    }

    public static function isVideo($path): bool
    {
        $extension = \File::extension($path);
        return in_array($extension, static::VIDEO_FORMATS);
    }
}
