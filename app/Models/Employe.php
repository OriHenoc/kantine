<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomComplet',
        'photo',
        'numero1',
        'numero2',
        'genre',
        'posteEmployeID',
        'email',
        'createdBy',
        'updatedBy',
    ];

    public function posteEmploye()
    {
        return $this->belongsTo(PosteEmploye::class, 'posteEmployeID');
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
