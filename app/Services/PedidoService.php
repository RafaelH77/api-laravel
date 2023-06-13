<?php

namespace App\Services;

use App\Repositories\Interfaces\IPedidoRepository;
use App\Repositories\Interfaces\IVendedorRepository;
use Illuminate\Support\Facades\Validator;

class PedidoService extends BaseService
{
    protected $repository;
    protected $vendedorRepository;

    public function __construct(IPedidoRepository $repository, IVendedorRepository $vendedorRepository)
    {
        $this->repository = $repository;
        $this->vendedorRepository = $vendedorRepository;
    }

    public function create($request)
    {
        /*
        Validação
        $validator = $request->validate([
            'valor' => 'required|numeric|min:0',
        ]);
        */

        $data = $request->all();

        $comissao = round($data['valor'] * 0.1, 2);

        $result = $this->repository->create(array_merge($data, ['comissao' => $comissao]));

        $vendedor = $this->vendedorRepository->getById($data['vendedor_id']);

        return array_merge($result->toArray(), ['vendedor_nome' => $vendedor->nome, 'vendedor_email' => $vendedor->email]);
    }

    public function getTotalPedidoPorDia($date)
    {
        return $this->repository->getTotalPedidoPorDia($date);
    }

    public function getPedidosPorVendedor(int $idVendedor)
    {
        return $this->repository->getPedidosPorVendedor($idVendedor);
    }
}
