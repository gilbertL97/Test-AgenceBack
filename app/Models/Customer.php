<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'cao_cliente'; // tabla real en la BD
    protected $primaryKey = 'co_cliente';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'no_razao',                // corporate_name
        'no_fantasia',             // trade_name
        'no_contato',              // contact_name
        'nu_telefone',             // phone
        'nu_ramal',                // extension
        'nu_cnpj',                 // cnpj
        'ds_endereco',             // address
        'nu_numero',               // address_number
        'ds_complemento',          // address_complement
        'no_bairro',               // neighborhood
        'nu_cep',                  // zip_code
        'no_pais',                 // country
        'co_ramo',                 // segment_id
        'co_cidade',               // city_id
        'co_status',               // status_id
        'ds_site',                 // website
        'ds_email',                // email
        'ds_cargo_contato',        // contact_position
        'tp_cliente',              // customer_type
        'ds_referencia',           // reference
        'co_complemento_status',   // status_complement_id
        'nu_fax',                  // fax
        'ddd2',                    // alt_ddd
        'telefone2',               // alt_phone
    ];
}
