@extends('super-admin.layouts.master')

@section('title', 'Audit Logs')

@section('content')
<div class="card">
    <div class="card-header">
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="event" value="{{ request('event') }}" class="form-control form-control-sm" placeholder="Event (e.g. tenant.created)" style="width:220px;">
            <button class="btn btn-sm btn-primary">Filter</button>
        </form>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tenant</th>
                    <th>Event</th>
                    <th>Details</th>
                    <th>IP</th>
                    <th>When</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->tenant?->name ?? '—' }}</td>
                        <td><code>{{ $log->event }}</code></td>
                        <td>
                            @if($log->new_values)
                                <small class="text-muted">{{ collect($log->new_values)->map(fn ($v, $k) => $k . '=' . $v)->implode(', ') }}</small>
                            @else
                                —
                            @endif
                        </td>
                        <td><small class="text-muted">{{ $log->ip_address ?? '—' }}</small></td>
                        <td>{{ $log->created_at?->format('M d, Y H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No audit logs found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($logs->hasPages())
        <div class="card-footer">{{ $logs->links() }}</div>
    @endif
</div>
@endsection
