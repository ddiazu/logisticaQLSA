<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notaventa extends Model
{
    //

    protected $table = 'notasdeventas';
    protected $primary_key = 'idNotaVenta';
    public $timestamps = false;

    protected $fillable = ['idNotaVenta', 'cot_año', 'fechahora_creacion', 'hora_creacion', 'idObra', 'idPlanta', 'idFormaEntrega', 'aprobada', 'ordenCompraCliente'];

}
