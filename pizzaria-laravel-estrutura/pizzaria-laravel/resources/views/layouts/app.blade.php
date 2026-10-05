<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pizzaria')</title>
    <link rel="stylesheet" href="{{ asset('css/pizzaria.css') }}">
</head>
<body>
<header class="topo">
    <div class="container topo-inner">
        <a href="{{ route('pedidos.index') }}" class="logo">🍕 Pizzaria</a>
        <nav>
            <a href="{{ route('pedidos.index') }}">Pedidos</a>
            <a href="{{ route('clientes.index') }}">Clientes</a>
            <a href="{{ route('produtos.index') }}">Produtos</a>
        </nav>
    </div>
</header>

<main class="container">
    @if(session('sucesso'))
        <div class="alert sucesso">{{ session('sucesso') }}</div>
    @endif

    @if(session('erro'))
        <div class="alert erro">{{ session('erro') }}</div>
    @endif

    @if($errors->any())
        <div class="alert erro">
            <strong>Corrija os seguintes campos:</strong>
            <ul>
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>
</body>
</html>
