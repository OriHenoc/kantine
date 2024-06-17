<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'nomComplet',
        'description',
        'numero1',
        'numero2',
        'genre',
        'entreprise',
        'image',
        'groupeDeClientID',
        'email',
        'createdBy',
        'updatedBy',
    ];

    public function groupeDeClient()
    {
        return $this->belongsTo(GroupeDeClient::class, 'groupeDeClientID');
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
