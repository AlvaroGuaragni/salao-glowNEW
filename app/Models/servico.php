<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Agendamento;

class Servico extends Model
{
    /** @use HasFactory<\Database\Factories\ServicoFactory> */
    use HasFactory;

    protected $table = 'servicos';

    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'duracao',
    ];

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }
}
