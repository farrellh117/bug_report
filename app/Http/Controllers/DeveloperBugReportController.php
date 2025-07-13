<?php

namespace App\Http\Controllers;

use App\Models\BugReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeveloperBugReportController extends Controller
{
    public function __construct()
    {
        // Middleware memastikan akses hanya untuk user role 'developer'
        $this->middleware(function ($request, $next) {
            if (Auth::check() && Auth::user()->role === 'developer') {
                return $next($request);
            }
            abort(403, 'Unauthorized');
        });
    }

    // Mengecek dan mengembalikan akses bug report yang relasinya valid
    private function checkBugReportAccess(BugReport $bugReport)
    {
        if ($bugReport->reporterUser?->role !== 'bug_tester') {
            abort(403, 'Unauthorized');
        }
    }

    // Tampil daftar bug report untuk developer (hanya yg pelapor bug_tester)
    public function index()
    {
        $bugReports = BugReport::with('reporterUser')
            ->whereHas('reporterUser', function ($q) {
                $q->where('role', 'bug_tester');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('developer.bug_reports.index', compact('bugReports'));
    }

    // Tampil detail bug report dengan pengecekan akses
    public function show(BugReport $bugReport)
    {
        $this->checkBugReportAccess($bugReport);

        return view('developer.bug_reports.show', compact('bugReport'));
    }

    // Tampil form edit status dan komentar developer
    public function edit(BugReport $bugReport)
    {
        $this->checkBugReportAccess($bugReport);

        return view('developer.bug_reports.edit', compact('bugReport'));
    }

    // Update status dan komentar developer saja, validasi dengan ketat
    public function update(Request $request, BugReport $bugReport)
    {
        $this->checkBugReportAccess($bugReport);

        $validated = $request->validate([
            'status' => 'required|in:open,in_progress,closed',
            'developer_comment' => 'nullable|string|max:1000',
        ]);

        $bugReport->update([
            'status' => $validated['status'],
            'developer_comment' => $validated['developer_comment'] ?? null,
        ]);

        return redirect()->route('developer.bug-reports.index')
            ->with('success', 'Bug report updated successfully.');
    }
}
