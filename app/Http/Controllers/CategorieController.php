<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Services\CategoryService;
class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories =Categorie::all();
        return response()->json(['status'=>'success','All Data'=>$categories]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
     $category = app(CategoryService::class)->create($request->all());

    return response()->json([
        'status' => 'success',
        'data' => $category,
    ], 201);
    }

 

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
      $category= app(CategoryService::class)->update($id, $request->all());
        return response()->json([
        'status' => 'updated',
        'data' => $category,
        ], 201);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        if(!empty(Categorie::findOrFail($id))){
            $categorie= app(CategoryService::class)->delete($id);
            return response()->json([
            'status' => 'success',
            'message' => 'Categorie deleted successfully',
        ]);
        }
        
    }
}
