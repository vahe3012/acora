@extends('layouts.front')

{{--@section('title')--}}
{{--    Coffered Ceilings | Faux Wood Beams | T&G Shiplap Planks--}}
{{--@endsection--}}

{{--@section('meta_tags')--}}
{{--    <meta name="description" content="Premium Ceiling &amp; Wall Treatment Products. Coffers, Beams &amp; Planks for Residential &amp; Commercial Applications. Talk to the Experts. BUY DIRECT &amp; SAVE!">--}}
{{--    <link rel="canonical" href="{{url('/')}}">--}}
{{--@endsection--}}

{{--@section('styles')--}}
{{--    <link rel="stylesheet" href="{{asset('dist/front/css/style.css'}}">--}}
{{--@endsection--}}

@section('content')
    <div class="page-content laws">
        <div class="page-title-box">
            <h1>{{ __('main.legal_field.title') }}</h1>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-4 tab-btn-box">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1"
                           role="tab" aria-controls="v-pills-1" aria-selected="true">
                            <span>{{ __('main.legal_field.legislation.title') }}</span>
                        </a>
                        <a class="nav-link" id="v-pills-2-tab" data-toggle="pill" href="#v-pills-2"
                           role="tab" aria-controls="v-pills-2" aria-selected="true">
                            <span>{{ __('main.legal_field.regulation.title') }}</span>
                        </a>
                    </div>
                </div>
                <div class="col-8 laws-content">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-1" role="tabpanel" aria-labelledby="v-pills-1-tab">
                            <h2>{{ __('main.legal_field.legislation.links') }}</h2>
                            @foreach($laws as $law)
                                <div class="laws-content-box">
                                    <a class="d-block w-100" href="{{ $law->link }}" target="_blank">
                                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M24 17.3333V25.3333C24 26.0406 23.719 26.7189 23.219 27.219C22.7189 27.719 22.0406 28 21.3333 28H6.66667C5.95942 28 5.28115 27.719 4.78105 27.219C4.28095 26.7189 4 26.0406 4 25.3333V10.6667C4 9.95942 4.28095 9.28115 4.78105 8.78105C5.28115 8.28095 5.95942 8 6.66667 8H14.6667" stroke="#001489" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M19.9997 4H27.9997M27.9997 4V12M27.9997 4L13.333 18.6667" stroke="#FF9E1B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <h5>{{ translate($law, 'title') }}</h5>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        <div class="tab-pane fade" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-2-tab">
                            @foreach($regulations as $regulation)
                                <div class="laws-content-box">
                                    <a class="d-block w-100" href="{{ $regulation->attachment->urls['original'] }}" target="_blank">
                                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M24 17.3333V25.3333C24 26.0406 23.719 26.7189 23.219 27.219C22.7189 27.719 22.0406 28 21.3333 28H6.66667C5.95942 28 5.28115 27.719 4.78105 27.219C4.28095 26.7189 4 26.0406 4 25.3333V10.6667C4 9.95942 4.28095 9.28115 4.78105 8.78105C5.28115 8.28095 5.95942 8 6.66667 8H14.6667" stroke="#001489" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M19.9997 4H27.9997M27.9997 4V12M27.9997 4L13.333 18.6667" stroke="#FF9E1B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <h5>{{ translate($regulation, 'title') }}</h5>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
