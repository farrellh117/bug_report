@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Bug Report #{{ $bugReport->id }}</h1>

    <a href="{{ route('developer.bug-reports.index') }}" class="btn btn-secondary mb-3">Kembali ke daftar</a>

    <div class="card">
        <div class="card-header">
            <strong>{{ $bugReport->title }}</strong>
        </div>
        <div class="card-body">
            <p><strong>Prioritas:</strong> {{ ucfirst($bugReport->priority) }}</p>
            <p><strong>Status:</strong> {{ ucfirst($bugReport->status) }}</p>
            <p><strong>Pelapor:</strong> {{ $bugReport->user->name ?? 'N/A' }}</p>
            <p><strong>Deskripsi:</strong> <br>{!! nl2br(e($bugReport->description)) !!}</p>
            <p><strong>Tanggal dibuat:</strong> {{ $bugReport->created_at->format('d M Y H:i') }}</p>
            <p><strong>Terakhir diperbarui:</strong> {{ $bugReport->updated_at->format('d M Y H:i') }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('developer.bug-reports.edit', $bugReport->id) }}" class="btn btn-warning">Edit Bug Report</a>
        </div>
    </div>
</div>
@endsection
