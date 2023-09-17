<?php

namespace App\Http\Controllers\apiList;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class CategoryController extends Controller
{
    public function categorySearch(Request $req){
        $category = $req->category;
        $posts = Post::when($category,function($query, $category){
                    $query -> where('category_id',$category);
                })->get();

        return response()->json([
            'posts' => $posts
        ]);
    }
    public function allCategory(){
        $categories = Category::all();
        return response()->json([
            'categories' => $categories
        ]);
    }
}
