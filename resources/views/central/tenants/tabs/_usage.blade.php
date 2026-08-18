<div class="card">
    <div class="card-header bg-white py-3"><h6 class="mb-0">Resource Usage</h6></div>
    <div class="card-body">
        <div class="row g-4">
            @foreach ($usage as $key => $info)
                <div class="col-md-6 col-lg-4">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span class="text-capitalize fw-medium">{{ str_replace('_', ' ', $key) }}</span>
                        <span class="fs-13">
                            <strong>{{ $info['usage'] }}</strong>
                            / {{ $info['unlimited'] ? '∞' : number_format($info['limit']) }}
                        </span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar {{ $info['percent'] >= 100 ? 'bg-danger' : ($info['percent'] >= 80 ? 'bg-warning' : 'bg-success') }}"
                             style="width: {{ $info['percent'] }}%"></div>
                    </div>
                    @if ($info['percent'] >= 100)
                        <small class="text-danger">Limit reached</small>
                    @elseif ($info['percent'] >= 80)
                        <small class="text-warning">Almost full</small>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
