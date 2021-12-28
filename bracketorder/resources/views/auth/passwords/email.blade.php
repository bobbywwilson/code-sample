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
                                <h5 id="login-heading">Reset Password</h5>
                            </div>
                            <div class="col s2 m2 l4 percent-25"></div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <div class="col s0 m2 l4 percent-25"></div>
                            <div class="col s12 m8 l4 percent-50">
                                @if (session('status'))
                                    <div class="alert alert-success success-message">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('password.email') }}">
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
                                            <button type="submit" class="waves-effect waves-light btn-large grey darken-4">Send Password Reset Link</button>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col s12 m12">
                                            <a class="waves-effect waves-light white btn white-black-button" href="{{ route('login') }}">Return to Login</a>
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
