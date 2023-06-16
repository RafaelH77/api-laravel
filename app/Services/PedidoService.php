<?php

namespace App\Services;

use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Repositories\Interfaces\IPedidoRepository;
use App\Repositories\Interfaces\IVendedorRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use function PHPUnit\Framework\isNull;

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

        $result->itens()->createMany($data['itens']);

        return $this->repository->getByIdWithVendedor($result->id);
    }

    public function update(int $id, $data)
    {
        $this->validate($this->validationRules);

        $comissao = $this->calculaComissao($data['valor']);

        $itens = $data['itens'];
        unset($data['itens']);

        $this->repository->update($id, array_merge($data, ['comissao' => $comissao]));

        $result = $this->repository->getByIdWithVendedor($id);
        $this->UpdateOrDeleteChildren($result->itens(), $itens);

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

    protected function UpdateOrDeleteChildren($dbChildList, $childList)
    {
        if (is_null($childList))
            return;

        $childListIds = array_column($childList, 'id');

        // Delete children
        if (!is_null($dbChildList)){
            $childListIdsDelete = array_column(array_filter($dbChildList->get()->toArray(), function($value) use($childListIds) {
                return !in_array($value['id'], $childListIds);
            }), 'id');

            $dbChildList
                ->whereIn('id', $childListIdsDelete)
                ->delete();
        }

        // Update/Insert children
        foreach ($childList as $child){
            $existingChild = null;
            if (array_key_exists('id', $child))
                $existingChild = $dbChildList->where('id', '=', $child['id']);

            if (!is_null($existingChild)) {
                $existingChild->update($child);
            } else {
                $dbChildList->create($child);
            }
        }
    }
}
