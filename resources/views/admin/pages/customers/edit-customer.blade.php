@extends('admin.layout.master')
@section('title', 'Edit Customer')
@section('content')

    <!-- Begin Wrapper -->
    <div class="main-wrapper">





        <!-- ========================
       Start Page Content
      ========================= -->

        <div class="page-wrapper">
            <div class="content">
                <!-- start row -->
                <div class="row">
                    <div class="col-md-10 mx-auto">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h6><a href="{{ route('customers.index') }}"><i
                                            class="isax isax-arrow-left me-2"></i>Customer</a></h6>
                                <a href="#" class="btn btn-outline-white d-inline-flex align-items-center"><i
                                        class="isax isax-eye me-1"></i>Preview</a>
                            </div>
                            <div class="card">
                                <div class="card-body">

                                    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row gx-3">
                                            <div class="col-lg-4 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="name" class="form-control"
                                                        value="{{ old('name', $customer->name) }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Email <span
                                                            class="text-danger">*</span></label>
                                                    <input type="email" name="email" class="form-control"
                                                        value="{{ old('email', $customer->email) }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Phone Number <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="phone" class="form-control"
                                                        value="{{ old('phone', $customer->phone) }}">
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
                                                                    class="form-control"
                                                                    value="{{ old('billing_address', $customer->billing_address) }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">State</label>
                                                                <select class="select" name="billing_state"
                                                                    id="billing_state">
                                                                    <option value="">Select State</option>
                                                                    @foreach ($states as $state)
                                                                        <option value="{{ $state->id }}"
                                                                            {{ $customer->billing_state == $state->id ? 'selected' : '' }}>
                                                                            {{ $state->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">City</label>
                                                                <select class="select" name="billing_city"
                                                                    id="billing_city">
                                                                    <option value="">Select City</option>
                                                                    @if ($customer->billing_state && $customer->billingStateRelation)
                                                                        @foreach ($customer->billingStateRelation->cities as $city)
                                                                            <option value="{{ $city->id }}"
                                                                                {{ $customer->billing_city == $city->id ? 'selected' : '' }}>
                                                                                {{ $city->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">Pincode</label>
                                                                <input type="text" name="billing_pincode"
                                                                    class="form-control"
                                                                    value="{{ old('billing_pincode', $customer->billing_pincode) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div
                                                        class="d-flex align-items-center justify-content-between mb-2 pt-4">
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
                                                                    id="shipping_address" class="form-control"
                                                                    value="{{ old('shipping_address', $customer->shipping_address) }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">State</label>
                                                                <select class="select" name="shipping_state"
                                                                    id="shipping_state">
                                                                    <option value="">Select State</option>
                                                                    @foreach ($states as $state)
                                                                        <option value="{{ $state->id }}"
                                                                            {{ $customer->shipping_state == $state->id ? 'selected' : '' }}>
                                                                            {{ $state->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">City</label>
                                                                <select class="select" name="shipping_city"
                                                                    id="shipping_city">
                                                                    <option value="">Select City</option>
                                                                    @if ($customer->shipping_state && $customer->shippingStateRelation)
                                                                        @foreach ($customer->shippingStateRelation->cities as $city)
                                                                            <option value="{{ $city->id }}"
                                                                                {{ $customer->shipping_city == $city->id ? 'selected' : '' }}>
                                                                                {{ $city->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">Pincode</label>
                                                                <input type="text" name="shipping_pincode"
                                                                    id="shipping_pincode" class="form-control"
                                                                    value="{{ old('shipping_pincode', $customer->shipping_pincode) }}">
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
                                                        <input type="text" name="bank_name" class="form-control"
                                                            value="{{ old('bank_name', $customer->bank_name) }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Branch</label>
                                                        <input type="text" name="branch" class="form-control"
                                                            value="{{ old('branch', $customer->branch) }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Account Holder</label>
                                                        <input type="text" name="account_holder" class="form-control"
                                                            value="{{ old('account_holder', $customer->account_holder) }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Account Number</label>
                                                        <input type="text" name="account_number" class="form-control"
                                                            value="{{ old('account_number', $customer->account_number) }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">IFSC</label>
                                                        <input type="text" name="ifsc" class="form-control"
                                                            value="{{ old('ifsc', $customer->ifsc) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between pt-4 border-top">
                                            <a href="{{ route('customers.index') }}"
                                                class="btn btn-outline-white">Cancel</a>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>

                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div>
                    </div><!-- end col -->
                </div>
                <!-- end row -->
            </div>



        </div>

        <!-- ========================
       End Page Content
      ========================= -->

    </div>
    <!-- End Wrapper -->

@endsection

@push('scripts')
    <script>
        // At top of script
        let choicesInstances = {};

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Choices (if used)
            if (typeof Choices !== 'undefined') {
                choicesInstances.billing_city = new Choices('#billing_city', {
                    searchEnabled: true
                });
                choicesInstances.shipping_city = new Choices('#shipping_city', {
                    searchEnabled: true
                });
            }

            // Load initial cities
            loadCities($('#billing_state').val(), $('#billing_city'), '{{ $customer->billing_city }}');
            loadCities($('#shipping_state').val(), $('#shipping_city'), '{{ $customer->shipping_city }}');
        });
        // Function to load cities for a state
        function loadCities(stateId, citySelect, selectedCity = null) {
            citySelect.html('<option>Loading...</option>');
            if (!stateId) {
                citySelect.html('<option value="">Select City</option>');
                return;
            }
            $.get('/get-cities/' + stateId, function(data) {
                citySelect.empty().append('<option value="">Select City</option>');
                $.each(data, function(_, city) {
                    citySelect.append(
                        `<option value="${city.id}" ${selectedCity == city.id ? 'selected' : ''}>${city.name}</option>`
                        );
                });
            });
        }

        // Billing State change
        $('#billing_state').on('change', function() {
            let stateId = $(this).val();
            loadCities(stateId, $('#billing_city'));
        });

        // Shipping State change
        $('#shipping_state').on('change', function() {
            let stateId = $(this).val();
            loadCities(stateId, $('#shipping_city'));
        });

        // On page load, ensure selected cities are shown
        $(document).ready(function() {
            loadCities($('#billing_state').val(), $('#billing_city'), '{{ $customer->billing_city }}');
            loadCities($('#shipping_state').val(), $('#shipping_city'), '{{ $customer->shipping_city }}');
        });

        // Copy Billing to Shipping
        document.getElementById('copyBilling').addEventListener('click', function() {
            // Get values
            const billingAddress = document.querySelector('[name="billing_address"]').value;
            const billingPincode = document.querySelector('[name="billing_pincode"]').value;
            const billingState = document.getElementById('billing_state').value;
            const billingCity = document.getElementById('billing_city').value;

            // Set shipping fields
            document.querySelector('[name="shipping_address"]').value = billingAddress;
            document.querySelector('[name="shipping_pincode"]').value = billingPincode;
            document.getElementById('shipping_state').value = billingState;

            // Trigger change on state to reload cities (if needed)
            $(document.getElementById('shipping_state')).trigger('change');

            // If billing state is selected, fetch and set cities
            if (billingState) {
                $.get('/get-cities/' + billingState, function(cities) {
                    const shippingCitySelect = $('#shipping_city');
                    shippingCitySelect.empty().append('<option value="">Select City</option>');

                    cities.forEach(city => {
                        const selected = (city.id == billingCity) ? 'selected' : '';
                        shippingCitySelect.append(
                            `<option value="${city.id}" ${selected}>${city.name}</option>`);
                    });

                    // Important: Refresh select plugin if used
                    shippingCitySelect.trigger('change'); // for Choices/Select2/etc.
                });
            } else {
                $('#shipping_city').empty().append('<option value="">Select City</option>').trigger('change');
            }
        });
    </script>
@endpush
