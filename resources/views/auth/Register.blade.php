@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">

                <div class="card-body">
                    <div class="row" style="justify-content:center;padding:10px;">
                        <h3>{{ __('Register') }}</h3>
                    </div>
                    <div class="row" style="justify-content:center;padding-bottom:5px;">
                        <img src="/adminlte/dist/img/perpus.png" alt="e-perpus" class="brand-image img-circle elevation-3" style="opacity: .8;height:150px;width:150px;">
                    </div>
               
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row"  style="justify-content:center;">

                            <div class="col-md-7">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Name">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row"  style="justify-content:center;">
                            <div class="col-md-7">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row"  style="justify-content:center;">
                            <div class="col-md-7">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row" style="justify-content:center;">
                            <div class="col-md-7">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                            </div>
                        </div>

                        <div class="form-group row mb-0"  style="justify-content:center;">
                            <div class="col-md-7">
                                <button type="submit" class="btn-block" style="background:#0071BC;border:none;outline:none;color:#ffffff;height: 7vh;border-radius:5px;" >
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
