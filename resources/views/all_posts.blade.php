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
                @if(!empty($posts))
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                            @foreach($posts as $post)
                                <tbody>
                                    <tr>
                                        <td>{{ $post->id }}</td>
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->content }}</td>
                                        <td>{{ $post->created_at }}</td>
                                        <td>{{ $post->updated_at }}</td>
                                        <td><a href="{{route('view-post', [$post->id])}}">Get Post</a></td>
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                    @endif
                @if(auth()->user()->is_admin)
                    <a href="{{ route('add-post') }}" class="btn btn-warning">Add Post</a>
                    <a href="{{ route('all-reviews') }}" class="btn btn-info">All Reviews</a>
                @endif
                <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </body>
</html>
