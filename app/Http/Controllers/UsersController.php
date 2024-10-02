<?php


namespace App\Http\Controllers;


use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController
{
    /**
     *
     * @return \Illuminate\Contracts\Support\Renderable|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (Auth::user()->role->role !== 'manager') {
            return response()->json(['error' => 'you are not allowed to view employees']);
        }

        $users = User::where('role_id', '!=', Role::managerRole())->paginate(10);

        return response()->json($users);
    }

    public function create(Request $request)
    {
        if (Auth::user()->role->role !== 'manager') {
            return response()->json(['error' => 'you not allowed to create employees']);
        }

        $data = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $employee_role_id = Role::employeeRole();

        if ($employee_role_id > 0) {
            $role_id = $employee_role_id;
        }

        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $role_id ?? null,
        ]);

        if ($user) {
            return response()->json($user);
        }

        return response()->json(['error' => 'user was not created']);
    }

    public function destroy($id)
    {
        if (User::destroy($id)) {
            return response()->json(['message' => 'User deleted successfully.']);
        }

        return response()->json(['error' => 'User was not deleted']);
    }
}
