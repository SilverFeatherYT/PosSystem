<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // return Customer::all();

        $customers = Customer::join('users', 'users.user_id', '=', 'customers.D_CusID')
            ->select(
                'customers.id',
                'users.name as D_CusName',
                'users.email as D_CusEmail',
                'customers.D_CusPhone',
                'customers.D_CusMemberPoint',
            )
            ->get();

        return $customers;
    }

    public function headings(): array
    {
        return ["CustomerID", "CustomerName", "CustomerEmail", "Phone", "MemberPoint"];
    }
}
