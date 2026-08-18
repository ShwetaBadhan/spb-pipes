<div class="card">
    <div class="card-header bg-white py-3"><h6 class="mb-0">Domains</h6></div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Domain</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tenant->domains as $domain)
                        <tr>
                            <td>
                                <a href="http://{{ $domain->domain }}:8000" target="_blank" class="text-primary">
                                    {{ $domain->domain }} <i class="fas fa-external-link-alt ms-1"></i>
                                </a>
                            </td>
                            <td>{{ $domain->created_at?->format('d M Y') }}</td>
                            <td class="text-end">
                                <a href="http://{{ $domain->domain }}:8000" target="_blank" class="btn btn-sm btn-soft-primary">Visit</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted py-4">No domains assigned.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
