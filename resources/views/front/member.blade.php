@extends('layouts.front')

@section('content')
    <div class="page-content analyzes partner">
        <div class="page-title-box">
            <h1>{{ translate($member, 'title') }}</h1>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-8 offset-2">
                    <div data-tab-content="1" class="tab-content-box active">
                        <div class="partner-box position-relative">
                            <div class="row">
                                <div class="col-5">
                                    <img src="{{ $member->image->urls['l'] }}" alt="" class="img-fluid">
                                </div>
                                <div class="partner-box-text col-7">
                                    <h3  class="ml-0">{{ translate($member, 'title') }}</h3>
                                    <p>{!! translate($member, 'description') !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
