@extends('layouts.front')

@section('content')
    <style>
        .carousel-inner img {
            width: 100%
        }

        .carousel-item img {
            object-fit: contain;
            height: 550px;
            width: 100%;
        }

        .carousel-item h4.carousel-image-title {
            padding: 8px 15px 10px;
            position: absolute;
            background: #0003;
            text-align: left;
            width: 100%;
            color: #fff;
            margin: 0;
            bottom: 0;
        }

        #myCarousel .carousel-indicators {
            position: static;
            margin-top: 0
        }

        #myCarousel .carousel-indicators>li {
            width: 100px
        }

        #myCarousel .carousel-indicators li img {
            display: block;
            opacity: 0.5;
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        #myCarousel .carousel-indicators li.active img {
            opacity: 1;
        }

        #myCarousel .carousel-indicators li:hover img {
            opacity: 0.75
        }
        #myCarousel .carousel-control-prev,
        #myCarousel .carousel-control-next {
            transform: translateY(-50%);
            height: 50px;
            width: 50px;
            opacity: 1;
            top: 50%;
        }
        #myCarousel .carousel-control-prev i,
        #myCarousel .carousel-control-next i {
            font-size: 40px;
            color: #919994;
        }
        #myCarousel .carousel-control-prev { left: -50px; }
        #myCarousel .carousel-control-next { right: -50px; }
    </style>
    <div class="page-content news">
        <div class="page-title-box">
            <h1>{{ __('main.digital_images.title') }}</h1>
        </div>
        <div class="container">
            <div class="row d-flex justify-content-center mt-3 mb-5">
                <div class="col-md-10">
                    <div id="myCarousel" class="carousel slide" data-ride="carousel" align="center">
                        <div class="carousel-inner">
                            @foreach($digitalImages as $i => $digitalImage)
                                <div class="carousel-item {{ $i == 0 ? 'active' : ' '}}">
                                    <img src="{{ $digitalImage->attachment->urls['l'] }}" class="rounded">
                                    <h4 class="carousel-image-title">{{$digitalImage->title_am}}</h4>
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true">
                                <i class='fas fa-angle-left'></i>
                            </span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true">
                                <i class='fas fa-angle-right'></i>
                            </span>
                            <span class="sr-only">Next</span>
                        </a>
                        <ol class="carousel-indicators list-inline">
                            @foreach($digitalImages as $i => $digitalImage)
                                <li class="list-inline-item {{ $i == 0 ? 'active' : ' '}}">
                                    <a id="carousel-selector-{{ $i }}" class="selected" data-slide-to="{{ $i }}" data-target="#myCarousel">
                                        <img src="{{ $digitalImage->attachment->urls['original'] }}" class="img-fluid rounded">
                                    </a>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
