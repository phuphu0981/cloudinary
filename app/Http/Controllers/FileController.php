<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class FileController extends Controller
{
    public function index()
    {
        // Lấy danh sách file từ Cloudinary
        $files = Cloudinary::admin()->assets(['type' => 'upload', 'max_results' => 20]);

        return view('files.index', ['files' => $files['resources']]);
    }

    // Cập nhật file (ví dụ: thay đổi metadata)
    public function update(Request $request, $publicId)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
    
        $uploadedFile = Cloudinary::upload($request->file('file')->getRealPath(), [
            'public_id' => $publicId, // Ghi đè ảnh cũ
            'overwrite' => true,      // Cho phép ghi đè
        ]);
    
        return redirect()->route('files.index')->with('success', 'File updated successfully!');
    }

    // Xóa file
    public function destroy($publicId)
    {
        Cloudinary::destroy($publicId);

        return redirect()->route('files.index')->with('success', 'File deleted successfully!');
    }

}
