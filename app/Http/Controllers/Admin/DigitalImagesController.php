<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DigitalImagesRequest;
use App\Models\DigitalImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DigitalImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.digital-images.index');
    }

    public function draw(Request $request): \Illuminate\Http\JsonResponse
    {
        $raw = "CONCAT(`title_en`,' ',`title_am`,' ')";
        $query = DigitalImages::searchFor($request, $raw)->with('attachment');
        $records = $query->orderBy('order', 'asc')->get()->toArray();
        $searchValue = $request->get('search')['value'];
        $totalDisplayRecords = DigitalImages::where(DB::raw($raw), 'like', '%' . $searchValue . '%')
            ->orWhere('id', $searchValue)->count();

        $response = [
            "draw" => intval($request->get('draw')),
            "iTotalRecords" => DigitalImages::count(),
            "iTotalDisplayRecords" => $totalDisplayRecords,
            "aaData" => $records
        ];

        return response()->json($response);
    }

    public function sort(Request $request)
    {
        try {
            $digitalImages = DigitalImages::all();

            foreach ($digitalImages as $digitalImage) {
                foreach ($request->order as $order) {
                    if ($order['id'] == $digitalImage->id) {
                        $digitalImage->update(['order' => $order['position']]);
                    }
                }
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.digital-images.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  DigitalImagesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DigitalImagesRequest $request)
    {
        $validated = $request->validated();
        $validated['order'] = DigitalImages::max('order') + 1;

        try {
            DB::beginTransaction();
            $digitalImage = DigitalImages::create($validated);
            DB::commit();

            return redirect()->route('admin.digital-images.edit', $digitalImage->id)->withSuccess('Successfully Created!');
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return redirect()->back()->withInput()->withError($exception->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\DigitalImages $digitalImage
     * @return \Illuminate\Http\Response
     */
    public function edit(DigitalImages $digitalImage)
    {
        return view('admin.digital-images.edit', compact('digitalImage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DigitalImagesRequest $request
     * @param \App\Models\DigitalImages $digitalImage
     * @return \Illuminate\Http\Response
     */
    public function update(DigitalImagesRequest $request, DigitalImages $digitalImage)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();
            $digitalImage->update($validated);
            DB::commit();
            return redirect()->back()->withSuccess('Successfully Updated!');
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return redirect()->back()->withInput()->withError($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\DigitalImages $digitalImage
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DigitalImages $digitalImage)
    {
        try {
            DB::beginTransaction();
            $digitalImage->delete();
            DB::commit();
            return redirect()->back();
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return redirect()->back()->with('error', "Digital image hasn't been deleted !");
        }
    }
}
