<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Http\Request;
class ArticleController extends Controller
{
    public function index()   {
        return response()->json(['s'=>'s']);
        
    }
    

    public function CreateArticle(Request $request,ArticleService $articleService)
    {
        // return response()->json(['status'=>'s']);
              $article1 = $articleService->store($request);
            return $article1;
}

    }

    // public function ListArticles(){
        
    // }
    // public function ViewArticle(){
        
    // }
    // public function CreateArticle(){
        
    // }
    // public function UpdateArticle($id,ArticleService $articleService){
    //     $article=$articleService->update($id);

    // }
    // public function DeleteArticle($id,ArticleService $articleService){
    //     $article=$articleService->delete($id);
        
    // }

