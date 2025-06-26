<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * @group Pages
     *
     * List all published pages
     *
     * Returns all pages with status 'published'.
     *
     * @response 200 scenario="Success" [
     *   {
     *     "id": 1,
     *     "title": "About Us",
     *     "slug": "about-us",
     *     "body": "...",
     *     "status": "published"
     *   }
     * ]
     */
    public function index()
    {
        return PageResource::collection(
            Page::where('status', 'published')->latest()->get()
        );
    }
    /**
     * @group Pages
     *
     * Show page by slug
     *
     * Returns a single page by its slug.
     *
     * @urlParam slug string required The slug of the page. Example: contact
     * @response 200 scenario="Success" {
     *   "id": 2,
     *   "title": "Contact",
     *   ...
     * }
     * @response 404 scenario="Not Found" {"message": "No query results for model [Page]"}
     */
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('status', 'published')->firstOrFail();
        return new PageResource($page);
    }
}
