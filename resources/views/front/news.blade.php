@extends('layouts.front')

@section('content')
    <div class="page-content news">
        <div class="page-title-box">
            <h1>{{ __('main.news.title') }}</h1>
        </div>
        <div class="container">
            @include('front.partials._news', compact('allCats', 'news'))
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function getNews(pageNum) {
            let params = window.location.pathname.split('/')
            let url = '/get-news'

            if (params[2]) {
                url = '/get-news/' + params[2];
            }

            $.post(url, {pageNum},
                function(result){
                    $(".page-content .container").html(result)
                    window.scrollTo(0, 0);
                })
        }

        function paginate(elem, event) {
            event.preventDefault()
            let href = elem.attr('href')
            let page = href.substr(href.indexOf("=") + 1)
            window.history.pushState('', '', '?page=' + page);
            getNews(page)
            return false;
        }

        $(() => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.pagination-box a', function(e) {
                paginate($(this), e)
            });
        })
    </script>
@endsection
