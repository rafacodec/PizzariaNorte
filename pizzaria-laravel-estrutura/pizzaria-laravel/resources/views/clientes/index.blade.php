@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
<div class="page-header">
    <div>
        <h1>Clientes</h1>
        <p>Cadastre e consulte os clientes da pizzaria.</p>
    </div>
    <a href="{{ route('clientes.create') }}" class="btn">+ Novo cliente</a>
</div>

<div class="card">
<table>
    <thead>
        <tr>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Endereço</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
    @forelse($clientes as $cliente)
        <tr>
            <td>{{ $cliente->nome }}</td>
            <td>{{ $cliente->telefone }}</td>
            <td>{{ $cliente->endereco ?: 'Não informado' }}</td>
            <td class="acoes">
                <a class="btn btn-small" href="{{ route('clientes.edit', $cliente) }}">Editar</a>
                <form method="POST" action="{{ route('clientes.destroy', $cliente) }}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-small btn-danger" onclick="return confirm('Excluir este cliente?')">Excluir</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="4" class="vazio">Nenhum cliente cadastrado.</td></tr>
    @endforelse
    </tbody>
</table>
</div>

{{ $clientes->links() }}
@endsection
