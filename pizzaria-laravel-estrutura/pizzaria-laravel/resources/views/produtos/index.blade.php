@extends('layouts.app')

@section('title', 'Produtos')

@section('content')
<div class="page-header">
    <div>
        <h1>Produtos</h1>
        <p>Gerencie pizzas, bebidas e outros produtos.</p>
    </div>
    <a href="{{ route('produtos.create') }}" class="btn">+ Novo produto</a>
</div>

<div class="card">
<table>
    <thead>
        <tr>
            <th>Produto</th>
            <th>Categoria</th>
            <th>Preço</th>
            <th>Ativo</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
    @forelse($produtos as $produto)
        <tr>
            <td>{{ $produto->nome }}</td>
            <td>{{ $produto->categoria }}</td>
            <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
            <td>{{ $produto->ativo ? 'Sim' : 'Não' }}</td>
            <td class="acoes">
                <a class="btn btn-small" href="{{ route('produtos.edit', $produto) }}">Editar</a>
                <form method="POST" action="{{ route('produtos.destroy', $produto) }}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-small btn-danger" onclick="return confirm('Excluir este produto?')">Excluir</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="5" class="vazio">Nenhum produto cadastrado.</td></tr>
    @endforelse
    </tbody>
</table>
</div>

{{ $produtos->links() }}
@endsection
