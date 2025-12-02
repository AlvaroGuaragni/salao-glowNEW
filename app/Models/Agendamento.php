<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;
use App\Models\Servico;
use App\Models\Pagamento;

class Agendamento extends Model
{
    /** @use HasFactory<\Database\Factories\AgendamentoFactory> */
    use HasFactory;

    protected $table = 'agendamentos';
    
    protected $fillable = [
        'cliente_id',
        'data_hora',
        'status',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function servicos()
    {
        return $this->belongsToMany(Servico::class, 'agendamento_servico');
    }

    public function pagamento()
    {
        return $this->hasOne(Pagamento::class);
    }
}
