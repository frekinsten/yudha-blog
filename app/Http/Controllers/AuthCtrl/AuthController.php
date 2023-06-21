<?php

namespace App\Http\Controllers\AuthCtrl;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\{Request, Response};
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\{Auth, Hash, Notification};
use App\Notifications\NewUserNotification;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        if (request()->ajax()) {
            $credential = [
                'email'     => $request['email'],
                'password'  => $request['password'],
            ];

            if (Auth::attempt($credential)) {
                if (auth()->user()->is_active) {
                    $request->session()->regenerate();
                    return response()->noContent();
                }

                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return response()->json(
                    ['error' => 'Gagal Login.'],
                    Response::HTTP_UNAUTHORIZED
                );
            }

            return response()->json(
                ['error' => 'Gagal Login.'],
                Response::HTTP_UNAUTHORIZED
            );
        }
    }

    public function register(AuthRequest $request)
    {
        if (request()->ajax()) {
            $user = User::create([
                'name'      => Str::title($request['name']),
                'username'  => preg_replace("/\s*/m", "", strtolower($request['name'])),
                'email'     => $request['email'],
                'password'  => Hash::make($request['password'])
            ]);
            $user->assignRole('Writer');

            $admins = User::role('Admin')->get();
            Notification::send($admins, new NewUserNotification($user));

            return response()->noContent();
        }
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->to('/');
    }
}
