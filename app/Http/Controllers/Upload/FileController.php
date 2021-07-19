<?php

namespace App\Http\Controllers\Upload;

use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,csv,txt,xlx,xls,pdf|max:2048'
        ]);
        if ($request->hasfile('imageFile')) {
            $file = $request->file('imageFile');
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
