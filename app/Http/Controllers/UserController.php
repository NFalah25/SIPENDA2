<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Page.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Page.user.create'); // Return the view for creating a user
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8|same:password',
            'nomor_pegawai' => 'required|string|max:255',
            'level' => 'required|string|in:admin,user',
        ]);
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nomor_pegawai' => $validated['nomor_pegawai'],
            'role' => $validated['level'],
            'password' => Hash::make($validated['password']),
        ]);
        return redirect()->route('user.index')->with('success', 'User berhasil diubah');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('Page.user.edit', compact('user')); // Return the view for editing a user
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        $user = User::find($id);
        $validated = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'nomor_pegawai' => 'required|string|max:255',
            'level' => 'required|string|in:admin,user',
            'password' => 'nullable|string|min:8|confirmed',
            'password_confirmation' => 'nullable|string|min:8|same:password',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nomor_pegawai' => $validated['nomor_pegawai'],
            'role' => $validated['level'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('user.index')->with('error', 'User not found.');
        }
        if ($user->id === Auth::id()) {
            return redirect()->route('user.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User Berhasil dihapus');
    }

    public function getUser(Request $request)
    {
        $users = User::select('id', 'name', 'email', 'nomor_pegawai', 'role')->get();
        $users = $users->map(function ($user) {
            $user->role = ucwords($user->role); // ucwords bikin huruf depan kapital
            return $user;
        });
        return datatables()->of($users)
            ->addIndexColumn()
            ->addColumn('role', function ($user) {
                $role = ucfirst($user->role);
                $badgeClass = '';

                switch (strtolower($user->role)) {
                    case 'admin':
                        $badgeClass = 'badge badge-primary';
                        break;
                    case 'user':
                        $badgeClass = 'badge badge-secondary';
                        break;
                    default:
                        $badgeClass = 'badge badge-light';
                }
                return '<span class="' . $badgeClass . '">' . $role . '</span>';
            })
            ->addColumn('aksi', function ($user) {
                $edit = '<a href="' . route('user.edit', $user->id) . '" class="btn btn-warning btn-sm">Edit</a>';
                $delete = '<form action="' . route('user.destroy', $user->id) . '" method="POST" style="display:inline;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>';
                return $edit . ' ' . $delete;
            })
            ->rawColumns(['aksi', 'role'])
            ->make(true);
    }

    public function profile()
    {
        $user = Auth::user();
        return view('Page.user.profile', compact('user'));
    }
}
