<?php

namespace App\Services;

use App\Repositories\Interfaces\IPedidoRepository;
use App\Repositories\Interfaces\IVendedorRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PedidoService extends BaseService
{
    protected $repository;
    protected $vendedorRepository;
    protected $validationRules = [
        'valor' => 'required|numeric|min:0',
    ];

    public function __construct(IPedidoRepository $repository, IVendedorRepository $vendedorRepository)
    {
        $this->repository = $repository;
        $this->vendedorRepository = $vendedorRepository;
    }

    public function create($data)
    {
        $this->validate($this->validationRules);

        $comissao = $this->calculaComissao($data['valor']);

        $result = $this->repository->create(array_merge($data, ['comissao' => $comissao]));

        return $this->repository->getByIdWithVendedor($result->id);
    }

    public function update(int $id, $data)
    {
        $this->validate($this->validationRules);

        $comissao = $this->calculaComissao($data['valor']);

        $this->repository->update($id, array_merge($data, ['comissao' => $comissao]));

        return $this->repository->getByIdWithVendedor($id);
    }

    public function getTotalPedidoPorDia($data)
    {
        $dataInicial = date("Y-m-d H:i:s", strtotime($data));
        $dataFinal = date("Y-m-d H:i:s", strtotime($data . ' 23:59:59'));
        return $this->repository->getTotalPedidoPorDia($dataInicial, $dataFinal);
    }

    public function calculaComissao($valor){
        return round($valor * 0.1, 2);
    }
}
