<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class NewsController extends Controller
{
    public function getTable(Request $request, $slug = null)
    {
        $currentPage = $request->get('pageNum');
        // Set the paginator to the current page
        Paginator::currentPageResolver(function() use ($currentPage) {
            return $currentPage;
        });

        return view("front.partials._news", $this->getNewsData($slug));
    }

    public function news($slug = null)
    {
        return view('front.news', $this->getNewsData($slug));
    }

    private function getNewsData($slug)
    {
        $allCats = null;

        if ($slug) {
            $allCats = Category::where('slug', $slug)->with('news')->firstOrFail();
            $news = $allCats->news()->orderBy('date', 'desc');
        } else {
            $news = News::query()->orderBy('date', 'desc');
        }

        $news = $news->paginate(5);
        return compact('allCats', 'news');
    }

    public function single(News $news)
    {
        $category = $news->categories()->pluck('id');
        $relatedNews = News::whereNotIn('id', [$news->id])->whereHas('categories', function (Builder $query) use ($category) {
            $query->wherein('id', $category);
        })->orderBy('updated_at', 'desc')->limit(3)->get();

        return view('front.singlenews', ['news' => $news, 'relatedNews' => $relatedNews]);
    }
}
