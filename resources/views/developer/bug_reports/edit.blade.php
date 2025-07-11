@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Bug Report #{{ $bugReport->id }}</h1>

    <a href="{{ route('developer.bug-reports.show', $bugReport->id) }}" class="btn btn-secondary mb-3">Kembali ke detail</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('developer.bug-reports.update', $bugReport->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="title">Judul</label>
            <input type="text" name="title" id="title" class="form-control"
                value="{{ old('title', $bugReport->title) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="priority">Prioritas</label>
            <select name="priority" id="priority" class="form-control" required>
                <option value="low" {{ old('priority', $bugReport->priority) == 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ old('priority', $bugReport->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ old('priority', $bugReport->priority) == 'high' ? 'selected' : '' }}>High</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="open" {{ old('status', $bugReport->status) == 'open' ? 'selected' : '' }}>Open</option>
                <option value="in_progress" {{ old('status', $bugReport->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="resolved" {{ old('status', $bugReport->status) == 'resolved' ? 'selected' : '' }}>Resolved</option>
                <option value="closed" {{ old('status', $bugReport->status) == 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="description">Deskripsi</label>
            <textarea name="description" id="description" rows="5" class="form-control" required>{{ old('description', $bugReport->description) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
