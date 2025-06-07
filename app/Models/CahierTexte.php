<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CahierTexte extends Pivot
{
    protected $table = 'cahier_textes';
    protected $fillable = [
        'user_id',
        'module_id',
        'date',
        'titre',
        'objectifs',
        'contenu',
        'devoirs',
        'fichier',
    ];
}
