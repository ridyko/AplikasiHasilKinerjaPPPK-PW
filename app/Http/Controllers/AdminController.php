<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WorkReport;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        if (strtoupper(auth()->user()->role) !== 'ADMIN') {
            return redirect()->route('dashboard.jabatan', ['role' => strtolower(auth()->user()->role)]);
        }
        
        $totalUsers = User::count();
        $totalReports = WorkReport::count();
        
        $reportsPerRole = WorkReport::selectRaw('role, count(*) as total')
            ->groupBy('role')
            ->get();

        $users = User::all();
        
        return view('admin.dashboard', compact('totalUsers', 'totalReports', 'reportsPerRole', 'users'));
    }

    public function manageUsers()
    {
        if (strtoupper(auth()->user()->role) !== 'ADMIN') {
            return redirect()->route('dashboard.jabatan', ['role' => strtolower(auth()->user()->role)]);
        }
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => strtoupper($request->role)
        ]);

        return back()->with('success', 'User created successfully!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Cannot delete yourself!');
        }
        $user->delete();
        return back()->with('success', 'User deleted successfully!');
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        $user->password = bcrypt('password');
        $user->save();

        return back()->with('success', "Password untuk {$user->name} berhasil di-reset menjadi 'password'");
    }

    public function allReports()
    {
        if (strtoupper(auth()->user()->role) !== 'ADMIN') {
            return redirect()->route('dashboard.jabatan', ['role' => strtolower(auth()->user()->role)]);
        }
        $reports = WorkReport::latest()->get();
        return view('admin.reports', compact('reports'));
    }

    public function deleteReport($id)
    {
        WorkReport::findOrFail($id)->delete();
        return back()->with('success', 'Report deleted successfully!');
    }

    public function settings()
    {
        if (strtoupper(auth()->user()->role) !== 'ADMIN') {
            return redirect()->route('dashboard.jabatan', ['role' => strtolower(auth()->user()->role)]);
        }
        $setting = Setting::first();
        return view('admin.settings', compact('setting'));
    }

    public function updateSettings(Request $request)
    {
        $setting = Setting::first();
        $data = $request->only(['app_name', 'school_name', 'primary_color', 'secondary_color', 'hero_badge', 'hero_title', 'hero_description']);

        if ($request->hasFile('logo')) {
            if ($setting->logo) {
                Storage::disk('public')->delete($setting->logo);
            }
            $data['logo'] = $request->file('logo')->store('branding', 'public');
        }

        if ($request->hasFile('hero_image')) {
            if ($setting->hero_image) {
                Storage::disk('public')->delete('hero/' . $setting->hero_image);
            }
            $file = $request->file('hero_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('hero', $filename, 'public');
            $data['hero_image'] = $filename;
        }

        $setting->update($data);
        return back()->with('success', 'Branding updated successfully!');
    }

    public function showChangePassword()
    {
        return view('auth.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama Anda salah.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui!');
    }
}
