@extends('layouts.front')

@section('content')
    <div class="page-content home">
        <div class="row w-100 m-0 {{--home-slider-section--}}">
            <div class="col-12 p-0">
                <div id="carouselExampleIndicators">
                    <div class="carousel-inner-box">
                        <div class="carousel-item-box">
                            <div class="container">
                                @if($slider)
                                    <div class="row home-post-box row-wrap-reverse">
                                        <div class="col-md-6 p-0 pl-md-3 pr-md-5">
                                            <h2>{{ strtoupper(translate($slider, 'title'))}}</h2>
                                            <div class='d-md-block d-none'> {!! translate($slider, 'description') !!}</div>
                                            {{--<a href="{{route('news', ['news'=> $mainNews->id])}}"
                                               class='d-none d-sm-block'>
                                                {{ __('main.slider.link_label') }}
                                                <i class='fas fa-arrow-right'></i>
                                            </a>--}}
                                        </div>
                                        <div class="col-md-6 p-0 pl-md-5 pr-md-3">
                                            <div id="CarouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                                <ol class="carousel-indicators">
                                                    @foreach($slider->images as $i => $image)
                                                        <li data-target="#CarouselExampleIndicators" data-slide-to="{{ $i }}" class="{{ $i == 0 ? 'active' : '' }}"></li>
                                                    @endforeach
                                                </ol>
                                                <div class="carousel-inner" >
                                                    @foreach($slider->images as $i => $image)
                                                        <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                                                            @if(\App\Models\Attachment::isVideo($image))
                                                                <video src="{{ $image }}" controls></video>
                                                            @else
                                                                <img src="{{ $image }}" class='my-3' >
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class='d-md-none d-block'> {!! translate($slider,'description') !!}</div>
                                            {{--<a href="{{route('news', ['news'=> $mainNews->id])}}"
                                               class='d-block d-sm-none'>
                                                {{ __('main.slider.link_label') }}
                                                <i class='fas fa-arrow-right'></i>
                                            </a>--}}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="carousel-caption"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="home-news-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2>{{ __('main.news.title') }}</h2>
                    </div>
                    <div class="col-sm-6 pr-4 home-news-content mb-5">
                        @if(count($news))
                            <a href="{{route('news', ['news'=> $news[0]->id])}}">
                                <img src="{{ $news[0]->mainImage->urls['l'] }}"/>
                                <span>{{ date('d.m', strtotime($news[0]->date)) }}</span>
                                <h4>{{ translate($news[0], 'title') }}</h4>
                                <p>{!! translate($news[0], 'excerpt')!!}</p>
                            </a>

                            @php unset($news[0]) @endphp
                        @endif
                    </div>
                    <div class="col-sm-6 pl-4 home-news-content mb-3">
                        <div class="home-news-content-box mb-3">
                            @foreach($news as $item)
                                <a href="{{route('news', ['news'=> $item->id])}}"
                                   class='mb-4 row align-items-center flex-nowrap'>
                                    <img src="{{$item->mainImage->urls['xs']}}" class='p-0 m-0'/>
                                    <div class='col-9 ml-0 py-0 pl-3 pr-1 mt-2'>
                                        <span>{{ date('d.m', strtotime($item->date)) }}</span>
                                        <h4>{!! getShortText($item, 'title', 90) !!}</h4>
                                        <div class='d-none d-sm-block ml-0'>{!! getShortText($item, 'excerpt', 250) !!}</div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <a class="mt-2" href="{{route('category.news')}}">
                            {{ __('main.news.all_news') }}
                            <i class='fas fa-arrow-right'></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        {{--Partners Section--}}
        <div class="home-partner-section">
            <div class="container p-0" id="slider_container" >
                <h2>{{ __('main.members.title') }}</h2>
                <section class="scrollerContainer" >
                    @foreach($members as $member)
                        <article>
                            <div class="caption">
                                <a href="{{ route('member', $member) }}">
                                    <img src="{{$member->image->urls['original']}}"/>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </section>
            </div>
        </div>
        <div class="home-course-section">
            <div class="container">
                <h2>{{ __('main.course.title') }}</h2>
                <div class="row">

                    @if($mainCourse)
                        <div class="col-md-6 col-lg-3 col-sm-6 p-12">
                            <div class="about-courses-box h-100">
                                <h3>{{ translate($mainCourse, 'title') }}</h3>
                                <p>{!! translate($mainCourse, 'description') !!}</p>
                            </div>
                        </div>
                    @endif

                    @foreach($courses as $i => $course)
                        <div class="col-md-6 col-lg-3 col-sm-6 p-12 pr-xl-0 d-flex">
                            <div class="course-box">
                                <a href="javascript:">
                                    <h3>{{ translate($course, 'title') }}</h3>
                                    <p>{{ translate($course, 'description') }}</p>
                                </a>
                                <a href="#" class='d-none'><i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a class="mt-2 d-none" href="{{route('category.news')}}">
                    Բոլոր դասընթացները
                    <i class='fas fa-arrow-right'></i>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            var scrollerSpeed = 2;
            var scrollerTransitionSpeed = 0.5;
            var scrollerItemsEl = '';

            $('.scrollerContainer > article').each(function (index) {
                scrollerItemsEl += $(this).prop('outerHTML');
            });

            $('.scrollerContainer').html(scrollerItemsEl);

            $('.scrollerContainer > article').wrapAll('<div class="scrollerGroup" />');

            var scrollerCount = $('.scrollerContainer .scrollerGroup > article').length;
            var scrollerItemWidth = 160;

            $('.scrollerContainer .scrollerGroup > article').css('width', scrollerItemWidth + 'px');
            $('.scrollerContainer .scrollerGroup').css('width', scrollerCount * scrollerItemWidth + 'px');
            $('.scrollerContainer .scrollerGroup > article').css('transition', 'margin ' + scrollerTransitionSpeed + 's');

            var scrollerLeftMargin = '-' + scrollerItemWidth - 72 + 'px';
            var scrollerFirstItem = true;

            scrollerAnimate(scrollerSpeed);

            function scrollerAnimate(speed) {
                setInterval(scrollerRotate, speed * 1000);
            }

            function scrollerRotate() {
                if (scrollerFirstItem) {
                    scrollerFirstItem = false;
                } else {
                    $('.scrollerContainer .scrollerGroup').append($('.scrollerContainer .scrollerGroup article:first-child'));
                }
                $('.scrollerContainer .scrollerGroup > article').css('margin-left', '0');
                $('.scrollerContainer .scrollerGroup > article:first-child').css('margin-left', scrollerLeftMargin);
            }

            $('#CarouselExampleIndicators').carousel({
                pause: true,
                interval: false
            });

            $('.carousel-indicators li').click(function () {
                $('.carousel-inner').find('.carousel-item video').each((index, elem) => {
                    $(elem).get(0).pause()
                })
            })
        });
    </script>
@endsection
