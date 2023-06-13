<?php

namespace App\Repositories;

use App\Repositories\Interfaces\IVendedorRepository;
use App\Models\Vendedor;
use Illuminate\Support\Facades\DB;

class VendedorRepository extends BaseRepository implements IVendedorRepository
{
    protected $entity;

    public function __construct(Vendedor $entity)
    {
        $this->entity = $entity;
    }

    public function getVendedoresComissao()
    {
        return $this->entity->withSum('pedidos', 'comissao')->get();

        /*
        return DB::table('vendedores')
            ->leftJoin('pedidos', 'vendedores.id', '=', 'pedidos.vendedor_id')
            ->select('vendedores.id', 'vendedores.nome', 'vendedores.email', DB::raw('ROUND(SUM(pedidos.comissao), 2) as comissao'))
            ->groupBy('vendedores.id')
            ->get();
        */
    }

    public function getPedidosById(int $id)
    {
        return  $this->entity->where('id', $id)->first()::with('pedidos')->paginate();
    }
}
