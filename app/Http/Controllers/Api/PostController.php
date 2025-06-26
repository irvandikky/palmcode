<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * @group Posts
     *
     * List published posts
     *
     * Returns a paginated list of published posts ordered by published date.
     *
     * @queryParam page int Optional. The page number. Example: 1
     * @response 200 scenario="Success" {
     *   "data": [
     *     {
     *       "id": 1,
     *       "title": "First Post",
     *       "slug": "first-post",
     *       "excerpt": "...",
     *       "content": "...",
     *       "image_url": "https://example.com/storage/image.jpg",
     *       "published_at": "2025-06-25",
     *       "categories": [...]
     *     }
     *   ],
     *   "links": {...},
     *   "meta": {...}
     * }
     */
    public function index()
    {
        return PostResource::collection(
            Post::with('categories')->where('status', 'published')->latest()->paginate(10)
        );
    }
    /**
     * @group Posts
     *
     * Show post by slug
     *
     * Returns a single post by its slug.
     *
     * @urlParam slug string required The slug of the post. Example: hello-world
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "title": "Hello World",
     *   ...
     * }
     * @response 404 scenario="Not Found" {"message": "No query results for model [Post]"}
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->where('status', 'published')->with('categories')->firstOrFail();
        return new PostResource($post);
    }
}
