<?php

namespace App\Http\Controllers;

use App\Jobs\UploadImageToS3;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Throwable;

class UploadController extends Controller
{
    protected $service;

    public function uploadImage(Request $request)
    {
        $image = $request->file('image');
        $s3 = Storage::disk('s3');

        $s3Path = 'uploads';
        $uploaded = $s3->putFile($s3Path, $image, 'public');
        return $uploaded;
    }

    public function uploadImageSqs(Request $request)
    {
        $imagePath = $request->file('image')->getPathname();
        UploadImageToS3::dispatch($imagePath)->onConnection('sqs');
        return response()->json(['message' => 'Image upload job dispatched.']);
    }
}
