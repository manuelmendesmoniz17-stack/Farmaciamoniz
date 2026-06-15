# Gestao Farmaceutica - Laravel

Sistema web de gestao farmaceutica com Laravel 13 e Bootstrap 5.

## Requisitos

- PHP 8.2+ (extensoes: zip, fileinfo, pdo_sqlite, openssl, mbstring, tokenizer)
- Composer

## Instalacao

```bash
cd laravel-app
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Aceda a: http://127.0.0.1:8000

## Credenciais

| Perfil        | Usuario      | Senha     |
|---------------|--------------|-----------|
| Administrador | admin        | admin123  |
| Funcionario   | funcionario  | func123   |

## Modulos

- Autenticacao (login, recuperar senha)
- Dashboard com graficos e alertas
- Medicamentos (CRUD)
- Estoque (entradas/saidas, historico, alertas)
- Clientes e Fornecedores
- Vendas PDV (carrinho, desconto, pagamento)
- Relatorios (vendas, estoque, validade, lucro)
- Configuracoes e backup (admin)
- Usuarios (admin)

## Tecnologias

- Laravel 13
- Bootstrap 5 + Bootstrap Icons
- Chart.js
- SQLite
"# Farmaciamoniz" 
"# Farmaciamoniz" 
