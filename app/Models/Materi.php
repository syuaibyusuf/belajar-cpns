<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $table = 'materi';
    
    protected $fillable = [
        'title', 'category', 'content', 'content_images', 'thumbnail', 'order_number', 'status', 'created_by'
    ];

    protected $casts = [
        'content_images' => 'array'
    ];

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public static function getCategories()
    {
        return [
            'twk' => 'Tes Wawasan Kebangsaan',
            'tiu' => 'Tes Intelegensi Umum',
            'tkp' => 'Tes Karakteristik Pribadi'
        ];
    }
    
    public function getThumbnailUrl()
    {
        if ($this->thumbnail && file_exists(public_path('uploads/materi/' . $this->thumbnail))) {
            return asset('uploads/materi/' . $this->thumbnail);
        }
        return null;
    }
    
    public function getParsedContent()
    {
        $content = e($this->content);
        
        $images = $this->content_images;
        if (is_string($images)) {
            $images = json_decode($images, true);
        }
        
        if (!is_array($images)) {
            $images = [];
        }
        
        foreach ($images as $image) {
            if (isset($image['placeholder']) && isset($image['path'])) {
                $imageUrl = asset('uploads/materi/' . $image['path']);
                $imageHtml = '<div class="my-6 flex justify-center">
                    <img src="' . $imageUrl . '" 
                         alt="Gambar Materi" 
                         class="max-w-full h-auto rounded-lg shadow-md border border-gray-200 cursor-pointer"
                         loading="lazy"
                         onclick="openLightbox(this.src)">
                </div>';
                $content = str_replace($image['placeholder'], $imageHtml, $content);
            }
        }
        
        return $content;
    }
}