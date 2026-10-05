@extends('layouts.app')

@section('title', 'Novo pedido')

@section('content')
<div class="page-header">
    <div>
        <h1>Novo pedido</h1>
        <p>Registre os dados e os produtos do pedido.</p>
    </div>
</div>

<form method="POST" action="{{ route('pedidos.store') }}" class="card form" id="pedido-form">
    @csrf

    <label>Cliente
        <select name="cliente_id" required>
            <option value="">Selecione o cliente</option>
            @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}" @selected(old('cliente_id') == $cliente->id)>
                    {{ $cliente->nome }} - {{ $cliente->telefone }}
                </option>
            @endforeach
        </select>
    </label>

    <div class="grid-2">
        <label>Tipo do pedido
            <select name="tipo" required>
                <option value="retirada">Retirada</option>
                <option value="local">Consumo no local</option>
                <option value="entrega">Entrega</option>
            </select>
        </label>

        <label>Forma de pagamento
            <select name="forma_pagamento" required>
                <option value="pix">PIX</option>
                <option value="dinheiro">Dinheiro</option>
                <option value="cartao_credito">Cartão de crédito</option>
                <option value="cartao_debito">Cartão de débito</option>
            </select>
        </label>
    </div>

    <h2>Produtos</h2>

    <div id="itens">
        <div class="item-pedido">
            <select name="produtos[0][id]" class="produto" required>
                <option value="">Selecione um produto</option>
                @foreach($produtos as $produto)
                    <option value="{{ $produto->id }}" data-preco="{{ $produto->preco }}">
                        {{ $produto->nome }} - R$ {{ number_format($produto->preco, 2, ',', '.') }}
                    </option>
                @endforeach
            </select>
            <input type="number" name="produtos[0][quantidade]" class="quantidade" min="1" value="1" required>
            <button type="button" class="btn btn-danger remover">Remover</button>
        </div>
    </div>

    <button type="button" class="btn btn-secondary" id="adicionar">+ Adicionar produto</button>

    <div class="total-box">
        Total estimado: <strong id="total">R$ 0,00</strong>
    </div>

    <label>Observações
        <textarea name="observacoes" rows="3" placeholder="Ex.: sem cebola, entregar após 19h...">{{ old('observacoes') }}</textarea>
    </label>

    <div class="form-actions">
        <a class="btn btn-secondary" href="{{ route('pedidos.index') }}">Cancelar</a>
        <button class="btn">Finalizar pedido</button>
    </div>
</form>

<script>
let indice = 1;

const produtosHtml = @json($produtos->map(fn($produto) => [
    'id' => $produto->id,
    'nome' => $produto->nome,
    'preco' => (float) $produto->preco
])->values());

function opcoesProdutos() {
    return '<option value="">Selecione um produto</option>' +
        produtosHtml.map(p =>
            `<option value="${p.id}" data-preco="${p.preco}">${p.nome} - R$ ${p.preco.toFixed(2).replace('.', ',')}</option>`
        ).join('');
}

function atualizarTotal() {
    let total = 0;

    document.querySelectorAll('.item-pedido').forEach(item => {
        const select = item.querySelector('.produto');
        const qtd = parseInt(item.querySelector('.quantidade').value || 0);
        const preco = parseFloat(select.selectedOptions[0]?.dataset.preco || 0);
        total += preco * qtd;
    });

    document.getElementById('total').textContent =
        total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
}

document.getElementById('adicionar').addEventListener('click', () => {
    const div = document.createElement('div');
    div.className = 'item-pedido';
    div.innerHTML = `
        <select name="produtos[${indice}][id]" class="produto" required>
            ${opcoesProdutos()}
        </select>
        <input type="number" name="produtos[${indice}][quantidade]" class="quantidade" min="1" value="1" required>
        <button type="button" class="btn btn-danger remover">Remover</button>
    `;
    document.getElementById('itens').appendChild(div);
    indice++;
});

document.addEventListener('change', atualizarTotal);
document.addEventListener('input', atualizarTotal);

document.addEventListener('click', (event) => {
    if (event.target.classList.contains('remover')) {
        const itens = document.querySelectorAll('.item-pedido');
        if (itens.length > 1) {
            event.target.closest('.item-pedido').remove();
            atualizarTotal();
        }
    }
});
</script>
@endsection
