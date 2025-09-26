<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
  protected $table      = 'cao_usuario';   // tu tabla real
   protected $primaryKey = 'co_usuario';
    public $incrementing  = true;
    public $timestamps    = false;

    protected $fillable = [
        'no_usuario',            // name
        'no_email',              // email
        'ds_senha',              // password
        'co_usuario_autorizacao',
        'nu_matricula',
        'dt_nascimento',
        'dt_admissao_empresa',
        'dt_desligamento',
        'dt_inclusao',
        'dt_expiracao',
        'nu_cpf',
        'nu_rg',
        'no_orgao_emissor',
        'uf_orgao_emissor',
        'ds_endereco',
        'no_email_pessoal',
        'nu_telefone',
        'dt_alteracao',
        'url_foto',
        'instant_messenger',
        'icq',
        'msn',
        'yms',
        'ds_comp_end',
        'ds_bairro',
        'nu_cep',
        'no_cidade',
        'uf_cidade',
        'dt_expedicao',
    ];

    protected $hidden = [
        'ds_senha',      // password
    ];

    protected $casts = [
        'ds_senha'            => 'hashed',
        'dt_nascimento'       => 'date',
        'dt_admissao_empresa' => 'date',
        'dt_desligamento'     => 'date',
        'dt_inclusao'         => 'datetime',
        'dt_expiracao'        => 'datetime',
        'dt_alteracao'        => 'datetime',
        'dt_expedicao'        => 'date',
    ];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
