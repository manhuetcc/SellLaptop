<?php

namespace App\Http\Controllers\API;

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
            ->select('id', 'name', 'email', 'created_at', 'avatar')
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
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $request->file->getClientOriginalName();
            $file->move(public_path() . '/uploads/avatar/', $filename);
        }
        $user_id = Auth::id();
        //lay duong dan file cu
        $oldfile = DB::table('users')
            ->select('avatar')
            ->where('id', $user_id)
            ->get();

        //delete file cu 
        Storage::delete(public_path() . '/uploads/avatar/', $oldfile);
        //update lai duong dan file moi
        User::findOrFail($user_id)
            ->update([
                'avatar' => $filename,
            ]);
        return $filename;
    }
}
