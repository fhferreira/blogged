<?php

namespace BinaryTorch\Blogged\Http\Controllers;

use BinaryTorch\Blogged\Models\Article;
use BinaryTorch\Blogged\Models\Category;
use BinaryTorch\Blogged\Filters\ArticleFilters;

class BlogController extends Controller
{
    /**
     * Show the blog home page.
     */
    public function index($category=null, ArticleFilters $filters)
    {
        $pagination = config('blogged.settings.pagination');

        if($category) {
            $category = Category::whereSlug($category)->firstOrFail();

            $articles = $category->articles()->published()->filter($filters)->paginate($pagination);
            
            return view('blogged::blog.index', compact('articles'));
        }

        $articles = Article::published()->with('category')->filter($filters)->paginate($pagination);

        return view('blogged::blog.index', compact('articles'));
    }

    /**
     * Show a given article.
     */
    public function show(Category $category, Article $article)
    {
        abort_if(! $article->published, 403);
        
        abort_if($category->id != $article->category_id, 404);

        $article->load('author');

        return view('blogged::blog.show', compact('article'));
    }
}