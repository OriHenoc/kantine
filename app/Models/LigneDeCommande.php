<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LigneDeCommande extends Model
{
    use HasFactory;

    protected $fillable = [
        'statut',
        'commandeID',
        'utilisateurID',
        'createdBy',
        'updatedBy',
    ];

    public function utilisateurs()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateurID');
    }

    public function commandes()
    {
        return $this->hasMany(Commande::class, 'commandeID');
    }

    public function creator()
    {
        return $this->belongsTo(Utilisateur::class, 'createdBy');
    }

    public function updater()
    {
        return $this->belongsTo(Utilisateur::class, 'updatedBy');
    }
}
