<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MEME_template;
use App\Templates;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class MEME_Controller extends Controller
{
    public function get_data()
    {
        $templates = new Templates();
        $files = glob(public_path('templates/*.{jpg,jpeg,png,gif,webp}'), GLOB_BRACE);

        foreach ($files as $file) {
            if (is_file($file)) {
                $fileSize = filesize($file);
                $template = new MEME_template([
                    'template_name' => basename($file),
                    'template_path' => $file,
                    'template_url' => url('templates/' . basename($file)), // tạo full URL
                    'file_size' => $fileSize,
                ]);
                $templates->add($template);
            }
        }

        return view('welcome', [
            'memes' => $templates->all(),
        ]);
    }
    public function store(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpeg,png,gif|max:5120', // Max 5MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        try {
            // Handle the file upload
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                // Generate a unique filename to prevent conflicts
                $filename = $file->getClientOriginalName();
                $file->move(public_path('templates'), $filename);

                return response()->json([
                    'success' => true,
                    'message' => 'Template uploaded successfully!',
                    'template' => [
                        'name' => $filename,
                        'url' => asset('templates/' . $filename),
                    ],
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'No file uploaded.',
            ], 400);

        } catch (\Exception $e) {
            \Log::error('Meme upload failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while uploading the template.',
            ], 500);
        }
    }
}
