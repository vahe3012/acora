<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportsRequest;
use App\Models\Category;
use App\Models\Reports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.reports.index');
    }

    public function draw(Request $request): \Illuminate\Http\JsonResponse
    {
        $raw = "CONCAT(`title_am`,' ',`description_am`,' ', `title_en`,' ',`description_en`,' ')";
        $query = Reports::searchFor($request, $raw);
        $records = $query->get()->toArray();
        $searchValue = $request->get('search')['value'];
        $totalDisplayRecords = Reports::where(DB::raw($raw), 'like', '%' . $searchValue . '%')
            ->orWhere('id', $searchValue)->count();

        $response = [
            "draw" => intval($request->get('draw')),
            "iTotalRecords" => Reports::count(),
            "iTotalDisplayRecords" => $totalDisplayRecords,
            "aaData" => $records
        ];

        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.reports.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\ReportsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReportsRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();
            $report = Reports::create($validated);
            DB::commit();
            return redirect()->route('admin.reports.edit', $report->id)->withSuccess('Successfully Created!');
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return redirect()->back()->withInput()->withError($exception->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reports  $report
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Reports $report)
    {
        $categories = Category::all();
        return view('admin.reports.edit', ['report' => $report, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\ReportsRequest $request
     * @param \App\Models\Reports $report
     * @return \Illuminate\Http\Response
     */
    public function update(ReportsRequest $request, Reports $report)
    {
        $validated = $request->validated();

        if (!isset($validated['attachments'])) {
            $report->attachments = '';
        }

        foreach ($validated['attachments'] as $i => $attachment) {
            if (!isset($attachment['files_am']) || !isset($attachment['files_en'])) unset($validated['attachments'][$i]);
        }

        try {
            DB::beginTransaction();
            $report->update($validated);
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
     * @param  \App\Models\Reports  $report
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy(Reports $report)
    {
        try {
            DB::beginTransaction();
            $report->delete();
            DB::commit();
            return redirect()->back();
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return redirect()->back()->with('error', "Reports hasn't been deleted !");
        }
    }
}
