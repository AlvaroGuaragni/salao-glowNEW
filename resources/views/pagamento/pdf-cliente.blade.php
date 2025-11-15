<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Relatório de Pagamentos</title>

</head>
<body>
    <div class="header">
        <h1>Relatório de Pagamentos</h1>
        <p>Salão Glow</p>
        <p>Gerado em: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="info-section">
        <p><strong>Cliente:</strong> {{ $cliente->nome ?? 'N/A' }}</p>
        <p><strong>Total de Registros:</strong> {{ $pagamentos->count() }}</p>
    </div>

    @if($pagamentos->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Agendamento</th>
                    <th>Serviço</th>
                    <th>Valor</th>
                    <th>Método</th>
                    <th>Status</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pagamentos as $index => $pagamento)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>#{{ $pagamento->agendamento_id }}</td>
                        <td>{{ $pagamento->agendamento->servico->nome ?? '-' }}</td>
                        <td class="text-right">R$ {{ number_format($pagamento->valor, 2, ',', '.') }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $pagamento->metodo)) }}</td>
                        <td>
                            @if($pagamento->status == 'pago')
                                <span class="badge badge-success">{{ ucfirst($pagamento->status) }}</span>
                            @elseif($pagamento->status == 'pendente')
                                <span class="badge badge-warning">{{ ucfirst($pagamento->status) }}</span>
                            @elseif($pagamento->status == 'cancelado')
                                <span class="badge badge-danger">{{ ucfirst($pagamento->status) }}</span>
                            @elseif($pagamento->status == 'reembolsado')
                                <span class="badge badge-secondary">{{ ucfirst($pagamento->status) }}</span>
                            @else
                                <span class="badge">{{ ucfirst($pagamento->status) }}</span>
                            @endif
                        </td>
                        <td>{{ $pagamento->created_at ? \Carbon\Carbon::parse($pagamento->created_at)->format('d/m/Y') : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <h3>Resumo Financeiro</h3>
            <p><strong>Total Geral:</strong> R$ {{ number_format($totalGeral, 2, ',', '.') }}</p>

        </div>
    @else
        <p style="text-align: center; padding: 20px; color: #666;">
            Nenhum pagamento registrado.
        </p>
    @endif

</body>
</html>

