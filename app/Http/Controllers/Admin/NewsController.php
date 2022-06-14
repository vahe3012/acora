<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Models\Category;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.news.index');
    }

    public function draw(Request $request): \Illuminate\Http\JsonResponse
    {
        $raw = "CONCAT(`title_am`,' ',`title_en`,' ',`excerpt_am`,' ',`excerpt_en`,' ',`content_am`,' ',`content_en`,' ')";
        $query = News::searchFor($request, $raw)->with('mainImage', 'categories');
        $records = $query->get()->toArray();
        $searchValue = $request->get('search')['value'];
        $totalDisplayRecords = News::where(DB::raw($raw), 'like', '%' . $searchValue . '%')
            ->orWhere('id', $searchValue)->count();

        $response = [
            "draw" => intval($request->get('draw')),
            "iTotalRecords" => News::count(),
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
        return view('admin.news.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\NewsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsRequest $request)
    {
        $validated = $request->validated();

        if (!$validated['date']) {
            $validated['date'] = Carbon::now()->format('Y-m-d');
        }

        try {
            DB::beginTransaction();
            $categories = [];

            if (isset($validated['categories'])) {
                $categories = $validated['categories'];
                unset($validated['categories']);
            }

            $news = News::create($validated);
            $news->categories()->sync($categories);
            DB::commit();
            return redirect()->route('admin.news.edit', $news->id)->withSuccess('Successfully Created!');
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return redirect()->back()->withInput()->withError($exception->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\News $news
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($newsId)
    {
        $news = News::findOrFail($newsId);
        $categories = Category::all();
        return view('admin.news.edit', ['news' => $news, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\NewsRequest $request
     * @param \App\Models\News $news
     * @return \Illuminate\Http\Response
     */
    public function update(NewsRequest $request, News $news)
    {
        $validated = $request->validated();

        if (!$validated['date']) {
            $validated['date'] = $news->created_at->format('Y-m-d');
        }

        try {
            DB::beginTransaction();
            $categories = [];

            if (isset($validated['categories'])) {
                $categories = $validated['categories'];
                unset($validated['categories']);
            }

            $news->update($validated);
            $news->categories()->sync($categories);
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
     * @param \App\Models\News $news
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        try {
            DB::beginTransaction();
            $news->delete();
            DB::commit();
            return redirect()->back();
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return redirect()->back()->with('error', "News hasn't been deleted !");
        }
    }
}
