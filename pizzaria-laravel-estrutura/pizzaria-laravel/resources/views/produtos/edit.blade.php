@extends('layouts.app')

@section('title', 'Editar produto')

@section('content')
<div class="page-header">
    <div>
        <h1>Editar produto</h1>
        <p>Atualize as informações do produto.</p>
    </div>
</div>

<form method="POST" action="{{ route('produtos.update', $produto) }}" class="card form">
    @csrf
    @method('PUT')

    <label>Nome
        <input type="text" name="nome" value="{{ old('nome', $produto->nome) }}" required>
    </label>

    <label>Descrição
        <textarea name="descricao" rows="3">{{ old('descricao', $produto->descricao) }}</textarea>
    </label>

    <label>Preço
        <input type="number" step="0.01" min="0" name="preco" value="{{ old('preco', $produto->preco) }}" required>
    </label>

    <label>Categoria
        <select name="categoria" required>
            @foreach(['Pizza', 'Bebida', 'Sobremesa', 'Outro'] as $categoria)
                <option value="{{ $categoria }}" @selected($produto->categoria === $categoria)>{{ $categoria }}</option>
            @endforeach
        </select>
    </label>

    <label class="check">
        <input type="checkbox" name="ativo" value="1" @checked($produto->ativo)>
        Produto disponível para pedidos
    </label>

    <div class="form-actions">
        <a class="btn btn-secondary" href="{{ route('produtos.index') }}">Cancelar</a>
        <button class="btn">Salvar alterações</button>
    </div>
</form>
@endsection
