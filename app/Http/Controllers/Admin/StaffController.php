<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StaffRequest;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.staff.index');
    }

    public function draw(Request $request)
    {
        $raw = "CONCAT(`fullname_am`,' ',`fullname_en`,' ',`description_am`,' ',`description_en`,' ',`position_am`,' ',`position_en`,' ')";
        $query = Staff::searchFor($request, $raw)->with('attachment');
        $records = $query->get()->toArray();
        $searchValue = $request->get('search')['value'];
        $totalDisplayRecords = Staff::where(DB::raw($raw), 'like', '%' . $searchValue . '%')
            ->orWhere('id', $searchValue)->count();

        $response = [
            "draw" => intval($request->get('draw')),
            "iTotalRecords" => Staff::count(),
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
        return view('admin.staff.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StaffRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StaffRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();
            $staff = Staff::create($validated);
            DB::commit();
            return redirect()->route('admin.staff.edit', $staff->id)->withSuccess('Successfully Created!');
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return redirect()->back()->withInput()->withError($exception->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff)
    {
        return view('admin.staff.edit', ['staff' => $staff]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\StaffRequest $request
     * @param \App\Models\Staff $staff
     * @return \Illuminate\Http\Response
     */
    public function update(StaffRequest $request, Staff $staff)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();
            $staff->update($validated);
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
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        try {
            DB::beginTransaction();
            $staff->delete();
            DB::commit();
            return redirect()->back();
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return redirect()->back()->with('error', "Analyze hasn't been deleted !");
        }
    }
}
