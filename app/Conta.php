<?php

namespace InternetBanking;

use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    protected $fillable = [
        'cliente_cpf', 'saldo'
    ];

    public function cliente()
    {
        return $this->belongsTo('InternetBanking\Cliente', 'cliente_cpf');
    }
}
