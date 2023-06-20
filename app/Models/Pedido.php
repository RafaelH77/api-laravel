<?php

namespace App\Models;

use Doctrine\Common\Annotations\Annotation\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $with = ['itens'];

    protected $fillable = [
        'vendedor_id',
        'valor',
        'comissao',
    ];


    public function vendedor(): BelongsTo
    {
        return $this->belongsTo(Vendedor::class);
    }

    public function itens(): HasMany
    {
        return $this->hasMany(PedidoItem::class);
    }

    public function setValorAttribute($value): void
    {
        $this->attributes['valor'] = $value;
        $this->attributes['comissao'] = $this->calculaComissao($value);
    }

    public function calculaComissao($valor){
        return round($valor * 0.1, 2);
    }
}
