<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Agendamento;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nome',
        'cpf',
        'email',
        'telefone',
        'foto_path',
    ];

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
