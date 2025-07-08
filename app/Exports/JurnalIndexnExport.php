<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class JurnalIndexnExport implements WithMultipleSheets
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function sheets(): array
    {
        return [
            new JurnalPertemuanExport($this->id),
            new JurnalAbsensiExport($this->id),
        ];
    }
}
