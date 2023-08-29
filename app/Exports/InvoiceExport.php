<?php

namespace App\Exports;

use App\Models\Receipt;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class InvoiceExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        // Get only the desired fields from the receipts

        $receipts = Receipt::join('transactions', 'transactions.D_TranID', '=', 'receipts.D_RecID')
            ->select(
                "receipts.id",
                "receipts.D_RecID",
                'transactions.D_TranCusName as cusName',
                "receipts.D_RecTotal",
                "receipts.D_RecCash",
                "receipts.D_RecChange",
                "receipts.created_at"
            )
            ->whereIn('receipts.id', $this->data['invoices']->pluck('id'))
            ->distinct()
            ->get();

        return $receipts;
    }

    public function headings(): array
    {
        return ["ID", "Transaction ID", "Customer Name", "Total Bill", "Receive Cash", "Change", "Date"];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->D_RecID,
            $row->cusName,
            $row->D_RecTotal,
            $row->D_RecCash,
            $row->D_RecChange,
            $row->created_at->format('Y-m-d'), // Format the date as desired
        ];
    }
}
