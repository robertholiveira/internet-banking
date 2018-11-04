<?php

namespace InternetBanking;

use Illuminate\Database\Eloquent\Model;

class Transacao_credito extends transacao
{
    protected $attributes = array(
        'tipo_transacao' => 'credito',
    );
}
