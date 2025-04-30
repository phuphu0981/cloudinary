@extends('layouts.app')

@section('content')
<div class="container">
    @if ($lovers->isEmpty())
        <h1>Lover</h1>
        <form action="{{ route('lovers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">Password</label>
                <input type="password" class="form-control" id="pass" name="pass" required>
            </div>
            <div class="mb-3">
                <label for="profile_text" class="form-label">Profile Text</label>
                <textarea class="form-control" id="profile_text" name="profile_text"></textarea>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content"></textarea>
            </div>
            <div class="mb-3">
                <label for="letter_text" class="form-label">Letter Text</label>
                <textarea class="form-control" id="letter_text" name="letter_text"></textarea>
            </div>
            <div class="mb-3">
                <label for="avatar" class="form-label">Avatar</label>
                <input type="file" class="form-control" id="avatar" name="avatar">
            </div>
            @for ($i = 1; $i <= 9; $i++)
            <div class="mb-3">
                <label for="picture{{ $i }}" class="form-label">Picture {{ $i }}</label>
                <input type="file" class="form-control" id="picture{{ $i }}" name="picture{{ $i }}">
            </div>
            @endfor
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    @endif

    <h2 class="mt-5">Lovers List</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>STT</th>
                <th>Field Name</th>
                <th>Field Value</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lovers as $index => $lover)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>Name</td>
                <td>{{ $lover->name }}</td>
                <td>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" 
                        data-id="{{ $lover->id }}" data-field="name" data-value="{{ $lover->name }}">Edit</button>
                    <form action="{{ route('lovers.destroy', $lover->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>Profile Text</td>
                <td>{{ $lover->profile_text }}</td>
                <td>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" 
                        data-id="{{ $lover->id }}" data-field="profile_text" data-value="{{ $lover->profile_text }}">Edit</button>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>Content</td>
                <td>{{ $lover->content }}</td>
                <td>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" 
                        data-id="{{ $lover->id }}" data-field="content" data-value="{{ $lover->content }}">Edit</button>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>Letter Text</td>
                <td>{{ $lover->letter_text }}</td>
                <td>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" 
                        data-id="{{ $lover->id }}" data-field="letter_text" data-value="{{ $lover->letter_text }}">Edit</button>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>Password</td>
                <td>{{ $lover->pass }}</td>
                <td>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" 
                        data-id="{{ $lover->id }}" data-field="pass" data-value="{{ $lover->pass }}">Edit</button>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>Avatar</td>
                <td>
                    @if ($lover->avatar)
                        <img src="{{ $lover->avatar }}" alt="Avatar" style="width: 100px; height: 100px;">
                    @else
                        No Avatar
                    @endif
                </td>
                <td>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" 
                        data-id="{{ $lover->id }}" data-field="avatar" data-value="">Edit</button>
                </td>
            </tr>
            @for ($i = 1; $i <= 9; $i++)
                @php $pictureField = 'picture' . $i; @endphp
                @if ($lover->{$pictureField})
                <tr>
                    <td></td>
                    <td>Picture {{ $i }}</td>
                    <td>
                        <img src="{{ $lover->{$pictureField} }}" alt="Picture {{ $i }}" style="width: 100px; height: 100px;">
                    </td>
                    <td>
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" 
                            data-id="{{ $lover->id }}" data-field="{{ $pictureField }}" data-value="">Edit</button>
                    </td>
                </tr>
                @endif
            @endfor
            @endforeach
        </tbody>
    </table>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Field</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="loverId" name="id">
                    <input type="hidden" id="fieldName" name="field">
                    <div class="mb-3">
                        <label for="fieldValue" class="form-label" id="fieldLabel"></label>
                        <input type="text" class="form-control" id="fieldValue" name="value">
                        <input type="file" class="form-control d-none" id="fieldFile" name="file">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const field = button.getAttribute('data-field');
        const value = button.getAttribute('data-value');

        const modalTitle = editModal.querySelector('.modal-title');
        const fieldLabel = editModal.querySelector('#fieldLabel');
        const fieldValue = editModal.querySelector('#fieldValue');
        const fieldFile = editModal.querySelector('#fieldFile');
        const editForm = editModal.querySelector('#editForm');

        modalTitle.textContent = `Edit ${field}`;
        fieldLabel.textContent = `Edit ${field}`;
        fieldValue.value = value;
        fieldValue.classList.remove('d-none');
        fieldFile.classList.add('d-none');

        if (field === 'avatar' || field.startsWith('picture')) {
            fieldValue.classList.add('d-none');
            fieldFile.classList.remove('d-none');
        }

        editForm.action = `/lovers/${id}`;
        editForm.querySelector('#loverId').value = id;
        editForm.querySelector('#fieldName').value = field;
    });
</script>
@endsection
