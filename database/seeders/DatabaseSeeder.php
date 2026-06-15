<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Configuracao;
use App\Models\Fornecedor;
use App\Models\Medicamento;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@farmacia.com',
            'username' => 'admin',
            'phone' => '923000000',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
        ]);

        User::create([
            'name' => 'Funcionario',
            'email' => 'func@farmacia.com',
            'username' => 'funcionario',
            'phone' => '923000001',
            'role' => 'funcionario',
            'password' => Hash::make('func123'),
        ]);

        Configuracao::create([
            'nome_farmacia' => 'Farmacia Central',
            'endereco' => 'Rua Principal, 100, Luanda',
            'telefone' => '222000000',
            'email' => 'contacto@farmacia.com',
        ]);

        $fornecedor = Fornecedor::create([
            'nome' => 'MedSupply Lda',
            'nif' => '5000123456',
            'telefone' => '222111222',
            'email' => 'vendas@medsupply.com',
            'endereco' => 'Av. Industrial, 50',
        ]);

        $medicamentos = [
            ['codigo' => 'MED001', 'nome_comercial' => 'Paracetamol 500mg', 'principio_ativo' => 'Paracetamol', 'categoria' => 'Analgesico', 'fabricante' => 'PharmaAO', 'preco_compra' => 50, 'preco_venda' => 120, 'quantidade' => 200, 'estoque_minimo' => 20],
            ['codigo' => 'MED002', 'nome_comercial' => 'Amoxicilina 500mg', 'principio_ativo' => 'Amoxicilina', 'categoria' => 'Antibiotico', 'fabricante' => 'BioMed', 'preco_compra' => 180, 'preco_venda' => 350, 'quantidade' => 80, 'estoque_minimo' => 15],
            ['codigo' => 'MED003', 'nome_comercial' => 'Ibuprofeno 400mg', 'principio_ativo' => 'Ibuprofeno', 'categoria' => 'Anti-inflamatorio', 'fabricante' => 'PharmaAO', 'preco_compra' => 70, 'preco_venda' => 150, 'quantidade' => 5, 'estoque_minimo' => 10],
            ['codigo' => 'MED004', 'nome_comercial' => 'Vitamina C 1000mg', 'principio_ativo' => 'Acido Ascorbico', 'categoria' => 'Vitamina', 'fabricante' => 'NutriPlus', 'preco_compra' => 90, 'preco_venda' => 200, 'quantidade' => 150, 'estoque_minimo' => 25],
        ];

        foreach ($medicamentos as $i => $med) {
            Medicamento::create(array_merge($med, [
                'lote' => 'L2026'.($i + 1),
                'data_fabricacao' => now()->subMonths(3),
                'data_validade' => now()->addMonths($i === 2 ? 1 : 12),
                'fornecedor_id' => $fornecedor->id,
            ]));
        }

        Cliente::create(['nome' => 'Joao Silva', 'telefone' => '923456789', 'email' => 'joao@email.com', 'endereco' => 'Bairro Azul']);
        Cliente::create(['nome' => 'Maria Santos', 'telefone' => '924567890', 'email' => 'maria@email.com', 'endereco' => 'Maianga']);
    }
}
