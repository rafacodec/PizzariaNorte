@extends('layouts.app')

@section('title', 'Novo cliente')

@section('content')
<div class="page-header">
    <div>
        <h1>Novo cliente</h1>
        <p>Preencha os dados do cliente.</p>
    </div>
</div>

<form method="POST" action="{{ route('clientes.store') }}" class="card form">
    @csrf
    <label>Nome
        <input type="text" name="nome" value="{{ old('nome') }}" required>
    </label>

    <label>Telefone
        <input type="text" name="telefone" value="{{ old('telefone') }}" required>
    </label>

    <label>Endereço
        <input type="text" name="endereco" value="{{ old('endereco') }}">
    </label>

    <div class="form-actions">
        <a class="btn btn-secondary" href="{{ route('clientes.index') }}">Cancelar</a>
        <button class="btn">Salvar cliente</button>
    </div>
</form>
@endsection
