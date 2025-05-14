@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $bugReport->title }}</h1>

    <p><strong>Reporter:</strong> {{ $bugReport->reporter }}</p>
    <p><strong>Priority:</strong> {{ ucfirst($bugReport->priority) }}</p>
    <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $bugReport->status)) }}</p>
    <p><strong>Description:</strong></p>
    <p>{{ $bugReport->description }}</p>

    <a href="{{ route('bug-reports.edit', $bugReport) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('bug-reports.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bug Report App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('bug-reports.index') }}">Bug Report</a>
        </div>
    </nav>

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
