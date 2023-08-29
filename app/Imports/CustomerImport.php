<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;

class CustomerImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // return new Customer([
        //     //
        // ]);

        // Logic to transform and save each row as a Transaction model
        $values = array_values($row);

        // Logic to transform and save each row as a Transaction model
        return new Customer([
            'id' => $values[0] ?? null,
            'D_CusName' => $values[1] ?? null,
            'D_CusEmail' => $values[2] ?? null,
            'D_CusPhone' => $values[4] ?? null,
            'D_CusMemberPoint' => $values[3] ?? null,

        ]);
    }
}
