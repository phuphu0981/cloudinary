<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Filesystem\Cloud;
use Cloudinary\Cloudinary;
use Illuminate\Http\Request;

class cloudController extends Controller
{
    public function index()
    {
        return view('upload'); // Hiển thị form upload
    }

    public function upload(Request $request)
    {
    $request->validate([
        'file' => 'required|file|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    // Khởi tạo Cloudinary
    $cloudinary = new Cloudinary();

    // Upload file vào thư mục "my_folder"
    $uploadedFile = $cloudinary->uploadApi()->upload(
        $request->file('file')->getRealPath(),
        ['folder' => 'phu'] // Đặt tên thư mục bạn muốn
    );

    $uploadedFileUrl = $uploadedFile['secure_url'];

    return back()->with('success', 'File uploaded successfully!')->with('file_url', $uploadedFileUrl);
    }

}

