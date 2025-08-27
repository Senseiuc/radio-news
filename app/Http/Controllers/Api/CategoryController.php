<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryController extends Controller
{
    /**
     * List categories for public consumption (name, slug, color)
     */
    public function index()
    {
        $categories = Category::query()
            ->select(['id','name','slug','color','sort_order'])
            ->orderByRaw('CASE WHEN sort_order IS NULL THEN 1 ELSE 0 END') // non-null first
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return JsonResource::collection($categories);
    }
}
