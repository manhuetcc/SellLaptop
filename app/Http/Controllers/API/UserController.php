<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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
            ->select('id', 'role_id', 'name', 'email', 'created_at', 'avatar')
            ->where('id', $id)
            ->get();
        return $profile;
    }

    public function updateDetail(Request $request)
    {
        User::findOrFail($request->id)
            ->update(
                [
                    'name' => $request->name,
                ]
            );
        return;
    }
    public function avatar()
    {
        $id = Auth::id();
        $profile = DB::table('users')
            ->select('avatar')
            ->where('id', $id)
            ->get();
        return $profile;
    }
    public function updateAvatar(Request $request)
    {
        $user_id = Auth::id();
        $oldfile = DB::table('users')->where('id', $user_id)->first();
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $request->file->getClientOriginalName();
            if ($oldfile == null) {
                File::makeDirectory(public_path() . '/uploads/avatar/' . $user_id);
            }
            $file->move(public_path() . '/uploads/avatar/' . $user_id, $filename);
        }
        //lay duong dan file cu

        //echo "$oldfile";
        //delete file cu 
        $print = $oldfile->avatar;
        if (File::exists(public_path() . '/uploads/avatar/' . $user_id . '/' . $print)) {
            File::delete(public_path() . '/uploads/avatar/' . $user_id . '/' . $print);
        }
        //update lai duong dan file moi
        User::findOrFail($user_id)
            ->update([
                'avatar' => $filename,
            ]);
        return $filename;
    }

    public function listUser()
    {
        $user = User::select('id', 'name', 'avatar')->get();
        return $user;
    }
}
