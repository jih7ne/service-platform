<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailVerification extends Model
{
    protected $fillable = [
        'email',
        'code',
        'expires_at',
        'verified'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified' => 'boolean'
    ];

    /**
     * Génère un code de vérification à 10 chiffres
     */
    public static function generateCode()
    {
        return str_pad(random_int(0, 9999999999), 10, '0', STR_PAD_LEFT);
    }

    /**
     * Crée une nouvelle vérification email
     */
    public static function createForEmail($email)
    {
        // Supprimer les anciennes vérifications pour cet email
        self::where('email', $email)->delete();
        
        return self::create([
            'email' => $email,
            'code' => self::generateCode(),
            'expires_at' => now()->addMinutes(30), // Expire dans 30 minutes
            'verified' => false
        ]);
    }

    /**
     * Vérifie si le code est valide
     */
    public static function verifyCode($email, $code)
    {
        $verification = self::where('email', $email)
            ->where('code', $code)
            ->where('expires_at', '>', now())
            ->where('verified', false)
            ->first();
            
        if ($verification) {
            $verification->verified = true;
            $verification->save();
            return true;
        }
        
        return false;
    }
}
