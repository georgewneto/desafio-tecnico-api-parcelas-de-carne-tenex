<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Carne;
use App\Services\ParcelasService;

class CarneController extends Controller
{
    public function show($id)
    {
        $carne = Carne::findOrFail($id);
        $carne->parcelas;
        return response()->json([
            'status' => true,
            'message' => 'Carnê encontrado',
            'data' => $carne
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'valor_total' => 'required|numeric',
            'qtd_parcelas' => 'required|integer',
            'data_primeiro_vencimento' => 'required|string',
            'periodicidade' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $valor_total = $request->input('valor_total');
        $qtd_parcelas = $request->input('qtd_parcelas');
        $data_primeiro_vencimento = $request->input('data_primeiro_vencimento');
        $periodicidade = $request->input('periodicidade');
        $valor_entrada = $request->input('valor_entrada', 0);

        $parcelasService = new ParcelasService();
        $carne_gerado = $parcelasService->gerarParcelas($valor_total, $qtd_parcelas, $data_primeiro_vencimento, $periodicidade, $valor_entrada);
        return response()->json($carne_gerado);

    }
}
