<?php

declare(strict_types=1);

namespace App\Services\API;

use App\Mail\PasswordChanged;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthService
{
    static public function loginApi($email, $password)
    {
        if (Auth::attempt(['email' => $email, 'password' => $password], true)) {

            $user = User::with('technicien')->find(Auth::id());
            return $user;
        }
    }


    static public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    static public function sendResetPasswordEmail($email)
    {
        $status = Password::sendResetLink(['email' => $email]);

        if ($status == Password::RESET_LINK_SENT) {
            return redirect()->route('check-your-email')->with('status', __($status));
        } else {
            return redirect()->route('login')->with('error', __($status));
        }
    }

    static public function resetPassword($data)
    {
        $user = User::where('email', $data['email'])->first();
        if ($user) {
            $user->password = Hash::make($data['password']);
            $user->setRememberToken(Str::random(60));
            $user->save();
            Mail::to($data['email'])->send(new PasswordChanged($user));
            return Mail::failures() ? redirect()->back()->with('error', __('Une erreur est survenue lors de l\'envoi du mail')) : self::login($user->email, $data['password']);
        } else {
            return redirect()->back()->with('error', __('Aucun utilisateur trouvé avec cette adresse email'));
        }
    }
}
