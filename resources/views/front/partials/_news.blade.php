<div class="row">
    <div class="col-sm-4 mb-5">
        <div class="tab-btn-box">
            <ul>
                <li data-tab="1" class="{{ !$allCats ? 'active' : '' }}">
                    <a href="{!! route('category.news') !!}" style="text-decoration:none">
                        <span>{{ __('main.news.all_news') }}</span></a>
                </li>
                @foreach(\App\Models\Category::all() as $category)
                    <li data-tab="2"
                        class="{{ $allCats && $allCats->slug === $category->slug ? 'active' : '' }}">
                        <a href="{!! route('category.news',[ 'slug'=> $category->slug] ) !!}"
                           style="text-decoration:none">
                            <span>{{ translate($category, 'title') }}</span></a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="col-sm-8">
        <div data-tab-content="1" class="tab-content-box active">
            <h2>{{ $allCats ? translate($allCats, 'title') : __('main.news.all_news') }}</h2>
            @if($news->count())
                @foreach($news as $singleNews)
                    <div class="news-box">
                        <a href="{{route('news', ['news'=> $singleNews->id])}}" class='align-items-center d-flex'>
                            <img src="{{ $singleNews->mainImage ? $singleNews->mainImage->urls['original'] : '' }}" class='col-3 pl-0 pr-2'>
                            <div class="col-9 news-text-box">
                                <h3>{!! getShortText($singleNews, 'title', 230) !!} </h3>
                                <p>{!! getShortText($singleNews, 'excerpt', 250) !!}</p>
                                <span>{{ date('d.m.Y', strtotime($singleNews->date)) }}</span>
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <div class="news-box">
                    <div class="news-text-box">
                        <h3>{{ __('main.news.empty') }}</h3>
                    </div>
                </div>
            @endif
        </div>
        {{ $news->links() }}
    </div>
</div>
