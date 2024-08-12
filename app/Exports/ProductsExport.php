<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromQuery, ShouldAutoSize, WithHeadings, WithMapping
{
    public function query()
    {
        return Product::query();
    }

    public function headings(): array
    {
        return [
            'Id',
            'Product Name',
            'Product Price',
            'Product Image'
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->name,
            $row->price,
            $row->image_url
        ];
    }
}
