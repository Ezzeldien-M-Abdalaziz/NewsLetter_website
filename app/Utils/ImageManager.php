<?php
namespace App\Utils;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageManager
{
    public static function uploadImages($post, $request)
    {
        if($request->hasFile('images')){
                foreach($request->file('images') as $image){
                    $file = Str::uuid() . '-' . time() . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('uploads/posts', $file , ['disk' => 'uploads']);
                    $post->images()->create([
                        'path' => $path
                    ]);
                }
        }
    }

    public static function deleteImages($post){
        if($post->images->count() > 0){
            foreach($post->images as $image){
                if(File::exists(public_path($image->path))){
                    File::delete(public_path($image->path));
                }
            }
        }
    }
}
