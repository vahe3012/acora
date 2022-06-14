@extends('layouts.front')

@section('styles')
    <style>
        a {
            text-decoration: none !important;
        }
    </style>
@endsection

@section('content')

    <div class="page-content news-page">
        <div class="page-title-box">
            <h1>{{ __('main.news.title') }}</h1>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-4 news-left-box">
                    <a href="{!! route('category.news') !!}">
                        <i class='fas fa-arrow-left'></i>
                        {{ __('main.news.all_news') }}
                    </a>

                    <div class="news-left-content-box">
                        @foreach($relatedNews as $related)
                        <a href="{{route('news', ['news'=> $related->id])}}">
                            <img src="{{$related->mainImage->urls['original']}}">
                            <div>
                                <span>{{ date('d.m', strtotime($related->date)) }}</span>
                                <h4>{!! getShortText($related, 'title', 90) !!}</h4>
                                <p>{!! getShortText($related, 'excerpt', 190) !!}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-8 news-content-box">
                    <h2>{{ translate($news, 'title') }}</h2>
                    <span>{{ date('d.m.Y', strtotime($news->date)) }}</span>
                    <div>
                        <img style="width: auto;" src="{{$news->mainImage->urls['original']}}">
                        <p>{!! translate($news, 'content') !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


