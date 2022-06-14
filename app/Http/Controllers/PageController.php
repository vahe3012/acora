<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.index');
    }


    public function draw(Request $request): \Illuminate\Http\JsonResponse
    {

        $query = Page::query();
        $draw = $request->get('draw');
        $start = $request->get("start");
        $total = $query->count();
        $rowperpage = $request->get("length"); // Rows display per page
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr ? $columnIndex_arr[0]['column'] : 0; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr ? $order_arr[0]['dir'] : 'asc'; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records

        if ($searchValue) {
            $query->where(DB::raw("CONCAT(`title`,' ', `id`,' ', `slug`,' ')"), 'like', '%' . $searchValue . '%')
                ->orWhere('id', $searchValue);
        }


        $searchByStatus = $request->get('filterByStatus');
        if ($searchByStatus) {
            $query->where('status', $searchByStatus)->get();
        }

        $totalRecordswithFilter = $query->count();
        $records = $query->orderBy($columnName, $columnSortOrder)->skip($start)->take($rowperpage)->get()->toArray();

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $total,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $records
        );

        return response()->json($response);
    }






















    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePageRequest  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePageRequest $request, Page $page)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        //
    }
}
