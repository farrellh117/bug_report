<?php

namespace App\Http\Controllers;

use App\Models\BugReport;
use Illuminate\Http\Request;

class BugReportController extends Controller
{
    public function index()
    {
        $bugReports = BugReport::orderBy('created_at', 'desc')->paginate(10);
        return view('bug_reports.index', compact('bugReports'));
    }

    public function create()
    {
        return view('bug_reports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required|in:open,in_progress,closed',
            'priority' => 'required|in:low,medium,high',
            'reporter' => 'required|max:100',
        ]);

        BugReport::create($request->all());

        return redirect()->route('bug-reports.index')->with('success', 'Bug report created successfully.');
    }

    public function show(BugReport $bugReport)
    {
        return view('bug_reports.show', compact('bugReport'));
    }

    public function edit(BugReport $bugReport)
    {
        return view('bug_reports.edit', compact('bugReport'));
    }

    public function update(Request $request, BugReport $bugReport)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required|in:open,in_progress,closed',
            'priority' => 'required|in:low,medium,high',
            'reporter' => 'required|max:100',
        ]);

        $bugReport->update($request->all());

        return redirect()->route('bug-reports.index')->with('success', 'Bug report updated successfully.');
    }

    public function destroy(BugReport $bugReport)
    {
        $bugReport->delete();

        return redirect()->route('bug-reports.index')->with('success', 'Bug report deleted successfully.');
    }
}
