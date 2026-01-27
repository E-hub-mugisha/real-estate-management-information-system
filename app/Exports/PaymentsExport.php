<?php

namespace App\Exports;

use App\Models\Payment;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PaymentsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Fetch filtered data
     */
    public function collection()
    {
        $query = Payment::with([
            'lease.tenant.user',
            'lease.unit.property'
        ]);

        // Filter by Property
        if ($this->request->property_id) {
            $query->whereHas('lease.unit', function ($q) {
                $q->where('property_id', $this->request->property_id);
            });
        }

        // Filter by Tenant
        if ($this->request->tenant_id) {
            $query->whereHas('lease', function ($q) {
                $q->where('tenant_id', $this->request->tenant_id);
            });
        }

        // Filter by Month
        if ($this->request->month) {
            $query->whereMonth('created_at', $this->request->month);
        }

        // Filter by Year
        if ($this->request->year) {
            $query->whereYear('created_at', $this->request->year);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Excel column headings
     */
    public function headings(): array
    {
        return [
            'Tenant Name',
            'Property',
            'Unit',
            'Amount',
            'Payment Method',
            'Status',
            'Payment Date',
        ];
    }

    /**
     * Map database fields to Excel columns
     */
    public function map($payment): array
    {
        return [
            $payment->lease->tenant->user->name ?? 'N/A',
            $payment->lease->unit->property->name ?? 'N/A',
            $payment->lease->unit->unit_number ?? 'N/A',
            number_format($payment->amount, 2),
            $payment->payment_method ?? 'N/A',
            ucfirst($payment->status),
            $payment->created_at->format('Y-m-d'),
        ];
    }
}
