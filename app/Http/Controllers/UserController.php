<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    private const ROLES = ['superadmin', 'admin', 'viewer'];

    public function index(): View
    {
        return view('users.index', [
            'users' => User::query()->orderBy('name')->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('users.form', [
            'roles' => $this->roles(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', Rule::in(self::ROLES)],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create($validated);

        return redirect()->route('users.index')->with('mensaje', 'Usuario creado correctamente.');
    }

    public function edit(User $user): View
    {
        return view('users.form', [
            'user' => $user,
            'roles' => $this->roles(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user)],
            'role' => ['required', Rule::in(self::ROLES)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if ($this->wouldRemoveLastSuperadmin($user, $validated['role'])) {
            return back()
                ->withErrors(['role' => 'Debe existir al menos un superadmin.'])
                ->withInput();
        }

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('mensaje', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->is(auth()->user())) {
            return redirect()->route('users.index')
                ->with('error', 'No puedes eliminar tu propia cuenta mientras tienes la sesión activa.');
        }

        if ($this->wouldRemoveLastSuperadmin($user, null)) {
            return redirect()->route('users.index')
                ->with('error', 'Debe existir al menos un superadmin.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('mensaje', 'Usuario eliminado correctamente.');
    }

    /**
     * @return array<string, string>
     */
    private function roles(): array
    {
        return [
            'superadmin' => 'Superadmin',
            'admin' => 'Admin',
            'viewer' => 'Solo lectura',
        ];
    }

    private function wouldRemoveLastSuperadmin(User $user, ?string $newRole): bool
    {
        return $user->role === 'superadmin'
            && $newRole !== 'superadmin'
            && User::query()->where('role', 'superadmin')->whereKeyNot($user->getKey())->doesntExist();
    }
}
