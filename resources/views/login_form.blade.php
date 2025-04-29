<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="{{ asset('/bootstrap.min.css') }}">
        <title>Example</title>
    </head>
    <body">
    <div class="row">
        <div class="col-6 offset-3">
            @if(session()->has("status"))
                <div class="alert alert-{{ session()->get('status') }}" role="alert">
                    {{ session()->get("message") }}
                </div>
            @endif
            <form action="{{ route('login-check') }}" method="post">
                <h4 class="text-center text-primary">Login</h4>
                @csrf
                <input placeholder="Enter your email here" type="text" name="email" id="email" class="form-control"><br/>
                <input placeholder="Enter your password here"  type="password" name="password" id="password" class="form-control"><br/>
                <input class="btn btn-primary" type="submit" value="Login">
            </form>
        </div>
    </div>
    </body>
</html>
