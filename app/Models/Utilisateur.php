<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'nomComplet',
        'photo',
        'solde',
        'numero1',
        'numero2',
        'genre',
        'profession',
        'email',
        'motDePasse',
        'roleID',
        'commentaire',
        'createdBy',
        'updatedBy',
    ];

    protected $hidden = [
        'motDePasse',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'roleID');
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
