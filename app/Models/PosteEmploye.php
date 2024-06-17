<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosteEmploye extends Model
{
    use HasFactory;
    protected $fillable = [
        'libelle',
        'description',
        'createdBy',
        'updatedBy',
    ];

    public function creator()
    {
        return $this->belongsTo(Utilisateur::class, 'createdBy');
    }

    public function updater()
    {
        return $this->belongsTo(Utilisateur::class, 'updatedBy');
    }
}
