@component('mail::message')

Cher(e) {{ $user->getFullName() }},

Nous sommes heureux de vous informer que votre compte a été créé dans notre système. Vos informations de connexion sont les suivantes :

Nom d'utilisateur : {{ $user->email }}<br>
Mot de passe : {{ $password }}

Vous pouvez accéder à votre compte en utilisant les informations de connexion ci-dessus.

Si vous avez des questions ou des préoccupations concernant votre compte technicien, n'hésitez pas à nous contacter.

Nous sommes impatients de travailler avec vous et de voir les contributions que vous apporterez à notre entreprise.

Cordialement,
NewEraCom
@endcomponent
