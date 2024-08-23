<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\Store;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromQuery, ShouldAutoSize, WithMapping
{
    public $store;

    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    public function query()
    {
        return Product::where('store_id', $this->store->id);
    }

    public function map($row): array
    {
        return [
            $row->name,
            null,
            100,
            1,
            null,
            null,
            'Baru',
            $row->image_url,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            'Aktif',
            100,
            30 * 16000
        ];
    }
}
