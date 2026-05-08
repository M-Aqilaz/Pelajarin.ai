<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(): View
    {
        $users = User::latest()->paginate(10);

        return view('pages.admin.users.index', compact('users'));
    }

    public function suspend(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa men-suspend akun sendiri.');
        }

        $user->update(['is_active' => false]);

        return back()->with('success', 'User berhasil disuspend.');
    }

    public function activate(User $user): RedirectResponse
    {
        $user->update(['is_active' => true]);

        return back()->with('success', 'User berhasil diaktifkan.');
    }

    public function updatePlan(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'plan' => ['required', 'in:free,premium'],
        ]);

        $plan = $validated['plan'];

        $user->update([
            'plan' => $plan,
            'room_limit' => $plan === 'premium' ? 9999 : 2,
            'match_credits' => $plan === 'premium' ? max((int) $user->match_credits, 9999) : 3,
        ]);

        return back()->with('success', 'Plan user berhasil diperbarui ke ' . ($plan === 'premium' ? 'Paid' : 'Freemium') . '.');
    }
}
