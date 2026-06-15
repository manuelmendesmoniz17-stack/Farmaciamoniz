@extends('layouts.app')
@section('title', $medicamento->exists ? 'Editar Medicamento' : 'Novo Medicamento')
@section('content')
<h4 class="mb-3">{{ $medicamento->exists ? 'Editar' : 'Novo' }} Medicamento</h4>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ $medicamento->exists ? route('medicamentos.update', $medicamento) : route('medicamentos.store') }}">
            @csrf @if($medicamento->exists) @method('PUT') @endif
            <div class="row g-3">
                <div class="col-md-3"><label class="form-label">Codigo</label><input name="codigo" class="form-control" value="{{ old('codigo', $medicamento->codigo) }}" required></div>
                <div class="col-md-5"><label class="form-label">Nome Comercial</label><input name="nome_comercial" class="form-control" value="{{ old('nome_comercial', $medicamento->nome_comercial) }}" required></div>
                <div class="col-md-4"><label class="form-label">Principio Ativo</label><input name="principio_ativo" class="form-control" value="{{ old('principio_ativo', $medicamento->principio_ativo) }}"></div>
                <div class="col-md-3"><label class="form-label">Categoria</label><input name="categoria" class="form-control" value="{{ old('categoria', $medicamento->categoria) }}"></div>
                <div class="col-md-3"><label class="form-label">Fabricante</label><input name="fabricante" class="form-control" value="{{ old('fabricante', $medicamento->fabricante) }}"></div>
                <div class="col-md-3"><label class="form-label">Lote</label><input name="lote" class="form-control" value="{{ old('lote', $medicamento->lote) }}"></div>
                <div class="col-md-3"><label class="form-label">Fornecedor</label>
                    <select name="fornecedor_id" class="form-select">
                        <option value="">--</option>
                        @foreach($fornecedores as $f)<option value="{{ $f->id }}" @selected(old('fornecedor_id', $medicamento->fornecedor_id) == $f->id)>{{ $f->nome }}</option>@endforeach
                    </select>
                </div>
                <div class="col-md-3"><label class="form-label">Data Fabricacao</label><input type="date" name="data_fabricacao" class="form-control" value="{{ old('data_fabricacao', $medicamento->data_fabricacao?->format('Y-m-d')) }}"></div>
                <div class="col-md-3"><label class="form-label">Data Validade</label><input type="date" name="data_validade" class="form-control" value="{{ old('data_validade', $medicamento->data_validade?->format('Y-m-d')) }}"></div>
                <div class="col-md-2"><label class="form-label">Preco Compra</label><input type="number" step="0.01" name="preco_compra" class="form-control" value="{{ old('preco_compra', $medicamento->preco_compra) }}" required></div>
                <div class="col-md-2"><label class="form-label">Preco Venda</label><input type="number" step="0.01" name="preco_venda" class="form-control" value="{{ old('preco_venda', $medicamento->preco_venda) }}" required></div>
                <div class="col-md-2"><label class="form-label">Quantidade</label><input type="number" name="quantidade" class="form-control" value="{{ old('quantidade', $medicamento->quantidade ?? 0) }}" required></div>
                <div class="col-md-2"><label class="form-label">Estoque Minimo</label><input type="number" name="estoque_minimo" class="form-control" value="{{ old('estoque_minimo', $medicamento->estoque_minimo ?? 10) }}" required></div>
            </div>
            <div class="mt-3"><button class="btn btn-primary">Salvar</button><a href="{{ route('medicamentos.index') }}" class="btn btn-link">Cancelar</a></div>
        </form>
    </div>
</div>
@endsection
