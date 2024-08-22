<?php

namespace App\Models;

use App\Models\Parcelas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carne extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
        'valor_entrada',
    ];

    public function parcelas()
    {
        return $this->hasMany(Parcelas::class);
    }

    public function totalParcelas()
    {
        return $this->parcelas()->count();
    }

    protected $dates = ['valor_entrada'];

}
