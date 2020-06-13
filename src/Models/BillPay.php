<?php

namespace SONFin\Models;

use Illuminate\Database\Eloquent\Model;

class BillPay extends Model
{
    // Mass Assignment
    protected $fillable = [
        'date_launch',
        'name',
        'value',
        'user_id',
        'category_cost_id'
    ];

    public function categoryCost()
    {
        /* Criar um relacionamento entre as models -> relacionamento 1..* ( 1 para muitos )
         No caso replica o relacionamento das tabelas para a orientação a objetos. */
        return $this->belongsTo(CategoryCost::class);
    }
}
