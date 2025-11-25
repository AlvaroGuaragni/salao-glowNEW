<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Relatório de Serviços</title>
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; }

</head>
<body>
    <div class="header">
        <h1>Relatório de Serviços</h1>
        <p>Salão Glow</p>
    </div>

    <div class="info-section">
        <p><strong>Total de Serviços:</strong> {{ $servicos->count() }}</p>
    </div>

    @if($servicos->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Serviço</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Duração (min)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($servicos as $index => $servico)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $servico->nome }}</td>
                        <td>{{ Str::limit($servico->descricao ?? '-', 80) }}</td>
                        <td class="text-right">R$ {{ number_format($servico->preco, 2, ',', '.') }}</td>
                        <td class="text-right">{{ $servico->duracao }}</td>
                    
                    </tr>
                @endforeach
            </tbody>
        </table>

       
    @else
        <p style="text-align: center; padding: 20px; color: #666;">
            Nenhum serviço encontrado.
        </p>
    @endif

</body>
</html>

