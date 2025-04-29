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
                @if(!empty($reviews))
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Post Title</th>
                                <th>Review</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                            @foreach($reviews as $review)
                                <tbody>
                                    <tr>
                                        <td>{{ $review->id }}</td>
                                        <td>{{ $review->name }}</td>
                                        <td>{{ $review->title }}</td>
                                        <td>{{ $review->content }}</td>
                                        <td>{{ ucfirst($review->status) }}</td>
                                        <td>{{ $review->created_at }}</td>
                                        <td>{{ $review->updated_at }}</td>
                                        @if(auth()->user()->is_admin)
                                            <td>
                                                <a href="{{ route('edit-review', [$review->id, $review->post_id, 'approved']) }}" class="btn btn-secondary">Approve</a>
                                                <a href="{{ route('edit-review', [$review->id, $review->post_id, 'disapproved']) }}" class="btn btn-danger">Disapprove</a>
                                            </td>
                                        @endif
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                    @endif
                <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
                <a href="{{ route('all-posts') }}" class="btn btn-warning">All Posts</a>
                @if(auth()->user()->is_admin)
                    <a href="{{ route('all-reviews') }}" class="btn btn-info">All Reviews</a>                    
                @endif
            </div>
        </div>
    </body>
</html>
