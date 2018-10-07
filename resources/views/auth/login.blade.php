{{--@extends('layouts.app')--}}

{{--@section('content')--}}
{{--<div class="container">--}}
    {{--<div class="row justify-content-center">--}}
        {{--<div class="col-md-8">--}}
            {{--<div class="card">--}}
                {{--<div class="card-header">{{ __('Login') }}</div>--}}

                {{--<div class="card-body">--}}
                    {{--<form method="POST" action="{{ route('login') }}">--}}
                        {{--@csrf--}}

                        {{--<div class="form-group row">--}}
                            {{--<label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>--}}

                                {{--@if ($errors->has('email'))--}}
                                    {{--<span class="invalid-feedback">--}}
                                        {{--<strong>{{ $errors->first('email') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group row">--}}
                            {{--<label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>--}}

                                {{--@if ($errors->has('password'))--}}
                                    {{--<span class="invalid-feedback">--}}
                                        {{--<strong>{{ $errors->first('password') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group row mb-0">--}}
                            {{--<div class="col-md-8 offset-md-4">--}}
                                {{--<button type="submit" class="btn btn-primary">--}}
                                    {{--{{ __('Login') }}--}}
                                {{--</button>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</form>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
{{--@endsection--}}

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>سهل - لوحة تحكم التطبيق </title>
    <link href={{asset("css/bootstrap.min.css")}} rel="stylesheet">
    <meta name="google-site-verification" content="hYgsIi14Fac8-Pvr4_rt7oshb94W4dfW2tDaZmtiv4c"/>

    <title>لوحة تحكم</title>
    <style>
        body{
            background: rgba(0,29,250,1);
            background: -moz-linear-gradient(left, rgba(0,29,250,1) 0%, rgba(30,58,8,0.62) 65%, rgba(30,58,8,0.41) 100%);
            background: -webkit-gradient(left top, right top, color-stop(0%, rgba(0,29,250,1)), color-stop(65%, rgba(30,58,8,0.62)), color-stop(100%, rgba(30,58,8,0.41)));
            background: -webkit-linear-gradient(left, rgba(0,29,250,1) 0%, rgba(30,58,8,0.62) 65%, rgba(30,58,8,0.41) 100%);
            background: -o-linear-gradient(left, rgba(0,29,250,1) 0%, rgba(30,58,8,0.62) 65%, rgba(30,58,8,0.41) 100%);
            background: -ms-linear-gradient(left, rgba(0,29,250,1) 0%, rgba(30,58,8,0.62) 65%, rgba(30,58,8,0.41) 100%);
            background: linear-gradient(to right, rgba(0,29,250,1) 0%, rgba(30,58,8,0.62) 65%, rgba(30,58,8,0.41) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#001dfa', endColorstr='#1e3a08', GradientType=1 );

        }
        .center {
            margin: 100px 350px 10px 0 ;
            width: 35%;
            padding: 20px ;
            background:white;
            border-radius: 25px;
            box-shadow: 5px 10px;

        }

    </style>
</head>
<body>
<div class="container" id='app'>
    <div class="center" >
        <img  src="http://www.shl-app.com/wp-content/uploads/Group-1663.png"
              style="width:50px;padding:10px 0 30px 0;display: block;
            margin-left: auto;
            margin-right: auto;
            " >

        <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group row">
        <label for="email" class="col-sm-4 col-form-label text-md-right">البريد الإلكتروني</label>

        <div class="col-md-6">
        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

        @if ($errors->has('email'))
        <span class="invalid-feedback">
        <strong>{{ $errors->first('email') }}</strong>
        </span>
        @endif
        </div>
        </div>

        <div class="form-group row">
        <label for="password" class="col-md-4 col-form-label text-md-right">الرقم السري</label>

        <div class="col-md-6">
        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

        @if ($errors->has('password'))
        <span class="invalid-feedback">
        <strong>{{ $errors->first('password') }}</strong>
        </span>
        @endif
        </div>
        </div>

        <div class="form-group row mb-0">
        <div class="col-md-8 offset-md-4">
        <button type="submit" class="btn btn-primary">
        دخول
        </button>
        </div>
        </div>
        </form>

    </div>
</div>
<!-- jQuery Version 1.11.0 -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script src={{asset("js/jquery-1.11.0.js")}}></script>

{{--<!-- Bootstrap Core JavaScript -->--}}
<script src={{asset("js/bootstrap.min.js")}}></script>










</body>
</html>