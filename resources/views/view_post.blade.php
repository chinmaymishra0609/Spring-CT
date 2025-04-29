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
                @if(!empty($post))
                    <h4 class="text-center text-primary">Post Details</h4>
                    <p>{{ $post->content }}</p>
                    Created At: <span>{{ $post->created_at }}</span><br/>
                    Updated At: <span>{{ $post->updated_at }}</span><br/><br/>
                @endif
                <a href="{{ route('add-review', [$post->id]) }}" class="btn btn-warning">Add Review</a>
                @if(auth()->user()->is_admin)
                    <a href="{{ route('all-reviews') }}" class="btn btn-info">All Reviews</a>
                @endif
                <a href="{{ route('all-posts') }}" class="btn btn-info">All Posts</a>
                @if(auth()->user()->is_admin)
                    <a href="{{ route('add-post') }}" class="btn btn-warning">Add Post</a>
                @endif
                <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-8 offset-2">
                @if(!empty($post_reviews))
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Review</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                @if(auth()->user()->is_admin)
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                            @foreach($post_reviews as $review)
                                <tbody>
                                    <tr>
                                        <td>{{ $review->id }}</td>
                                        <td>{{ $review->name }}</td>
                                        <td>{{ $review->content }}</td>
                                        <td>{{ $review->created_at }}</td>
                                        <td>{{ $review->updated_at }}</td>
                                        @if(auth()->user()->is_admin)
                                            <td>
                                                <a href="{{ route('edit-review', [$review->id, $post->id, 'approved']) }}" class="btn btn-secondary">Approve</a>
                                                <a href="{{ route('edit-review', [$review->id, $post->id, 'disapproved']) }}" class="btn btn-danger">Disapprove</a>
                                            </td>
                                        @endif
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                    @endif
            </div>
        </div>
    </body>
</html>
