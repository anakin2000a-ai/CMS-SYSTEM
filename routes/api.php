<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\NotificationCampaignController;
use App\Http\Controllers\SubscriberController;
use App\Models\Notification_campaign;

//any one can see it
Route::get('/v1/categories',[CategorieController::class,'index']);
//any one for article
Route::get('/v1/articles/', [ArticleController::class, 'ListArticles']);
Route::get('/v1/articles/{slug}', [ArticleController::class, 'ViewArticle']);
//any one for subsubcriber
Route::post('/v1/subscribe', [SubscriberController::class, 'AddSubscribe']);
Route::post('/v1/unsubscribe/{id}', [SubscriberController::class, 'UnSubscribe']);
//login and register
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

 
Route::middleware(['auth:sanctum', 'isAuthor'])->group(function () {
    //only Auth for article
    Route::delete('/v1/articles/{id}', [ArticleController::class, 'DeleteArticle']);
     Route::put('/v1/articles/{id}', [ArticleController::class, 'UpdateArticle']);
     Route::post('/v1/articles', [ArticleController::class, 'CreateArticle']);

    //create,update,delete for categories
    Route::post('/v1/categories',[CategorieController::class, 'store']);
    Route::put('/v1/categories/{id}',[CategorieController::class, 'update']);
    Route::delete('/v1/categories/{id}',[CategorieController::class, 'destroy']);
    //list susubcrebers 
    Route::get('/v1/subscribers', [SubscriberController::class, 'ListSubscribe']);

    //Notifications
    Route::get('/v1/notifications', [NotificationCampaignController::class, 'ListNotifications']);
    Route::get('/v1/notifications/{id}', [NotificationCampaignController::class, 'GetCampaignById']);
    Route::post('/v1/notifications', [NotificationCampaignController::class, 'CreateCampaign']);
    Route::post('/v1/notifications/{id}/send', [NotificationCampaignController::class, 'SendCampaign']);

    //logout
    Route::post('/logout', [AuthController::class, 'logout']);


});
 