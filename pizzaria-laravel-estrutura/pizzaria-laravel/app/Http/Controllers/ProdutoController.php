<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProdutoController extends Controller
{
    public function index(): View
    {
        $produtos = Produto::latest()->paginate(10);

        return view('produtos.index', compact('produtos'));
    }

    public function create(): View
    {
        return view('produtos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'descricao' => ['nullable', 'string'],
            'preco' => ['required', 'numeric', 'min:0'],
            'categoria' => ['required', 'string', 'max:50'],
        ]);

        $dados['ativo'] = $request->boolean('ativo', true);

        Produto::create($dados);

        return redirect()
            ->route('produtos.index')
            ->with('sucesso', 'Produto cadastrado com sucesso.');
    }

    public function edit(Produto $produto): View
    {
        return view('produtos.edit', compact('produto'));
    }

    public function update(Request $request, Produto $produto): RedirectResponse
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'descricao' => ['nullable', 'string'],
            'preco' => ['required', 'numeric', 'min:0'],
            'categoria' => ['required', 'string', 'max:50'],
        ]);

        $dados['ativo'] = $request->boolean('ativo');

        $produto->update($dados);

        return redirect()
            ->route('produtos.index')
            ->with('sucesso', 'Produto atualizado com sucesso.');
    }

    public function destroy(Produto $produto): RedirectResponse
    {
        if ($produto->itens()->exists()) {
            return back()->with('erro', 'Não é possível excluir um produto que já aparece em pedidos.');
        }

        $produto->delete();

        return redirect()
            ->route('produtos.index')
            ->with('sucesso', 'Produto excluído com sucesso.');
    }
}
