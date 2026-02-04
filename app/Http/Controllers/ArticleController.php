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
         $article = $articleService->create($request);
        return response()->json([
            'message' => 'Article created successfully',
            'data' => $article,
        ], 201);
    }

    // public function ListArticles(){
        
    // }
    // public function ViewArticle(){
        
    // }
    // public function CreateArticle(){
        
    // }
    // public function UpdateArticle(){
        
    // }
    // public function DeleteArticle(){
        
    // }
}
