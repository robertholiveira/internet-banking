<?php

namespace InternetBanking;

use Illuminate\Database\Eloquent\Model;

class Transacao extends Model
{

    protected $fillable = [
        'conta_id','nome_transacao', 'valor_transacao', 'data_transacao', 'saldo_atual'
    ];
    protected $table = 'transacoes';

    protected $primaryKey = 'transacao_id';

    public $timestamps = false;
    
    public function conta()
    {
        return $this->BelongsTo('InternetBanking\Conta');
    }
}
