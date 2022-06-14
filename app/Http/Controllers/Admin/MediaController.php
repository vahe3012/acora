<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use Illuminate\Http\Request;
use function response;
use function view;

class MediaController extends Controller
{
    public function index()
    {
        $items = Attachment::all();
        return view('partners.index', ['items' => $items]);
    }

    public function uploadFile(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'attachment' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf,' . implode(',', Attachment::VIDEO_FORMATS),
        ]);

        $uploaded = Attachment::upload($request->file('attachment'));

        $created = Attachment::create([
            'path' => $uploaded['path'],
            'format' => $uploaded['format'],
            'name' => $uploaded['name'],
        ]);

        return response()->json(['success' => true, 'item' => $created]);
    }

    public function deleteFile($id)
    {
        $attachment = Attachment::findOrFail($id);

        try {
            if ($attachment) {
                foreach ($attachment->urls as $url) {
                    $url = substr($url, strpos($url, "/media/"));
                    \Storage::delete('/public' . $url);
                }

                $attachment->delete();
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'File not found']);
            }
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()]);
        }
    }
}
