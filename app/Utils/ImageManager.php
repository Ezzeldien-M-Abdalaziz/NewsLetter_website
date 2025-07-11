<?php
namespace App\Utils;

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
}
