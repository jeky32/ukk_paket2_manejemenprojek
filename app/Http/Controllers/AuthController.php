<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // ==========================================================
    // 🔹 LOGIN
    // ==========================================================
    public function showLogin()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
    $request->validate([
        'email' => 'required|string',
        'password' => 'required|string',
    ]);

    // ✅ FIX: Gunakan $request->email bukan $request->login
    $loginField = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    $user = User::where($loginField, $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'Email tidak ditemukan.'])->withInput();
    }

    // 🔐 Cek password
    if (!Hash::check($request->password, $user->password)) {
        // Auto-hash untuk password plaintext (jika ada)
        if ($user->password === $request->password) {
            $user->password = Hash::make($request->password);
            $user->save();
        } else {
            return back()->withErrors(['password' => 'Password salah.'])->withInput();
        }
    }

    // ✅ Login berhasil
    Auth::login($user);
    $request->session()->regenerate();

    session([
        'user_id'   => $user->id,
        'role'      => $user->role,
        'username'  => $user->username,
        'full_name' => $user->full_name ?? $user->username,
    ]);

    return $this->redirectByRole($user);
    }
    // ==========================================================
    // 🔹 REGISTER
    // ==========================================================
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email|max:255|unique:users,email',
            'password'  => 'required|string|min:6|confirmed',
        ]);

        // 🔹 Buat username unik otomatis
        $baseUsername = Str::slug($request->full_name);
        $username = $baseUsername ?: 'user';
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter++;
        }

        // 🔹 Tentukan role otomatis:
        // 1 = admin, 2 = teamlead, 3+ = developer
        $userCount = User::count();
        if ($userCount === 0) {
            $role = 'admin';
        } elseif ($userCount === 1) {
            $role = 'teamlead';
        } else {
            $role = 'developer';
        }

        // 🔹 Simpan user ke database
        $user = User::create([
            'username'  => $username,
            'full_name' => $request->full_name,
            'email'     => $request->email,
            'password'  => $request->password, // auto hash di model User
            'role'      => $role,
        ]);

        // 🔹 Login otomatis setelah register
        Auth::login($user);

        // 🔹 Redirect sesuai role
        return $this->redirectByRole($user, true);
    }

    // ==========================================================
    // 🔹 LOGOUT
    // ==========================================================
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil logout!');
    }

    // ==========================================================
    // 🔹 Fungsi bantu: Redirect berdasarkan role
    // ==========================================================
    private function redirectByRole($user, $isRegister = false)
    {
        $message = $isRegister
            ? "Akun {$user->role} berhasil dibuat! Selamat datang, {$user->full_name}."
            : "Selamat datang kembali, {$user->full_name}!";

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard')->with('success', $message);
            case 'teamlead':
                return redirect()->route('teamlead.dashboard')->with('success', $message);
            case 'developer':
                return redirect()->route('developer.dashboard')->with('success', $message);
            case 'designer':
                return redirect()->route('designer.dashboard')->with('success', $message);
            default:
                return redirect()->route('dashboard')->with('success', $message);
        }
    }
}
