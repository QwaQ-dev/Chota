<?php

namespace App\Http\Controllers;

use App\Models\RolesUsers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeamController extends Controller
{
    public function index()
    {
        if (request()->user()->isWorker() || request()->user()->isAdmin()) {
            $usersList = [
                RolesUsers::where('role_id', 3)->get(),
                RolesUsers::where('role_id', 2)->get(),
                RolesUsers::where('role_id', 1)->get()
            ];

            return view("team", compact("usersList"));
        } else {
            return abort(404);
        }
    }

    public function createNewUser()
    {
        if (request()->user()->isAdmin()) {
            return view("createNewUser");
        } else {
            return abort(404);
        }
    }

    public function store()
    {
        if (request()->user()->isAdmin()) {
            request()->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
                'role_id' => ['required'],
                'password' => ['required', 'confirmed'],
            ]);

            $user = User::create([
                'name' => request()->name,
                'email' => request()->email,
                'password' => Hash::make(request()->password),
            ]);

            RolesUsers::create([
                'user_id' => $user->id,
                'role_id' => request()->role_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return back()->with('status', 'user-added');
        } else {
            return abort(404);
        }
    }

    public function update(User $user)
    {
        if (request()->user()->isAdmin()) {
            request()->validate([
                'name' => ['required', 'string', 'max:255']
            ]);

            $user->update(['name' => request()->name]);

            $delete = RolesUsers::where('user_id', $user["id"])->delete();

            if (request()["is_admin"] === "on") {
                RolesUsers::create([
                    'user_id' => $user["id"],
                    'role_id' => 3,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            if (request()["is_worker"] === "on") {
                RolesUsers::create([
                    'user_id' => $user["id"],
                    'role_id' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            if (request()["is_user"] === "on") {
                RolesUsers::create([
                    'user_id' => $user["id"],
                    'role_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return back()->with('status', 'user-updated');
        } else {
            return abort(404);
        }
    }
}
