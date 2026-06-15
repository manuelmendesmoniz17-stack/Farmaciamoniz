@extends('layouts.app')
@section('title', 'PDV - Nova Venda')
@section('content')
<h4 class="mb-3">Ponto de Venda</h4>
<div class="row g-3">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="input-group mb-3">
                    <input type="text" id="buscaMed" class="form-control" placeholder="Buscar medicamento por nome ou codigo...">
                    <button class="btn btn-outline-primary" type="button" id="btnBuscar">Buscar</button>
                </div>
                <div id="resultados" class="list-group mb-3" style="max-height:200px;overflow-y:auto"></div>
                <div class="row g-2 align-items-end">
                    <div class="col"><label class="form-label small">Quantidade</label><input type="number" id="qtyAdd" class="form-control" value="1" min="1"></div>
                    <div class="col-auto"><button class="btn btn-success" id="btnAdd" disabled>Adicionar ao Carrinho</button></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <form method="POST" action="{{ route('vendas.store') }}" id="formVenda">
            @csrf
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><strong>Carrinho</strong></div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0" id="carrinho">
                        <thead><tr><th>Item</th><th>Qtd</th><th>Subtotal</th><th></th></tr></thead>
                        <tbody></tbody>
                    </table>
                    <p class="text-center text-muted py-3" id="carrinhoVazio">Carrinho vazio</p>
                </div>
                <div class="card-footer">
                    <div class="mb-2"><label class="form-label">Cliente</label>
                        <select name="cliente_id" class="form-select form-select-sm">
                            <option value="">Consumidor Final</option>
                            @foreach($clientes as $c)<option value="{{ $c->id }}">{{ $c->nome }}</option>@endforeach
                        </select>
                    </div>
                    <div class="mb-2"><label class="form-label">Desconto (Kz)</label><input type="number" name="desconto" id="desconto" class="form-control form-control-sm" value="0" min="0" step="0.01"></div>
                    <div class="mb-2"><label class="form-label">Pagamento</label>
                        <select name="forma_pagamento" class="form-select form-select-sm" required>
                            <option value="dinheiro">Dinheiro</option>
                            <option value="multicaixa">Multicaixa</option>
                            <option value="transferencia">Transferencia</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between fw-bold fs-5 mb-2">
                        <span>Total:</span><span id="totalDisplay">0,00 Kz</span>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" id="btnFinalizar" disabled>Finalizar Venda</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
let carrinho = [], selecionado = null;
const fmt = v => v.toLocaleString('pt-PT', {minimumFractionDigits:2}) + ' Kz';

document.getElementById('btnBuscar').onclick = buscar;
document.getElementById('buscaMed').addEventListener('keyup', e => { if(e.key === 'Enter') buscar(); });

function buscar() {
    fetch(`{{ route('medicamentos.search') }}?q=${encodeURIComponent(document.getElementById('buscaMed').value)}`)
        .then(r => r.json()).then(data => {
            const el = document.getElementById('resultados');
            el.innerHTML = data.length ? data.map(m => `
                <button type="button" class="list-group-item list-group-item-action" data-med='${JSON.stringify(m)}'>
                    <strong>${m.nome_comercial}</strong> (${m.codigo}) - ${fmt(m.preco_venda)} - Est: ${m.quantidade}
                </button>`).join('') : '<div class="list-group-item text-muted">Nenhum resultado</div>';
            el.querySelectorAll('button[data-med]').forEach(btn => btn.onclick = () => {
                selecionado = JSON.parse(btn.dataset.med);
                document.getElementById('btnAdd').disabled = false;
                el.querySelectorAll('.active').forEach(x => x.classList.remove('active'));
                btn.classList.add('active');
            });
        });
}

document.getElementById('btnAdd').onclick = () => {
    if (!selecionado) return;
    const qty = parseInt(document.getElementById('qtyAdd').value) || 1;
    const exist = carrinho.find(i => i.medicamento_id === selecionado.id);
    if (exist) exist.quantidade += qty; else carrinho.push({ medicamento_id: selecionado.id, nome: selecionado.nome_comercial, preco: parseFloat(selecionado.preco_venda), quantidade: qty });
    render();
};

function render() {
    const tbody = document.querySelector('#carrinho tbody');
    document.getElementById('carrinhoVazio').style.display = carrinho.length ? 'none' : 'block';
    tbody.innerHTML = carrinho.map((item, i) => {
        const sub = item.preco * item.quantidade;
        return `<tr><td>${item.nome}</td><td>${item.quantidade}</td><td>${fmt(sub)}</td>
            <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="remover(${i})">x</button></td></tr>`;
    }).join('');
    const subtotal = carrinho.reduce((s, i) => s + i.preco * i.quantidade, 0);
    const desc = parseFloat(document.getElementById('desconto').value) || 0;
    document.getElementById('totalDisplay').textContent = fmt(Math.max(0, subtotal - desc));
    document.getElementById('btnFinalizar').disabled = !carrinho.length;
    document.querySelectorAll('#formVenda input[name^="itens"]').forEach(e => e.remove());
    carrinho.forEach((item, i) => {
        ['medicamento_id','quantidade'].forEach(f => {
            const inp = document.createElement('input');
            inp.type = 'hidden'; inp.name = `itens[${i}][${f}]`; inp.value = item[f === 'medicamento_id' ? 'medicamento_id' : 'quantidade'];
            document.getElementById('formVenda').appendChild(inp);
        });
    });
}
window.remover = i => { carrinho.splice(i, 1); render(); };
document.getElementById('desconto').oninput = render;
</script>
@endpush
