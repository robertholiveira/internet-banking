<?php

namespace InternetBanking;

use Illuminate\Database\Eloquent\Model;
use InternetBanking\Transacao;
class Transacao_debito extends Transacao
{
    protected $attributes = array(
        'tipo_transacao' => 'debito',
    );
}
