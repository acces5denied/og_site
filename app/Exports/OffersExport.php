<?php

namespace App\Exports;

use App\Offer;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OffersExport implements FromCollection, Responsable, WithHeadings
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    private $fileName = 'export_offers.xlsx';
    
    public function collection()
    {
        return Offer::all();
    }
    
    public function headings(): array
    {
        return [
            'id',
            'name',
            'status',
			'rating',
            'price',
            'currency',
			'sale_type',
            'area',
			'floor',
            'rooms',
			'bedroom',
			'bathroom',
            'text',
            'quote',
            'address',
            'geo_lat',
            'geo_lon',
			'windows_view',
			'repair_type',
            'cat_id',
			'parking',
			'material_type',
            'subway_id',
            'type',
            'finish',
            'user_id',
			'slug',
			'publish_terms',
			'bet',
			'in_export',
			'in_export_ya',
			'text_cian',
            'seo_title',
            'seo_descr',
            'src_site',
            'src_lot',
            'src_tel',
            'src_link',
            'src_notice',
            'created_at',
            'updated_at',
        ];
    }
}
