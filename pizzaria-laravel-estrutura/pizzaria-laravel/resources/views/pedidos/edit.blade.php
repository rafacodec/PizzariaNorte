@extends('layouts.app')

@section('title', 'Editar pedido')

@section('content')
<div class="page-header">
    <div>
        <h1>Editar pedido #{{ str_pad($pedido->id, 4, '0', STR_PAD_LEFT) }}</h1>
        <p>Atualize os dados básicos do pedido.</p>
    </div>
</div>

<form method="POST" action="{{ route('pedidos.update', $pedido) }}" class="card form">
    @csrf
    @method('PUT')

    <label>Cliente
        <select name="cliente_id" required>
            @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}" @selected($pedido->cliente_id == $cliente->id)>
                    {{ $cliente->nome }} - {{ $cliente->telefone }}
                </option>
            @endforeach
        </select>
    </label>

    <div class="grid-2">
        <label>Tipo
            <select name="tipo">
                <option value="retirada" @selected($pedido->tipo === 'retirada')>Retirada</option>
                <option value="local" @selected($pedido->tipo === 'local')>Consumo no local</option>
                <option value="entrega" @selected($pedido->tipo === 'entrega')>Entrega</option>
            </select>
        </label>

        <label>Forma de pagamento
            <select name="forma_pagamento">
                <option value="pix" @selected($pedido->forma_pagamento === 'pix')>PIX</option>
                <option value="dinheiro" @selected($pedido->forma_pagamento === 'dinheiro')>Dinheiro</option>
                <option value="cartao_credito" @selected($pedido->forma_pagamento === 'cartao_credito')>Cartão de crédito</option>
                <option value="cartao_debito" @selected($pedido->forma_pagamento === 'cartao_debito')>Cartão de débito</option>
            </select>
        </label>
    </div>

    <label>Observações
        <textarea name="observacoes" rows="4">{{ old('observacoes', $pedido->observacoes) }}</textarea>
    </label>

    <div class="form-actions">
        <a class="btn btn-secondary" href="{{ route('pedidos.show', $pedido) }}">Cancelar</a>
        <button class="btn">Salvar alterações</button>
    </div>
</form>
@endsection
