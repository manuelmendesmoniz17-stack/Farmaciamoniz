@extends('layouts.app')
@section('title', 'Estoque')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Estoque</h4>
    <a href="{{ route('estoque.historico') }}" class="btn btn-outline-secondary btn-sm">Historico</a>
</div>

@if($alertasBaixo->count())
<div class="alert alert-warning"><strong>Estoque baixo:</strong> {{ $alertasBaixo->pluck('nome_comercial')->join(', ') }}</div>
@endif
@if($alertasValidade->count())
<div class="alert alert-danger"><strong>Validade proxima:</strong> {{ $alertasValidade->pluck('nome_comercial')->join(', ') }}</div>
@endif

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light"><tr><th>Medicamento</th><th>Qtd</th><th>Minimo</th><th>Validade</th><th>Acao</th></tr></thead>
                    <tbody>
                    @foreach($medicamentos as $m)
                    <tr>
                        <td>{{ $m->nome_comercial }} <small class="text-muted">({{ $m->codigo }})</small></td>
                        <td>{{ $m->quantidade }}</td>
                        <td>{{ $m->estoque_minimo }}</td>
                        <td>{{ $m->data_validade?->format('d/m/Y') ?? '-' }}</td>
                        <td><button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalMov" data-id="{{ $m->id }}" data-nome="{{ $m->nome_comercial }}">Movimentar</button></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{ $medicamentos->links() }}
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><strong>Nova Movimentacao</strong></div>
            <div class="card-body">
                <form method="POST" action="{{ route('estoque.movimento') }}">
                    @csrf
                    <div class="mb-2"><label class="form-label">Medicamento</label>
                        <select name="medicamento_id" class="form-select" required>
                            @foreach($medicamentos as $m)<option value="{{ $m->id }}">{{ $m->nome_comercial }}</option>@endforeach
                        </select>
                    </div>
                    <div class="mb-2"><label class="form-label">Tipo</label>
                        <select name="tipo" class="form-select" required>
                            <optgroup label="Entradas">
                                <option value="compra">Compra</option><option value="doacao">Doacao</option><option value="ajuste">Ajuste</option>
                            </optgroup>
                            <optgroup label="Saidas">
                                <option value="perda">Perda</option><option value="vencido">Produto Vencido</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="mb-2"><label class="form-label">Quantidade</label><input type="number" name="quantidade" class="form-control" min="1" required></div>
                    <div class="mb-2"><label class="form-label">Observacao</label><textarea name="observacao" class="form-control" rows="2"></textarea></div>
                    <button class="btn btn-primary w-100">Registar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalMov" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <form method="POST" action="{{ route('estoque.movimento') }}">@csrf
            <div class="modal-header"><h5 class="modal-title">Movimentar</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <input type="hidden" name="medicamento_id" id="movMedId">
                <p id="movMedNome" class="fw-bold"></p>
                <select name="tipo" class="form-select mb-2" required>
                    <option value="compra">Compra</option><option value="doacao">Doacao</option><option value="ajuste">Ajuste</option>
                    <option value="perda">Perda</option><option value="vencido">Vencido</option>
                </select>
                <input type="number" name="quantidade" class="form-control mb-2" min="1" placeholder="Quantidade" required>
                <textarea name="observacao" class="form-control" placeholder="Observacao"></textarea>
            </div>
            <div class="modal-footer"><button class="btn btn-primary">Confirmar</button></div>
        </form>
    </div></div>
</div>
@endsection
@push('scripts')
<script>
document.getElementById('modalMov').addEventListener('show.bs.modal', e => {
    const btn = e.relatedTarget;
    document.getElementById('movMedId').value = btn.dataset.id;
    document.getElementById('movMedNome').textContent = btn.dataset.nome;
});
</script>
@endpush
