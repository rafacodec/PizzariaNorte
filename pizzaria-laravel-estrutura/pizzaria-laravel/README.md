# Sistema Pizzaria - Laravel

Estrutura inicial para um sistema de gerenciamento de clientes, produtos e pedidos.

## Requisitos
- PHP 8.2+
- Composer
- MySQL
- Laravel 11/12
- Node.js + npm (opcional para Vite)

## Instalação

```bash
composer create-project laravel/laravel pizzaria
cd pizzaria
```

Substitua/adapte os arquivos deste pacote nas pastas correspondentes.

Crie o banco MySQL:

```sql
CREATE DATABASE pizzaria CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Configure o `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pizzaria
DB_USERNAME=root
DB_PASSWORD=
```

Depois:

```bash
php artisan migrate
php artisan serve
```

Acesse http://127.0.0.1:8000

## Estrutura

- Clientes: cadastro, edição, exclusão e consulta.
- Produtos: cadastro de pizzas, bebidas etc.
- Pedidos: criação e acompanhamento básico.
- Itens do pedido: produtos e quantidades.
- Status: recebido, em preparo, pronto, saiu para entrega, entregue e cancelado.

A autenticação e o dashboard avançado podem ser adicionados na próxima etapa.
