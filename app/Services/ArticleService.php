<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
class ArticleService
{
    public function create(Request $request)
    {
        
        // Validation
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

            //  صورة مرفوعة
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

       //iimage
      $imageId = null;

        if ($request->hasFile('featured_image')) {

            $imageFile = $request->file('featured_image');

            //  تنظيف اسم الملف
            $originalName = preg_replace('/[^A-Za-z0-9\-_\.]/', '_', $imageFile->getClientOriginalName());

            //  التاريخ الحالي قبل الاسم
            $date = now()->format('Y-m-d_H-i-s');

            //  الاسم الجديد
            $newName = $date . "_" . $originalName;

            //  مجلد الحفظ داخل public
            $folder = public_path('images');

            if (!is_dir($folder)) {
                mkdir($folder, 0755, true);
            }

            //  نقل الملف إلى public/images
            $imageFile->move($folder, $newName);

            // ✅ مسار ويب (نسبي)
            $relativePath = 'images/' . $newName;

            // ✅ URL كامل مع اسم السيرفر
            $fullUrl = url($relativePath); // مثال: http://127.0.0.1:8000/images/....

            // ✅ استخراج أبعاد الصورة (ضروري لأن width/height مطلوبين)
            $absolutePath = $folder . DIRECTORY_SEPARATOR . $newName;
            [$width, $height] = getimagesize($absolutePath);

            // ✅ إنشاء record بجدول images
            $image = Image::create([
                'url' => $fullUrl,
                'thumbnail_url' => null,              // إذا ما عم تعمل thumbnail حالياً
                'alt' => $request->input('alt'),
                'width' => $width,
                'height' => $height,
            ]);

             $imageId = $image->id;
        
            }
     
      //create article
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

            //  user_id من المستخدم الحالي
            'user_id' =>auth()->id(),

            'category_id' => $request->category_id,

            //  ربط الصورة
            'featured_image_id' => $imageId,
        ]);

        return $request;
    }
}
