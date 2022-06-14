<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProgramsRequest;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.programs.index');
    }

    public function draw(Request $request)
    {
        $raw = "CONCAT(`title_en`,' ',`title_am`,' ',`description_am`,' ',`description_en`,' ')";
        $query = Program::searchFor($request, $raw)->with('attachment');
        $records = $query->get()->toArray();
        $searchValue = $request->get('search')['value'];
        $totalDisplayRecords = Program::where(DB::raw($raw), 'like', '%' . $searchValue . '%')
            ->orWhere('id', $searchValue)->count();

        $response = [
            "draw" => intval($request->get('draw')),
            "iTotalRecords" => Program::count(),
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
        return view('admin.programs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\ProgramsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProgramsRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();
            $program = Program::create($validated);
            DB::commit();
            return redirect()->route('admin.programs.edit', $program->id)->withSuccess('Successfully Created!');
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return redirect()->back()->withInput()->withError($exception->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function edit(Program $program)
    {
        return view('admin.programs.edit', compact('program'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\ProgramsRequest $request
     * @param \App\Models\Program $program
     * @return \Illuminate\Http\Response
     */
    public function update(ProgramsRequest $request, Program $program)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();
            $program->update($validated);
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
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function destroy(Program $program)
    {
        try {
            DB::beginTransaction();
            $program->delete();
            DB::commit();
            return redirect()->back();
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return redirect()->back()->with('error', "Analyze hasn't been deleted !");
        }
    }
}
