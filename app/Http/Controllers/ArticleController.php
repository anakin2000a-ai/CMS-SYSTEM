<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use ReturnTypeWillChange;

class ArticleController extends Controller
{
    

    public function CreateArticle(Request $request,ArticleService $articleService) {
        // return response()->json(['status'=>'s']);
              $article1 = $articleService->store($request);
            return $article1;
     }
    public function DeleteArticle($id,ArticleService $articleService){
        $article=$articleService->delete($id);
        return $article; 
    }
       
    public function UpdateArticle(Request $request, $id,ArticleService $articleService){
         $article=$articleService->update($request,$id);
        return $article;
    }      
    public function ListArticles(){
         $articles = Article::all();
         return response()->json([
            'message' => 'Articles retrieved successfully.',
            'data' => $articles ],
             200);
        
    }
    public function ViewArticle($slug, ArticleService $articleService){
        $article=$articleService->ViewArticleSlug($slug);
        return $article;
    }  
 }



 
   

