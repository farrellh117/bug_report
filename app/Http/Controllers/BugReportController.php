<?php

namespace App\Http\Controllers;

use App\Models\BugReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BugReportController extends Controller
{
    public function showRegistrationForm() {
        return view('bug_reports.register');
    }

    public function register(Request $request) {
        // Validasi input registrasi
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Buat user baru dengan password yang sudah di-hash
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // Login otomatis setelah registrasi sukses
        Auth::login($user);

        // Redirect ke halaman index bug reports
        return redirect()->route('bug-reports.index');
    }

    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('bug_reports.auth');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input login
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba autentikasi user
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Redirect ke halaman bug report index setelah login sukses
            return redirect()->intended(route('bug-reports.index'));
        }

        // Jika gagal, kembali ke form login dengan error
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Method lain yang sudah ada di BugReportController
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
