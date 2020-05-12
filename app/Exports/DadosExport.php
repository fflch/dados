<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DadosExport implements FromArray, WithHeadings
{
    protected $data_in;
    public function __construct($data_in, $headings){
        $this->data_in = $data_in;
        $this->headings = $headings;
    }

    public function array(): array
    {
        return $this->data_in;
    }

    public function headings() : array
    {
        return $this->headings;
    }
}
