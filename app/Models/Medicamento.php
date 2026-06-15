<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medicamento extends Model
{
    protected $table = 'medicamentos';

    protected $fillable = [
        'codigo', 'nome_comercial', 'principio_ativo', 'categoria', 'fabricante',
        'lote', 'data_fabricacao', 'data_validade', 'preco_compra', 'preco_venda',
        'quantidade', 'estoque_minimo', 'fornecedor_id',
    ];

    protected function casts(): array
    {
        return [
            'data_fabricacao' => 'date',
            'data_validade' => 'date',
            'preco_compra' => 'decimal:2',
            'preco_venda' => 'decimal:2',
        ];
    }

    public function fornecedor(): BelongsTo
    {
        return $this->belongsTo(Fornecedor::class);
    }

    public function movimentos(): HasMany
    {
        return $this->hasMany(EstoqueMovimento::class);
    }

    public function isEstoqueBaixo(): bool
    {
        return $this->quantidade <= $this->estoque_minimo;
    }

    public function isVencido(): bool
    {
        return $this->data_validade && $this->data_validade->isPast();
    }

    public function isProximoVencimento(int $dias = 30): bool
    {
        return $this->data_validade
            && ! $this->isVencido()
            && $this->data_validade->lte(now()->addDays($dias));
    }
}
