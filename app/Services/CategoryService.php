<?php

namespace App\Services;

use App\Models\Categorie;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CategoryService
{
    public function create(array $data)
    {
        $v = Validator::make($data, [
            'name' => 'required|string',
            'slug' => 'required|string|unique:categories,slug',
            'description' => 'nullable|string',
            'sort_order' => 'required|integer',
            'articles_count' => 'nullable|integer',
        ]);

        if ($v->fails()) {
            throw new ValidationException($v);
        }

         return Categorie::create($v->validated());
    }
    public function update($id, array $data)
    {
        // نجيب التصنيف
        $category = Categorie::findOrFail($id);

        // Validation
        $v = Validator::make($data, [
            'name' => 'required|string',
            'slug' => 'required|string|unique:categories,slug,' . $id,
            'description' => 'nullable|string',
            'sort_order' => 'required|integer',
            'articles_count' => 'nullable|integer',
        ]);

        if ($v->fails()) {
            throw new ValidationException($v);
        }

        // Update
    
          $category->update($v->validated());
          return  $category;
    }
    public function delete($id)
    {
        $category = Categorie::findOrFail($id);
        $category->delete();

        return response()->json([
            'success' => 'status',
            'message' => 'Category deleted successfully'
        ]);
    }
}
