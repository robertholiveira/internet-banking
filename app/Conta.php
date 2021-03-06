<?php

namespace InternetBanking;

use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    protected $fillable = [
        'cliente_cpf', 'saldo', 'conta_id'
    ];
    
    protected $primaryKey = 'conta_id';

    public function transacoes()
    {
        return $this->hasMany('InternetBanking\Transacao', 'conta_id');
    }

    
    
    public function cliente()
    {
        return $this->belongsTo('InternetBanking\Cliente', 'cliente_cpf');
    }

}
