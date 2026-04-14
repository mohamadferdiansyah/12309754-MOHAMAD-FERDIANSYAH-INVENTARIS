<?php

namespace App\Http\Controllers;

use App\Exports\AdminAccountsExport;
use App\Exports\OperatorAccountsExport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function adminsIndex()
    {
        $users = User::query()
            ->where('role', 'admin')
            ->orderBy('id', 'asc')
            ->get();

        return view('users.admin', compact('users'));
    }

    public function operatorsIndex()
    {
        $users = User::query()
            ->where('role', 'staff')
            ->orderBy('id', 'asc')
            ->get();

        return view('users.operator', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:150'],
                'email' => ['required', 'email', 'max:150', 'unique:users,email'],
                'role' => ['required', 'in:admin,staff'],
            ],
            [
                'name.required' => 'The name field is required.',
                'email.required' => 'The email field is required.',
                'email.email' => 'The email must be a valid email address.',
                'email.unique' => 'The email has already been taken.',
                'role.required' => 'The role selection is required.',
                'role.in' => 'Role must be admin or operator.',
            ]
        );

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],

            'password' => Hash::make('temp-password'),
        ]);

        $prefix = substr($validated['email'], 0, 4);
        $plainPassword = $prefix . $user->id;

        $user->password = Hash::make($plainPassword);
        $user->save();

        $redirectRoute = $user->role === 'admin'
            ? 'users.admin'
            : 'users.operator';

        return redirect()
            ->route($redirectRoute)
            ->with('success', "Account created successfully. Password: {$plainPassword}");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:150'],
                'email' => ['required', 'email', 'max:150', 'unique:users,email,' . $user->id],
                'new_password' => ['nullable', 'string', 'min:8'],
            ],
            [
                'name.required' => 'The name field is required.',
                'email.required' => 'The email field is required.',
                'email.email' => 'The email must be a valid email address.',
                'email.unique' => 'The email has already been taken.',
                'new_password.min' => 'The new password must be at least 8 characters.',
            ]
        );

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['new_password'])) {
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        if ($user->role === 'admin') {
            return redirect()
                ->route('users.admin')
                ->with('success', 'Account updated successfully.');
        }

        return redirect()
            ->route('users.edit', $user->id)
            ->with('success', 'Account updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (Auth::id() === $user->id) {
            return back()->with('error', 'Tidak dapat menghapus akun yang sedang dipakai.');
        }

        $user->delete();

        return redirect()
            ->route('users.admin')
            ->with('success', 'Account deleted successfully.');
    }

    public function exportAdminsExcel()
    {
        return Excel::download(new AdminAccountsExport, 'admin-accounts.xlsx');
    }

    public function exportOperatorsExcel()
    {
        return Excel::download(new OperatorAccountsExport, 'operator-accounts.xlsx');
    }

    public function resetPassword(User $user)
    {
        if (Auth::id() === $user->id) {
            return back()->with('error', 'You cannot reset password for the currently logged-in account.');
        }

        $plainPassword = substr($user->email, 0, 4) . $user->id;

        $user->password = Hash::make($plainPassword);
        $user->save();

        return back()->with('success', "Password reset successfully. New password: {$plainPassword}");
    }
}
