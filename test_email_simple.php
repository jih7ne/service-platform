<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;

try {
    Mail::raw('Test email from Helpora - ' . date('Y-m-d H:i:s'), function($message) {
        $message->to('raissouni.aya@etu.uae.ac.ma')
                ->subject('Test Email - Helpora Feedback System');
    });
    
    echo "Email de test envoyé avec succès à raissouni.aya@etu.uae.ac.ma !\n";
} catch (Exception $e) {
    echo "Erreur lors de l'envoi de l'email: " . $e->getMessage() . "\n";
}
