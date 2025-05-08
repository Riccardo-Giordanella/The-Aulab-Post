<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TraitUse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class ArticleController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth', except: ['index', 'show', 'byCategory', 'byAuthor', 'articleSearch']),
        ];
    }

    public function index()
    {
        $articles = Article::where('is_accepted', true)->orderBy('created_at', 'desc')->get();
        return view('article.index', compact('articles'));
    }


    public function create()
    {
        return view("article.create");
    }

    public function byCategory(Category $category)
    {
        $articles = $category->articles()->where('is_accepted', true)->orderBy("created_at", "desc")->get();
        return view("article.by-category", compact("category", "articles"));
    }

    public function byAuthor(User $user)
    {
        $articles = $user->articles()->where('is_accepted', true)->orderBy("created_at", "desc")->get();
        return view("article.by-author", compact("user", "articles"));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:articles|min:5',
            'subtitle' => 'required|min:5',
            'body' => 'required|min:10',
            'image' => 'required|image',
            'category' => 'required',
        ]);

        $article = Article::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'body' => $request->body,
            'image' => $request->file('image')->store('images', 'public'),
            'category_id' => $request->category,
            'user_id' => Auth::user()->id,
        ]);

        $tags = explode(',', $request->tags);

        foreach ($tags as $i => $tag) {
            $tags[$i] = trim($tag);
        }

        foreach ($tags as $tag) {
            $newTag = Tag::updateOrCreate([
                'name' => strtolower($tag)
            ]);

            $article->tags()->attach($newTag);
        }

        return redirect()->route('homepage')->with('message', 'Articolo creato con successo');
    }

    public function storeCategory(Request $request)
    {
        Category::create([
            'name' => strtolower($request->name)
        ]);

        return redirect()->back()->with('message', 'Categoria inserita correttamente');
    }

    public function articleSearch(Request $request)
    {
        $query = $request->input('query');
        $articles = Article::search($query)->where('is_accepted', true)->orderBy('created_at', 'desc')->get();
        return view('article.search-index', compact('articles', 'query'));
    }

    public function show(Article $article)
    {
        return view('article.show', compact('article'));
    }

    public function edit(Article $article)
    {
        //
    }

    public function update(Request $request, Article $article)
    {
        //
    }

    public function destroy(Article $article)
    {
        //
    }
}
