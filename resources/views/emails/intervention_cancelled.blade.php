@component('mail::message')
# Intervention annulée

Bonjour {{ $userName }},

Nous vous informons que l'intervention prévue avec {{ $targetName }} le {{ $dateIntervention }} a été annulée.

**Motif :** {{ $reason }}

Si vous avez des questions, n'hésitez pas à nous contacter.

Merci de votre compréhension.

L'équipe Helpora
@endcomponent
