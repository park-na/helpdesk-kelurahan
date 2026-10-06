<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Halaman Profil
    |--------------------------------------------------------------------------
    */

    public function edit()
    {
        return view('staff.profile.edit');
    }


    /*
    |--------------------------------------------------------------------------
    | Update Data Profil
    |--------------------------------------------------------------------------
    */

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users', 'email')
                    ->ignore($user->id),
            ],
        ], [
            'name.required' =>
            'Nama wajib diisi.',

            'email.required' =>
            'Email wajib diisi.',

            'email.email' =>
            'Format email tidak valid.',

            'email.unique' =>
            'Email sudah digunakan oleh pengguna lain.',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];

        $user->save();

        return back()->with(
            'success_profile',
            'Profil berhasil diperbarui.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Ganti Password
    |--------------------------------------------------------------------------
    */

    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'password.required' =>
            'Password baru wajib diisi.',

            'password.min' =>
            'Password baru minimal 8 karakter.',

            'password.confirmed' =>
            'Konfirmasi password tidak cocok.',
        ]);

        $user = Auth::user();

        $user->password = Hash::make(
            $data['password']
        );

        $user->save();

        return back()->with(
            'success_password',
            'Password berhasil diubah.'
        );
    }
}
