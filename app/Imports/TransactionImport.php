<?php

namespace App\Imports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class TransactionImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Logic to transform and save each row as a Transaction model
        $values = array_values($row);

        // Logic to transform and save each row as a Transaction model
        return new Transaction([
            'D_TranID' => $values[0] ?? null,
            'D_TranCusName' => $values[1] ?? null,
            'D_TranProductName' => $values[2] ?? null,
            'D_TranProductQty' => $values[3] ?? null,
            'D_TranProductPrice' => $values[4] ?? null,
            'D_TranPaymentType' => $values[5] ?? null,
        ]);
    }
}
