@extends('admin.layout.master')
@section('title', 'Add Customer')
@section('content')


    <!-- ========================
               Start Page Content
              ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content">

            <!-- start row -->
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6><a href="{{ route('customers.index') }}"><i class="isax isax-arrow-left me-2"></i>Customer</a>
                            </h6>
                            <a href="#" class="btn btn-outline-white d-inline-flex align-items-center"><i
                                    class="isax isax-eye me-1"></i>Preview</a>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="mb-3">Add Customer</h5>
                                <form action="{{ route('customers.store') }}" method="POST">
                                    @csrf

                                    <div class="row gx-3">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Name <span
                                                        class="text-danger ms-1">*</span></label>
                                                <input type="text" name="name" class="form-control"
                                                    value="{{ old('name') }}">
                                                @error('name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Email <span
                                                        class="text-danger ms-1">*</span></label>
                                                <input type="email" name="email" value="{{ old('email') }}"
                                                    class="form-control">
                                                @error('email')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Phone Number <span
                                                        class="text-danger ms-1">*</span></label>
                                                <input type="number" name="phone" value="{{ old('phone') }}"
                                                    class="form-control">
                                                @error('phone')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="border-top my-2">
                                        <div class="row gx-5">
                                            <div class="col-md-6 ">
                                                <h6 class="mb-3 pt-4">Billing Address</h6>
                                                <div class="row">

                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Address</label>
                                                            <input type="text" name="billing_address"
                                                                value="{{ old('billing_address') }}" id="billing_address"
                                                                class="form-control">
                                                            @error('billing_address')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">State</label>
                                                            <select class="select" name="billing_state" id="billing_state">
                                                                <option value="">Select State</option>
                                                                @foreach ($states as $state)
                                                                    <option value="{{ $state->id }}">
                                                                        {{ $state->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('billing_state')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">City</label>
                                                            <select class="select" name="billing_city" id="billing_city">
                                                                <option value="">Select City</option>
                                                            </select>
                                                            @error('billing_city')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Pincode</label>
                                                            <input type="text" name="billing_pincode"
                                                                value="{{ old('billing_pincode') }}" id="billing_pincode"
                                                                class="form-control">
                                                            @error('billing_pincode')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-between mb-2 pt-4">
                                                    <h6>Shipping Address</h6>
                                                    <a href="javascript:void(0)" id="copyBilling"
                                                        class="d-inline-flex align-items-center text-primary text-decoration-underline fs-13">
                                                        <i class="isax isax-document-copy me-1"></i>Copy From Billing
                                                    </a>

                                                </div>
                                                <div class="row">

                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Address</label>
                                                            <input type="text" name="shipping_address"
                                                                id="shipping_address" value="{{ old('shipping_address') }}"
                                                                class="form-control">
                                                            @error('shipping_address')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">State</label>
                                                            <select class="select" name="shipping_state"
                                                                id="shipping_state">
                                                                <option value="">Select State</option>
                                                                @foreach ($states as $state)
                                                                    <option value="{{ $state->id }}">
                                                                        {{ $state->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('shipping_state')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">City</label>
                                                            <select class="select" name="shipping_city"
                                                                id="shipping_city">
                                                                <option value="">Select City</option>
                                                            </select>
                                                            @error('shipping_city')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Pincode</label>
                                                            <input type="text" name="shipping_pincode"
                                                                id="shipping_pincode"
                                                                value="{{ old('billing_pincode') }}"
                                                                class="form-control">
                                                            @error('shipping_pincode')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="border-top my-2">
                                        <h6 class="mb-3 pt-4">Banking Details</h6>
                                        <div class="row gx-3">
                                            <div class="col-lg-4 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Bank Name</label>
                                                    <input type="text" name="bank_name"
                                                        value="{{ old('bank_name') }}" class="form-control">
                                                    @error('shipping_pincode')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Branch</label>
                                                    <input type="text" name="branch" value="{{ old('branch') }}"
                                                        class="form-control">
                                                    @error('branch')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Account Holder</label>
                                                    <input type="text" name="account_holder"
                                                        value="{{ old('account_holder') }}" class="form-control">
                                                    @error('account_holder')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Account Number</label>
                                                    <input type="text" name="account_number"
                                                        value="{{ old('account_number') }}" class="form-control">
                                                    @error('account_number')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">IFSC</label>
                                                    <input type="text" name="ifsc" value="{{ old('ifsc') }}"
                                                        class="form-control">
                                                    @error('ifsc')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between pt-4 border-top">
                                        <button type="button" class="btn btn-outline-white">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Create New</button>
                                    </div>
                                </form>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div>
                </div><!-- end col -->
            </div>
            <!-- end row -->

        </div>
        <!-- End Content -->



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
    <script>
        $('#billing_state').on('change', function() {
            let stateId = $(this).val();
            let citySelect = $('#billing_city');

            citySelect.html('<option value="">Loading...</option>');

            if (stateId) {
                $.ajax({
                    url: '/get-cities/' + stateId,
                    type: 'GET',
                    success: function(data) {
                        citySelect.empty();
                        citySelect.append('<option value="">Select City</option>');

                        $.each(data, function(key, city) {
                            citySelect.append(
                                '<option value="' + city.id + '">' + city.name + '</option>'
                            );
                        });
                    }
                });
            } else {
                citySelect.html('<option value="">Select City</option>');
            }
        });

        $('#shipping_state').on('change', function() {
            let stateId = $(this).val();
            let citySelect = $('#shipping_city');

            citySelect.html('<option value="">Loading...</option>');

            if (stateId) {
                $.get('/get-cities/' + stateId, function(data) {
                    citySelect.empty().append('<option value="">Select City</option>');

                    $.each(data, function(_, city) {
                        citySelect.append(
                            `<option value="${city.id}">${city.name}</option>`
                        );
                    });
                });
            } else {
                citySelect.html('<option value="">Select City</option>');
            }
        });

       document.getElementById('copyBilling').addEventListener('click', function () {
    const billingAddress = document.getElementById('billing_address');
    const billingPincode = document.getElementById('billing_pincode');
    const billingState   = document.getElementById('billing_state');
    const billingCity    = document.getElementById('billing_city');

    const shippingAddress = document.getElementById('shipping_address');
    const shippingPincode = document.getElementById('shipping_pincode');
    const shippingState   = document.getElementById('shipping_state');
    const shippingCity    = document.getElementById('shipping_city');

    // Copy address & pincode
    shippingAddress.value = billingAddress.value;
    shippingPincode.value = billingPincode.value;

    // Copy state
    shippingState.value = billingState.value;

    // If using a select plugin, trigger change so UI updates
    $(shippingState).trigger('change');

    // Load shipping cities via AJAX
    if (billingState.value) {
        $.ajax({
            url: '/get-cities/' + billingState.value,
            type: 'GET',
            success: function(data) {
                shippingCity.innerHTML = '<option value="">Select City</option>';
                $.each(data, function(_, city) {
                    shippingCity.innerHTML += `<option value="${city.id}">${city.name}</option>`;
                });

                // Set shipping city after options are loaded
                shippingCity.value = billingCity.value;
                $(shippingCity).trigger('change'); // update UI if select plugin used
            }
        });
    } else {
        shippingCity.innerHTML = '<option value="">Select City</option>';
    }
});

    </script>
@endpush
