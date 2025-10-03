<?php

namespace App\Exports;

use App\Models\OrderItem;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    use Exportable;

    protected $from;
    protected $to;
    protected $totalSales = 0;

    public function __construct(string $from, string $to)
    {
        $this->from = Carbon::parse($from)->startOfDay();
        $this->to   = Carbon::parse($to)->endOfDay();
    }

    public function collection()
    {
        $items = OrderItem::with('order', 'product')
            ->whereBetween('created_at', [$this->from, $this->to])
            ->get();

        // Calculate total sales
        $this->totalSales = $items->sum('subtotal');

        // Append a summary row
        $items->push((object) [
            'order_id'   => '',
            'created_at' => null,
            'product'    => (object) ['name' => ''],
            'quantity'   => '',
            'price'      => 'TOTAL',
            'subtotal'   => $this->totalSales,
        ]);

        return $items;
    }

    public function headings(): array
    {
        return ['Order ID', 'Date & Time', 'Product Name', 'Quantity', 'Price', 'Subtotal'];
    }

    public function map($item): array
    {
        // Handle the summary row
        if ($item->price === 'TOTAL') {
            return ['', '', '', '', 'TOTAL SALES', $item->subtotal];
        }

        return [
            $item->order_id,
            optional($item->created_at)->format('Y-m-d H:i'),
            $item->product->name ?? 'Unknown',
            $item->quantity,
            $item->price,
            $item->subtotal,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();

        return [
            1 => ['font' => ['bold' => true]], // headings
            $lastRow => ['font' => ['bold' => true]], // total row
        ];
    }
}
