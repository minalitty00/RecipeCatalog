<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount('recipes', 'comments')
            ->latest()
            ->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }
    
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }
    
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
        ]);
        
        $user->update($validated);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Пользователь обновлён');
    }
    
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Вы не можете удалить себя');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Пользователь удалён');
    }
}
