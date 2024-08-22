<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Carne;

class Parcelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'valor',
        'data_vencimento',
        'numero',
        'entrada',
        'carne_id'
    ];

    public function carnes()
    {
        return $this->belongsTo(Carne::class);
    }

    protected $dates = ['data_vencimento'];

}
