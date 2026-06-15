<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fornecedor extends Model
{
    protected $table = 'fornecedores';

    protected $fillable = ['nome', 'nif', 'telefone', 'email', 'endereco'];

    public function medicamentos(): HasMany
    {
        return $this->hasMany(Medicamento::class);
    }
}
