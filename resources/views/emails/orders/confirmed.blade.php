@component('mail::message')
# Merci pour votre commande !

Bonjour {{ $commande->nom_complet }},

Nous avons bien reçu votre commande n° **{{ $commande->id }}**. Elle est actuellement en cours de traitement.

**Détails de la commande :**
* **Total :** {{ $commande->total }} DH
* **Téléphone :** {{ $commande->telephone }}
* **Adresse :** {{ $commande->adresse }}

@component('mail::button', ['url' => config('app.url')])
Voir ma commande
@endcomponent

Merci de votre confiance,<br>
L'équipe {{ config('app.name') }}
@endcomponent