<?php

namespace App\Exports;

use App\Models\LaborCostAssignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaborHistoryExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $startDate;
    protected $endDate;
    protected $filters;

    public function __construct($startDate, $endDate, $filters = [])
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = LaborCostAssignment::with(['laborType', 'product', 'supervisor'])
            ->whereBetween('date', [$this->startDate, $this->endDate]);

        // Apply filters
        if (isset($this->filters['category']) && $this->filters['category']) {
            $query->whereHas('laborType', function ($q) {
                $q->where('category', $this->filters['category']);
            });
        }

        if (isset($this->filters['labor_type_id']) && $this->filters['labor_type_id']) {
            $query->where('labor_type_id', $this->filters['labor_type_id']);
        }

        if (isset($this->filters['product_id']) && $this->filters['product_id']) {
            $query->where('product_id', $this->filters['product_id']);
        }

        return $query->orderBy('date', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Date',
            'Labor Type',
            'Category',
            'Product',
            'Batch Number',
            'Quantity',
            'Rate Amount',
            'Total Cost',
            'Supervisor',
            'Workers Count',
            'Shift',
            'Notes',
            'Created At'
        ];
    }

    public function map($assignment): array
    {
        return [
            $assignment->date->format('Y-m-d'),
            $assignment->laborType->name ?? 'N/A',
            ucfirst($assignment->laborType->category ?? 'N/A'),
            $assignment->product->name ?? 'N/A',
            $assignment->batch_number ?? '-',
            $assignment->quantity,
            $assignment->rate_amount,
            $assignment->total_cost,
            $assignment->supervisor->name ?? '-',
            $assignment->workers_count,
            ucfirst($assignment->shift ?? '-'),
            $assignment->notes ?? '-',
            $assignment->created_at->format('Y-m-d H:i:s')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}