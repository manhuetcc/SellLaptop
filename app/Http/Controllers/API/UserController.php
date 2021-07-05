<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;

class UserController extends Controller
{
    // Auth's information 
    public function show()
    {
        $id = Auth::id();
        $profile = DB::table('users')
            ->select('name', 'email', 'created_at')
            ->where('id', $id)
            ->get();
        return $profile;
    }
    public function updateAvatar(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $request->file->getClientOriginalName();
            $file->move(public_path() . '/uploads/avatar/', $filename);
        }
        $user_id = Auth::id();
        User::findOrFail($user_id)
            ->update([
                'avatar' => $filename,
            ]);
        return $filename;
    }
}
