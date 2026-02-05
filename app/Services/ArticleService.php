<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class ArticleService
{
    public function store(Request $request)
    {
            // Validation for the article fields and images
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'content' => 'nullable|string',
            'status' => 'required|in:draft,published,scheduled,archived',
            'tags' => 'required|array',
            'tags.*' => 'string',
            'reading_time' => 'required|integer|min:1',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
            'category_id' => 'required|integer',

            // Validate the images array
            'featured_image.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Create the Article
        $article = Article::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . "-" . uniqid(),
            'excerpt' => $validated['excerpt'],
            'content' => $validated['content'] ?? null,
            'status' => $validated['status'],
            'tags' => $validated['tags'],
            'reading_time' => $validated['reading_time'],
            'views_count' => 0,
            'is_featured' => $validated['is_featured'] ?? false,
            'published_at' => $validated['published_at'] ?? null,
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
        ]);

        // Handle images if uploaded
        if ($request->hasFile('featured_image')) {
            foreach ($request->file('featured_image') as $imageFile) {
                // Clean the image name
                $originalName = preg_replace('/[^A-Za-z0-9\-_\.]/', '_', $imageFile->getClientOriginalName());
                $date = now()->format('Y-m-d_H-i-s');
                $newName = $date . "_" . $originalName;

                // Store image in the public directory
                $folder = public_path('images');
                if (!is_dir($folder)) {
                    mkdir($folder, 0755, true);
                }

                // Move the file to public/images
                $imageFile->move($folder, $newName);

                // Relative URL path for the image
                $relativePath = 'images/' . $newName;
                $fullUrl = url($relativePath); // Full URL with the server name

                // Get image dimensions
                $absolutePath = $folder . DIRECTORY_SEPARATOR . $newName;
                [$width, $height] = getimagesize($absolutePath);

                // Create image record associated with the article
                $article->featuredImage()->create([
                    'url' => $fullUrl,
                    'thumbnail_url' => null,  // You can create thumbnails if needed
                    'alt' => $request->input('alt'),
                    'width' => $width,
                    'height' => $height,
                ]);
            }
        }

       // Return response with article details
        return response()->json([
            'article_id' => $article->id,
            'message' => 'Article and images created successfully.',
        ], 201);
        return response()->json(['status'=>'ok']);
        return $request;
    }
  

  
}

 












//   public function delete($id){
//         try {
//             // Attempt to find the article by ID
//             $article = Article::findOrFail($id);  // If not found, a ModelNotFoundException will be thrown

//             // Delete the article and its related images (Cascade Delete will take care of deleting images if supported by the database)
//             $article->delete();

//             // Return a successful response
//             return response()->json([
//                 'message' => 'Article and related images deleted successfully.'
//             ], 200);
//         } catch (ModelNotFoundException $e) {
//             // If the article is not found
//             return response()->json([
//                 'error' => 'Article not found',
//                 'message' => 'The article with the given ID does not exist.'
//             ], 404);
//         } catch (\Exception $e) {
//             // If any unexpected error occurs
//             return response()->json([
//                 'error' => 'Failed to delete article and images',
//                 'message' => $e->getMessage()
//             ], 500);
//         }
//     }
    // public function update(Request $request, $id)
    // {
    //     // Validation
    //     $validated = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'excerpt' => 'required|string',
    //         'content' => 'nullable|string',

    //         'status' => 'required|in:draft,published,scheduled,archived',
    //         'tags' => 'required|array',
    //         'tags.*' => 'string',
    //         'reading_time' => 'required|integer|min:1',
    //         'is_featured' => 'boolean',
    //         'published_at' => 'nullable|date',
    //         'category_id' => 'required|integer',

    //         // array of images
    //         'featured_image.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    //     ]);

    //     // Find the article by ID
    //     $article = Article::findOrFail($id);

    //     // Update the article
    //     $article->update([
    //         'title' => $validated['title'],
    //         'slug' => Str::slug($validated['title']) . "-" . uniqid(),
    //         'excerpt' => $validated['excerpt'],
    //         'content' => $validated['content'] ?? null,
    //         'status' => $validated['status'],
    //         'tags' => $validated['tags'],
    //         'reading_time' => $validated['reading_time'],
    //         'is_featured' => $validated['is_featured'] ?? false,
    //         'published_at' => $validated['published_at'] ?? null,
    //         'category_id' => $request->category_id,
    //     ]);

    //     // Handle the images
    //     if ($request->hasFile('featured_image')) {
    //         // Delete old images (if any) – this step can be skipped if you want to keep old images
    //         $article->featuredImage()->delete();

    //         // Process and store new images
    //         foreach ($request->file('featured_image') as $imageFile) {
    //             // Clean image name
    //             $originalName = preg_replace('/[^A-Za-z0-9\-_\.]/', '_', $imageFile->getClientOriginalName());
    //             $date = now()->format('Y-m-d_H-i-s');
    //             $newName = $date . "_" . $originalName;

    //             // Store image inside public folder
    //             $folder = public_path('images');
    //             if (!is_dir($folder)) {
    //                 mkdir($folder, 0755, true);
    //             }

    //             // Move file to public/images
    //             $imageFile->move($folder, $newName);

    //             // Relative web path
    //             $relativePath = 'images/' . $newName;
    //             // Full URL with the server name
    //             $fullUrl = url($relativePath);

    //             // Get image dimensions
    //             $absolutePath = $folder . DIRECTORY_SEPARATOR . $newName;
    //             [$width, $height] = getimagesize($absolutePath);

    //             // Create image record and associate with the article
    //             $article->featuredImage()->create([
    //                 'url' => $fullUrl,
    //                 'thumbnail_url' => null, // You can generate a thumbnail if needed
    //                 'alt' => $request->input('alt'),
    //                 'width' => $width,
    //                 'height' => $height,
    //             ]);
    //         }
    //     }

    //     // Return a response with the article data
    //     return response()->json([
    //         'article_id' => $article->id,
    //         'message' => 'Article and images updated successfully.',
    //     ]);
    // }