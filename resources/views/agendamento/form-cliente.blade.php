@extends('layouts.base')

@section('title', isset($agendamento) ? 'Editar Agendamento' : 'Novo Agendamento')

@section('content')
    <h1 class="mb-3">{{ isset($agendamento) ? 'Editar Agendamento' : 'Novo Agendamento' }}</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ isset($agendamento) ? route('agendamentos.updateForClient', $agendamento) : route('agendamentos.store') }}" method="POST">
                @csrf
                @if(isset($agendamento))
                    @method('PUT')
                @endif
                
                <div class="mb-3">
                    <label for="servico_ids" class="form-label">Quais serviços você deseja? * (selecione um ou mais)</label>
                    <select id="servico_ids" name="servico_ids[]" class="form-select @error('servico_ids') is-invalid @enderror" multiple required>
                        @foreach($servicos as $servico)
                            <option value="{{ $servico->id }}" 
                                @if(isset($agendamento) && $agendamento->servicos->contains($servico->id))
                                    selected
                                @elseif(is_array(old('servico_ids')) && in_array($servico->id, old('servico_ids')))
                                    selected
                                @endif
                            >
                                {{ $servico->nome }} - R$ {{ number_format($servico->preco, 2, ',', '.') }} ({{ $servico->duracao }} min)
                            </option>
                        @endforeach
                    </select>
                    @error('servico_ids')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Use Ctrl+Click (ou Cmd+Click no Mac) para selecionar múltiplos serviços</small>
                </div>

                <div class="mb-3">
                    <div class="alert alert-info" id="servicos-selecionados" style="display: none;">
                        <strong>Serviços selecionados:</strong>
                        <div id="lista-servicos"></div>
                        <strong>Duração total: <span id="duracao-total">0</span> min</strong>
                        <div class="mt-2"><strong>Preço total: R$ <span id="preco-total">0,00</span></strong></div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="data_hora" class="form-label">Qual a data e hora? *</label>
                    <input 
                        type="datetime-local" 
                        id="data_hora" 
                        name="data_hora" 
                        class="form-control @error('data_hora') is-invalid @enderror" 
                        value="{{ old('data_hora', isset($agendamento) && $agendamento->data_hora ? \Carbon\Carbon::parse($agendamento->data_hora)->format('Y-m-d\TH:i') : null) }}" 
                        required
                    >
                    @error('data_hora')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        {{ isset($agendamento) ? 'Salvar Alterações' : 'Confirmar Agendamento' }}
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Voltar</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectServicos = document.getElementById('servico_ids');
            const servicosSelecionados = document.getElementById('servicos-selecionados');
            const listaServicos = document.getElementById('lista-servicos');
            const duracaoTotal = document.getElementById('duracao-total');
            const precoTotal = document.getElementById('preco-total');

            function atualizarResumo() {
                const opcoesSelecionadas = Array.from(selectServicos.selectedOptions);
                
                if (opcoesSelecionadas.length === 0) {
                    servicosSelecionados.style.display = 'none';
                    return;
                }

                servicosSelecionados.style.display = 'block';
                
                let totalDuracao = 0;
                let totalPreco = 0;
                let html = '<ul class="mb-2">';

                opcoesSelecionadas.forEach(option => {
                    const texto = option.textContent;
                    const duracao = parseInt(option.dataset.duracao) || 0;
                    const preco = parseFloat(option.dataset.preco) || 0;
                    
                    totalDuracao += duracao;
                    totalPreco += preco;
                    html += `<li>${texto}</li>`;
                });

                html += '</ul>';
                listaServicos.innerHTML = html;
                duracaoTotal.textContent = totalDuracao;
                precoTotal.textContent = totalPreco.toLocaleString('pt-BR', {minimumFractionDigits: 2});
            }

            // Passar dados dos serviços via data-attributes
            @foreach($servicos as $servico)
                const option{{ $servico->id }} = Array.from(selectServicos.options).find(o => o.value === '{{ $servico->id }}');
                if (option{{ $servico->id }}) {
                    option{{ $servico->id }}.dataset.duracao = {{ $servico->duracao }};
                    option{{ $servico->id }}.dataset.preco = {{ $servico->preco }};
                }
            @endforeach

            selectServicos.addEventListener('change', atualizarResumo);
            
            // Atualizar ao carregar a página
            atualizarResumo();
        });
    </script>
@endsection