<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @group Categories
     *
     * List all categories
     *
     * Returns a list of all categories, including posts if loaded.
     *
     * @response 200 scenario="Success" [
     *   {
     *     "id": 1,
     *     "name": "News",
     *     "slug": "news"
     *   }
     * ]
     */
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }
}
