<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClienteController extends Controller
{
    public function index(): View
    {
        $clientes = Cliente::latest()->paginate(10);

        return view('clientes.index', compact('clientes'));
    }

    public function create(): View
    {
        return view('clientes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'telefone' => ['required', 'string', 'max:30'],
            'endereco' => ['nullable', 'string', 'max:255'],
        ]);

        Cliente::create($dados);

        return redirect()
            ->route('clientes.index')
            ->with('sucesso', 'Cliente cadastrado com sucesso.');
    }

    public function edit(Cliente $cliente): View
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente): RedirectResponse
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'telefone' => ['required', 'string', 'max:30'],
            'endereco' => ['nullable', 'string', 'max:255'],
        ]);

        $cliente->update($dados);

        return redirect()
            ->route('clientes.index')
            ->with('sucesso', 'Cliente atualizado com sucesso.');
    }

    public function destroy(Cliente $cliente): RedirectResponse
    {
        if ($cliente->pedidos()->exists()) {
            return back()->with('erro', 'Não é possível excluir um cliente que possui pedidos.');
        }

        $cliente->delete();

        return redirect()
            ->route('clientes.index')
            ->with('sucesso', 'Cliente excluído com sucesso.');
    }
}
