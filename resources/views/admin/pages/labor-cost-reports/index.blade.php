@extends("admin.layout.master")
@section("title","Labor Cost Reports")
@section("content")

<div class="page-wrapper">
    <div class="content content-two">
        <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
            <div>
                <h6>Generate Labor Cost Report</h6>
                <p class="text-muted mb-0">Select report type and filters to generate detailed reports</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('labor-cost-reports.generate') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Start Date *</label>
                                <input type="date" name="start_date" class="form-control" 
                                       value="{{ date('Y-m-01') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">End Date *</label>
                                <input type="date" name="end_date" class="form-control" 
                                       value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Report Type *</label>
                                <select name="report_type" class="select" required>
                                    <option value="summary">Summary Report</option>
                                    <option value="detailed">Detailed Report</option>
                                    <option value="category-wise">Category-wise Report</option>
                                    <option value="product-wise">Product-wise Report</option>
                                    <option value="labor-type-wise">Labor Type-wise Report</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select name="category" class="select">
                                    <option value="">All Categories</option>
                                    <option value="production">Production</option>
                                    <option value="logistics">Logistics</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Labor Type</label>
                                <select name="labor_type_id" class="select">
                                    <option value="">All Labor Types</option>
                                    @foreach($laborTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Product</label>
                                <select name="product_id" class="select">
                                    <option value="">All Products</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="isax isax-document-text me-1"></i>Generate Report
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection