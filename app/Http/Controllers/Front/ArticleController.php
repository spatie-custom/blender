<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Repositories\ArticleRepository;

class ArticleController extends Controller
{
    public function index(...$articleSlugs)
    {
        $articleSlug = collect($articleSlugs)->last();

        $article = ArticleRepository::findBySlug($articleSlug);

        if ($article->hasChildren()) {
            return redirect($article->firstChild->fullUrl);
        }

        return view('front.article.index')->with(compact('article'));
    }
}
