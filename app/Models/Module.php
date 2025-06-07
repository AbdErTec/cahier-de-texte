<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'filiere_id', // Add this to allow mass assignment
        'nom_module', // Include other fields you want to allow mass assignment for
    ];

    public function enseigne_par() {
        return $this->belongsToMany(User::class, 'cahierTexte')->withPivot('date', 'titre', 'objectifs', 'contenu', 'devois')->withTimestamps();
    }

    public function appartient() {
        return $this->belongsTo(Filiere::class);
    }

    public function seances(){
        return $this->hasMany(Seance::class);
    }
}
