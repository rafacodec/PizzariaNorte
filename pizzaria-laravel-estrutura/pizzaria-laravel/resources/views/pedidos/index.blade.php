@extends('layouts.app')

@section('title', 'Pedidos')

@section('content')
<div class="page-header">
    <div>
        <h1>Pedidos</h1>
        <p>Centralize e acompanhe os pedidos da pizzaria.</p>
    </div>
    <a href="{{ route('pedidos.create') }}" class="btn">+ Novo pedido</a>
</div>

<div class="card">
<table>
    <thead>
        <tr>
            <th>Pedido</th>
            <th>Cliente</th>
            <th>Tipo</th>
            <th>Status</th>
            <th>Total</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
    @forelse($pedidos as $pedido)
        <tr>
            <td>#{{ str_pad($pedido->id, 4, '0', STR_PAD_LEFT) }}</td>
            <td>{{ $pedido->cliente->nome }}</td>
            <td>{{ ucfirst($pedido->tipo) }}</td>
            <td><span class="status status-{{ $pedido->status }}">{{ str_replace('_', ' ', ucfirst($pedido->status)) }}</span></td>
            <td>R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</td>
            <td><a class="btn btn-small" href="{{ route('pedidos.show', $pedido) }}">Ver pedido</a></td>
        </tr>
    @empty
        <tr><td colspan="6" class="vazio">Nenhum pedido cadastrado.</td></tr>
    @endforelse
    </tbody>
</table>
</div>

{{ $pedidos->links() }}
@endsection
