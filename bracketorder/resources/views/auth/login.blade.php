@extends('mobile.layouts.app')

@section('content')
<div class="container" id="login-card">
    <div class="row ">
        <div class="col m12 adjust-for-footer">
            <div class="card">
                <div class="card-action">
                    <div class="row">
                        <div class="col s0 m2 l4 percent-25"></div>
                        <div class="col s12 m8 l4 percent-50">
                            <h5 id="login-heading">Login</h5>
                        </div>
                        <div class="col s2 m2 l4 percent-25"></div>
                    </div>
                </div>

                <div class="card-content">
                    <div class="row">
                        <div class="col s0 m2 l4 percent-25"></div>
                        <div class="col s12 m8 l4 percent-50">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group row">
                                    <div class="col s12 m12">
                                        <div class="input-field">
                                            <input id="email" type="email" class="{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}">
                                            <label for="email">Email</label>
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col s12 m12">
                                        <div class="input-field">
                                            <input id="password" type="password" class="{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}">
                                            <label for="password">Password</label>
                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col s12 m12">
                                        <button type="submit" class="waves-effect waves-light btn-large grey darken-4 no-image-button">Login</button>
                                    </div>

                                    <div class="col s12 m12">
                                        <a class="waves-effect waves-light btn-large grey darken-4" href="{{ url('auth/google') }}"><i class="fab fa-google-plus-square"></i> Login with Google</a>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col s12 m12">
                                        <a class="waves-effect waves-light white btn white-black-button" href="{{ route('password.request') }}">Recover Password</a>
                                    </div>

                                    <div class="col s12 m12">
                                        <a class="waves-effect waves-light white btn white-black-button" href="{{ route('register') }}">Subscribe</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col s12 m8 l4 percent-25"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
