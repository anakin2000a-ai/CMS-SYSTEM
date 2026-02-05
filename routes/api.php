<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Api\AuthController;


//any one can see it
Route::get('/v1/categories',[CategorieController::class,'index']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Route::get('/api/v1/articles',[ArticleController::class,'ListArticles']);
// Route::get('/api/v1/articles/{slug}',[ArticleController::class,'ViewArticle']);
// Route::post('/v1/articles',[ArticleController::class,'CreateArticle']);
// Route::get('/api/v1/articles/{id}',[ArticleController::class,'UpdateArticle']);
// Route::get('/api/v1/articles/{id}',[ArticleController::class,'DeleteArticle']);

Route::middleware(['auth:sanctum', 'isAuthor'])->group(function () {
    // Route::delete('/v1/articles/{id}', [ArticleController::class, 'DeleteArticle']);
    // Route::put('/v1/articles/{id}', [ArticleController::class, 'UpdateArticle']);
     Route::post('/v1/articles', [ArticleController::class, 'CreateArticle']);

    //create,update,delete for categories
    Route::post('/v1/categories',[CategorieController::class, 'store']);
    Route::put('/v1/categories/{id}',[CategorieController::class, 'update']);
    Route::delete('/v1/categories/{id}',[CategorieController::class, 'destroy']);
});
// Route::get('/categories', [CategorieController::class, 'index']);
// Route::middleware('auth:sanctum')->group(function () {
//     // Protected (Auth required)
//     Route::middleware('auth:sanctum')->group(function () {
//         // Create category
//         Route::post('categories', [CategorieController::class, 'store']);

//         // Update category
//         Route::put('categories/{id}', [CategorieController::class, 'update']);

//         // Delete category
//         Route::delete('categories/{id}', [CategorieController::class, 'destroy']);
//     });
// });