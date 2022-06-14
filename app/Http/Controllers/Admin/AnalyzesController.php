<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnalyzesRequest;
use App\Models\Analyzes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyzesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.analyzes.index');
    }

    public function draw(Request $request)
    {
        $raw = "CONCAT(`title_am`,' ',`title_en`,' ')";
        $query = Analyzes::searchFor($request, $raw)->with('attachment');
        $records = $query->get()->toArray();
        $searchValue = $request->get('search')['value'];
        $totalDisplayRecords = Analyzes::where(DB::raw($raw), 'like', '%' . $searchValue . '%')
            ->orWhere('id', $searchValue)->count();

        $response = [
            "draw" => intval($request->get('draw')),
            "iTotalRecords" => Analyzes::count(),
            "iTotalDisplayRecords" => $totalDisplayRecords,
            "aaData" => $records
        ];

        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.analyzes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\AnalyzesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnalyzesRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();
            $analyze = Analyzes::create($validated);
            DB::commit();
            return redirect()->route('admin.analyzes.edit', $analyze->id)->withSuccess('Successfully Created!');
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return redirect()->back()->withInput()->withError($exception->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Analyzes $analyze
     * @return \Illuminate\Http\Response
     */
    public function edit(Analyzes $analyze)
    {
        return view('admin.analyzes.edit', compact('analyze'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\AnalyzesRequest $request
     * @param \App\Models\Analyzes $analyze
     * @return \Illuminate\Http\Response
     */
    public function update(AnalyzesRequest $request, Analyzes $analyze)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();
            $analyze->update($validated);
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
     * @param Analyzes $analyze
     * @return \Illuminate\Http\Response
     */
    public function destroy(Analyzes $analyze)
    {
        try {
            DB::beginTransaction();
            $analyze->delete();
            DB::commit();
            return redirect()->back();
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return redirect()->back()->with('error', "Analyze hasn't been deleted !");
        }
    }
}
