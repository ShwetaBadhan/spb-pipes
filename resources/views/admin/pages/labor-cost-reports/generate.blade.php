@extends('admin.layout.master')
@section('title', 'Labor Cost Report')
@section('content')

    <div class="page-wrapper">
        <div class="content content-two">
            <!-- Report Header -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">Labor Cost Report</h5>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} to
                                {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                            </small>
                        </div>
                        <!-- Before export buttons, add: -->
                        @php
                            $exportFilters = array_merge($filters, [
                                'start_date' => $startDate,
                                'end_date' => $endDate,
                                'report_type' => $reportType,
                            ]);
                        @endphp
                        <div>
                            <a href="{{ route('labor-cost-reports.index') }}" class="btn btn-secondary me-2">
                                <i class="isax isax-arrow-left me-1"></i>Back
                            </a>
                            <a href="{{ route('labor-cost-reports.export-pdf') . '?' . http_build_query($exportFilters) }}"
                                class="btn btn-danger me-2">
                                <i class="isax isax-document-download me-1"></i>Export PDF
                            </a>
                            <a href="{{ route('labor-cost-reports.export-excel') . '?' . http_build_query($exportFilters) }}"
                                class="btn btn-success">
                                <i class="isax isax-document-download me-1"></i>Export Excel
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @if ($data['type'] == 'summary')
                @include('admin.pages.labor-cost-reports.partials.summary-report')
            @elseif($data['type'] == 'detailed')
                @include('admin.pages.labor-cost-reports.partials.detailed-report')
            @elseif($data['type'] == 'category-wise')
                @include('admin.pages.labor-cost-reports.partials.category-wise-report')
            @elseif($data['type'] == 'product-wise')
                @include('admin.pages.labor-cost-reports.partials.product-wise-report')
            @elseif($data['type'] == 'labor-type-wise')
                @include('admin.pages.labor-cost-reports.partials.labor-type-wise-report')
            @endif

        </div>
    </div>

@endsection
