<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class DadosExportNoHeader implements FromArray
{
    protected $data_in;
    public function __construct($data_in){
        $this->data_in = $data_in;
    }

    public function array(): array
    {
        return $this->data_in;
    }

}
