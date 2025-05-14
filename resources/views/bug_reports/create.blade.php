@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Bug Report</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('bug-reports.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="priority" class="form-label">Priority</label>
            <select name="priority" class="form-select" required>
                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Open</option>
                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="reporter" class="form-label">Reporter</label>
            <input type="text" name="reporter" class="form-control" value="{{ old('reporter') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{ route('bug-reports.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
