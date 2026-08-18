<div class="card">
    <div class="card-header bg-white py-3"><h6 class="mb-0">Activity Logs</h6></div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th>IP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activityLogs as $log)
                        <tr>
                            <td><small>{{ $log->created_at->format('d M Y H:i:s') }}</small></td>
                            <td><code class="fs-12">{{ $log->action }}</code></td>
                            <td>{{ $log->description }}</td>
                            <td><small class="text-muted">{{ $log->ip_address ?? '—' }}</small></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">No activity logs yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
