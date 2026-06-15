<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EstoqueMovimento extends Model
{
    protected $table = 'estoque_movimentos';

    protected $fillable = [
        'medicamento_id', 'user_id', 'venda_id', 'tipo', 'quantidade', 'observacao',
    ];

    public function medicamento(): BelongsTo
    {
        return $this->belongsTo(Medicamento::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function venda(): BelongsTo
    {
        return $this->belongsTo(Venda::class);
    }

    public static function tiposEntrada(): array
    {
        return ['compra' => 'Compra', 'doacao' => 'Doacao', 'ajuste' => 'Ajuste'];
    }

    public static function tiposSaida(): array
    {
        return ['venda' => 'Venda', 'perda' => 'Perda', 'vencido' => 'Produto Vencido'];
    }
}
