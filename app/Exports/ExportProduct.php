<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportProduct implements FromCollection,WithHeadings,ShouldAutoSize,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Item::with('extras','multi_image')->get();
        
    }
    public function map($item): array
    {
        
        $newextras =[];
        $newimages = [];
        if(!empty($item->extras))
        {
            foreach($item->extras as $extras)
            {
               $newextras[] = $extras->name;
               
            }
        }
        if(!empty($item->multi_image))
        {
            foreach($item->multi_image as $image)
            {
               $newimages[] = $image->image;
            }
        }
        return[
            $item->cat_id,
            $item->item_name,
            $item->sku,
            implode('|',$newimages),
            $item->video_url,
            $item->tax,
            $item->description,
            $item->item_price,
            $item->item_original_price,
            $item->stock_management,
            $item->qty,
            $item->min_order,
            $item->max_order,
            $item->low_qty,
            implode('|',$newextras),
        ];
    }
    public function headings(): array
    {
        return [
            'category_id',
            'product_name',
            'sku',
            'image',
            'video_url',
            'tax',
            'description',
            'selling price',
            'original price',
            'stock_management',
            'qty',
            'min_order',
            'max_order',
            'low_qty',
            'extras',
        ];
    }
}
