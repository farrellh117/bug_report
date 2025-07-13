<?php

namespace App\Http\Controllers;

use App\Models\BugReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BugReportController extends Controller
{
    public function showRegistrationForm()
    {
        return view('bug_reports.register'); // Pastikan view ini ada di resources/views/bug_reports/register.blade.php
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        Auth::login($user);

        return redirect()->route('bug_tester.bug-reports.index');
    }

    public function showLoginForm()
    {
        return view('bug_reports.auth'); // Pastikan view auth.blade.php di folder bug_reports
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('bug_tester.bug-reports.index'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'developer') {
            $bugReports = BugReport::whereHas('reporterUser', function ($query) {
                $query->where('role', 'bug_tester');
            })->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $bugReports = BugReport::where('reporter_id', $user->id)->orderBy('created_at', 'desc')->paginate(10);
        }

        return view('bug_reports.index', compact('bugReports'));
    }

    public function create()
    {
        $this->authorizeRole('bug_tester');
        return view('bug_reports.create');
    }

    public function store(Request $request)
    {
        $this->authorizeRole('bug_tester');

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required|in:open,in_progress,closed',
            'priority' => 'required|in:low,medium,high',
            //'reporter' => 'required|max:100', // Tidak perlu input manual
        ]);

        // Tambahkan pengisian kolom reporter dan reporter_id supaya tidak error
        $validatedData['reporter'] = Auth::user()->name;
        $validatedData['reporter_id'] = Auth::id();

        BugReport::create($validatedData);

        return redirect()->route('bug_tester.bug-reports.index')->with('success', 'Bug report created successfully.');
    }

    public function show(BugReport $bugReport)
    {
        $this->authorizeAccess($bugReport);

        return view('bug_reports.show', compact('bugReport'));
    }

    public function edit(BugReport $bugReport)
    {
        $this->authorizeAccess($bugReport);

        return view('bug_reports.edit', compact('bugReport'));
    }

    public function update(Request $request, BugReport $bugReport)
    {
        $this->authorizeAccess($bugReport);

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required|in:open,in_progress,closed',
            'priority' => 'required|in:low,medium,high',
            //'reporter' => 'required|max:100', // Tidak perlu input manual
        ]);

        $bugReport->update($validatedData);

        return redirect()->route('bug_tester.bug-reports.index')->with('success', 'Bug report updated successfully.');
    }

    public function destroy(BugReport $bugReport)
    {
        $this->authorizeAccess($bugReport);

        $bugReport->delete();

        return redirect()->route('bug_tester.bug-reports.index')->with('success', 'Bug report deleted successfully.');
    }

    private function authorizeRole($role)
    {
        $user = Auth::user();
        if (!$user || $user->role !== $role) {
            abort(403, 'Akses ditolak');
        }
    }

    private function authorizeAccess(BugReport $bugReport)
    {
        $user = Auth::user();

        if ($user->role === 'bug_tester' && $bugReport->reporter_id !== $user->id) {
            abort(403, 'Akses ditolak');
        }

        if ($user->role === 'developer' && $bugReport->reporterUser->role !== 'bug_tester') {
            abort(403, 'Akses ditolak');
        }
    }
}
