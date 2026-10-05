@extends('layouts.app')

@section('title', 'Editar cliente')

@section('content')
<div class="page-header">
    <div>
        <h1>Editar cliente</h1>
        <p>Atualize os dados de {{ $cliente->nome }}.</p>
    </div>
</div>

<form method="POST" action="{{ route('clientes.update', $cliente) }}" class="card form">
    @csrf
    @method('PUT')

    <label>Nome
        <input type="text" name="nome" value="{{ old('nome', $cliente->nome) }}" required>
    </label>

    <label>Telefone
        <input type="text" name="telefone" value="{{ old('telefone', $cliente->telefone) }}" required>
    </label>

    <label>Endereço
        <input type="text" name="endereco" value="{{ old('endereco', $cliente->endereco) }}">
    </label>

    <div class="form-actions">
        <a class="btn btn-secondary" href="{{ route('clientes.index') }}">Cancelar</a>
        <button class="btn">Salvar alterações</button>
    </div>
</form>
@endsection
