@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $bugReport->title }}</h1>

    <p><strong>Reporter:</strong> {{ $bugReport->reporter }}</p>
    <p><strong>Priority:</strong> {{ ucfirst($bugReport->priority) }}</p>
    <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $bugReport->status)) }}</p>
    <p><strong>Description:</strong></p>
    <p>{{ $bugReport->description }}</p>

    @php
        $isBugTester = auth()->user()->isBugTester();
        $prefix = auth()->user()->role === 'bug_tester' ? 'bug_tester' : 'developer';
    @endphp

    @if ($isBugTester)
        <a href="{{ route($prefix . '.bug-reports.edit', $bugReport) }}" class="btn btn-warning">Edit</a>
    @endif
    
    <a href="{{ route($prefix . '.bug-reports.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection
