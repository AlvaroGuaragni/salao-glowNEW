<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Agendamento;

class Pagamento extends Model
{
    /** @use HasFactory<\Database\Factories\PagamentoFactory> */
    use HasFactory;

    protected $table = 'pagamentos';

    protected $fillable = [
        'agendamento_id',
        'valor',
        'metodo',
        'status',
    ];

    public function agendamento()
    {
        return $this->belongsTo(Agendamento::class);
    }
}
