<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class ArraySheetExport implements FromArray, WithTitle
{
    protected $data;
    protected $title;

    public function __construct(array $data, string $title)
    {
        $this->data = $data;
        $this->title = $title;
    }

    public function array(): array
    {
        // Caso o array esteja vazio, evita erro
        if (empty($this->data)) {
            return [];
        }

        // Caso todos os itens sejam strings simples (ex: ['abc', 'def']), transforma em array associativo
        if (is_string(reset($this->data))) {
            return array_map(fn($item) => ['Descrição' => $item], $this->data);
        }

        // Caso alguns sejam strings e outros arrays, transforma todos em arrays com uma chave
        return array_map(function ($item) {
            if (is_array($item)) {
                return $item;
            } else {
                return ['Descrição' => $item];
            }
        }, $this->data);
    }

    public function title(): string
    {
        return substr($this->title, 0, 30);
    }
}
