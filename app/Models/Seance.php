<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    protected $fillable = [
        'user_id', 'module_id', 'groupe_id', 'jour', 'h_debut', 'h_fin',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function module() {
        return $this->belongsTo(Module::class);
    }

    public function groupe() {
        return $this->belongsTo(groupe::class);
    }
}
