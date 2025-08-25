<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servidor extends Model
{
    protected $table = 'servidores';
    protected $fillable = [
    'nome','cpf','dt_nascimento','naturalidade','cep','endereco','lote','cidade','uf','cargo','vinculo','dt_entrada','dt_saida',
    'unidade_escolar','codigo_ue','email','contato','sexo','funcao_id',
    ];

    public function funcao()
    {
        return $this->belongsTo(\App\Models\Funcao::class, 'funcao_id');
    }
}

