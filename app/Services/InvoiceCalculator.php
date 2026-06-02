<?php

namespace App\Services;

class InvoiceCalculator
{
    public function calculate(
        float $baseUsdCost,
        float $fxRate,
        float $fxBufferPercent,
        float $serviceFee = 0,
        float $gatewayFee = 0
    ): array {
        $localCost = $baseUsdCost * $fxRate;

        $fxBufferAmount = ($localCost * $fxBufferPercent) / 100;

        $totalNairaAmount = $localCost + $fxBufferAmount + $serviceFee + $gatewayFee;

        return [
            'local_cost' => round($localCost, 2),
            'fx_buffer_amount' => round($fxBufferAmount, 2),
            'total_naira_amount' => round($totalNairaAmount, 2),
        ];
    }

    public function generateReference(): string
    {
        return 'STE-' . now()->format('YmdHis') . '-' . strtoupper(str()->random(6));
    }
}