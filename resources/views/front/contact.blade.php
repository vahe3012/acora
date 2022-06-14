@extends('layouts.front')

@section('content')
    <div class="page-content contact">
        <div class="page-title-box">
            <h1>{{ __('main.contact.title') }}</h1>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>{{ __('main.contact.data') }}</h2>
                    <div class="contact-box">
                        <div>
                            <i class="fas fa-phone-alt"></i>
                            <span>
                            {{ __('main.contact.phone') }}
                            <a href="tel:{{ $phoneNumber }}">{{ $phoneNumber }}</a>
                        </span>
                        </div>
                        <div>
                            <i class="far fa-envelope"></i>
                            <span>
                            {{ __('main.contact.email') }}
                            <a href="mailto:{{ $emailAddress }}">{{ $emailAddress }}</a>
                        </span>
                        </div>
                        <div>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>
                            {{ __('main.contact.address') }}
                            <a href="javascript:">{{ \App\Models\Setting::getByKey('address_' . App::getLocale()) }}.</a>
                        </span>
                        </div>
                    </div>
                    <div id="map">
                        <iframe
                            style="width: 100%; height: 100%"
                            frameborder="0"
                            scrolling="no"
                            marginheight="0"
                            marginwidth="0"
                            src="https://maps.google.com/maps?q={{ $mapAddress ?? '' }}&t=&z=17&ie=UTF8&iwloc=&output=embed"
                        >
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="contact-form-content">
            <div class="container pb-0 pt-0">
                <div class="row">
                    <div class="col-5 contact-form-text">
                        <h2>{{ __('main.contact.title') }}</h2>
                        <p>{{ __('main.contact.label') }}</p>
                        <h5>{{ __('main.contact.social_label') }}</h5>
                        <div class="contact-social-icon-box">
                            <a href="https://www.facebook.com/ucora" target="_blank">
                                <i class='fab fa-facebook'></i>
                            </a>
                            <a href="javascript:">
                                <i class='fab fa-twitter'></i>
                            </a>
                            <a href="javascript:">
                                <i class='fab fa-linkedin-in'></i>
                            </a>
                            <a href="javascript:">
                                <i class='fab fa-youtube'></i>
                            </a>
                            <a href="javascript:">
                                <i class='fab fa-instagram'></i>
                            </a>
                            <a href="javascript:">
                                <i class='fab fa-viber'></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-7 pr-0">
                        <form method="POST" action="{{ route('contact-send') }}">
                            @csrf
                            <div class="position-relative">
                                <input type="text" placeholder="{{ __('main.contact.form.name') }}" name="name" value="{{ old('name') }}" required/>
                                <span class="text-danger">@error('name') {{ $message }} @enderror</span>
                            </div>
                            <div class="position-relative">
                                <input type="email" placeholder="{{ __('main.contact.email') }}" name="email" value="{{ old('email') }}" required />
                                <span class="text-danger">@error('email') {{ $message }} @enderror</span>
                            </div>
                            <div class="position-relative">
                                <textarea placeholder="{{ __('main.contact.form.message') }}" name="message" required>{{ old('message') }}</textarea>
                                <span class="text-danger">@error('message') {{ $message }} @enderror</span>
                            </div>
                            <button type="submit">
                                {{ __('main.contact.form.send') }}
                                <i class='fas fa-arrow-right'></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
