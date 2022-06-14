<header>
    <div class="bg-white container p-sm-0 position-relative pt-2 py-0">
        <nav class="navbar navbar-expand-lg p-0 navbar-dark d-lg-none d-flex position-absolute h-100">
            <div class="h-100 container">
                <button class="h-100 navbar-toggler order-1 mx-auto" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <!-- <span class="navbar-toggler-icon"></span> -->
                    <i class="fa fa-bars text-white"></i>
                </button>
            </div>
        </nav>
        <div class="row">
            <div class="col-10 col-lg-8 header-logo-box p-0 p-sm-3">
                <a href="/" class='d-flex align-items-center'>
                    <img src="{{asset("/images/acora-logo.png")}}"/>
                    <h2><strong>ՀՀ վարկային կազմակերպությունների ասոցացիա հկ</strong></h2>
                </a>
            </div>
            <div class="col-4 header-content-box justify-content-end d-none d-lg-inline-flex align-items-center">
                <a href="tel:{{$settings->get('phone_number')}}">{{$settings->get('phone_number')}}</a>
                <div class="border-header"></div>
                <div class="header-language-box">
                    <a class="{{ \Illuminate\Support\Facades\App::getLocale() == 'am' ? 'active' : '' }}" data-lang="am" href="{{ url('setlocale/am') }}">Հայ</a>
                    <a class="{{ \Illuminate\Support\Facades\App::getLocale() == 'en' ? 'active' : '' }}" data-lang="en" href="{{ url('setlocale/en') }}">Eng</a>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg pt-0 pb-0 navbar-dark position-absolute w-100">
        <div class="container">
            <div class="collapse navbar-collapse justify-content-center" id="navbarCollapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about-us') }}">{{ __('main.about.title') }}</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('main.programs.title') }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a href="{{ route('programs') }}" class="dropdown-item">{{ __('main.programs.implemented') }}</a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('category.news')}}">{{ __('main.news.title') }}</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('main.publications.title') }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a href="{{ route('reports') }}" class="dropdown-item">{{ __('main.reports.title') }}</a>
                            <a href="{{ route('analyzes') }}" class="dropdown-item">{{ __('main.analyzes.title') }}</a>
                            <a href="{{ route('digitalImages') }}" class="dropdown-item">{{ __('main.digital_images.title') }}</a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('legislation') }}">{{ __('main.legal_field.title') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact-us') }}">{{ __('main.contact.title') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
