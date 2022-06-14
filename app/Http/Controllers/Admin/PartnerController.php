<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerRequest;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.partners.index');
    }

    public function draw(Request $request): \Illuminate\Http\JsonResponse
    {
        $raw = "CONCAT(`title_am`,' ',`description_am`,' ',`title_en`,' ',`description_en`)";
        $query = Partner::searchFor($request, $raw)->with('image');
        $records = $query->get()->toArray();
        $searchValue = $request->get('search')['value'];
        $totalDisplayRecords = Partner::where(DB::raw($raw), 'like', '%' . $searchValue . '%')
            ->orWhere('id', $searchValue)->count();

        $response = [
            "draw" => intval($request->get('draw')),
            "iTotalRecords" => Partner::select('count(*) as allcount')->count(),
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
        return view('admin.partners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\PartnerRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PartnerRequest $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();
            $partner = Partner::create($validated);
            DB::commit();
            return redirect()->route('admin.partners.edit', $partner->id)->withSuccess('Successfully Created!');
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return redirect()->back()->withInput()->withError($exception->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($partnerId)
    {
        $partner = Partner::with('image')->where('id', $partnerId)->firstOrFail();

        return view('admin.partners.edit', ['partner' => $partner,]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\PartnerRequest $request
     * @param \App\Models\Partner $partner
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PartnerRequest $request, Partner $partner): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();

        if (!isset($validated['is_partner'])) {
            $validated['is_partner'] = 0;
        }

        try {
            DB::beginTransaction();
            $partner->update($validated);
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
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Partner $partner): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();
            $partner->delete();
            DB::commit();
            return redirect()->back();
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return redirect()->back()->with('error', "Partner hasn't been deleted !");
        }
    }
}
