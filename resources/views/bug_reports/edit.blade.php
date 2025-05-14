@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Bug Report</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('bug-reports.update', $bugReport) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $bugReport->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required>{{ old('description', $bugReport->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="priority" class="form-label">Priority</label>
            <select name="priority" class="form-select" required>
                <option value="low" {{ old('priority', $bugReport->priority) == 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ old('priority', $bugReport->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ old('priority', $bugReport->priority) == 'high' ? 'selected' : '' }}>High</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="open" {{ old('status', $bugReport->status) == 'open' ? 'selected' : '' }}>Open</option>
                <option value="in_progress" {{ old('status', $bugReport->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="closed" {{ old('status', $bugReport->status) == 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="reporter" class="form-label">Reporter</label>
            <input type="text" name="reporter" class="form-control" value="{{ old('reporter', $bugReport->reporter) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('bug-reports.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
