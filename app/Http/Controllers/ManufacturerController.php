<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use App\Http\Requests\StoreManufacturerRequest;
use App\Http\Requests\UpdateManufacturerRequest;
use Illuminate\Http\JsonResponse;

class ManufacturerController extends Controller
{
    /**
     * Lista todos os fabricantes
     */
    public function index(): JsonResponse
    {
        $manufacturers = Manufacturer::orderBy('name', 'asc')->get();
        return response()->json($manufacturers);
    }

    /**
     * Cria um novo fabricante
     */
    public function store(StoreManufacturerRequest $request): JsonResponse
    {
        $manufacturer = Manufacturer::create($request->validated());
        return response()->json($manufacturer, 201);
    }

    /**
     * Exibe um fabricante específico
     */
    public function show(Manufacturer $manufacturer): JsonResponse
    {
        return response()->json($manufacturer);
    }

    /**
     * Atualiza um fabricante
     */
    public function update(UpdateManufacturerRequest $request, Manufacturer $manufacturer): JsonResponse
    {
        $manufacturer->update($request->validated());
        return response()->json($manufacturer);
    }

    /**
     * Deleta um fabricante
     */
    public function destroy(Manufacturer $manufacturer): JsonResponse
    {
        try {
            $manufacturer->delete();
            return response()->json(['message' => 'Fabricante removido com sucesso.']);
        } catch (\Illuminate\Database\QueryException $e) {
            // Código de erro padrão para violação de chave estrangeira (foreign key constraint)
            if ($e->getCode() == "23000") {
                return response()->json([
                    'error' => 'Não é possível excluir este fabricante pois existem veículos vinculados a ele.'
                ], 409); // 409 Conflict
            }
            throw $e;
        }
    }
}
