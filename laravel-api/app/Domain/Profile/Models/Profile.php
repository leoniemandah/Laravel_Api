<?php

namespace App\Domain\Profile\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    use HasFactory;

    protected $fillable = [
        'lastName',
        'firstName',
        'image',
        'status'
    ];
}
