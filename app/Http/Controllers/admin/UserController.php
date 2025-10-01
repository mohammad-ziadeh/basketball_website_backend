<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();
        $showUsers = $request->get('show') === 'all';
        $allUsers = User::get();
        $now = now();

        // -------{{ Start Filters }}------- //



        if ($request->has('role') && $request->role != 'all') {
            $query->where('role', $request->role);
        }
        if ($request->has('gender') && $request->gender != 'all') {
            $query->where('gender', $request->gender);
        }



        if ($request->has('deleted')) {
            if ($request->deleted == 'only') {
                $query->onlyTrashed();
            } elseif ($request->deleted == 'with') {
                $query->withTrashed();
            }
        }

        if ($request->has('sort') && $request->sort == 'desc') {
            $query->orderBy('id', 'desc');
        } else {
            $query->orderBy('id', 'asc');
        }

        // -------{{ End Filters }}------- //

        $users = $query->paginate(10);

        return view('dashboards.admin.user.users', compact('users', 'allUsers', 'showUsers', 'now'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("dashboards.admin.user.users");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:player,parent,coach,admin',
            'gender' => 'required|in:male,female',
            'phone' => 'nullable|string|max:20',
            'school' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'password' => 'nullable|string|min:8',
        ]);

        User::create([
            'role' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password ?? '12345678'),
            'gender' => $request->gender,
            'school' => $request->school,
            'phone' => $request->phone,
            'dob' => $request->dob,
            'name' => $request->name,
        ]);

        return redirect('users')->with('success', 'User stored successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:player,parent,coach,admin',
            'gender' => 'required|in:male,female',
            'phone' => 'nullable|string|max:20',
            'school' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'password' => 'nullable|string|min:8',
        ]);

        $data = [
            'role' => $request->role,
            'email' => $request->email,
            'gender' => $request->gender,
            'school' => $request->school,
            'phone' => $request->phone,
            'dob' => $request->dob,
            'name' => $request->name,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect('users')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from stordob.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('users.index')->with('success', 'User restored successfully.');
    }

    public function deletePermanently($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();

        return redirect()->route('users.index')->with('success', 'User deleted permanently');
    }

    public function showChildren($parentId)
    {
        $parent = User::with('children')->where('role', 'parent')->findOrFail($parentId);
        $allPlayers = User::where('role', 'player')->orderBy('name')->get();

        return view('dashboards.admin.user.parent-child-assign', compact('parent', 'allPlayers'));
    }

    public function updateChildren(Request $request, $parentId)
    {
        $parent = User::where('role', 'parent')->findOrFail($parentId);

        $request->validate([
            'children' => 'array',
            'children.*' => 'exists:users,id',
        ]);

        User::where('parent_id', $parent->id)->update(['parent_id' => null]);

        if ($request->has('children')) {
            User::whereIn('id', $request->children)->update(['parent_id' => $parent->id]);
        }

        return redirect()->back()->with('success', 'Children assigned successfully.');
    }
}
