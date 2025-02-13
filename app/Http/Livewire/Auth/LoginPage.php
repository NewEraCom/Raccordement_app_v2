<?php

declare(strict_types=1);

namespace App\Http\Livewire\Auth;

use App\Models\User;
use App\Services\web\LoginService;
use Livewire\Component;

class LoginPage extends Component
{

    public $email, $password;

    public function login()
{
    $this->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Attempt to log in
    $user = User::where('email', $this->email)->first();

    if (!$user) {
        $this->addError('error', 'Erreur ! L\'adresse e-mail ou le mot de passe est incorrect.');
        return;
    }

    // Check if the account is deactivated (status = 0)
    if ($user->status == 0) {
        $this->addError('error', 'Votre compte est désactivé. Veuillez contacter le support IT pour plus d\'assistance.');
        return;
    }


    // Call the LoginService to handle redirection
    LoginService::login($this->email, $this->password);
}

    
    public function render()
    {
        return view('livewire.auth.login-page')->layout('layouts.auth', [
            'title' => 'Login',
        ]);
    }
}
