<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload to Cloudinary</title>
</head>
<body>
    <h1>Upload File to Cloudinary</h1>
    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
        <p>File URL: <a href="{{ session('file_url') }}" target="_blank">{{ session('file_url') }}</a></p>
    @endif
    <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>