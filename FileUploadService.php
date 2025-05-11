<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class FileUploadService
{
    protected string $basePath;

    /**
     * Set the base public path for uploads (relative to public/).
     */
    public function __construct(string $path = 'uploads')
    {
        $this->basePath = public_path($path);

        // Ensure the directory exists
        if (!File::exists($this->basePath)) {
            File::makeDirectory($this->basePath, 0755, true);
        }
    }

    /**
     * Upload a file to the set path.
     */
    public function upload(UploadedFile $file, string $filename = null): string
    {
        $filename = $filename ?? uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($this->basePath, $filename);
        return $this->getRelativePath($filename);
    }

    /**
     * Check if a file exists in the upload path.
     */
    public function exists(string $relativePath): bool
    {
        return File::exists(public_path($relativePath));
    }

    /**
     * Delete a file from the upload path.
     */
    public function delete(string $relativePath): bool
    {
        $fullPath = public_path($relativePath);
        return File::exists($fullPath) && File::delete($fullPath);
    }

    /**
     * Get full public path.
     */
    public function getFullPath(string $filename): string
    {
        return $this->basePath . '/' . ltrim($filename, '/');
    }

    /**
     * Get the relative path to store in DB or return to user.
     */
    protected function getRelativePath(string $filename): string
    {
        return str_replace(public_path(), '', $this->basePath . '/' . $filename);
    }
}
