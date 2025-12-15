<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataExport implements WithMultipleSheets
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        $sheets = [];
        
        foreach ($this->data as $sheetName => $sheetData) {
            $sheets[] = new DataSheet($sheetData, $sheetName);
        }

        return $sheets;
    }
}

class DataSheet implements FromCollection, WithTitle, WithHeadings
{
    protected $data;
    protected $title;

    public function __construct($data, $title)
    {
        $this->data = $data;
        $this->title = $title;
    }

    public function collection()
    {
        // Konversi array ke collection
        return collect($this->data);
    }

    public function title(): string
    {
        return $this->title;
    }

    public function headings(): array
    {
        // Sesuaikan dengan struktur data Anda
        if (!empty($this->data) && is_array($this->data[0])) {
            return array_keys($this->data[0]);
        }
        
        return ['Data'];
    }
}

