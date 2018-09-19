<?php

namespace InternetBanking;

use Illuminate\Database\Eloquent\Model;

class VerificarCliente extends Model
{
    protected $guarded = [];
 
    public function cliente()
    {
        return $this->belongsTo('InternetBanking\Cliente', 'cliente_cpf');
    }
}
