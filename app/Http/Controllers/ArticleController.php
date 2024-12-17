<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    //

    public function insert(Request $request)
    {
        $request-> validate([
            'title' => 'required|min:6',
            'article' => 'required|min:6',
        ]);
        // if($request)
        // $notification = array(
        //     'message' => 'Successfully Done',
        //     'alert-type' => 'success'
        // );
        return back()-> with($notification);

        if($request->format == 'create'){
            DB::table('articles')->insert([
                'title'=> $request->title,
                'article'=> $request->article,
                'email' => Auth::user()->email,
            ]);

        } else {
            $art = Article::where('id', $request->id)->first();
            $art->title =$request->title;
            $art->article =$request->article;
            $art->save();
        }
        $notification = array(
            'message' => 'Successfully Done',
            'alert-type' => 'success'
        );
        return back()-> with($notification);
    }

    public function getArticles() {
        // dd("article");
        $articles = Article::all();
        return $articles;
    }

    public function deleteArticle(Request $request)
    {
       $del =  Article::where('id' , $request->index)->first()->delete();
    }
}
