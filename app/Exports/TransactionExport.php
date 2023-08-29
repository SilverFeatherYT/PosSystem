<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        // Get only the desired fields from the transactions
        $transactions = Transaction::select(
            "D_TranID",
            "D_TranCusName",
            "D_TranProductName",
            "D_TranProductQty",
            "D_TranProductPrice",
            "D_TranPaymentType",
            "created_at"
        )
            ->whereIn('id', $this->data['transactions']->pluck('id'))
            ->get();

        return $transactions;
    }

    public function headings(): array
    {
        return ["ID", "CustomerName", "ProductName", "ProductQuantity", "ProductPrice", "PaymentType", "Date"];
    }

    public function map($row): array
    {
        return [
            $row->D_TranID,
            $row->D_TranCusName,
            $row->D_TranProductName,
            $row->D_TranProductQty,
            $row->D_TranProductPrice,
            $row->D_TranPaymentType,
            $row->created_at->format('Y-m-d'), // Format the date as desired
        ];
    }
}
