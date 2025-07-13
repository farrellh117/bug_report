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

    @php
        $isDeveloper = auth()->user()->isDeveloper();
        $isBugTester = auth()->user()->isBugTester();
    @endphp

    <form action="{{ route('bug_tester.bug-reports.update', $bugReport) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $bugReport->title) }}" required {{ $isDeveloper ? 'readonly' : '' }}>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required {{ $isDeveloper ? 'readonly' : '' }}>{{ old('description', $bugReport->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="priority" class="form-label">Priority</label>
            <select name="priority" class="form-select" required {{ $isDeveloper ? 'disabled' : '' }}>
                <option value="low" {{ old('priority', $bugReport->priority) == 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ old('priority', $bugReport->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ old('priority', $bugReport->priority) == 'high' ? 'selected' : '' }}>High</option>
            </select>
            @if ($isDeveloper)
                <input type="hidden" name="priority" value="{{ $bugReport->priority }}">
            @endif
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select" required {{ $isDeveloper ? 'disabled' : '' }}>
                <option value="open" {{ old('status', $bugReport->status) == 'open' ? 'selected' : '' }}>Open</option>
                <option value="in_progress" {{ old('status', $bugReport->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="closed" {{ old('status', $bugReport->status) == 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
            @if ($isDeveloper)
                <input type="hidden" name="status" value="{{ $bugReport->status }}">
            @endif
        </div>

        <div class="mb-3">
            <label for="reporter" class="form-label">Reporter</label>
            <input type="text" name="reporter" class="form-control" value="{{ old('reporter', $bugReport->reporter) }}" required {{ $isDeveloper ? 'readonly' : '' }}>
        </div>

        @if ($isBugTester)
            <button type="submit" class="btn btn-primary">Update</button>
        @else
            <div class="alert alert-info">
                You have read-only access on this bug report.
            </div>
        @endif
        
        <a href="{{ route('bug_tester.bug-reports.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
