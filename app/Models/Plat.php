<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plat extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle',
        'description',
        'typeDePlatsID',
        'image',
        'prix',
        'quantite',
        'statut',
        'createdBy',
        'updatedBy',
    ];

    public function typeDePlat()
    {
        return $this->belongsTo(TypeDePlat::class, 'typeDePlatID');
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
