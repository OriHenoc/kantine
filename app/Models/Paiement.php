<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'statut',
        'montantAPayer',
        'montantPaye',
        'montantRestant',
        'commentaire',
        'ticketID',
        'createdBy',
        'updatedBy',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'ticketID');
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
