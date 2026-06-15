<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    protected $table = 'configuracoes';

    protected $fillable = ['nome_farmacia', 'logotipo', 'endereco', 'telefone', 'email'];

    public static function atual(): self
    {
        return static::firstOrCreate([], [
            'nome_farmacia' => 'Farmacia Central',
        ]);
    }
}
