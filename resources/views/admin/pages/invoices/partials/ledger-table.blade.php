@if ($ledgers->isEmpty())
    <div class="text-center py-4">
        <i class="isax isax-document-text fs-1 text-muted mb-2"></i>
        <p class="text-muted mb-0">No ledger entries found for selected dates.</p>
    </div>
@else
    <table class="table table-hover table-sm mb-0">
        <thead class="table-light">
            <tr>
                <th>Date & Time</th>
                <th>Type</th>
                <th>Paid (₹)</th>
                <th>Balance (₹)</th>
                <th>Mode</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ledgers as $entry)
                <tr>
                    <td>{{ $entry->created_at->format('d M Y, h:i A') }}</td>
                    <td>
                        <span class="badge {{ $entry->transaction_type == 'invoice_created' ? 'bg-info' : ($entry->transaction_type == 'payment_received' ? 'bg-success' : 'bg-warning') }}">
                            {{ ucfirst(str_replace('_', ' ', $entry->transaction_type)) }}
                        </span>
                    </td>
                    <td>
                        @if ($entry->credit > 0)
                            <span class="text-success">₹{{ number_format($entry->credit, 0) }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="{{ $entry->balance >= 0 ? 'text-dark' : 'text-danger' }}">
                        ₹{{ number_format(abs($entry->balance), 0) }}
                    </td>
                    <td>{{ $entry->payment_mode ? ucfirst(str_replace('_', ' ', $entry->payment_mode)) : '-' }}</td>
                    <td><small>{{ $entry->notes ?? '-' }}</small></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

@push('scripts')
<script>
function filterLedger() {
    const startDate = document.getElementById('filter-start-date').value;
    const endDate = document.getElementById('filter-end-date').value;

    if (!startDate || !endDate) {
        alert('Please select both start and end dates.');
        return;
    }

    const url = "{{ route('admin.invoices.ledger.filter', $invoice->id) }}"; // ✅ Now correct

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ start_date: startDate, end_date: endDate })
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.text();
    })
    .then(html => {
        document.getElementById('filtered-ledger-container').innerHTML = html;
        // Optional: show success badge
        const badge = document.querySelector('#ledgerModal .badge.bg-info');
        if (badge) badge.textContent = `${new DOMParser().parseFromString(html, 'text/html').querySelectorAll('tbody tr').length} Entries`;
    })
    .catch(error => {
        console.error('Filter error:', error);
        document.getElementById('filtered-ledger-container').innerHTML = 
            `<div class="alert alert-danger text-center py-3 mb-0">❌ ${error.message}</div>`;
    });
}

// Initialize date pickers
document.addEventListener('DOMContentLoaded', () => {
    const startInput = document.getElementById('filter-start-date');
    const endInput = document.getElementById('filter-end-date');

    // Set default: last 6 months to today
    const today = new Date();
    const sixMonthsAgo = new Date(today.setMonth(today.getMonth() - 6));
    startInput.value = sixMonthsAgo.toISOString().split('T')[0];
    endInput.value = new Date().toISOString().split('T')[0];

    // Attach listeners
    startInput.addEventListener('change', filterLedger);
    endInput.addEventListener('change', filterLedger);

    // Also trigger on modal open (in case user opens modal after editing)
    const modal = document.getElementById('ledgerModal');
    modal.addEventListener('shown.bs.modal', filterLedger);
});
</script>
@endpush