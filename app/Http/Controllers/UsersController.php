<?php


namespace App\Http\Controllers;


use App\Jobs\SendEmployeeCreatedEmailJob;
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

        $users = User::where('employer_id', Auth::id())->paginate(10);

        if ($request->is('api/*')) {
            return response()->json($users);
        }

        return view('pages.users.list', compact('users'));
    }

    public function create(Request $request)
    {
        if (Auth::user()->role->role !== 'manager') {
            return response()->json(['error' => 'you not allowed to create employees']);
        }

        if ($request->method() != "POST") {
            return view('pages.users.create');
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
            'employer_id' => Auth::id(),
        ]);

        if ($user) {
            SendEmployeeCreatedEmailJob::dispatch($user->id);
            if ($request->is('api/*')) {
                return response()->json($user);
            }
            return redirect()->route('users.index');
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
