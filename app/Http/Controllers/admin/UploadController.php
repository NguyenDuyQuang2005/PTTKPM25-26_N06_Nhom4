<?php

namespace App\Http\Controllers\admin;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
   public function uploadImage(Request $request)
{
    $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
    $request->file('file')->storeAs('images', $fileName, 'public'); 
    $path = '/storage/images/' . $fileName;

    return response()->json([
        'success' => true,
        'path' => $path
    ]);
}

public function uploadImages(Request $request)
{
    if (!$request->hasFile('files')) {
        return response()->json([
            'success' => false,
            'message' => 'No files uploaded.'   
        ]);
    }

    $paths = [];
    $folder = 'images';

    foreach ($request->file('files') as $file) {
        if (!$file->isValid()) continue;

        $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                    . '-' . time() . '-' . Str::random(5) . '.'
                    . $file->getClientOriginalExtension();
        
        $path = $file->storeAs($folder, $fileName, 'public');

        $paths[] = '/storage/' . $path;
    }

    return response()->json([
        'success' => true,
        'paths' => $paths
    ]);
}

}


