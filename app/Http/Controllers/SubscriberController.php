<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Services\ArticleService;
use App\Services\Sub;
use App\Services\SubsubcribeService;
use Illuminate\Http\Request;
use App\Models\User;

class SubscriberController extends Controller
{
    
    public function AddSubscribe(Request $request,SubsubcribeService $subsubcribeServise) {
         $subsubcribe=$subsubcribeServise->NewSubsubcriber($request);
        return $subsubcribe;
      
    }
    public function UnSubscribe($id,SubsubcribeService $subsubcribeServise) {
         $subsubcribe=$subsubcribeServise->UnSubscribeService($id);
        return $subsubcribe;
      
    }
    public function ListSubscribe(){
        // Retrieve all users where 'is_active' is true
        $users = User::where('is_active', true)->get();

        // Return the users in a JSON response
        return response()->json([
            'message' => 'Active users retrieved successfully.',
            'data' => $users
        ], 200);  // HTTP status code 200 for "OK"
    }


     
}
