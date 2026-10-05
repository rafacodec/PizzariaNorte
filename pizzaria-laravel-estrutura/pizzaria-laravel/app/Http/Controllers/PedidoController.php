<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ItemPedido;
use App\Models\Pedido;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PedidoController extends Controller
{
    public function index(): View
    {
        $pedidos = Pedido::with('cliente')
            ->latest()
            ->paginate(10);

        return view('pedidos.index', compact('pedidos'));
    }

    public function create(): View
    {
        $clientes = Cliente::orderBy('nome')->get();
        $produtos = Produto::where('ativo', true)->orderBy('nome')->get();

        return view('pedidos.create', compact('clientes', 'produtos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'cliente_id' => ['required', 'exists:clientes,id'],
            'tipo' => ['required', 'in:local,retirada,entrega'],
            'forma_pagamento' => ['required', 'in:dinheiro,pix,cartao_credito,cartao_debito'],
            'observacoes' => ['nullable', 'string'],
            'produtos' => ['required', 'array', 'min:1'],
            'produtos.*.id' => ['required', 'exists:produtos,id'],
            'produtos.*.quantidade' => ['required', 'integer', 'min:1'],
        ]);

        DB::transaction(function () use ($dados) {
            $pedido = Pedido::create([
                'cliente_id' => $dados['cliente_id'],
                'tipo' => $dados['tipo'],
                'status' => 'recebido',
                'forma_pagamento' => $dados['forma_pagamento'],
                'observacoes' => $dados['observacoes'] ?? null,
                'valor_total' => 0,
            ]);

            $total = 0;

            foreach ($dados['produtos'] as $item) {
                $produto = Produto::findOrFail($item['id']);
                $quantidade = (int) $item['quantidade'];
                $subtotal = $produto->preco * $quantidade;

                ItemPedido::create([
                    'pedido_id' => $pedido->id,
                    'produto_id' => $produto->id,
                    'quantidade' => $quantidade,
                    'preco_unitario' => $produto->preco,
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
            }

            $pedido->update(['valor_total' => $total]);
        });

        return redirect()
            ->route('pedidos.index')
            ->with('sucesso', 'Pedido cadastrado com sucesso.');
    }

    public function show(Pedido $pedido): View
    {
        $pedido->load(['cliente', 'itens.produto']);

        return view('pedidos.show', compact('pedido'));
    }

    public function updateStatus(Request $request, Pedido $pedido): RedirectResponse
    {
        $dados = $request->validate([
            'status' => ['required', 'in:recebido,em_preparo,pronto,saiu_entrega,entregue,cancelado'],
        ]);

        $pedido->update(['status' => $dados['status']]);

        return back()->with('sucesso', 'Status do pedido atualizado.');
    }

    public function edit(Pedido $pedido): View
    {
        $pedido->load(['cliente', 'itens.produto']);
        $clientes = Cliente::orderBy('nome')->get();

        return view('pedidos.edit', compact('pedido', 'clientes'));
    }

    public function update(Request $request, Pedido $pedido): RedirectResponse
    {
        $dados = $request->validate([
            'cliente_id' => ['required', 'exists:clientes,id'],
            'tipo' => ['required', 'in:local,retirada,entrega'],
            'forma_pagamento' => ['required', 'in:dinheiro,pix,cartao_credito,cartao_debito'],
            'observacoes' => ['nullable', 'string'],
        ]);

        $pedido->update($dados);

        return redirect()
            ->route('pedidos.show', $pedido)
            ->with('sucesso', 'Pedido atualizado com sucesso.');
    }

    public function destroy(Pedido $pedido): RedirectResponse
    {
        $pedido->delete();

        return redirect()
            ->route('pedidos.index')
            ->with('sucesso', 'Pedido excluído com sucesso.');
    }
}
