<h3>Payments Report</h3>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Tenant</th>
            <th>Property</th>
            <th>Unit</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $payment)
        <tr>
            <td>{{ $payment->lease->tenant->user->name }}</td>
            <td>{{ $payment->lease->unit->property->name }}</td>
            <td>{{ $payment->lease->unit->number }}</td>
            <td>{{ $payment->amount }}</td>
            <td>{{ $payment->status }}</td>
            <td>{{ $payment->created_at->format('Y-m-d') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
