@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Bug Reports</h1>

    {{-- Tampilkan tombol Create hanya untuk bug tester --}}
    @if(auth()->user()->isBugTester())
        <a href="{{ route('bug_tester.bug-reports.create') }}" class="btn btn-primary mb-3">Create New Bug Report</a>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($bugReports->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Reporter</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bugReports as $bug)
                <tr>
                    <td><a href="{{ route('bug_tester.bug-reports.show', $bug) }}">{{ $bug->title }}</a></td>
                    <td>{{ $bug->reporter }}</td>
                    <td>{{ ucfirst($bug->priority) }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $bug->status)) }}</td>
                    <td>{{ $bug->created_at->format('Y-m-d') }}</td>
                    <td>
                        @if(auth()->user()->isBugTester())
                            <a href="{{ route('bug_tester.bug-reports.edit', $bug) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('bug_tester.bug-reports.destroy', $bug) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        @elseif(auth()->user()->isDeveloper())
                            {{-- Jika developer hanya lihat tanpa aksi, kosongkan --}}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $bugReports->links() }}
    @else
        <p>No bug reports found.</p>
    @endif
</div>
@endsection
