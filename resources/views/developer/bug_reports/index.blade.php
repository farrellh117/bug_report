@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Bug Report untuk Developer</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($bugReports->count() > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                    <th>Pelapor</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bugReports as $bugReport)
                    <tr>
                        <td>{{ $bugReport->id }}</td>
                        <td>{{ $bugReport->title }}</td>
                        <td>{{ ucfirst($bugReport->priority) }}</td>
                        <td>{{ ucfirst($bugReport->status) }}</td>
                        <td>{{ $bugReport->user->name ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('developer.bug-reports.show', $bugReport->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('developer.bug-reports.edit', $bugReport->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $bugReports->links() }} {{-- Pagination --}}
    @else
        <p>Tidak ada bug report yang ditemukan.</p>
    @endif
</div>
@endsection
