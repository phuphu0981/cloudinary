<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File List</title>
</head>
<body>
    <h1>Danh sách file</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Hình ảnh</th>
                <th>Tên file</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($files as $file)
                <tr>
                    <td><img src="{{ $file['secure_url'] }}" alt="File" width="100"></td>
                    <td>{{ $file['public_id'] }}</td>
                    <td>
                        <form action="{{ route('files.update', $file['public_id']) }}" method="POST" enctype="multipart/form-data" style="display: inline;">
                            @csrf
                            <input type="file" name="file" required>
                            <button type="submit">Sửa</button>
                        </form>

                        <!-- Form xóa file -->
                        <form action="{{ route('files.destroy', $file['public_id']) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa file này?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>