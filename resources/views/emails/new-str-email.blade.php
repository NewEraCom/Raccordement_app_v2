@component('mail::message')

Cher Administrateur,

Je vous écris pour vous informer que nous avons créé un nouveau sous-traitant dans notre système.

Nom d'utilisateur : {{ $user->getFullname() }}<br>
Adresse email : {{ $user->email }}<br>
Mode de passe : {{ $password }}<br>

Cordialement,<br>
L'équipe de support.
@endcomponent
