<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteExtra extends Model
{
    /** @use HasFactory<\Database\Factories\ClienteExtraFactory> */
    use HasFactory;

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'endereco',
        'cidade',
        'estado',
        'cep',
        'observacoes',
    ];
}
