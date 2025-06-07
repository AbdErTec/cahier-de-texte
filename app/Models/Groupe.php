<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    protected $table = 'groupes';

    protected $fillable = [
        'filiere_id', // Add this to allow mass assignment
        'nom_groupe', // Include other fields you want to allow mass assignment for
    ];

 
}
