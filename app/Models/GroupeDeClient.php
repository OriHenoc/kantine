<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupeDeClient extends Model
{
    use HasFactory;

    protected $fillable = [
            'code',
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
