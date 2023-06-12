<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Vendedor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    /**
     * Criar venda
     *
     *  * @OA\Post(
     *     tags={"/pedido"},
     *     path="/pedido",
     *     @OA\Parameter(
     *          name="vendedor_id",
     *          in="query",
     *          @OA\Schema(type="bigint"),
     *          style="form",
     *     ),
     *     @OA\Parameter(
     *          name="valor",
     *          in="query",
     *          @OA\Schema(type="float"),
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
        $order = Order::create(array_merge($request->all(), ['commission' => round($request['value']*0.085, 2)]));
        $seller = Seller::find($order->seller_id);
        $responseObject = [
          'id' => $order->id,
          'name' => $seller->name,
          'email' => $seller->email,
          'comission' => $order->commission,
          'value' => $order->value,
          'created_at' => $order->created_at,
        ];
        return new Response($responseObject, 200);
    }

    /**
     * Mostrar o total de vendas do dia
     *
     *   * @OA\Get(
     *     tags={"/pedido"},
     *     path="/pedido/total/{data}",
     *     @OA\Parameter(
     *          name="data",
     *          in="path",
     *          example="13-06-2022",
     *          @OA\Schema(type="string"),
     *          style="form",
     *     ),
     *     @OA\Response(response="200", description="Sucesso")
     *   )
     *
     * @param  string  $date
     * @return \Illuminate\Http\Response
     */
    public function showTotalOrders($date)
    {
        return new Response(
            DB::table('orders')
                ->select(DB::raw('SUM(orders.value) as total'))
                ->whereBetween('orders.created_at', [date("Y-m-d H:i:s", strtotime($date)), date("Y-m-d H:i:s", strtotime($date . ' 23:59:59'))])
                ->get(), 200
        );
    }
}
