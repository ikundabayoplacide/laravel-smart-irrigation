<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminLoginController extends Controller
{
    public function index()
    {
        return view("admin.login");
    }

    public function admincheck(Request $request)
    {
        $credentials = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"],
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            if (in_array($user->role, ['admin', 'sedo', 'cooperative_manager', 'self_farmer'])) {
                Auth::login($user);

                // $dashboardController = new AdminDashboardController();
                // return $dashboardController->dashboard($request);
                return redirect()->route('admin.dashboard');
            }
        }

        return redirect()->back()->withErrors(['Invalid login credentials']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return view('admin.login');
    }

    public function changeLocale($locale)
    {
        if (in_array($locale, config('app.available_locales'))) {
            session(['locale' => $locale]);
            Log::info('Locale changed to: ' . $locale);
        }
        return redirect()->back();
    }
}