<?php

declare(strict_types=1);

namespace App\Services\web;

use App\Mail\PasswordChanged;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class LoginService
{
    static public function login($email, $password)
    {
        if (Auth::attempt(['email' => $email, 'password' => $password], true)) {
            switch (Auth::user()->roles->first()->name) {
                case 'admin':
                    Auth::user()->update(['is_online' => true]);
                    return redirect()->route('admin.dashboard');
                    break;
                case 'superadmin':
                    // TODO return redirect()->route('supervisor.dashboard');
                    break;
                case 'supervisor':
                    Auth::user()->update(['is_online' => true]);
                    return redirect()->route('supervisor.dashboard');
                    break;
                case 'soustraitant':
                    Auth::user()->update(['is_online' => true]);
                    return redirect()->route('soustraitant.dashboard');
                    break;
                case 'controller':
                    Auth::user()->update(['is_online' => true]);
                    return redirect()->route('controller.dashboard');
                    break;
                case 'sales':
                    Auth::user()->update(['is_online' => true]);
                    return redirect()->route('sales.dashboard');
                    break;
                case 'sav':
                    Auth::user()->update(['is_online' => true]);
                    return redirect()->route('sav.dashboard');
                    break;
                case 'technicien':
                    Auth::logout();
                    abort(401, 'Unauthorized action.');
                    break;
                default:
                    return redirect()->route('login');
                    break;
            }
        }
    }

    static public function redirectToHomePage($role)
    {
        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
                break;
            case 'sav':
                return redirect()->route('sav.dashboard');
                break;
            case 'superadmin':
                // TODO return redirect()->route('supervisor.dashboard');
                break;
            case 'supervisor':
                return redirect()->route('supervisor.dashboard');
                break;
            case 'soustraitant':
                return redirect()->route('soustraitant.dashboard');
                break;
            case 'controller':
                return redirect()->route('controller.dashboard');
                break;
            case 'storekeeper':
                return redirect()->route('storekeeper.dashboard');
                break;
            case 'sales':
                return redirect()->route('supervisor.dashboard');
                break;
            case 'technicien':
                Auth::logout();
                abort(401, 'Unauthorized action.');
                break;
            default:
                return redirect()->route('login');
                break;
        }
    }

    static public function logout()
    {
        Auth::user()->update(['is_online' => false]);
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
