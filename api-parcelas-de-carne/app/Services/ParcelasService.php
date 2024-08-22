<?php

namespace App\Services;
use App\Models\Carne;
use App\Models\Parcelas;

class ParcelasService
{
    public function gerarParcelas($valor_total, $qtd_parcelas, $data_primeiro_vencimento, $periodicidade, $valor_entrada)
    {
        $parcelas = [];
        if ($valor_entrada > 0) {
            $soma_parcelas = $valor_total - $valor_entrada;
        } else {
            $soma_parcelas = $valor_total;
        }
        $valor_parcela = round($soma_parcelas / $qtd_parcelas, 2);
        $restante = $soma_parcelas - ($valor_parcela * $qtd_parcelas);
        $data_vencimento = new \DateTime($data_primeiro_vencimento);

        // Se houver valor de entrada, adicionar como uma parcela separada
        if ($valor_entrada > 0) {
            $parcelas[] = [
                'data_vencimento' => $data_primeiro_vencimento,
                'valor' => $valor_entrada,
                'numero' => 0,
                'entrada' => true,
            ];
            $data_vencimento->modify($periodicidade === 'mensal' ? '+1 month' : '+1 week');
        }

        // Gerar as demais parcelas
        for ($i = 1; $i <= $qtd_parcelas; $i++) {
            $valor_parcela_final = $valor_parcela;

            // Distribuir o restante na última parcela, se houver restante
            if ($i == $qtd_parcelas) {
                $valor_parcela_final = round($valor_parcela_final + $restante, 2);
            }

            $parcelas[] = [
                'data_vencimento' => $data_vencimento->format('Y-m-d'),
                'valor' => $valor_parcela_final,
                'numero' => $i,
            ];

            $data_vencimento->modify($periodicidade === 'mensal' ? '+1 month' : '+1 week');
        }

        //salvando no banco de dados
        $carne = new Carne();
        $carne->total = $valor_total;
        $carne->valor_entrada = $valor_entrada;
        $carne->save();
        $qtd = 0;
        foreach ($parcelas as $p) {
            $qtd++;
            $parcela = new Parcelas();
            $parcela->valor = $p['valor'];
            $parcela->data_vencimento = $p['data_vencimento'];
            $parcela->carne_id = $carne->id;
            //testa se existe a propriedade entrada no objeto
            try {
                $parcela->entrada = $p['entrada'];
            } catch (\Throwable $th) {
                $parcela->entrada = false;
            }
            $parcela->numero = $qtd;
            $parcela->save();
        }

        return [
            'total' => $valor_total,
            'valor_entrada' => $valor_entrada,
            'parcelas' => $parcelas,
            'id' => $carne->id
        ];
    }
}
