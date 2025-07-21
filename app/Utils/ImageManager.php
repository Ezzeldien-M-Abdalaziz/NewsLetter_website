<?php
namespace App\Utils;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageManager
{
    public static function uploadImages($request , $post=null , $user=null)
    {
        if($request->hasFile('images')){
                foreach($request->file('images') as $image){
                    $path = self::storeImageInLocal($image , 'uploads/posts');
                    $post->images()->create([
                        'path' => $path
                    ]);
                }
        }

        //one image
        if($request->hasFile('image')){
            $path = self::storeImageInLocal($request->file('image') , 'uploads/users');
            $user->update([
                'image' => $path
            ]);
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

    public static function deleteUserImage($user) {
    if ($user->image && File::exists(public_path($user->image))) {
        File::delete(public_path($user->image));
    }
}

    private static function generateImageName($file){
        return Str::uuid() . '-' . time() . '.' . $file->getClientOriginalExtension();
    }

    private static function storeImageInLocal($file , $path){
        $newName = self::generateImageName($file);
        $path = $file->storeAs($path, $newName , ['disk' => 'uploads']);
        return $path;
    }
}
