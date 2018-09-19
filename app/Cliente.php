<?php

namespace InternetBanking;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Cliente extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cpf','name', 'email', 'password', 'conta', 'verificado'
    ];
    protected $table = 'clientes';
    protected $primaryKey = 'cpf';
    public $incrementing = false;
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function conta()
    {
        return $this->hasOne('InternetBanking\Conta');
    }

    public function VerificarCliente()
    {
        return $this->hasOne('InternetBanking\VerificarCliente');
    }

  
}
