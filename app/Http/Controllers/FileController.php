<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use \ZipArchive;

class FileController extends Controller
{
    public function download($id)
    {
        $file = File::findOrFail($id);

        $filePath = storage_path('app/public/' . $file->storage_path);

        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->download($filePath, $file->name);
    }

    public function downloadFolder($id)
    {
        $folder = Folder::with(['files', 'children'])->findOrFail($id);

        // Create temporary zip file
        $zipFileName = $folder->name . '_' . time() . '.zip';
        $zipPath = storage_path('app/temp/' . $zipFileName);

        // Ensure temp directory exists
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $zip = new ZipArchive();

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            abort(500, 'Could not create zip file');
        }

        // Recursively add files and folders to zip
        $this->addFolderToZip($zip, $folder, '');

        $zip->close();

        // Return download response and delete file after sending
        return response()->download($zipPath, $folder->name . '.zip')->deleteFileAfterSend(true);
    }

    private function addFolderToZip(ZipArchive $zip, Folder $folder, string $parentPath)
    {
        // Create folder path inside zip
        $currentPath = $parentPath ? $parentPath . '/' . $folder->name : $folder->name;

        // Add the folder itself (even if empty)
        $zip->addEmptyDir($currentPath);

        // Add all files in this folder
        foreach ($folder->files as $file) {
            $filePath = storage_path('app/public/' . $file->storage_path);
            if (file_exists($filePath)) {
                $zip->addFile($filePath, $currentPath . '/' . $file->name);
            }
        }

        // Recursively add child folders
        foreach ($folder->children as $childFolder) {
            // Load the child folder's files and children
            $childFolder->load(['files', 'children']);
            $this->addFolderToZip($zip, $childFolder, $currentPath);
        }
    }
}
