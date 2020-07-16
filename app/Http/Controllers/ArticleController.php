<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::published()->get();
        return view('articles.index', compact('articles'));
    }
}
