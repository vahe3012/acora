<?php
namespace App\Services;

use App\Models\Attachment;
use App\Models\Gallery;

class HelperService {
    public function filterText($text) {
        if(!is_string($text)) {
            return $text;
        }

        return htmlspecialchars_decode(trim(preg_replace('/\s+/', '', $text)));
    }
    public function getAuthUser () {
        $user = \Illuminate\Support\Facades\Auth::user();

        if(!$user) {
            return null;
        }

        $role = $user->roles && isset($user->roles[0]) ? $user->roles[0]['name'] : null;

        return [
          'id' => $user->id,
          'name' => $user->name,
          'email' => $user->email,
          'nickname' => $user->nickname,
          'role' => $role,
          'isAdmin' => $role === 'admin' || $role === 'Super Admin',
          'isSuperAdmin' => $role === 'Super Admin',
        ];
    }

    public function initGalleries ($content) {
        if(!$content) {
            return $content;
        }
        $segments = explode('{||gallery_', $content);
        unset($segments[0]);

        $galleryIds = [];
        foreach ($segments as $segment) {
            $galleryIds[] = explode('||}', $segment)[0];
        }

        $galleries = Gallery::whereIn('id', $galleryIds)->with('images')->get();

        foreach ($galleries as $gallery) {
            $galleryHtml = '<div class="gallery-carousel row"><div class="main-carousel col-md-6 offset-3" id="gallery_' . $gallery->id . '" data-flickity=\'{ }\'>';
            foreach($gallery->images as $image) {

                $galleryHtml .= '<div class="carousel-cell"><img src="'.$image->urls['large'].'"></div>';
            }
            $galleryHtml .= '</div></div>';

            $content = str_replace('{||gallery_' . $gallery->id . '||}', $galleryHtml, $content);
        }

        return $content;
    }
}
