<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('articles.index', [
            'articles' => Article::where('user_id', auth()->user()->id)->with(['category', 'user'])->latest()->paginate(5)
            // 'articles' => Article::latest()->paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articles.create', [
            // 'categories' => Category::where('user_id', auth()->user()->id)->with(['user'])->latest()->get()
            "categories" => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000'
        ]);

        if ($request->file('image')) {
            $data['image'] = $request->file('image')->store('images');
        } else {
            $data['image'] = "images/placeholder.png";
        }

        $data['user_id'] = auth()->user()->id;
        Article::create($data);

        return redirect('/articles')->with('success', 'New Article has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return view('articles.show', [
            // 'article' => Article::findOrFail($article->id)
            'article' => $article,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return view('articles.edit', [
            "article" => $article,
            // "categories" => Category::where('user_id', auth()->user()->id)->with(['user'])->latest()->get()
            "categories" => Category::all()
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000'
        ]);
        if($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $data['image'] = $request->file('image')->store('images');
        }

        $data['user_id'] = auth()->user()->id;
        Article::where('id', $article->id)->update($data);
        
        return redirect('/articles')->with('success', 'Article has been edited!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        if ($article->image != "images/placeholder.png") {
            Storage::delete($article->image);
        }
        Article::destroy($article->id);

        return redirect('/articles')->with('delete', 'Article successfully removed');
    }
}
