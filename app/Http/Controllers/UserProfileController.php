<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserProfileController extends Controller
{
    public function index(Request $request)
    {
        //get index method from sekolahController
        $sekolah = new sekolahController();
        $gender = $sekolah->indexgender();
        $gender = [
            'Laki Laki',
            'Perempuan',
        ];
        $kelas = [
            'X RPL 1',
            'X RPL 2',
            'X AKL 1',
            'X OTKP 1',
        ];

        $data = [
            'user' => User::where('id', auth()->user()->id)->with('profile')->first(),
            'gender' => $gender,
            'kelas' => $kelas,
        ];
        return response()->json($data);
    }

    public function updateUser(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            // 'city' => 'required',
            'gender' => 'required',
            'kelas' => 'required',
        ]);

        try {
            $user = User::find(auth()->user()->id);

            // Update user data
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->save();

            // Update or create user profile
            if (!$user->profile) {
                $profile = new UserProfile();
                $profile->user_id = $user->id;
            } else {
                $profile = $user->profile;
            }

            $profile->address = $data['address'];
            // $profile->city = $data['city'];
            $profile->gender = $data['gender'];
            $profile->kelas = $data['kelas'];
            $profile->save();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'message' => 'Profile failed to update',
                'error' => $th->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'Edit Profil Berhasil',
        ]);
    }
}
