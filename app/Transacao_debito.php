<?php

namespace InternetBanking;

use Illuminate\Database\Eloquent\Model;

class Transacao_debito extends transacao
{
    protected $attributes = array(
        'tipo_transacao' => 'debito',
    );
}
