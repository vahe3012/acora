<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use function response;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index()
    {
        $query = Attachment::orderBy('id', 'desc');
        $data = ['page' => $_GET['page'] ?? 1, 'perPage' => $_GET['perPage'] ?? 22];
        $data['total'] = Attachment::count();
        $data['items'] = $query->skip(($data['page'] - 1) * $data['perPage'])->take($data['perPage'])->get();
        return response()->json($data);
    }
}
