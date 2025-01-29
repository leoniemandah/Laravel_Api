<?php

namespace App\Domain\Profile\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'image',
        'statut',
        'admin_id', // Relation avec Admin
    ];

    public function admin()
    {
        return $this->belongsTo(\App\Domain\Admin\Models\Admin::class);
    }
}
