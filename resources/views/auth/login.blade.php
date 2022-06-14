@extends('layouts.auth')

@section('content')
    <div class="login-box">
        <div class="login-logo">
{{--            <a href=""><b>Acora</b></a>--}}
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <img class="w-100 mb-4" src="{{asset("/images/acora-logo.png")}}">
                <form action="{{ route('login.post') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="էլ․ հասցե">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control"  name="password" placeholder="Գաղտնաբառ">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember" style="font-size: 13px;vertical-align: text-top;">
                                    Հիշել
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Մուտք</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

{{--                <div class="social-auth-links text-center mb-3">--}}
{{--                    <p>- OR -</p>--}}
{{--                    <a href="#" class="btn btn-block btn-primary">--}}
{{--                        <i class="fab fa-facebook mr-2"></i> Sign in using Facebook--}}
{{--                    </a>--}}
{{--                    <a href="#" class="btn btn-block btn-danger">--}}
{{--                        <i class="fab fa-google-plus mr-2"></i> Sign in using Google+--}}
{{--                    </a>--}}
{{--                </div>--}}
                <!-- /.social-auth-links -->
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
@endsection
