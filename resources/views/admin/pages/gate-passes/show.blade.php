@extends('admin.layout.master')
@section('title', 'Show')
@section('content')
    <div class="page-wrapper">
        <!-- Start Content -->
        <div class="content content-two">
            <!-- Page Header -->
            <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
                <div>
                    <a href="{{ route('admin.gate-passes.index') }}" class="btn btn-primary d-flex align-items-center"><i
                            class="isax isax-arrow-left me-1"></i>Back</a>

                </div>
                <div>
                    <h6>Gate Pass Details - {{ $firstEntry->batch_number }}</h6>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">


                    <div>
                        <a href="{{ route('admin.gate-passes.slip', $firstEntry->batch_number) }}" class="btn btn-success"
                            target="_blank">
                            <i class="fas fa-file-pdf"></i> Generate Slip
                        </a>
                    </div>
                </div>
            </div>
            {{-- end page header --}}
            <!-- Start Table Search -->
            <div class="mb-3">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="table-search d-flex align-items-center mb-0">
                            <div class="search-input">
                                <a href="javascript:void(0);" class="btn-searchset"><i
                                        class="isax isax-search-normal fs-12"></i></a>
                            </div>
                        </div>
                        <a class="btn btn-outline-white fw-normal d-inline-flex align-items-center"
                            href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#customcanvas">
                            <i class="isax isax-filter me-1"></i>Filter
                        </a>
                    </div>
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="dropdown">
                            <a href="javascript:void(0);"
                                class="dropdown-toggle btn btn-outline-white d-inline-flex align-items-center fw-medium"
                                data-bs-toggle="dropdown">
                                <i class="isax isax-sort me-1"></i>Sort By : <span class="fw-normal ms-1">Latest</span>
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end">
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item">Latest</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item">Oldest</a>
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown">
                            <a href="javascript:void(0);"
                                class="dropdown-toggle btn btn-outline-white d-inline-flex align-items-center"
                                data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                <i class="isax isax-grid-3 me-1"></i>Column
                            </a>
                            <ul class="dropdown-menu  dropdown-menu">
                                <li>
                                    <label class="dropdown-item d-flex align-items-center form-switch">
                                        <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                        <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                        <span>ID</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="dropdown-item d-flex align-items-center form-switch">
                                        <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                        <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                        <span>Date</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="dropdown-item d-flex align-items-center form-switch">
                                        <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                        <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                        <span>Reference Number</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="dropdown-item d-flex align-items-center form-switch">
                                        <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                        <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                        <span>Description</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="dropdown-item d-flex align-items-center form-switch">
                                        <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                        <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                        <span>Attachment</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="dropdown-item d-flex align-items-center form-switch">
                                        <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                        <input class="form-check-input m-0 me-2" type="checkbox">
                                        <span>Amount</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="dropdown-item d-flex align-items-center form-switch">
                                        <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                        <input class="form-check-input m-0 me-2" type="checkbox">
                                        <span>Payment Mode</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="dropdown-item d-flex align-items-center form-switch">
                                        <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                        <input class="form-check-input m-0 me-2" type="checkbox">
                                        <span>Status</span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Filter Info -->
                <div class="align-items-center gap-2 flex-wrap filter-info mt-3">
                    <h6 class="fs-13 fw-semibold">Filters</h6>
                    <span class="tag bg-light border rounded-1 fs-12 text-dark badge"><span
                            class="num-count d-inline-flex align-items-center justify-content-center bg-success fs-10 me-1">1</span>Status
                        Selected<span class="ms-1 tag-close"><i class="fa-solid fa-x fs-10"></i></span></span>
                    <span class="tag bg-light border rounded-1 fs-12 text-dark badge"><span
                            class="num-count d-inline-flex align-items-center justify-content-center bg-success fs-10 me-1">1</span>$10,000
                        - $25,500<span class="ms-1 tag-close"><i class="fa-solid fa-x fs-10"></i></span></span>
                    <a href="#" class="link-danger fw-medium text-decoration-underline ms-md-1">Clear All</a>
                </div>
                <!-- /Filter Info -->

            </div>
            <!-- End Table Search -->
            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '{{ session('success') }}',
                        timer: 5000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                </script>
            @endif

            @if ($errors->any())
                <script>
                    let errorMessages = [];
                    @foreach ($errors->all() as $error)
                        errorMessages.push("{{ $error }}");
                    @endforeach

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        html: errorMessages.join('<br>'),
                        timer: 6000,
                        timerProgressBar: true,
                        showConfirmButton: true
                    });
                </script>
            @endif
            <div class="table-responsive">
                <table class="table table-nowrap datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Labor Type</th>
                            <th>Workers</th>
                            <th>Rate/Worker</th>
                            <th>Total Cost</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gatePasses as $index => $gp)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $gp->product->name }}</td>
                                <td>{{ $gp->quantity }}</td>
                                <td>{{ $gp->laborType->name }}</td>
                                <td>{{ $gp->workers_count }}</td>
                                <td>₹{{ number_format($gp->rate_amount, 2) }}</td>
                                <td>₹{{ number_format($gp->total_cost, 2) }}</td>
                                <td class="action-item">
                                    <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                        <i class="isax isax-more"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('admin.gate-passes.edit', $gp->id) }}"
                                                class="dropdown-item d-flex align-items-center">
                                                <i class="isax isax-edit me-2"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"
                                                data-bs-toggle="modal"
                                                data-bs-target="#delete_modal{{ $gp->id }}"><i
                                                    class="isax isax-trash me-2"></i>Delete</a>
                                        </li>
                                    </ul>


                                </td>
                            </tr>
                            <!-- Start Modal  -->
                            <div class="modal fade" id="delete_modal{{ $gp->id }}">
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-body text-center">

                                            <div class="mb-3">
                                                <img src="{{ url('assets/img/icons/delete.svg') }}" alt="img">
                                            </div>
                                            <form action="{{ route('admin.gate-passes.destroy', $gp->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <h6 class="mb-1">Delete Gate Pass Entry</h6>
                                                <p class="mb-3">Are you sure, you want to delete Gate Pass Entry?</p>
                                                <div class="d-flex justify-content-center">
                                                    <a href="javascript:void(0);" class="btn btn-outline-white me-3"
                                                        data-bs-dismiss="modal">Cancel</a>
                                                    <button type="submit" class="btn btn-primary">Yes, Delete</button>
                                                </div>
                                            </form>
                                        </div> <!-- end modal-body -->
                                    </div> <!-- end modal-content -->
                                </div>
                            </div>
                            <!-- End Modal  -->
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6" class="text-right">Grand Total:</th>
                            <th>₹{{ number_format($totalCost, 2) }}</th>
                            <th></th>
                        </tr>
                    </tfoot>

                </table>
            </div>
        </div>

    </div>
@endsection