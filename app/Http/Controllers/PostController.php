<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller{
    /**
     * Display a login form.
     */
    public function login(){
        // Check if user is already logged in.
        if(!empty(Auth::user()->id)){
            // Load the login form.
            return redirect("all-posts");
        }

        // Load the login form.
        return view("login_form");
    }

    /**
     * Check the login credentials.
     */
    public function login_check(Request $request){
        // Check if user is already logged in.
        if(!empty(Auth::user()->id)){
            // Load the login form.
            return redirect("all-posts");
        }

        // Get the form data.
        $email = $request->input("email");
        $password = $request->input("password");

        // Create the new User object.
        $user = User::where(["email" => $email, "password" => $password])->first();

        // On success.
        if($user){
            // Login the user.
            Auth::login($user);

            // Return the response.
            return redirect("/all-posts");
        } else {
            // Return the response.
            return redirect("/login")->with(["status" => "danger", "message" => "Invalid credentials."]);
        }
    }

    /**
     * Logout the user.
     */
    public function logout(){
        // Check if user is already logged in.
        if(!empty(Auth::user()->id)){
            // Logout the user.
            Auth::logout();
        }

        // Return the response.
        return redirect("login")->with(["status" => "success", "message" => "Logged out successfully."]);
    }

    /**
     * Display a add post form.
     */
    public function add_post(){
        // Check if user is already logged in.
        if(empty(Auth::user()->id)){
            // Load the login form.
            return redirect("login");
        }

        // Check if user is already logged in.
        if(!Auth::user()->is_admin){
            // Load the login form.
            return redirect()->back();
        }

        // Load the add post form.
        return view("add_post");
    }

    /**
     * Save the resource.
     */
    public function save_post(Request $request){
        // Check if user is already logged in.
        if(empty(Auth::user()->id)){
            // Load the login form.
            return redirect("login");
        }

        // Check if user is already logged in.
        if(!Auth::user()->is_admin){
            // Load the login form.
            return redirect()->back();
        }

        // Create the new Post object.
        $post = new Post();

        // Set the Post object.
        $post->title = $request->input("title");
        $post->content = $request->input("post-data");

        // Save the Post object.
        $result = $post->save();

        // On success.
        if($result){
            // Return the response.
            return redirect("/add-post")->with(["status" => "success", "message" => "Post has been saved."]);
        } else {
            // Return the response.
            return redirect("/add-post")->with(["status" => "danger", "message" => "Post has not been saved."]);
        }
    }

    /**
     * Display a listing of the posts.
     */
    public function all_posts(){
        // Check if user is already logged in.
        if(empty(Auth::user()->id)){
            // Load the login form.
            return redirect("login");
        }

        // Get the all post.
        $data["posts"] = Post::all();

        // Load all the posts view.
        return view("all_posts", $data);
    }

    /**
     * Display a listing of the reviews.
     */
    public function all_reviews(){
        // Check if user is already logged in.
        if(empty(Auth::user()->id)){
            // Load the login form.
            return redirect("login");
        }

        // Check if user is already logged in.
        if(!Auth::user()->is_admin){
            // Load the login form.
            return redirect()->back();
        }

        // Get the post reviews by post id.
        $data["reviews"] = DB::table("reviews")
                            ->select("users.name", "posts.title", "reviews.*")
                            ->leftJoin("users", "users.id", "=", "reviews.user_id")
                            ->leftJoin("posts", "posts.id", "=", "reviews.post_id")
                            ->orderBy("reviews.id", "desc")
                            ->get();

        // Load all the reviews view.
        return view("all_reviews", $data);
    }

    /**
     * Display a view of the post.
     */
    public function view_post($id){
        // Check if user is already logged in.
        if(empty(Auth::user()->id)){
            // Load the login form.
            return redirect("login");
        }

        // Get the post by id.
        $data["post"] = Post::find($id);

        // Check if user is already logged in.
        if(Auth::user()->is_admin){
            // Get the post reviews by post id.
            $data["post_reviews"] = DB::table("reviews")
                                        ->select("users.name", "reviews.*")
                                        ->leftJoin("users", "users.id", "=", "reviews.user_id")
                                        ->where(["post_id" => $id])
                                        ->orderBy("reviews.id", "desc")
                                        ->get();
        } else {
            // Get the post reviews by post id and user id.
            $data["post_reviews"] = DB::table("reviews")
                                    ->select("users.name", "reviews.*")
                                    ->leftJoin("users", "users.id", "=", "reviews.user_id")
                                    ->where(["post_id" => $id, "user_id" => Auth::user()->id, "status" => "approved"])
                                    ->orderBy("reviews.id", "desc")
                                    ->get();
        }

        // Load all the posts view.
        return view("view_post", $data);
    }

    /**
     * Display a add review form.
     */
    public function add_review($post_id){
        // Check if user is already logged in.
        if(empty(Auth::user()->id)){
            // Load the login form.
            return redirect("login");
        }

        // Load the add review form.
        return view("add_review", ["post_id" => $post_id]);
    }

    /**
     * Save the review.
     */
    public function save_review(Request $request){
        // Check if user is already logged in.
        if(empty(Auth::user()->id)){
            // Load the login form.
            return redirect("login");
        }

        // Create the new review object.
        $review = new Review();

        // Get the form data.
        $post_id = $request->input("post-id");
        $content = $request->input("content");

        // Set the review object.
        $review->user_id = Auth::user()->id;
        $review->post_id = $post_id;
        $review->content = $content;

        // Save the review object.
        $result = $review->save();

        // On success.
        if($result){
            // Return the response.
            return redirect("/view-post/$post_id")->with(["status" => "success", "message" => "Post review has been saved."]);
        } else {
            // Return the response.
            return redirect("/view-post/$post_id")->with(["status" => "danger", "message" => "Post review has not been saved."]);
        }
    }

    /**
     * Edit the review.
     */
    public function edit_review(Request $request, $review_id, $post_id, $status){
        // Check if user is already logged in.
        if(empty(Auth::user()->id)){
            // Load the login form.
            return redirect("login");
        }

        $review = Review::find($review_id);

        // Set the review object.
        $review->status = $status;
        // Get the review object by id.

        // Save the review object.
        $result = $review->save();

        // On success.
        if($result){
            // Return the response.
            return redirect()->back()->with(["status" => "success", "message" => "Post review status has been updated."]);
        } else {
            // Return the response.
            return redirect()->back()->with(["status" => "danger", "message" => "Post review status has not been updated."]);
        }
    }
}
