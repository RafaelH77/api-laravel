<?php

namespace App\Http\Controllers;

use App\Models\Vendedor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class VendedorController extends Controller
{
    /**
     * Listar todos os vendedores
     *
     *  * @OA\Get(
     *     tags={"vendedor"},
     *     path="/vendedor",
     *     @OA\Response(response="200", description="Sucesso")
     *  )
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new Response(
            DB::table('sellers')
                ->leftJoin('orders', 'sellers.id', '=', 'orders.seller_id')
                ->select('sellers.id', 'sellers.name', 'sellers.email', DB::raw('ROUND(SUM(orders.commission), 2) as commission'))
                ->groupBy('sellers.id')
                ->get(), 200
        );
    }

    /**
     * Criar vendedor
     *
     *  * @OA\Post(
     *     tags={"vendedor"},
     *     path="/vendedor",
     *     @OA\Parameter(
     *          name="name",
     *          in="query",
     *          @OA\Schema(type="string"),
     *          style="form",
     *     ),
     *     @OA\Parameter(
     *          name="email",
     *          in="query",
     *          @OA\Schema(type="string"),
     *          style="form",
     *     ),
     *     @OA\Response(response="200", description="Sucesso")
     *  )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $seller = Seller::create($request->all());
        return new Response($seller, 200);
    }

    /**
     * Mostrar todas as vendas do vendedor
     *
     *   * @OA\Get(
     *     tags={"vendedor"},
     *     path="/vendedor/{vendedor}/pedido",
     *     @OA\Parameter(
     *          name="vendedor",
     *          in="path",
     *          @OA\Schema(type="bigint"),
     *          style="form",
     *     ),
     *     @OA\Response(response="200", description="Sucesso")
     *   )
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showOrders($id)
    {
        return new Response(
            DB::table('sellers')
                ->join('orders', 'sellers.id', '=', 'orders.seller_id')
                ->select('orders.id', 'sellers.name', 'sellers.email', DB::raw('ROUND(orders.commission, 2) as commission'),
                    'orders.value', 'orders.created_at')
                ->where('sellers.id', '=', $id)
                ->get(), 200
        );
    }

}
