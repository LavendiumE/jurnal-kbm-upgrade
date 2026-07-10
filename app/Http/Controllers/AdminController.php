<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Informasi;

class AdminController extends Controller
{
    // Dashboard Admin

  
  
    public function dashboard()
    {
        $totalGuru = \App\Models\Guru::count();

        $pending = \App\Models\User::where('is_approved', false)->count();

        $recent = \App\Models\Jadwal::with(['guru', 'kelas', 'mapel'])
            ->latest()
            ->take(5)
            ->get();

        $informasis = \App\Models\Informasi::latest()->get();

        return view('admin.dashboard', compact(
            'totalGuru',
            'pending',
            'recent',
            'informasis'
        ));
    }


    // List user pending
    public function pendingUsers()
    {
        $users = User::where(function ($query) {
            $query->where('is_approved', 0)
                  ->orWhereNull('is_approved');
        })->latest()->get();

        return view('admin.pending', compact('users'));
    }

    // Approve user
    public function approve($id)
    {
        $user = User::findOrFail($id);

        $user->is_approved = 1;
        $user->save();

        return back()->with('success', 'User berhasil di-approve.');
    }

    // Hapus user yang belum di-approve
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Biar aman, hanya boleh menghapus user yang belum approve
        if ($user->is_approved) {
            return back()->with('error', 'User yang sudah di-approve tidak dapat dihapus.');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }
}