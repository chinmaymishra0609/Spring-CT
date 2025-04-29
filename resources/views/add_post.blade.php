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
        <div class="col-8 offset-2">
            @if(session()->has("status"))
                <div class="alert alert-{{ session()->get('status') }}" role="alert">
                    {{ session()->get("message") }}
                </div>
            @endif
            <form action="{{ route('save-post') }}" method="post">
                <h4 class="text-center text-primary">Add Post</h4>
                @csrf
                <input placeholder="Enter post title here" type="text" class="form-control" name="title" id="title"><br/>
                <textarea placeholder="Enter post content here" rows="10" class="form-control" name="post-data" id="post-data"></textarea><br/>
                <input class="btn btn-primary" type="submit" value="Submit">
                <a href="{{ route('all-posts') }}" class="btn btn-warning">All Posts</a>
                @if(auth()->user()->is_admin)
                    <a href="{{ route('all-reviews') }}" class="btn btn-info">All Reviews</a>
                @endif
                <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
            </form>
        </div>
    </div>
    </body>
</html>
