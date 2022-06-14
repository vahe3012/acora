<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CoursesRequest;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.courses.index');
    }

    public function draw(Request $request)
    {
        $raw = "CONCAT(`title_am`,' ',`title_en`,' ',`description_am`,' ',`description_en`,' ')";
        $query = Course::searchFor($request, $raw);
        $records = $query->get()->toArray();
        $searchValue = $request->get('search')['value'];
        $totalDisplayRecords = Course::where(DB::raw($raw), 'like', '%' . $searchValue . '%')
            ->orWhere('id', $searchValue)->count();

        $response = [
            "draw" => intval($request->get('draw')),
            "iTotalRecords" => Course::count(),
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
        return view('admin.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\CoursesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CoursesRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            if ($validated['is_main']) {
                $oldMain = Course::where('is_main', 1)->first();

                if ($oldMain) {
                    $oldMain->is_main = 0;
                    $oldMain->save();
                }
            }

            $course = Course::create($validated);
            DB::commit();
            return redirect()->route('admin.courses.edit', $course->id)->withSuccess('Successfully Created!');
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return redirect()->back()->withInput()->withError($exception->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\CoursesRequest $request
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function update(CoursesRequest $request, Course $course)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            if ($validated['is_main']) {
                $oldMain = Course::where('is_main', 1)->first();

                if ($oldMain && $oldMain->id != $course->id) {
                    $oldMain->is_main = 0;
                    $oldMain->save();
                }
            }

            $course->update($validated);
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
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Course $course)
    {
        try {
            DB::beginTransaction();
            $course->delete();
            DB::commit();
            return redirect()->back();
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return redirect()->back()->with('error', "Analyze hasn't been deleted !");
        }
    }
}
