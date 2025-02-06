<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SubmissionController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:10',
            'email' => [
                'required', 
                'email', 
                'regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
                function ($attribute, $value, $fail) {
                    if (stripos($value, 'gmail.com') !== false) {
                        $fail('Gmail addresses are not allowed.');
                    }
                }
            ],
            'phone' => ['required', 'regex:/^\+\d{1,3}\s?\(\d{3}\)\s?\d{3}[-.]?\d{4}$/'],
            'message' => 'required|min:10',
            'street' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'country' => 'required',
            'images.*' => 'image|mimes:jpg,jpeg',
            'files.*' => 'mimes:pdf'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Handle file uploads
        $imagePaths = [];
        $filePaths = [];

        // Store images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'Files');
                $imagePaths[] = $path;
            }
        }

        // Store files
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('files', 'Files');
                $filePaths[] = $path;
            }
        }

        // Create submission
        $submission = Submission::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'message' => $request->input('message'),
            'street' => $request->input('street'),
            'state' => $request->input('state'),
            'zip' => $request->input('zip'),
            'country' => $request->input('country'),
            'image_paths' => json_encode($imagePaths),
            'file_paths' => json_encode($filePaths)
        ]);

        return response()->json([
            'message' => 'Submission successful',
            'submission' => $submission
        ], 201);
    }

    /**
     * List all files for a specific submission
     */
    public function listFiles($submissionId)
    {
        $submission = Submission::findOrFail($submissionId);
        
        $files = [
            'images' => $submission->image_paths ? 
                array_map(function($path) {
                    return [
                        'path' => $path,
                        'url' => Storage::disk('Files')->url($path),
                        'name' => basename($path)
                    ];
                }, json_decode($submission->image_paths)) : [],
            'documents' => $submission->file_paths ? 
                array_map(function($path) {
                    return [
                        'path' => $path,
                        'url' => Storage::disk('Files')->url($path),
                        'name' => basename($path)
                    ];
                }, json_decode($submission->file_paths)) : []
        ];

        return response()->json($files);
    }

    /**
     * Download a specific file
     */
    public function downloadFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'path' => 'required|string',
            'type' => 'required|in:image,document'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid file parameters'], 400);
        }

        $path = $request->input('path');

        // Verify file exists
        if (!Storage::disk('Files')->exists($path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        // Stream the file download
        return Storage::disk('Files')->download($path);
    }
}
