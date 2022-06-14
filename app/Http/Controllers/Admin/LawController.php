<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LawRequest;
use App\Models\Law;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('type')) {
            session()->put('lawType', $request->get('type'));
        }

        return view('admin.laws.index');
    }

    public function draw(Request $request): \Illuminate\Http\JsonResponse
    {
        $raw = "CONCAT(`title_en`,' ',`title_am`,' ',`link`,' ')";
        $query = Law::searchFor($request, $raw)
            ->where('type', session()->get('lawType'));

        if (session()->get('lawType') == Law::TYPE_REGULATION) {
            $query->with('attachment');
        }

        $records = $query->get()->toArray();
        $searchValue = $request->get('search')['value'];
        $totalDisplayRecords = Law::where('type', session()->get('lawType'))
            ->where(DB::raw($raw), 'like', '%' . $searchValue . '%')
            ->orWhere('id', $searchValue)->count();

        $response = [
            "draw" => intval($request->get('draw')),
            "iTotalRecords" => Law::where('type', session()->get('lawType'))->count(),
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
        return view('admin.laws.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\LawRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LawRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $law = Law::create($validated);
            DB::commit();

            return redirect()->route('admin.laws.edit', $law->id)->withSuccess('Successfully Created!');
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return redirect()->back()->withInput()->withError($exception->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Law  $law
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Law $law)
    {
        return view('admin.laws.edit', ['law' => $law]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\LawRequest  $request
     * @param  \App\Models\Law  $law
     * @return \Illuminate\Http\Response
     */
    public function update(LawRequest $request, Law $law)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();
            $law->update($validated);
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
     * @param  \App\Models\Law  $law
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy(Law $law)
    {
        try {
            DB::beginTransaction();
            $law->delete();
            DB::commit();
            return redirect()->back();
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return redirect()->back()->with('error', "Law hasn't been deleted !");
        }
    }
}
