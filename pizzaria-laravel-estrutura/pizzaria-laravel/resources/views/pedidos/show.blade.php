@extends('layouts.app')

@section('title', 'Pedido #' . $pedido->id)

@section('content')
<div class="page-header">
    <div>
        <h1>Pedido #{{ str_pad($pedido->id, 4, '0', STR_PAD_LEFT) }}</h1>
        <p>{{ $pedido->cliente->nome }} · {{ $pedido->cliente->telefone }}</p>
    </div>
    <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Voltar</a>
</div>

<div class="grid-2">
    <div class="card">
        <h2>Dados do pedido</h2>
        <p><strong>Tipo:</strong> {{ ucfirst($pedido->tipo) }}</p>
        <p><strong>Pagamento:</strong> {{ str_replace('_', ' ', ucfirst($pedido->forma_pagamento)) }}</p>
        <p><strong>Observações:</strong> {{ $pedido->observacoes ?: 'Nenhuma' }}</p>
    </div>

    <div class="card">
        <h2>Status</h2>
        <p><span class="status status-{{ $pedido->status }}">{{ str_replace('_', ' ', ucfirst($pedido->status)) }}</span></p>

        <form method="POST" action="{{ route('pedidos.status', $pedido) }}" class="form">
            @csrf
            @method('PATCH')
            <select name="status">
                @foreach([
                    'recebido' => 'Recebido',
                    'em_preparo' => 'Em preparo',
                    'pronto' => 'Pronto',
                    'saiu_entrega' => 'Saiu para entrega',
                    'entregue' => 'Entregue',
                    'cancelado' => 'Cancelado',
                ] as $valor => $nome)
                    <option value="{{ $valor }}" @selected($pedido->status === $valor)>{{ $nome }}</option>
                @endforeach
            </select>
            <button class="btn">Atualizar status</button>
        </form>
    </div>
</div>

<div class="card">
    <h2>Itens</h2>
    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Preço unitário</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
        @foreach($pedido->itens as $item)
            <tr>
                <td>{{ $item->produto->nome }}</td>
                <td>{{ $item->quantidade }}</td>
                <td>R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}</td>
                <td>R$ {{ number_format($item->subtotal, 2, ',', '.') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pedido-total">
        Total: R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}
    </div>
</div>
@endsection
