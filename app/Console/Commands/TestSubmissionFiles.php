<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Submission;
use Illuminate\Support\Facades\Storage;

class TestSubmissionFiles extends Command
{
    protected $signature = 'submission:test-files 
        {submissionId? : The ID of the submission to test}
        {--list : List files for a submission}
        {--download= : Download a specific file by its path}';

    protected $description = 'Test file URLs and downloads for submissions';

    public function handle()
    {
        $submissionId = $this->argument('submissionId');
        $listFiles = $this->option('list');
        $downloadPath = $this->option('download');

        if ($listFiles && $submissionId) {
            $this->listSubmissionFiles($submissionId);
        } elseif ($downloadPath) {
            $this->downloadFile($downloadPath);
        } else {
            $this->showSubmissionList();
        }
    }

    protected function showSubmissionList()
    {
        $submissions = Submission::latest()->take(10)->get();
        
        $this->info('Recent Submissions:');
        $headers = ['ID', 'Name', 'Email', 'Images', 'Files'];
        $data = $submissions->map(function ($submission) {
            return [
                'id' => $submission->id,
                'name' => $submission->name,
                'email' => $submission->email,
                'images' => count(json_decode($submission->image_paths ?? '[]')),
                'files' => count(json_decode($submission->file_paths ?? '[]'))
            ];
        });

        $this->table($headers, $data);
        $this->info('Use submissionId with --list or --download options');
    }

    protected function listSubmissionFiles($submissionId)
    {
        $submission = Submission::findOrFail($submissionId);
        
        $this->info("Files for Submission #$submissionId:");
        
        // List Images
        $this->info("\nImages:");
        $imagePaths = json_decode($submission->image_paths ?? '[]');
        if (empty($imagePaths)) {
            $this->warn('No images found.');
        } else {
            foreach ($imagePaths as $path) {
                $fullPath = Storage::disk('Files')->path($path);
                $url = Storage::disk('Files')->url($path);
                $exists = Storage::disk('Files')->exists($path);
                
                $this->line("- Path: $path");
                $this->line("  Full Path: $fullPath");
                $this->line("  URL: $url");
                $this->line("  Exists: " . ($exists ? 'Yes' : 'No'));
            }
        }

        // List Documents
        $this->info("\nDocuments:");
        $filePaths = json_decode($submission->file_paths ?? '[]');
        if (empty($filePaths)) {
            $this->warn('No documents found.');
        } else {
            foreach ($filePaths as $path) {
                $fullPath = Storage::disk('Files')->path($path);
                $url = Storage::disk('Files')->url($path);
                $exists = Storage::disk('Files')->exists($path);
                
                $this->line("- Path: $path");
                $this->line("  Full Path: $fullPath");
                $this->line("  URL: $url");
                $this->line("  Exists: " . ($exists ? 'Yes' : 'No'));
            }
        }
    }

    protected function downloadFile($path)
    {
        if (!Storage::disk('Files')->exists($path)) {
            $this->error("File not found: $path");
            return;
        }

        $fullPath = Storage::disk('Files')->path($path);
        $destinationPath = storage_path('app/downloads/' . basename($path));

        // Ensure download directory exists
        if (!file_exists(dirname($destinationPath))) {
            mkdir(dirname($destinationPath), 0755, true);
        }

        // Copy file to download directory
        if (copy($fullPath, $destinationPath)) {
            $this->info("File downloaded successfully:");
            $this->line("Source: $fullPath");
            $this->line("Destination: $destinationPath");
        } else {
            $this->error("Failed to download file.");
        }
    }
}
