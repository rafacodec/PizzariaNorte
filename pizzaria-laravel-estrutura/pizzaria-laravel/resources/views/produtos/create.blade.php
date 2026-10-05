@extends('layouts.app')

@section('title', 'Novo produto')

@section('content')
<div class="page-header">
    <div>
        <h1>Novo produto</h1>
        <p>Cadastre uma pizza, bebida ou outro item.</p>
    </div>
</div>

<form method="POST" action="{{ route('produtos.store') }}" class="card form">
    @csrf

    <label>Nome
        <input type="text" name="nome" value="{{ old('nome') }}" placeholder="Ex.: Pizza Calabresa" required>
    </label>

    <label>Descrição
        <textarea name="descricao" rows="3">{{ old('descricao') }}</textarea>
    </label>

    <label>Preço
        <input type="number" step="0.01" min="0" name="preco" value="{{ old('preco') }}" required>
    </label>

    <label>Categoria
        <select name="categoria" required>
            <option value="Pizza">Pizza</option>
            <option value="Bebida">Bebida</option>
            <option value="Sobremesa">Sobremesa</option>
            <option value="Outro">Outro</option>
        </select>
    </label>

    <label class="check">
        <input type="checkbox" name="ativo" value="1" checked>
        Produto disponível para pedidos
    </label>

    <div class="form-actions">
        <a class="btn btn-secondary" href="{{ route('produtos.index') }}">Cancelar</a>
        <button class="btn">Salvar produto</button>
    </div>
</form>
@endsection
