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
            <form action="{{ route('save-review') }}" method="post">
                <h4 class="text-center text-primary">Add Review</h4>
                @csrf
                <input type="hidden" name="post-id" id="post-id" value="{{ $post_id }}">
                <textarea rows="10" class="form-control" name="content" id="content"></textarea><br/>
                <input class="btn btn-primary" type="submit" value="Submit">
                @if(auth()->user()->is_admin)
                    <a href="{{ route('add-post') }}" class="btn btn-warning">Add Post</a>
                    <a href="{{ route('all-reviews') }}" class="btn btn-info">All Reviews</a>
                @endif
                <a href="{{ route('view-post', [$post_id]) }}" class="btn btn-warning">Back To Post</a>
                <a href="{{ route('all-posts') }}" class="btn btn-info">All Posts</a>
                <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
            </form>
        </div>
    </div>
    </body>
</html>
