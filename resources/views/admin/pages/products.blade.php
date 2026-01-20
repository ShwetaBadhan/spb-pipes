@extends('admin.layout.master')
@section('title', 'Products')
@section('content')

    <!-- ========================
           Start Page Content
          ========================= -->

    <div class="page-wrapper">

        <!-- Start Container  -->
        <div class="content content-two">

            <!-- Page Header -->
            <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
                <div>
                    <h6>Products</h6>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                    <div class="dropdown">
                        <a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex align-items-center"
                            data-bs-toggle="dropdown">
                            <i class="isax isax-export-1 me-1"></i>Export
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);">Download as PDF</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);">Download as Excel</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <a href="{{ route('add-product') }}" class="btn btn-primary d-flex align-items-center"><i
                                class="isax isax-add-circle5 me-1"></i>New Product</a>
                    </div>
                </div>
            </div>
            <!-- End Page Header -->

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

                    </div>

                </div>


                <!-- /Filter Info -->

            </div>
            <!-- End Table Search -->

            <!-- Start Table List -->
            <div class="table-responsive">
                <table class="table table-nowrap datatable">
                    <thead>
                        <tr>
                            <th class="no-sort">
                                <div class="form-check form-check-md">
                                    <input class="form-check-input" type="checkbox" id="select-all">
                                </div>
                            </th>
                            <th class="no-sort">Code</th>
                            <th class="no-sort">Product Name</th>
                            <th class="no-sort">Category</th>
                            <th class="no-sort">Unit</th>
                            <th>Quantity</th>
                            <th>Selling Price</th>
                            <th>Purchase Price</th>
                            <th class="no-sort">Status</th>
                            <th class="no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    <div class="form-check form-check-md">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                </td>
                                <td>
                                    <a href="javascript:void(0);" class="link-default">{{ $product->code }}</a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="javascript:void(0);"
                                            class="avatar avatar-sm rounded-circle me-2 flex-shrink-0">
                                            @if ($product->image_path)
                                                <img src="{{ asset('storage/' . $product->image_path) }}"
                                                    alt="{{ $product->name }}">
                                            @else
                                                <img src="{{ asset('assets/img/products/default.jfif') }}" alt="Default">
                                            @endif
                                        </a>
                                        <div>
                                            <h6 class="fs-14 fw-medium mb-0"><a
                                                    href="javascript:void(0);">{{ $product->name }}</a></h6>
                                        </div>
                                    </div>
                                </td>
                                <!-- Category Name -->
                                <td>
                                    {{ $product->category?->name ?? '—' }}
                                </td>
                                <!-- Unit Name -->
                                <td class="text-dark">
                                    {{ $product->unit?->name ?? '—' }}
                                </td>
                                <td>{{ $product->variants->sum('quantity') }}</td>
                                <td class="text-dark">
                                    ₹{{ number_format($product->variants->min('selling_price'), 2) }}
                                </td>

                                <td class="text-dark">
                                    ₹{{ number_format($product->variants->min('purchase_price'), 2) }}
                                </td>

                                <td>
                                    @if ($product->status)
                                        <span class="badge badge-soft-success d-inline-flex align-items-center">
                                            Active <i class="isax isax-tick-circle ms-1"></i> </span>
                                    @else
                                        <span class="badge badge-soft-danger d-inline-flex align-items-center">Inactive<i
                                                class="isax isax-close-circle ms-1"></i></span>
                                    @endif
                                </td>
                                <td class="action-item">
                                    <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                        <i class="isax isax-more"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('edit-product', $product->id) }}"
                                                class="dropdown-item d-flex align-items-center"><i
                                                    class="isax isax-edit me-2"></i>Edit</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"
                                                data-bs-toggle="modal" data-bs-target="#delete_modal{{ $product->id }}"><i
                                                    class="isax isax-trash me-2"></i>Delete</a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <!-- Start Delete -->
                            <div class="modal fade" id="delete_modal{{ $product->id }}">
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-body text-center">
                                            <div class="mb-3">
                                                <img src="assets/img/icons/delete.svg" alt="img">
                                            </div>
                                            <h6 class="mb-1">Delete Product {{ $product->name }}</h6>
                                            <p class="mb-3">Are you sure, you want to delete product?</p>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="d-flex justify-content-center">
                                                    <a href="javascript:void(0);" class="btn btn-outline-white me-3"
                                                        data-bs-dismiss="modal">Cancel</a>
                                                    <button type="submit" class="btn btn-primary">Yes, Delete</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Delete -->
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- End Table List -->

        </div>
        <!-- container  -->



    </div>
    <!-- ========================
           End Page Content
          ========================= -->




@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 4000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                timer: 4000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        </script>
    @endif

@endpush
