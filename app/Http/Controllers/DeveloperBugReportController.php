<?php

namespace App\Http\Controllers;

use App\Models\BugReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeveloperBugReportController extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan hanya user dengan role 'developer' yang boleh akses
        $this->middleware(function ($request, $next) {
            if (Auth::check() && Auth::user()->role === 'developer') {
                return $next($request);
            }
            abort(403, 'Unauthorized');
        });
    }

    public function index()
    {
        // Pastikan BugReport model memiliki relasi reporterUser() yang menunjuk ke model User pelapor
        $bugReports = BugReport::with('reporterUser')
            ->whereHas('reporterUser', function ($query) {
                $query->where('role', 'bug_tester');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('developer.bug_reports.index', compact('bugReports'));
    }

    public function show(BugReport $bugReport)
    {
        // Cek memastikan hanya bug report dari reporter berrole bug_tester yang bisa diakses developer
        if ($bugReport->reporterUser?->role !== 'bug_tester') {
            abort(403, 'Unauthorized');
        }

        return view('developer.bug_reports.show', compact('bugReport'));
    }

    public function edit(BugReport $bugReport)
    {
        if ($bugReport->reporterUser?->role !== 'bug_tester') {
            abort(403, 'Unauthorized');
        }

        return view('developer.bug_reports.edit', compact('bugReport'));
    }

    public function update(Request $request, BugReport $bugReport)
    {
        if ($bugReport->reporterUser?->role !== 'bug_tester') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'status' => 'required|in:open,in_progress,closed',
            'developer_comment' => 'nullable|string',
        ]);

        // Menggunakan mass assignment dengan fill dan save agar lebih rapi
        $bugReport->fill([
            'status' => $validated['status'],
            'developer_comment' => $validated['developer_comment'] ?? null,
        ])->save();

        return redirect()->route('developer.bug-reports.index')
            ->with('success', 'Bug report updated successfully.');
    }
}
